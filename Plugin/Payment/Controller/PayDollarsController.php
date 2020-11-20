<?php
App::uses('PaymentAppController', 'Payment.Controller');


		// SHAPaydollarSecure

/**
 * PayDollars Controller
 *
 * @property PayDollar $PayDollar
 * @property PaginatorComponent $Paginator
 */
class PayDollarsController extends PaymentAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->PayDollar->recursive = 0;
		$this->set('payDollars', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->PayDollar->exists($id)) {
			throw new NotFoundException(__('Invalid pay dollar log'));
		}
		$options = array('conditions' => array('PayDollar.' . $this->PayDollar->primaryKey => $id));
		$this->set('payDollar', $this->PayDollar->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->PayDollar->create();
			if ($this->PayDollar->save($this->request->data)) {
				$this->Session->setFlash(__('The pay dollar log has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pay dollar log could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$members = $this->PayDollar->Member->find('list');
		$schools = $this->PayDollar->School->find('list');
		$this->set(compact('members', 'schools'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
        $this->PayDollar->id = $id;
		if (!$this->PayDollar->exists($id)) {
			throw new NotFoundException(__('Invalid pay dollar log'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PayDollar->save($this->request->data)) {
				$this->Session->setFlash(__('The pay dollar log has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pay dollar log could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('PayDollar.' . $this->PayDollar->primaryKey => $id));
			$this->request->data = $this->PayDollar->find('first', $options);
		}
		$members = $this->PayDollar->Member->find('list');
		$schools = $this->PayDollar->School->find('list');
		$this->set(compact('members', 'schools'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->PayDollar->id = $id;
		if (!$this->PayDollar->exists()) {
			throw new NotFoundException(__('Invalid pay dollar log'));
		}
		if ($this->PayDollar->delete()) {
			$this->Session->setFlash(__('Pay dollar log deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Pay dollar log was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}


	public function api_add_pay_dollar() {
	
		$this->Api->init_result();

		if ($this->request->is('post')) {
			$this->disableCache();
			$status = 999;
			$message = "";
			$params = (object)array();
			$data = $this->request->data;
			
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';

			} elseif (!isset($data['school_id']) || empty($data['school_id'])) {
				$message = __('missing_parameter') .  'school_id';

			} elseif (!isset($data['amount']) || empty($data['amount'])) {
				$message = __('missing_parameter') .  'amount';
				
			} elseif (!isset($data['token']) || empty($data['token'])) {
				$message = __('missing_parameter') .  'token';
				
			} else {
	
				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);
				$this->Api->set_language($data['language']);

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);

				if (!$result_MemberLoginMethod) {
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_data_api;
				}

				$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
				$resule_MemberRole = $obj_MemberRole->check_exist_role($result_MemberLoginMethod['Member']['MemberRole'], Environment::read('role.school-admin'));
			
				if (!$resule_MemberRole) {
					$status = 600;
					$message = __d('member', 'invalid_role');
					goto load_data_api;
				}
				
				// App::import(
				// 	'Vendor',
				// 	'Payment.PaydollarSecure.SHAPaydollarSecure',
				// 	array('file' => 'PaydollarSecure' . DS . 'SHAPaydollarSecure.php')
				// );
				
				App::import(
					'Vendor',
					'Payment.SHAPaydollarSecure',
					array('file' => 'PaydollarSecure' . DS . 'SHAPaydollarSecure.php')
				);

				$orderRef 		= substr(uniqid(rand(), false), 0, 9) . date('YmdHis');
				$currCode 		= Environment::read('paydollar.currency');
				$amount 		= $data['amount'];
				$paymentType 	= Environment::read('paydollar.payment_type');
			
				$paydollarSecure 	= new SHAPaydollarSecure(); 
				$secure_hash 		= $paydollarSecure->generatePaymentSecureHash(Environment::read('paydollar.merchant_id'), $orderRef, $currCode, $amount, $paymentType, Environment::read('paydollar.secure_hash_secret'));

				
				// save to DB;
				$data = array(
					'school_id' 	=> $data['school_id'],
					'Amt'			=> $data['amount'],
					'Cur'			=> $currCode,
					'succeedcode'	=> array_search('Processing', $this->PayDollar->status),
					'Ref'			=> $orderRef,
					'secureHash' 	=> $secure_hash,
					'member_id'		=> $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
				);

				if (!$this->PayDollar->save($data)) {
					$message = __('data_is_not_saved') . 'Pay dollar ' . json_encode($this->PayDollar->invalidFields());
					$status = 999;
					goto load_data_api;
				}

				$params = array(
					'orderRef' 		=> $orderRef,
					'secureHash' 	=> $secure_hash,
				);
				$message = __('data_is_saved');
				$status = 200;


			}

			load_data_api:
			$this->Api->set_result($status, $message, $params);	// param = token when login
		}
		
		$this->Api->output();
	}

	public function api_payment_data_feed() {	// webhook frm payasia

		// $this->autoLayout = false;
		// $this->autoRender = false;

		$this->Api->init_result();
		if ($this->request->is('post')) {
			$this->disableCache();

			$result = (object)array();
			
			$data = $this->request->data;
			$this->Api->set_post_params($this->request->params, $data);
			$this->Api->set_save_log(true);

			$this->Api->set_language('zho');

			$this->PayDollar->payment_data_feed($data);
			
			load_data_api:
            $this->Api->set_result(200, __('data_is_saved'), $result);
        }

		$this->Api->output();
	}


	public function api_get_payment_receipt_info() {	// web

		$this->Api->init_result();

		if ($this->request->is('post')) {
			$this->disableCache();
			$status = 999;
			$message = "";
			$params = (object)array();
			$data = $this->request->data;
			
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';

			} elseif (!isset($data['Ref']) || empty($data['Ref'])) {
				$message = __('missing_parameter') .  'Ref';

			} elseif (!isset($data['token']) || empty($data['token'])) {
				$message = __('missing_parameter') .  'token';
				
			} else {
	
				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);
				$this->Api->set_language($data['language']);

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);

				if (!$result_MemberLoginMethod) {
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_data_api;
				}

				$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
				$resule_MemberRole = $obj_MemberRole->check_exist_role($result_MemberLoginMethod['Member']['MemberRole'], Environment::read('role.school-admin'));
			
				if (!$resule_MemberRole) {
					$status = 600;
					$message = __d('member', 'invalid_role');
					goto load_data_api;
				}
				
				$params = $this->PayDollar->get_payment_receipt_info($result_MemberLoginMethod['MemberLoginMethod']['member_id'], $data['Ref'], $data['language']);
				
				$message = __('retrieve_data_successfully');
				$status = 200;
			}

			load_data_api:
			$this->Api->set_result($status, $message, $params);	// param = token when login
		}
		
		$this->Api->output();
	}
				
	//  $stock = $stock - $quantity;
	// 	$this->Shop->id = $id;
	// 	$this->Shop->saveField('stock', $stock);
}
