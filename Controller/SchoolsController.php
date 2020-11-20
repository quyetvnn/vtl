<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class SchoolsController extends AppController {

	public $components = array('Paginator', 'Email');
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	public $school_detail = array();

	public function beforeFilter() {
		parent::beforeFilter();
		$this->layout = "bootstrap";
		$current_user = $this->current_user ;
		
		if(isset($this->request->params['pass']) && !empty($this->request->params['pass'])){
			$school_code = $this->request->params['pass'][0];
			$school_detail = array();
			$allow_edit_school_info = false;
			$params = array(
				'language' => $this->lang18,
				'school_code' => $school_code
			);

			$resp = $this->Common->curl_post('api/school/schools/get_school_by_code.json', $params);
	        if($resp!=false){
	            $resp = json_decode($resp, true);
	            if(count($resp['params'])>0){
	                $school_detail = $resp['params'][0];
	                $school_detail['logo'] = '';
	                $school_detail['banner'] = '';
	                
	                $school_detail['minimal_name'] = $this->Common->get_minimal_name($school_detail['name']);
	                foreach ($school_detail['image'] as $i) {
	                    if($i['image_type_id']==1){
	                        $school_detail['logo'] = Router::url('/', true).$i['path'];
	                    }
	                    else if($i['image_type_id']==3){
	                    	$school_detail['banner'] = Router::url('/', true).$i['path'];
	                    }
	                }
	                $this->school_detail = $school_detail;
	                $list_menu = array(
	                	array(
	                		"menu_id" => 1,
	                		"title" => __d('school', 'bulletin_board'),
							"link" => array(
								'plugin' => '', 
			                    'controller' => 'schools', 
			                    'action' => 'landing',
			                    $school_detail['school_code'],
			                    'admin' => false
							), 
				            "config" => array('escape' => false, 'class' => 'text-dark-liver')
	                	),
	                	array(
	                		"menu_id" => 2,
	                		"title" => __d('member', 'teacher'),
							"link" => array(
				                'plugin' => '', 
			                    'controller' => 'schools', 
			                    'action' => 'teachers',
			                    $school_detail['school_code'],
			                    'admin' => false
							),
							"config" =>  array('escape' => false, 'class' => 'text-dark-liver')
	                	),
	                	array(
	                		"menu_id" => 3,
	                		"title" => __d('school', 'category'),
							"link" => array(
				                'plugin' => '', 
			                    'controller' => 'schools', 
			                    'action' => 'category',
			                    $school_detail['school_code'],
			                    'admin' => false
							),
							"config" =>  array('escape' => false, 'class' => 'text-dark-liver')
	                	)
					);
					$allow_menu_id = array(1);
					$allow_action = array('landing');
					if(isset($this->current_user) && !empty($this->current_user)){
						$current_user = $this->current_user;
						if($current_user['is_school_admin']){
							$role_school_admin = $current_user['member_role'][Environment::read('role.school-admin')];
							$contains_school = 	array_filter($role_school_admin, function($obj) use ($school_code) {
												    if ($obj['School']['school_code']==$school_code) return true;
												    return false;
												});
							if (!empty($contains_school)) {
							    $allow_menu_id = array(1, 2, 3);
								$allow_action = array('landing', 'teachers', 'category', 'group_member');
								$allow_edit_school_info = true;
							}
						}
					}
					$current_action = $this->request->params['action'];
					if(!in_array($current_action, $allow_action)){
						$this->redirect( array(
									'plugin' => '', 
				                    'controller' => 'schools', 
				                    'action' => 'landing',
				                    $school_detail['school_code'],
				                    'admin' => false
								)
						);
					}
	                $this->set(compact( 'school_detail', 'list_menu', 'allow_menu_id', 'allow_action', 'current_action', 'allow_edit_school_info'));
	            }
	        }
	        if(count($school_detail)==0){
	        	$this->Session->setFlash(__d('member', 'page_not_found'), 'flash/error');
				$this->redirect('/');
	        }
		}

		$this->set(compact( 'current_user'));
	}

	public function index() {
		$this->layout = "bootstrap";
		$current_user = $this->current_user;
	}

	public function payment(){
		$this->layout = "bootstrap";
		$current_user = $this->current_user;
		if(!isset($current_user) || empty($current_user)){
			$this->Session->setFlash(__d('member', 'please_login_first'), 'flash/error');
			$this->redirect('/');
		}
		if(!$current_user['is_school_admin']){
			$this->Session->setFlash(__d('member', 'this_account_dont_exist_student_role'), 'flash/error');
			$this->redirect('/');
		}
		$obj_MemberManageSchool = ClassRegistry::init('Member.MemberManageSchool');
		$obj_School = ClassRegistry::init('School.School');
		$manage_school = $obj_MemberManageSchool->find('all', array(
			'conditions' => array(
				'MemberManageSchool.member_id' 	=> $current_user['member_id'],
				'School.status' => array_search('Normal', $obj_School->status),
			),
			'contain' => array(
				'School' => array(
					'SchoolLanguage' => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18,	
						),
					),
					'SchoolImage',
				),
			),
		));
		$param_url = $this->params['url'];
		$payment_receipt = array();
        if(isset($param_url['Ref']) && !empty($param_url['Ref']) ){
        	$req_body = array('Ref' => $param_url['Ref'], 'language' => $this->lang18, 'token' => $this->current_user['token']);
        	$payment_receipt = $this->Common->curl_post('api/payment/pay_dollars/get_payment_receipt_info.json', $req_body);
	        if($payment_receipt!=false){
	            $payment_receipt = json_decode($payment_receipt, true, 512, JSON_UNESCAPED_UNICODE);
	            $payment_receipt = $payment_receipt['params'];
	        }
        }

        if ($this->request->is('post')) {
        	$data = $this->request->data;
			$flag               = false;
			// $template           = "confirm_payment_" . $this->lang18;
			$template           = "confirm_payment_a4l_admin_tmp_" . $this->lang18;
			// $template_member    = "confirm_payment_school_admin_tmp_" . $this->lang18;
			// $school_admin_email = $this->current_user['email'];          //// email's current school admin
			$all4learn_email    = "support@all4learn.com";          //// email's current school admin

			$credit = $data['amount'];
			$school_name = $data['school_name'];

			$data_Email = array(
			    'credit' => $credit,
			    'school_name' => $school_name
			);

			$send_to = $all4learn_email;
			$result_email = $this->Email->send($send_to, __d('member', 'send_confirm_payment'), $template, $data_Email);

			if($result_email['status']){
				$flag = true;
		        $message = __d('member', 'purchase_success_message');
		        $this->Session->setFlash($message, 'flash/success_modal');

				// $data_Email = array(
				//     'credit' => $credit,
				//     'school_name' => $school_name
				// );
			 //    $send_to = $school_admin_email;
			 //    $result_email = $this->Email->send($send_to, __d('member', 'send_confirm_payment'), $template_member, $data_Email);

			 //    if($result_email['status']){
			 //        $flag = true;
			 //        // $tdate = date( Environment::read('locale_format.'.$this->Session->read('Config.language')));
			 //        $message = __d('member', 'purchaser_success_message');
			 //        $this->Session->setFlash($message, 'flash/success_modal');

			 //    } else {
			 //        $message = $result_email['message'];
			 //        $this->Session->setFlash($message, 'flash/error');
			 //    }
			   
			}else{
			    $message = $result_email['message'];
			    $this->Session->setFlash($message, 'flash/error');
			}
        }

		$this->set(compact('manage_school', 'payment_receipt'));
	}

	public function landing($code = null){
		$this->layout = "bootstrap";
		$layout_class = 'school-page';
		$current_user = $this->current_user;
		
		if(isset($this->current_user) && !empty($this->current_user)){
			if($current_user['is_school_admin']){
				$role_school_admin = $current_user['member_role'][Environment::read('role.school-admin')];
				$contains_school = 	array_filter($role_school_admin, function($obj) use ($code) {
									    if ($obj['School']['school_code']==$code) return true;
									    return false;
									});
			}
		}
        $this->set(compact('layout_class'));
	}

	public function teachers($code = null){
		$this->layout = "bootstrap";
		$layout_class = 'school-page';

		$arr_role = array(Environment::read('role.teacher'), Environment::read('role.school-admin'));
		$role_config = array(
			Environment::read('role.teacher') => array(
				'class' => 'text-blue-light border-blue-light',
				'name' => array(
					'chi' => 'Teacher chi',
					'zho' => 'Teacher zho',
					'eng' => 'Teacher'
				)
			),
			Environment::read('role.student') => array(
				'class' => 'text-green border-green',
				'name' => array(
					'chi' => 'Student chi',
					'zho' => 'Student zho',
					'eng' => 'Student'
				)
			),
			Environment::read('role.school-admin') => array(
				'class' => 'text-green border-green',
				'name' => array(
					'chi' => 'school-admin chi',
					'zho' => 'school-admin zho',
					'eng' => 'School Admin'
				)
			)
		);
		if(isset($this->current_user) && !empty($this->current_user)){
			$current_user = $this->current_user;
			if($current_user['is_school_admin']){
				$role_school_admin = $current_user['member_role'][Environment::read('role.school-admin')];
				$contains_school = 	array_filter($role_school_admin, function($obj) use ($code) {
									    if ($obj['School']['school_code']==$code) return true;
									    return false;
									});
			}
		}
		
		
		$params = array(
			'language' => $this->lang18,
			'school_code' => $code
		);

		$conditions  = $contain = array();
	
		
		$conditions = array(
			'MemberRole.school_id' 	=> $this->school_detail['id'],
			'MemberRole.role_id IN' => $arr_role
		);
		$contain = array(
			'Member' => array(
				'MemberRole' =>array(
					'fields' => array(
						'MemberRole.role_id'
					),
					'conditions'=> array(
						'MemberRole.role_id IN' => $arr_role,
						'MemberRole.school_id' 	=> $this->school_detail['id'],
					)
				),
				'MemberLanguage' => array(
					'fields' => array(
						'MemberLanguage.name'
					),
					'conditions'=> array(
						'MemberLanguage.alias' => $this->lang18,
					)
				),
				'MemberImage' => array(
					'fields' => array(
						'MemberImage.path'
					),
					'conditions'=> array(
						'MemberImage.image_type_id' => 2,
					)
				)
			)
		);
	

		$obj_ImageType = ClassRegistry::init('Dictionary.ImageType');
		$result_ImageType = $obj_ImageType->find_id_by_slug('member-avatar');

		$obj_MemberRole = ClassRegistry::init('Member.MemberRole');

		$all_settings = array(
			'fields' => array(
				'DISTINCT Member.id',
				// 'Member.nick_name',
			),
			'conditions' => $conditions,
			'contain' => $contain,
		);

		$data_search = $this->request->query;
		if (isset($data_search['button_export_teacher']) && !empty($data_search['button_export_teacher'])) {
		
			$sent = $this->requestAction(array(
				'plugin' => '',
				'controller' => 'schools',
				'action' => 'export',
				'ext' => 'json'
			), array(
				'school_id' => $this->school_detail['id'],
				'role' 		=> $arr_role,
 				'type' => 'xlsx',
				'language' => "",
			));
		}

		$this->Paginator->settings = $all_settings;
		$lst_teacher = $this->paginate($obj_MemberRole);
		$this->set(compact('layout_class', 'role_config', 'lst_teacher'));
	}

	public function category($code = null){
		$this->layout = "bootstrap";
		$layout_class = 'school-page';
		$categories =array();
		$params = array(
			'language' => $this->lang18,
			'school_id' => $this->school_detail['id'],
			'token' => $this->current_user['token']
		);
		$resp = $this->Common->curl_post('api/school/schools_categories/get_item.json', $params);
        if($resp!=false){
            $resp = json_decode($resp, true, 512, JSON_UNESCAPED_UNICODE);
            if( isset($resp['status']) && $resp['status']==200){
            	$cats = $resp['params'];
            	foreach ($cats as $cat) {
            		$categories[$cat['SchoolsCategory']['id']] = reset($cat['SchoolsCategoriesLanguage'])['name'];
            	}
            }
        }
		$this->set(compact('layout_class', 'categories'));
	}

	public function group_member($code = null, $group_id = null){
		$this->layout = "bootstrap";
		$layout_class = 'school-page';
		$current_action = 'category';
		$this->set(compact('layout_class', 'categories', 'current_action', 'group_id'));
	}

	public function export() {

		$results = array(
			'status' => false, 
			'message' => __('missing_parameter'),
			'params' => array(),
		);
		$this->disableCache();
		if ($this->request->is('get')) {
			$header = array(
				'no',
				__d('member', 'username'),
				__d('member', 'name'),
				__d('administration', 'role'),
			);

			// get school code
			$obj_School = ClassRegistry::init('School.School');
			$result_School = $obj_School->get_school_by_id($this->request->school_id);

			// data;
			$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
			//$results = $obj_MemberLoginMethod->get_member_belong_school_with_role($this->request->school_id, $this->request->role, $this->lang18);

			$results = $obj_MemberLoginMethod->get_member_belong_school_with_role_pagination($this->current_user['member_id'], $this->request->school_id, $this->request->role, $this->lang18, 0, 0);


			$file_name =  date('Ymd') . '_teacher_' . $result_School['School']['school_code'];

			if ($this->request->type == "xlsx") {
				$this->Common->export_excel_v2($header, $results, $file_name);
          	}
		}

		$this->set(array(
			'results' => $results,
			'_serialize' => array('results')
		));
	}


	public function welcome(){
		$this->layout = "bootstrap";
		$layout_class = 'school-page';
		$current_user = $this->current_user;
		if(isset($current_user) && !empty($current_user)){
			if(!$current_user['is_self_register']) {
				$this->Session->setFlash(__d('member', 'no_permission'), 'flash/error');
				$this->redirect('/');
			}
		}
		$this->set(compact('layout_class'));
	}
	
}
