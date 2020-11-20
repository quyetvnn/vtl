<?php
App::uses('MemberAppController', 'Member.Controller');
/**
 * MemberLoginMethods Controller
 */
class MemberLoginMethodsController extends MemberAppController {

	public $components = array('Paginator','Email');

	public function beforeFilter(){
		parent::beforeFilter();
        $this->set('title_for_layout', __d('member','member_record') .  " > " . __d('member','member_login_method') );
  	}

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;

	public function logout() {
		setcookie("currentuser", "", 1, '/');
		$this->redirect("/");
	}
	
	public function admin_index() {
	
		$data_search = $this->request->query;
		$conditions = array();

		$school_id = array();
		if ($this->school_id) {
			$school_id = $this->school_id;
			$conditions = array(
				'MemberLoginMethod.school_id' => $this->school_id,
			);
		}

		if (isset($data_search["member_id"]) && $data_search["member_id"]) {
			$conditions['MemberLoginMethod.member_id'] = $data_search["member_id"];
		}
	
		if (isset($data_search["username"]) && !empty(trim($data_search["username"]))) {
			$conditions['MemberLoginMethod.username LIKE'] = "%" . trim($data_search["username"]) . "%";
		}

		if (isset($data_search["is_status"]) && $data_search["is_status"] != null) {
			$conditions['MemberLoginMethod.enabled'] = $data_search["is_status"];
		}

		$all_settings = array(
			'contain' => array(
				'School' => array(
					'SchoolLanguage' => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18,
						),
					),
				),
				'Member'
			),
			'order' => array(
				'MemberLoginMethod.id DESC',
			),
			'conditions' => $conditions,
		);

		$this->Paginator->settings = $all_settings;
		$memberLoginMethods = $this->paginate();

		$obj_Member = ClassRegistry::init('Member.Member');
		$members	= $obj_Member->get_list_member($school_id);
		
		$this->set(compact('members', 'memberLoginMethods', 'school_id', 'data_search'));
	}

	public function admin_add() {
	}

	public function admin_edit($id) {	// edit password

		$this->MemberLoginMethod->id = $id;
		if (!$this->MemberLoginMethod->exists($id)) {
			throw new NotFoundException(__('Invalid MemberLoginMethod'));
		}

		$obj_Member = ClassRegistry::init('Member.Member');
	
		if ($this->request->is('post') || $this->request->is('put')) {

			$data = $this->request->data;
			$data['MemberLoginMethod']['password'] = $obj_Member->set_password($data['MemberLoginMethod']['password']);
			$data['MemberLoginMethod']['token'] = array();
	
			if ($this->MemberLoginMethod->save($data['MemberLoginMethod'])) {

				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));

			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('MemberLoginMethod.' . $this->MemberLoginMethod->primaryKey => $id));
			$this->request->data = $this->MemberLoginMethod->find('first', $options);
		}

		$members = $obj_Member->get_full_list($this->lang18);	
		$schools = $this->MemberLoginMethod->School->get_list_school($this->school_id, $this->lang18);

		$this->set(compact('members', 'schools'));
	}

	public function admin_change_account_status($username, $id, $member_id, $enabled = 0) {

		$this->MemberLoginMethod->id = $id;
		if (!$this->MemberLoginMethod->exists($id)) {
			throw new NotFoundException(__('Invalid MemberLoginMethod'));
		}

		// update MemberLoginMethod
		$this->MemberLoginMethod->id = $id;
		$this->MemberLoginMethod->saveField('enabled',  !$enabled);

		// get email from member_id
		$result_Member = $this->MemberLoginMethod->Member->get_obj($member_id);
		if (!$result_Member) {
			throw new NotFoundException(__('Invalid Member'));
		}

		$email = $result_Member['Member']['email'];

		if ($enabled == true) {
			$username = "void." . $username;

			if ($email && !empty($email)) {
				if (strpos($email, "void.") === false) {
					$email = "void." . $email;
				}
			}
		
		} else {
			$pos = strpos($username, "void.");

			if ($pos >= 0) {
				$username = substr($username, strlen("void."), strlen($username) - strlen("void."));

				if ($email && !empty($email)) {
					if (strpos($email, "void.") === 0) {
						$email 		= substr($email, strlen("void."), strlen($email) - strlen("void."));
					}

					// check exist email in db
					$cond = array(
						'Member.email' => $email,
					);
					if ($this->MemberLoginMethod->Member->hasAny($cond)) {
						$this->Session->setFlash(__d('member', 'exist_email'), 'flash/error');
						$this->redirect(array('action' => 'index'));
					}
				}

				$result_MemberLoginMethod = $this->MemberLoginMethod->get_obj_by_id($id);
				if (!$result_MemberLoginMethod) {
					throw new NotFoundException(__('Invalid Member Login Method'));
				}

				// check username exist
				$cond = array(
					'MemberLoginMethod.username'		=> $username,
					'MemberLoginMethod.login_method_id'	=> $result_MemberLoginMethod['MemberLoginMethod']['login_method_id'],
				);
				if ($this->MemberLoginMethod->hasAny($cond)) {
					$this->Session->setFlash(__d('member', 'exist_username'), 'flash/error');
					$this->redirect(array('action' => 'index'));
				}
			}
		}
		
		$this->MemberLoginMethod->saveField('username', $username);

		// update Member
		$data_Member = array(
			'id' 		=> $member_id,
			'enabled' 	=> !$enabled,
			'username' 	=> $username,
			'email'		=> $email, 
		);

		$obj_Member = ClassRegistry::init('Member.Member');

		if (!$obj_Member->save($data_Member)) {
			$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			$this->redirect(array('action' => 'index'));
		}


		$this->Session->setFlash(__('data_is_saved'), 'flash/success');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_view() {
	}

	public function admin_delete($id = null) {

		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->MemberLoginMethod->id = $id;
		if (!$this->MemberLoginMethod->exists()) {
			throw new NotFoundException(__('Invalid member'));
		}
		if ($this->MemberLoginMethod->delete()) {
			$this->Session->setFlash(__('data_is_saved'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

	public function login() {
		$this->layout = "bootstrap";
		
		if ($this->request->is('post')) {
			$data = $this->request->data;

			$data['username'] = strtolower($data['username']);
			$data['school_code'] = strtolower($data['school_code']);
		
			$data['language'] = $this->lang18;

			$logged_user = $this->MemberLoginMethod->login($data);
		
			if( isset($logged_user['status']) && isset($logged_user['params']) && ($logged_user['status'] == true) ){
				$current_user = $logged_user['params'];

				$this->Session->write('Member.id', $current_user['MemberLoginMethod']['id']);
				$this->Session->write('Member.current', $current_user);

                if(isset($this->request->query['last_url']) && $this->request->query['last_url'] != '') {
                    $this->redirect($this->request->query['last_url']);

                } else {

					// priority
					$is_teacher = $is_student = false;
					foreach ($current_user['Role_id'] as $role) {

						if ($role == Environment::read('role.teacher')) {
							$is_teacher  = true;
						
						} elseif ($role == Environment::read('role.student')) {
							$is_student  = true;
						} 
					}

					if ($is_teacher) {
						$this->redirect(array(
							'plugin' => '',			// use member here will lost css
							'controller' => 'teacher_portals',
							'action' => 'index',
							'admin' => false
						));
					}

					if ($is_student) {
						$this->redirect(array(
							'plugin' => '',
							'controller' => 'student_portals',	// use Routes goto 
							'action' => 'index',
							'admin' => false
						));
					}

					$this->Session->setFlash('This member dont have any role', 'flash/error');
					$this->redirect("/landing");
                }
			} else {
				
				$this->Session->setFlash($logged_user['message'], 'flash/error');
				$this->redirect("/landing");
			}
        }
	}


	// -------------- WEB API ----------------
	public function api_login_social_method() {		// if not token => register new
		$this->Api->init_result();

		if ($this->request->is('post')) {
            $this->disableCache();
            $status = 999;
            $message = "";
            $params = (object)array();
			$data = $this->request->data;
			
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';

			} elseif  ( (!isset($data['email']) || empty($data['email'])) ) {
				$message = __('missing_parameter') .  'email';
				
			} elseif  ( (!isset($data['email']) || empty($data['email'])) ) {
				$message = __('missing_parameter') .  'email';

			} elseif  ( (!isset($data['social_uuid']) || empty($data['social_uuid'])) ) {
				$message = __('missing_parameter') .  'social_uuid';

			} elseif  ( (!isset($data['name']) || empty($data['name'])) ) {
				$message = __('missing_parameter') .  'name';

			} elseif  ( (!isset($data['social_type']) || empty($data['social_type'])) ) {	// 1: FB, 2: Google
				$message = __('missing_parameter') .  'social_type';

			} else {

				$obj_LoginMethod = ClassRegistry::init('Member.LoginMethod');
				$login_method_id = array();
				if ($data['social_type'] == 1) {
					$login_method_id = Environment::read('fb_app.login_method_id');

				} elseif ($data['social_type'] == 2) {
					$login_method_id = Environment::read('gg_app.login_method_id');

				} 

				$this->Api->set_language($data['language']);

				// $this->Member
                $url_params = $this->request->params;
                $this->Api->set_post_params($url_params, $data);
				$this->Api->set_save_log(true);

				$db = $this->MemberLoginMethod->getDataSource();
				$db->begin();

				// check verified from link
				if (isset($data['username_link']) && !empty($data['username_link']) && 
					isset($data['school_id_link']) && !empty($data['school_id_link']) && 
					isset($data['role_id_link']) && !empty($data['role_id_link']) ) {

					$obj_InviteMemberHistory = ClassRegistry::init('Member.InviteMemberHistory');
					$result_InviteMemberHistory = $obj_InviteMemberHistory->get_obj($data['role_id_link'], $data['school_id_link'], $data['username_link']);
				
					if (!$result_InviteMemberHistory) {		// don't exist link invite
						$status 	= 999;
						$message = __d('member', 'link_invite_not_availabled');
						goto return_result;
					} else {

						if ($result_InviteMemberHistory['InviteMemberHistory']['verified'] == true) {
							$status 	= 999;
							$message = __d('member', 'link_invite_used');
							goto return_result;
						}
					}
				}


				$result = $this->MemberLoginMethod->login_social_method($data, $login_method_id);

                $status 	= $result['status'];
				$message 	= $result['message'];
				$type 		= $result['params']['type'];
			    
                if ($status == 200) {

					// update avatar_link (optional)
					if (isset($data['avatar_link']) && !empty($data['avatar_link']) && $type == 0) {
						// download avatar
						try {
							$ch = curl_init($data['avatar_link']);

							$upload_folder = WWW_ROOT;
							$upload_folder .= 'uploads' . DS . 'MemberImage';
							
							if(!file_exists($upload_folder)){
								@mkdir($upload_folder, 0777, true);
							}
						
							$folder = new Folder($upload_folder, true, 0777);

							if ($folder) {
								$ext  = '.jpg';
								// rename the uploaded file
								$renamed_file = date('Ymd-Hi') . '-' . 'fbimage-' .uniqid() .  $ext;

								$fp = fopen($upload_folder . "/" . $renamed_file, 'wb');
								curl_setopt($ch, CURLOPT_FILE, $fp);
								curl_setopt($ch, CURLOPT_HEADER, 0);
								curl_exec($ch);
								curl_close($ch);
								fclose($fp);

								$obj_ImageType = ClassRegistry::init('Dictionary.ImageType');
								$result_ImageType = $obj_ImageType->find_id_by_slug('member-avatar');
								if (!$result_ImageType) {
									$db->rollback();
									$status 	= 999;
									$message 	= __d('member', 'invalid_image_type');
									goto return_result;
								}

								$data_MemberImage  = array(
									'member_id' => $result['params']['member_id'],
									'width' 	=> isset($data['width']) ? $data['width'] : 0,
									'height' 	=> isset($data['height']) ? $data['height'] : 0,
									'size' 		=> isset($data['size']) ? $data['size'] : 0,
									'image_type_id' => $result_ImageType['ImageType']['id'],
									'path' 		=> "uploads/MemberImage/" . $renamed_file,
									'enabled' 	=> true
								);

								if (!empty($data_MemberImage)) {
									
									$obj_MemberImage = ClassRegistry::init('Member.MemberImage');
									if (!$obj_MemberImage->saveAll($data_MemberImage)) {
										$db->rollback();
										$status = 999;
										$message = __('data_is_not_saved') . " Member Image";
										goto return_result;
									}
								}
							}
						
						} catch(Exception $ex) {
							$db->rollback();
							$message =  $ex->getMessage();
							$status = 800;
							goto return_result;
						}
					}

                    $params = $result['params'];
                    if (!$params) {
                        $params = (object)array();
					}
					
					$db->commit();

				} else {
					$db->rollback();
				}
			}

			return_result:
            $this->Api->set_result($status, $message, $params);	// param = token when login
        }
        
		$this->Api->output();
	}


	public function api_login() {	// web

		$this->Api->init_result();

        if ($this->request->is('post')) {

			$this->disableCache();

			$status =  999;
			$message = "";

			$results = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['password']) || empty($data['password'])) {
                $message = __('missing_parameter') .  'password';

			} elseif (!isset($data['username']) || empty($data['username'])) {
				$message = __('missing_parameter') . "username";

			
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);

				$data['username'] = strtolower($data['username']);

				// check verified from link
				if (isset($data['username_link']) && !empty($data['username_link']) && 
					isset($data['school_id_link']) && !empty($data['school_id_link']) && 
					isset($data['role_id_link']) && !empty($data['role_id_link']) ) {

					$data['username_link'] = strtolower($data['username_link']);

					$obj_InviteMemberHistory = ClassRegistry::init('Member.InviteMemberHistory');
					$result_InviteMemberHistory = $obj_InviteMemberHistory->get_obj($data['role_id_link'], $data['school_id_link'], $data['username_link']);
				
					if (!$result_InviteMemberHistory) {		// dont exist link invite
						$status 	= 999;
						$message = __d('member', 'link_invite_not_availabled');
						goto load_api_data;
					} else {

						if ($result_InviteMemberHistory['InviteMemberHistory']['verified'] == true) {
							$status 	= 999;
							$message = __d('member', 'link_invite_not_availabled') . "!";
							goto load_api_data;
						}
					}
				}


				$temp = $this->MemberLoginMethod->login($data);
				$status 	= $temp['status'];
				$message 	= $temp['message'];
				$results 	= $temp['result'];

				if ($status == 903) {	// send mail verified again
					$template = "register_confirm_" . $data['language'];
					$data_email = array(
						'username' => $data['username'],
						'code' => $temp['result']['register_code'],
					);

					$email = $temp['result']['email'];

					$result_email = $this->Email->send($email,  __d('member', 'active_register_code'), $template, $data_email);
				
					if ($result_email['status'])  {
						$status = 903;
						$email_filter = $this->filter_email_info($email);
						
						$message = sprintf (__d('member', 'send_mail_register_success_with_member'), $email_filter);

					} else {
						$status = 999;
						$message = $result_email['message'];
					}
				}
			}

			load_api_data:
            $this->Api->set_result($status, $message, $results);
        }

		$this->Api->output();
	}


	public function api_logout() {	// web

		$this->Api->init_result();

        if ($this->request->is('post')) {

			$this->disableCache();

			$status =  999;
			$message = "";
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['token']) || empty($data['token'])) {
				$message = __('missing_parameter') . "token";
			
			} else {
				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);

				$result_MemberLoginMethod = $this->MemberLoginMethod->get_data_from_token($data['token']);
				if (!$result_MemberLoginMethod) {
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_api_data;
				}

				$result = $this->MemberLoginMethod->logout($result_MemberLoginMethod['MemberLoginMethod']['member_id']);
				if ($result) {
					$status = $result['status'];
					$message = $result['message'];

				} else {
					$status = $result['status'];
					$message = $result['message'];
				}

				goto load_api_data;
			}

			load_api_data:
            $this->Api->set_result($status, $message, (object)array());
        }

		$this->Api->output();
	}

	public function api_get_list_teacher() {	// web

		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";

			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['school_id']) || empty($data['school_id'])) {
				$message = __('missing_parameter') . "school_id";
			
			} else {
				$this->Api->set_language($data['language']);
				$result = $this->MemberLoginMethod->get_list_teacher($data['school_id'], $data['language']);
				$status =  200;
				$message = __('retrieve_data_successfully');
			}

			load_api_data:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}

	public function api_register() {	// web

		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";

			$results = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['username']) || empty($data['username'])) {
                $message = __('missing_parameter') .  'username';

			} elseif (!isset($data['password']) || empty($data['password'])) {
				$message = __('missing_parameter') . "password";

			} elseif (!isset($data['email']) || empty($data['email'])) {
				$message = __('missing_parameter') . "email";

			} elseif (!isset($data['phone_number']) || empty($data['phone_number'])) {
				$message = __('missing_parameter') . "phone_number";
			
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);

				$data['email']  = strtolower($data['email']);
				$data['username']  = strtolower($data['username']);

				// check verified from link
				if (isset($data['username_link']) && !empty($data['username_link']) && 
					isset($data['school_id_link']) && !empty($data['school_id_link']) && 
					isset($data['role_id_link']) && !empty($data['role_id_link']) ) {

					$data['username_link'] = strtolower($data['username_link']);
					$obj_InviteMemberHistory = ClassRegistry::init('Member.InviteMemberHistory');
					$result_InviteMemberHistory = $obj_InviteMemberHistory->get_obj($data['role_id_link'], $data['school_id_link'], $data['username_link']);
					
					if (!$result_InviteMemberHistory) {		// dont exist link invite
						$status 	= 999;
						$message = __d('member', 'link_invite_not_availabled');
						goto load_api_data;
					} else {

						if ($result_InviteMemberHistory['InviteMemberHistory']['verified'] == true) {
							$status 	= 999;
							$message = __d('member', 'link_invite_used');
							goto load_api_data;
						}
					}
					$temp = $this->MemberLoginMethod->register_with_email_invitation($data);

				} else {
					$temp = $this->MemberLoginMethod->register($data);
				}
		
				$status = $temp['status'];
				$message = $temp['message'];
			
				if ($status == 200) {
					$template = "register_confirm_" . $data['language'];
					$data_email = array(
						'username' => $data['username'],
						'code' => $temp['result'],
					);

					//Environment::read('company_name') . 
					// ****
					// $result_email = $this->Email->send($data['email'],  __d('member', 'active_register_code'), $template, $data_email);
				
					// if ($result_email['status'])  {
					// 	$status = 200;
					// 	$email_filter = $this->filter_email_info($data['email']);
					// 	$message = sprintf (__d('member', 'send_mail_register_success_with_member'), $email_filter);

					// } else {
					// 	$status = 999;
					// 	$message = $result_email['message'];
					// }
					$status = 200;
					$message = 'dang ky thanh cong';

				}
			}

			load_api_data:
            $this->Api->set_result($status, $message, $results);
        }

		$this->Api->output();
	}

	// confirm register
	public function api_confirm_register() {	// web

		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['username']) || empty($data['username'])) {
                $message = __('missing_parameter') .  'username';

			} elseif (!isset($data['register_code']) || empty($data['register_code'])) {
				$message = __('missing_parameter') . "register_code";
			
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);
				$data['school_id'] = Environment::read('self_register');	// 0

				$temp = $this->MemberLoginMethod->confirm_register($data);
		
				$status = $temp['status'];
				$message = $temp['message'];
				$result = $temp['result'];
			}

			load_api_data:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}

	public function api_get_list_teachers() {	// web

		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['school_id']) || empty($data['school_id'])) {
                $message = __('missing_parameter') .  'school_id';
			
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);
				$result = $this->School->get_list_school_by_id($data['school_id'], $data['language']);
		
				$status 	= 200;
				$message 	= __('retrieve_data_successfully');
			}

			load_api_data:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}

	public function api_get_profile() {
		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";

			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['token']) || empty($data['token'])) {
				$message = __('missing_parameter') . "token";
			
			} else {
				$this->Api->set_language($data['language']);

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);
				
				$result_MemberLoginMethod = $this->MemberLoginMethod->get_data_from_token($data['token']);

				if (!$result_MemberLoginMethod) {
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_data_api;
				}
				$result = $this->MemberLoginMethod->get_profile($result_MemberLoginMethod['MemberLoginMethod']['id'], $data['language']);
				$status =  200;
				$message = __('retrieve_data_successfully');
			}

			load_data_api:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}

	public function api_reset_password() {
		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";

			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['token']) || empty($data['token'])) {
				$message = __('missing_parameter') . "token";

			} elseif (!isset($data['old_password']) || empty($data['old_password'])) {
				$message = __('missing_parameter') . "old_password";
			
			} elseif (!isset($data['new_password']) || empty($data['new_password'])) {
				$message = __('missing_parameter') . "new_password";
			
			} else {
				$this->Api->set_language($data['language']);

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);
				
				$result_MemberLoginMethod = $this->MemberLoginMethod->get_data_from_token($data['token']);

				if (!$result_MemberLoginMethod) {
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_data_api;
				}
				$result = $this->MemberLoginMethod->get_profile($result_MemberLoginMethod['MemberLoginMethod']['id'],  $data['language']);
				
				$obj_Member = ClassRegistry::init('Member.Member');
				$data['old_password'] = $obj_Member->set_password($data['old_password']);
				if ($result['MemberLoginMethod']['password'] != $data['old_password']) {
					$status = 999;
					$message = __d('member', 'invalid_password');
					goto load_data_api;
				} 

				$id = $result_MemberLoginMethod['MemberLoginMethod']['id'];
				// $member_id = $result_MemberLoginMethod['MemberLoginMethod']['member_id'];
				// $school_id = $result_MemberLoginMethod['MemberLoginMethod']['login_method_id'];
				$username = $result_MemberLoginMethod['MemberLoginMethod']['username'];

				$this->MemberLoginMethod->id 		= $id;
				$this->MemberLoginMethod->saveField('password', $obj_Member->set_password($data['new_password']));

				// check this role is schooladmin?
				$obj_Administrator = ClassRegistry::init('Administration.Administrator');
				$administor_id = $obj_Administrator->get_id_by_email($username, $result['MemberLoginMethod']['member_id']);

				if ($administor_id) {
					$obj_Administrator->id = $administor_id;
					$obj_Administrator->saveField('password', $obj_Member->set_password($data['new_password']));
				}

				$status =  200;
				$message = __('change_password_successfully');
			}

			load_data_api:
            $this->Api->set_result($status, $message,  (object)array());
        }

		$this->Api->output();
	}



	public function api_forgot_password() {
	
		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";

			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['email']) || empty($data['email'])) {
				$message = __('missing_parameter') . "email";
			
			} else {
				$this->Api->set_language($data['language']);

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				// check in db is this email exist, if yes -> send mail

				$obj_Member = ClassRegistry::init('Member.Member');

				$conditions = array(
					'Member.email' => $data['email'],
				);
				if ($result_Member = $obj_Member->get_obj_with_conditions($conditions)) {	// exist -> send mail

					$forgot_key = strtoupper(md5(uniqid(time())));
					
					// update forgot key to member
					$data_Member = array(
						'forgot_key' => $forgot_key,
						'id' => $result_Member['Member']['id'],
					);
					if (!$obj_Member->save($data_Member)) {
						$status = 999;
						$message = __('data_is_not_saved') . " Member!";
					}

					
					$result_MemberLoginMethod = $this->MemberLoginMethod->get_obj_by_member_id($result_Member['Member']['id']);

					$school_code = array();
					if ($result_MemberLoginMethod['MemberLoginMethod']['login_method_id'] != 0 &&  
						$result_MemberLoginMethod['MemberLoginMethod']['login_method_id'] != 900001 &&
						$result_MemberLoginMethod['MemberLoginMethod']['login_method_id'] != 900002) {

							$obj_School = ClassRegistry::init('School.School');
							$result_School = $obj_School->get_obj($result_MemberLoginMethod['MemberLoginMethod']['login_method_id']);
							$school_code = $result_School['School']['school_code'];
					}

					// https://all4learn.com/forgot_password?key=2FHIOHFOAKASDHWHCHGFJJOJFOGKCB
					$data_Email = array(
						'link' 		=> Router::url('/', true) . 'forgot_password?key=' . $forgot_key,
						'username'	=> $result_MemberLoginMethod['MemberLoginMethod']['username'],
						'school_code' => $school_code,
					);
			
					$template = "forgot_password_" . $this->lang18;
					$result_email = $this->Email->send($data['email'], __d('member', 'forgot_password'), $template, $data_Email);
				
					if ($result_email['status'])  {
						$status = 200;
						$email_filter = $this->filter_email_info($data['email']);
						
						$message = sprintf (__d('member', 'send_mail_forgot_success_with_member'), $email_filter);
						if( Environment::is('development') ){
							$message = sprintf (__d('member', 'send_mail_forgot_success_with_member') . ' ' . $forgot_key, $email_filter);
						}
						

					} else {
						$status = 999;
						$message = $result_email['message'];
					}
				} else {
					$status = 999;
					$message = __d('member', 'email_does_not_exist');
				}
			}

			load_data_api:
            $this->Api->set_result($status, $message,  (object)array());
        }

		$this->Api->output();
	}

	public function api_use_link_reset_password() {
		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";

			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['key']) || empty($data['key'])) {
				$message = __('missing_parameter') . "key";

			} elseif (!isset($data['password']) || empty($data['password'])) {
				$message = __('missing_parameter') . "password";
			
			} else {
				$this->Api->set_language($data['language']);

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);


				$db = $this->MemberLoginMethod->getDataSource();
				$db->begin();

				$obj_Member 			= ClassRegistry::init('Member.Member');

				$conditions = array(
					'Member.forgot_key' => $data['key'],
				);
				if ($result_Member = $obj_Member->get_obj_with_conditions($conditions)) {

					// get member login method;
					$result_MemberLoginMethod = $this->MemberLoginMethod->get_all_login_method_by_member_id($result_Member['Member']['id']);

					if ($result_MemberLoginMethod) {

						$data_MemberLoginMethod = array();
						foreach ($result_MemberLoginMethod as $value) {

							// change password
							$data_MemberLoginMethod[] = array(
								'id' 		=> $value['MemberLoginMethod']['id'],
								'password' 	=> $data['password'],
							);
						}

						// save all
						if (!$this->MemberLoginMethod->saveAll($data_MemberLoginMethod)) {	// reupdate pw
							$db->rollback();
							$status = 999;
							$message = __('data_is_not_saved') . " MemberLoginMethod";
						}

						// remove key from member 
						$obj_Member->id = $result_Member['Member']['id'];
						$obj_Member->save('forgot_key', array());

						$db->commit();
						$status = 200;
						$message = __('data_is_saved');

					} else {
						$db->rollback();
						$status = 999;
						$message = __('data_not_change');
					}
					
				} else {
					$db->rollback();
					$status = 999;
					$message = __('invalid_data') . ' (key)';
				}
			}

			load_data_api:
            $this->Api->set_result($status, $message,  (object)array());
        }

		$this->Api->output();
	}

	public function api_get_member_belong_school_with_role_pagination() {
		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$results = array();

			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['token']) || empty($data['token'])) {
				$message = __('missing_parameter') . "token";

			} elseif (!isset($data['school_id']) || empty($data['school_id'])) {
				$message = __('missing_parameter') . "school_id";

			} elseif (!isset($data['role']) || empty($data['role'])) {
				$message = __('missing_parameter') . "role";

			// } elseif (!isset($data['group_id'])) {
			// 	$message = __('missing_parameter') . "group_id";

			// } elseif (!isset($data['offset'])) {
			// 	$message = __('missing_parameter') . "offset";

			// } elseif (!isset($data['limit'])) {
			// 	$message = __('missing_parameter') . "limit";

			} elseif (!isset($data['search_text'])) {	// search on UI
				$message = __('missing_parameter') . "search_text";

			} else {
				$this->Api->set_language($data['language']);

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$result_MemberLoginMethod = $this->MemberLoginMethod->get_data_from_token($data['token']);
				if (!$result_MemberLoginMethod) {
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_data_api;
				}

				// Check is this member manage this school
				$cond = array(
					'MemberManageSchool.school_id' => $data['school_id'],
					'MemberManageSchool.member_id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
				);
				$obj_MemberManageSchool = ClassRegistry::init('Member.MemberManageSchool');
				if (!$obj_MemberManageSchool->hasAny($cond)) {
					$status = 600;
					$message = __d('member', 'invalid_role');
					goto load_data_api;
				}

				$group_id 	= isset($data['group_id']) ? $data['group_id'] : array();
				$limit		= isset($data['limit']) ? $data['limit'] : array();
				$offset 	= isset($data['offset']) ? $data['offset'] : array();

				$temp = $this->MemberLoginMethod->Member->get_member_belong_school_with_role_pagination(
					$result_MemberLoginMethod['MemberLoginMethod']['member_id'],
					$data['school_id'], json_decode($data['role']), 
					$group_id,
					$data['language'], 
					$offset, 
					$limit, 
					$data['search_text']);

				$results['content'] = $temp['content'];
				$results['total'] = $temp['total'];
				

				$status = 200;
				$message = __('retrieve_data_successfully');
			}

			load_data_api:
            $this->Api->set_result($status, $message,  $results);
        }

		$this->Api->output();
	}
}
