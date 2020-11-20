<?php
App::uses('MemberAppController', 'Member.Controller');
/**
 * MembersCredits Controller
 *
 * @property MembersCredit $MembersCredit
 * @property PaginatorComponent $Paginator
 */
class MembersCreditsController extends MemberAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Email');


	public function beforeFilter(){
		parent::beforeFilter();

		if ($this->params['prefix'] == "admin") {
			if ($this->params['action'] == "admin_add") {
				$this->set('title_for_layout', __d('member','member') .  " > " . __d('member','add_member') . " > " . __d('member','members_credits') );
			}

			if ($this->params['action'] == "admin_index") {
				$this->set('title_for_layout', __d('member','member') .  " > " . __d('member','members_credits') );
			}
		}
	}
	  
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		
		$conditions = array();

		$data_search = $this->request->query;
		if (isset($data_search["school_id"]) && $data_search["school_id"]) {
			$conditions['MembersCredit.school_id'] = $data_search["school_id"];
		}

		if (isset($data_search["credit_type_id"]) && $data_search["credit_type_id"]) {
			$conditions['MembersCredit.credit_type_id'] = $data_search["credit_type_id"];
		}
	
		if (isset($data_search["pay_dollar_ref"]) && !empty(trim($data_search["pay_dollar_ref"]))) {
			$conditions['MembersCredit.pay_dollar_ref LIKE'] = "%" . trim($data_search["pay_dollar_ref"]) . "%";
		}

		if (isset($data_search["remark"]) && $data_search["remark"] != null) {
			$conditions['MembersCredit.remark LIKE'] = "%" . trim($data_search["remark"]) . "%";
		}

		$all_settings = array(
			'order' => 'MembersCredit.id DESC',
			'conditions' => $conditions,
			'contain' => array(
				'School' => array(
					'fields' => array(
						'School.school_code',
					),
					'SchoolLanguage' => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18,
						),
						'fields' => array(
							'SchoolLanguage.name',
						),
					),
				),
				'Member' => array(
					'MemberLanguage' => array(
						'conditions' => array(
							'MemberLanguage.alias' => $this->lang18,
						),
						'fields' => array(
							'MemberLanguage.name',
						),
					),
				),
				'CreditType' => array(
					'CreditTypeLanguage' => array(
						'conditions' => array(
							'CreditTypeLanguage.alias' => $this->lang18,
						),
						'fields' => array(
							'CreditTypeLanguage.name',
						),
					),
				),
				'CreatedBy',
			),
		);

		$this->Paginator->settings = $all_settings;
		$membersCredits = $this->paginate();

		$obj_School = ClassRegistry::init('School.School');
		$school_id = $this->school_id;
		$schools = array();
		if ($this->school_id) {
			$schools = $obj_School->get_list_school($school_id, $this->lang18);
		} else {
			$schools = $obj_School->get_list_school(array(), $this->lang18);
		}

		$obj_CreditType = ClassRegistry::init('Credit.CreditType');
		$creditTypes = $obj_CreditType->get_full_list($this->lang18);
		$this->set(compact('membersCredits', 'schools', 'school_id', 'data_search', 'creditTypes'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->MembersCredit->exists($id)) {
			throw new NotFoundException(__('Invalid members credit'));
		}
		$options = array(
			'conditions' => array( 'MembersCredit.' . $this->MembersCredit->primaryKey => $id),
			'contain' => array(
				'School' => array(
					'SchoolLanguage' => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18,
						),
						'fields' => array(
							'SchoolLanguage.name',
						),
					),
				),
				'Member' => array(
					'MemberLanguage' => array(
						'conditions' => array(
							'MemberLanguage.alias' => $this->lang18,
						),
						'fields' => array(
							'MemberLanguage.name',
						),
					),
				),
				'CreditType' => array(
					'CreditTypeLanguage' => array(
						'conditions' => array(
							'CreditTypeLanguage.alias' => $this->lang18,
						),
						'fields' => array(
							'CreditTypeLanguage.name',
						),
					),
				),
				'CreatedBy',
				'UpdatedBy',
			),
		
		);
		$this->set('membersCredit', $this->MembersCredit->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {

		$obj_School = ClassRegistry::init('School.School');

		if ($this->request->is('post')) {
			$this->MembersCredit->create();

			$data = $this->request->data;
			if ($this->MembersCredit->save($data['MembersCredit'])) {

				// Update money to school. 
			
				$result_School = $obj_School->get_school_by_id($data['MembersCredit']['school_id']);

				// get credit type
				$result_CreditType = $this->MembersCredit->CreditType->get_all();
				$new_credit = 0;
				$amount = 0;

				foreach ($result_CreditType as $val) {
					if ($data['MembersCredit']['credit_type_id'] == $val['CreditType']['id']) {
						if ($val['CreditType']['is_add_point'] == true) {	// +
							$new_credit = $result_School['School']['credit'] + $data['MembersCredit']['credit'];
							$amount = $data['MembersCredit']['credit'];
						} else {											// -
							$new_credit = $result_School['School']['credit'] - $data['MembersCredit']['credit'];
							$amount = -$data['MembersCredit']['credit'];
						
						}
					}
				}

				// $obj_School->id = $data['MembersCredit']['school_id'];
				// $obj_School->saveField('credit', $new_credit);	// update field

				$data_School = array(
					'id' => $data['MembersCredit']['school_id'],
					'credit' => $new_credit,
				);

				if (!$obj_School->save($data_School)) {
					$message = __('data_is_not_saved');
					$this->Session->setFlash($message, 'flash/error');
					$this->redirect(array('action' => 'index'));
				}

				$obj_Member = ClassRegistry::init('Member.Member');

				// send mail to school admin 
				$school_name = $obj_School->get_school_name_by_id($data['MembersCredit']['school_id'], $this->lang18);
					
				$template = "recharge_email_succeed_tmp_" . $this->lang18;
				$data_Email = array(
					'school_name' 	=> $school_name,
					'current_date' 	=> $obj_School->format_date_time($this->lang18),
					'amount'		=> $amount,
				);


				
				if (isset($data['MembersCredit']['member_id']) && !empty($data['MembersCredit']['member_id']) ) {
					$result_Member = $obj_Member->get_obj($data['MembersCredit']['member_id']);
					if ($result_Member['Member']['email']) {
						
				
						$send_to = $result_Member['Member']['email'];
						$result_email = $this->Email->send($send_to, __d('member', 'add_confirm_payment'), $template, $data_Email);
				
						if ($result_email['status']) {
							$message = __d('member', 'send_mail_succeed') . $send_to;
							$this->Session->setFlash($message, 'flash/success');
	
						} else {
							$message = $result_email['message'];
							$this->Session->setFlash($message, 'flash/error');
						}
					}

				} else { 	// send all school admin

					// get school admin from this school
					$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
					$result_MemberRole = $obj_MemberRole->get_member_id(Environment::read('role.school-admin'), $data['MembersCredit']['school_id']);
					
					$message = "";
					$message_succeed = "";
					$message_failed = "";

					if ($result_MemberRole) {
						foreach ($result_MemberRole as $role) {

							$result_Member = $obj_Member->get_obj($role['MemberRole']['member_id']);	// get email
					
							if ($result_Member) {
								$send_to = $result_Member['Member']['email'];
								$result_email = $this->Email->send($send_to, __d('member', 'add_confirm_payment'), $template, $data_Email);
						
								if ($result_email['status']) {
									$message_succeed = __d('member', 'send_mail_succeed') . $send_to . "\n";
			
								} else {
									$message_failed = $result_email['message']. $send_to . "\n";
								}
							}
							
						}

						$message = $message_succeed . $message_failed;
						if ($message) {
							$this->Session->setFlash( h($message), 'flash/success');
						}
					}

					$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				}
				

				$this->redirect(array('action' => 'index'));

			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		}
	
		$this->load_data();
		$this->set(compact('members', 'creditTypes', 'schools'));
	}


	private function load_data() {
		$schools = array();
		$members = array();
		
		$conditions = array();
		$school_id = array();
		
		$schools = $this->MembersCredit->School->get_list_school(array(), $this->lang18);
		$creditTypes = $this->MembersCredit->CreditType->get_full_list($this->lang18);
	
		$this->set(compact('schools', 'school_id', 'creditTypes'));
	}


	// 2. Show the latest {n} transaction records for each school in front end
	public function api_get_latest_transaction_record() {
		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = array();

			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';

			} elseif (!isset($data['token']) || empty($data['token'])) {
				$message = __('missing_parameter') . "token";

			} elseif (!isset($data['school_code']) || empty($data['school_code'])) {
				$message = __('missing_parameter') . "school_code";
			
			} elseif (!isset($data['limit']) || empty($data['limit'])) {
				$message = __('missing_parameter') . "limit";

			} else {
				$this->Api->set_language($data['language']);

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);
				if (!$result_MemberLoginMethod) {
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_api_data;
				}

				// get school id from school code
				$obj_School = ClassRegistry::init('School.School');
				$result_School = $obj_School->get_obj_by_school_code($data['school_code']);

				if (!$result_School) {
					$status = 999;
					$message = __('invalid_data') . " (School code invalid)";
					goto load_api_data;
				}

				// check this member is manage this school
				$obj_MemberManageSchool = ClassRegistry::init('Member.MemberManageSchool');
				$conditions = array(
					'MemberManageSchool.school_id' => $result_School['School']['id'],
					'MemberManageSchool.member_id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
				);

				if (!$obj_MemberManageSchool->hasAny($conditions)) {
					$status = 999;
					$message = __('invalid_data') . " (This Member dont manage this school)";
					goto load_api_data;
				}

				// get report
				$obj_MembersCredit = ClassRegistry::init('Member.MembersCredit');
				$result = $obj_MembersCredit->get_latest_transaction_record($result_School['School']['id'], $data['limit']);

				$status = 200;
				$message = __('retrieve_data_successfully');
			}

			load_api_data:
            $this->Api->set_result($status, $message,  $result);
        }

		$this->Api->output();
	}
}
