<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * MemberLoginMethod Model
 *
 * @property Member $Member
 * @property LoginMethod $LoginMethod
 */
class MemberLoginMethod extends MemberAppModel {

	public $actsAs = array('Containable');
	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Member' => array(
			'className' => 'Member.Member',
			'foreignKey' => 'member_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'School' => array(
			'className' => 'School.School',
			'foreignKey' => 'school_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function get_data_from_token($token) {

		$result = $this->find('first', array(
			'conditions' 	=> array(
				'MemberLoginMethod.token' => $token,
				'MemberLoginMethod.enabled' => true,
			),
			'fields'		=> array(
				'MemberLoginMethod.*',
			),
			'contain' => array(
				'Member' => array(
					'MemberRole' => array(
						'fields' => array(
							'MemberRole.*',
						),
					),
				),
				'School' => array(
					'fields' => array(
						'School.school_code',
					),
				),
			),
		));

		if ($result) {

			$result_MemberLoginMethod = $this->find('all', array(
				'conditions' 	=> array(
					'MemberLoginMethod.member_id' => $result['MemberLoginMethod']['member_id'],
					'MemberLoginMethod.enabled' => true,
				),
				'fields'		=> array(
					'MemberLoginMethod.id',
				),
				'contain' => array(
					'Member' => array(
						'MemberRole' => array(
							'fields' => array(
								'MemberRole.*',
							),
						),
					),
					'School' => array(
						'fields' => array(
							'School.school_code',
						),
					),
				),
			));

			foreach ($result_MemberLoginMethod as $val) {
				$result['Member']['MemberRole'] = array_merge($result['Member']['MemberRole'], $val['Member']['MemberRole']);
				$result['Member']['LoginMethod'][] = $val['School'];
			}		
		}
		return $result;
	}

	// login_facebook, google, ... method

	public function get_member_with_uuid($uuid, $email, $login_method_id) {

		$conditions = array();
		$obj_Member = ClassRegistry::init('Member.Member');
		if ($login_method_id == Environment::read('fb_app.login_method_id')) {
			$conditions = array(
				'Member.facebook_id' 		=> $uuid,
				'Member.email' 				=> $email,
			);

		
		} elseif ($login_method_id == Environment::read('gg_app.login_method_id')) {
			$conditions = array(
				'Member.google_id' 			=> $uuid,
				'Member.email' 				=> $email,
			);
		}
		return $obj_Member->find('first', array(
			'fields' => array(
				'Member.*',
			),
			'conditions' => $conditions,
			'contain' => array(
				'MemberLoginMethod' => array(
					'conditions' => array(
						'MemberLoginMethod.username' => array(),
						'MemberLoginMethod.password' => array(),
						'MemberLoginMethod.school_id' => array(),
					),
				),
			),
		));
	}

	public function login_social_method($data, $login_social_method) {
		
		// generate token -------
		$token = $this->generateToken_advance(16);

		$status = 999;
		$message = "";

		$new_user = 0;
		$exist_user = 1;

		$member_id = array();
		$type = $new_user;			///  0: new users, 1: exists users

		$obj_Member = ClassRegistry::init('Member.Member');
		$obj_ImageType = ClassRegistry::init('Dictionary.ImageType');

		$result_ImageType = $obj_ImageType->find_id_by_slug('member-avatar');
		if (!$result_ImageType) {
			$status = 999;
			$message = __('cannot_find') . ' Image Type';
			goto return_data;
		}

		if (isset($data['username_link']) && !empty($data['username_link']) && 
			isset($data['school_id_link']) && !empty($data['school_id_link']) && 
			isset($data['role_id_link']) && !empty($data['role_id_link']) ) {
			$obj_InviteMemberHistory =  ClassRegistry::init('Member.InviteMemberHistory');

			$data['username_link'] = strtolower($data['username_link']);
			$update = $obj_InviteMemberHistory->updateAll(
				array(
					'InviteMemberHistory.verified' => true,
				), 
				array(
					'InviteMemberHistory.role_id' => $data['role_id_link'],
					'InviteMemberHistory.school_id' => $data['school_id_link'],
					'InviteMemberHistory.email' => $data['username_link'],
				)
			);
			if (!$update) {
				$status = 999;
				$message = __('data_is_not_saved');
				goto return_data;
			}
		}

		if (!$exist_member = $this->get_member_with_uuid($data['social_uuid'], $data['email'], $data['login_method_id'])) { // => register new

			$data_Member = array(
				'verified'  	=> 1, 
				'phone_number' 	=> isset($data['phone_number']) ? $data['phone_number'] : array(),
				'join_date' 	=> date('Y-m-d H:i:s'),
			);

			if ($login_social_method == Environment::read('fb_app.login_method_id')) {
				$data_Member['facebook_id'] = $data['social_uuid'];

			} elseif ($login_social_method == Environment::read('gg_app.login_method_id')) {
				$data_Member['google_id'] = $data['social_uuid'];
			
			}
		
			if ($model_Member = $obj_Member->save($data_Member)) {
				$member_id = $model_Member['Member']['id'];

				// save login method;
				$data_MemberLoginMethod = array(
					'member_id' => $model_Member['Member']['id'],
					'username' 	=> array(),
					'password' 	=> array(),
					'token'	 	=> $token,
					'school_id'	=> array(),
				);
				if (!$this->save($data_MemberLoginMethod)) {
					$message = __('data_is_not_saved') . " Member Login Method";
					$status = 999;
					goto return_data;
				}
				$this->clear();

				$obj_MemberLanguage = ClassRegistry::init('Member.MemberLanguage');
				$data_MemberLanguage = $obj_MemberLanguage->generate_all_member_language($data['name'], $model_Member['Member']['id'], array(), array());
							
				if (!$obj_MemberLanguage->saveAll($data_MemberLanguage)) {
					$message = __('data_is_not_saved') . " Member Language";
					$status = 999;
					goto return_data;
				}
				
			} else {
				$message = __('data_is_not_saved') . " Member Login Method";
				$status = 999;
				goto return_data;
			}

		} else {	// exist email (self-register before) => login
			
			$member_id = $exist_member['Member']['id'];
			$data_Member = array(
				'id' 		=> $member_id,
				'username'  => $data['social_uuid'],
				'email'  	=> $data['email'],
				'verified'  => 1, 
			);

			if (count($exist_member['MemberLoginMethod']) == 0) {
				$status = 999;
				$message = __('retrieved_data_failed') . " Member login method";
				goto return_data;
			}

			$member_id = $exist_member['Member']['id'];
			$type = $exist_user;

			$data_MemberLoginMethod = array(
				'id'		=> reset($exist_member['MemberLoginMethod'])['id'],
				'member_id' => $member_id,
				'username' 	=> array(),
				'password'	=> array(),
				'token'	 	=> $token,
			);
			
			// save token to member login method
			if (!$this->save($data_MemberLoginMethod )) {
				$status = 999;
				$message = __('data_is_not_saved') . " Member login method";
				goto return_data;
			}
			$this->clear();
		}
	
		$status = 200;
		$message = __d('member', 'login_success');

		// binding account here
		if (isset($data['username_link']) && !empty($data['username_link']) && 
			isset($data['school_id_link']) && !empty($data['school_id_link'])) {

			$username_link 		= strtolower($data['username_link']);
			$login_method_id 	= $data['school_id_link'];
			$is_exist = $this->check_exist($username_link, $login_method_id);

			if (!$is_exist) {
				$data_MemberLoginMethod = array(
					'member_id' => $member_id,
					'username' 	=> $username_link,
					'password' 	=> $data['social_token'],
					'school_id' => $data['school_id_link'],
				);

				if (!$this->save($data_MemberLoginMethod)) {
					$status 	= 999;	
					$message 	= __d('member', 'binding_account_failed');
					goto return_data;
				}
				$this->clear();
			}
		
			// $school_ids = $this->get_school_ids($member_id);

			// add register role to Member Role
			$obj_MemberRole = ClassRegistry::init('Member.MemberRole');

			// check exist
			$role_id = isset($data['role_id_link']) && !empty($data['role_id_link']) 		? $data['role_id_link'] : Environment::read('role.register');
			$school_id = isset($data['school_id_link']) && !empty($data['school_id_link']) 	? $data['school_id_link'] : Environment::read('self_register');

			$is_exist = $obj_MemberRole->check_exist($member_id, $role_id, $school_id);
			if (!$is_exist) {
				$data_MemberRole = array(
					'member_id' => $member_id,
					'role_id' 	=> $role_id,
					'school_id'	=> $school_id,
				);
				if (!$obj_MemberRole->save($data_MemberRole)) {
					$status = 999;	
					$message = __('data_is_not_saved') . " Member Role";
					goto return_data;
				}
			}
		
			$status = 200;					
			$message = __d('member', 'binding_account_succeed');
		
			goto return_data;
		}

		return_data:
		return array(
			'status' 	=> $status,
			'message' 	=> $message,
			'params' 	=> array(
				'member_id'	=>  $member_id,	// for update avatar
				'type'		=> $type,		// for update avatar for register time
				'token'		=> $token,		// for update avatar for register time
			)
		);
	}

	// login method
	public function login($data) {

		$data['username'] = strtolower($data['username']);
		$db = $this->getDataSource();
		$db->begin();

		$obj_ImageType 	= ClassRegistry::init('Dictionary.ImageType');
		$obj_School 	= ClassRegistry::init('School.School');

		$conditions = array();
		if (isset($data['school_code']) && !empty($data['school_code'])) {
			$result_School = $obj_School->get_obj_by_school_code($data['school_code']);
			$school_code_id = $result_School['School']['id'];
			$conditions = array(
				'MemberLoginMethod.school_id' => 	$school_code_id,
			);
			
		} else {

			$conditions = array(	
				'MemberLoginMethod.school_id' => 	Environment::read('role.register'),		// 100;
			);
		}
		


		$result = $this->find('first', array(
			'fields' => array(
				'MemberLoginMethod.*',
			),
			'conditions' => array_merge($conditions, array(
				'MemberLoginMethod.username' => $data['username'],
			)),
			'contain' => array(
				'Member' => array(
					'fields' => array(
						'Member.id',
						'Member.email',
						'Member.verified',
						'Member.register_code',
					),
					'MemberImage' => array(
						'fields' => array(
							'MemberImage.*',
						),
						'conditions' => array(
							'MemberImage.image_type_id' => $obj_ImageType->get_id_by_slug('member-avatar'),
						),
					),
					'MemberLanguage' => array(
						'fields' => array(
							'MemberLanguage.*',
						),
						'conditions' => array(
							'MemberLanguage.alias' => $data['language'],
						),
					),
					'MemberRole' => array(
						'fields' => array(
							'MemberRole.id',
						),
						'conditions' => array(
							'MemberRole.enabled' => true,
						),
						'Role' => array(
							'fields' => array(
								'Role.*',
							),
						)
					),
				),
			),
		));


		if (isset($data['username_link']) && !empty($data['username_link']) && 
			isset($data['school_id_link']) && !empty($data['school_id_link']) && 
			isset($data['role_id_link']) && !empty($data['role_id_link']) ) {

			$data['username_link'] =  strtolower($data['username_link']);
			$obj_InviteMemberHistory =  ClassRegistry::init('Member.InviteMemberHistory');
			$update = $obj_InviteMemberHistory->updateAll(
				array(
					'InviteMemberHistory.verified' => true,
				), 
				array(
					'InviteMemberHistory.role_id' => $data['role_id_link'],
					'InviteMemberHistory.school_id' => $data['school_id_link'],
					'InviteMemberHistory.email' => $data['username_link'],
				)
			);
			if (!$update) {
				$temp = array(
					'status' => 999,			// invalid_username
					'result' => array(),
					'message' => __('data_is_not_saved'),
				);
				goto load_data;
			}
		}

		$temp = array();
		if (!$result) {
			$temp = array(
				'status' => 901,			// invalid_username
				'result' => array(),
				'message' => __d('member', 'invalid_username'),
			);
			goto load_data;
		}

		if ($result['Member']['verified'] == false) {	// verified = false // send mail again (from controller)
			$temp = array(
				'status' => 903,			
				'result' => array(
					'register_code' => $result['Member']['register_code'],
					'email' => $result['Member']['email'],
				),
				'message' => __d('member', 'member_not_verified'),
			);
			goto load_data;
		}

		$hash_pw = $this->set_password($data['password']); 	// hash('sha256', $data['password'] . Environment::read('secret_key'));
		if ($result['MemberLoginMethod']['password'] != $hash_pw) {
			$temp = array(
				'status' => 902,			// invalid_password
				'result' => array(),
				'message' => __d('member', 'invalid_password'),
			);
			goto load_data;
		}
		
		// gen token
		$token = $this->generateToken_advance(16);
		$tmp = array(
			'id'	=> $result['MemberLoginMethod']['id'],
			'token' => $token,
		);

		// update token
		if (!$this->save($tmp)) {
			$db->rollback();
			$temp = array(
				'status' => 999,					// succeed,
				'result' => $result,
				'message' => __d('administration', 'login_fail'),
			);
			goto load_data;
		}

		$this->clear();

		// return token to client
		$result['MemberLoginMethod']['token'] =  $token;

		// binding account here
		if (isset($data['username_link']) && !empty($data['username_link']) && 
			isset($data['school_id_link']) && !empty($data['school_id_link'])) {

			$username = strtolower($data['username_link']);
			$login_method_id = $data['school_id_link'];
			$is_exist = $this->check_exist($username, $login_method_id);
			if (!$is_exist) {
				$data_MemberLoginMethod = array(
					'member_id' => $result['Member']['id'],
					'username' 	=> $username,
					'password' 	=> $this->set_password($data['password']),
					'school_id' => $data['school_id_link'],
				);

				if (!$this->save($data_MemberLoginMethod)) {
					$db->rollback();
					$temp = array(
						'status' => 999,	
						'result' => array(),
						'message' => __d('member', 'binding_account_failed'),
					);
					goto load_data;
				}
				$this->clear();
			}
		
			$school_ids = $this->get_school_ids($result['Member']['id']);

			// add register role to Member Role
			$obj_MemberRole = ClassRegistry::init('Member.MemberRole');

			// check exist
			$member_id = $result['Member']['id'];
			$role_id = isset($data['role_id_link']) && !empty($data['role_id_link']) ? $data['role_id_link'] : Environment::read('role.register');
			$school_id = isset($data['school_id_link']) && !empty($data['school_id_link']) ? $data['school_id_link'] : Environment::read('self_register');

			$is_exist = $obj_MemberRole->check_exist($member_id, $role_id, $school_id);
			if (!$is_exist) {
				$data_MemberRole = array(
					'member_id' => $member_id,
					'role_id' 	=> $role_id,
					'school_id'	=> $school_id,
				);
				if (!$obj_MemberRole->save($data_MemberRole)) {
					$temp = array(
						'status' => 999,	
						'message' => __('data_is_not_saved') . " Member Role",
					);
					goto load_data;
				}
			}
			
			$db->commit();

			// get name community after binding;
			$obj_School = ClassRegistry::init('School.School');
			$result['Member']['community'] = $obj_School->get_list_school_by_id($school_ids, $data['language']);
		

			$temp = array(
				'status' => 200,					
				'result' => $result,
				'message' => __d('member', 'binding_account_succeed'),
			);
			goto load_data;
		}
		
		// no binding account 
		$db->commit();
		$school_ids = $this->get_school_ids($result['Member']['id']);

		// get name community;
		$obj_School = ClassRegistry::init('School.School');
		$result['Member']['community'] = $obj_School->get_list_school_by_id($school_ids, $data['language']);
		
		$temp = array(
			'status' => 200,					// succeed,
			'result' => $result,
			'message' => __d('administration', 'login_success'),
		);

		load_data:
		return $temp;
	}

	public function logout($member_id) {

		$update = $this->updateAll(
			array(
				'MemberLoginMethod.token' => NULL,
			),
			array(
				'MemberLoginMethod.member_id' => $member_id
			)
		);

		$temp = array(
			'status' => 999,	
			'message' => __d('member', 'logout_failed'),
		);

		if ($update) {
			$temp = array(
				'status' => 200,	
				'message' => __d('member', 'logout_success'),
			);
		}

		return $temp;
	}


	public function register_with_email_invitation($data) {

		$obj_Member = ClassRegistry::init('Member.Member');
		$data['username'] = trim(strtolower($data['username']));
		$data['email'] = trim(strtolower($data['email']));

		// 1a. check conditions
		$result = $obj_Member->find('first', array(
			'fields' => array(
				'Member.*',
			),
			'conditions' => array(
				'Member.email' 			=> $data['email']
			),
		));

		$temp = array();
		if ($result) {
		
			if ($result['Member']['email'] == strtolower($data['email'])) {
				$temp = array(
					'status' => 999,	
					'message' => __d('member', 'exist_email'),
				);
				goto load_data;
			}
		}

		// 1b. check conditions username link
		$result = $this->find('first', array(
			'fields' => array(
				'MemberLoginMethod.id',
			),
			'conditions' => array(
				'MemberLoginMethod.username' 			=> $data['username_link'],
				'MemberLoginMethod.school_id' 			=> $data['school_id_link'],
			),
		));

		$temp = array();
		if ($result) {
			$temp = array(
				'status' => 999,	
				'message' => __d('member', 'exist_username') . "!!",
			);

			goto load_data;
		}

		$db = $this->getDataSource();
		$db->begin();

		// save Member
		$register_code = $this->gen_random_number(4);
		$data_Member = array(
		//	'username' 	=> $data['school_id_link'] . "_" . $data['username'],
			'email' 	=> $data['email'],								// gen email
			'phone_number'		=> $data['phone_number'],
			'invitation_code' 	=> isset($data['invitation_code']) ? $data['invitation_code'] : array(),					
			'register_code'	=> $register_code,							// gen register code
			'join_day'	=> date('Y-m-d H:i:s'),
		);
		
		if (!$model_Member = $obj_Member->save($data_Member)) {
			$db->rollback();
			$temp = array(
				'status' => 999,	
				'message' => __('data_is_not_saved') . " Member",
			);
			goto load_data;
		}

		// save Member Language
		$obj_MemberLanguage = ClassRegistry::init('Member.MemberLanguage');
		$data_MemberLanguage = $obj_MemberLanguage->generate_all_member_language($data['name'], $model_Member['Member']['id']);
		
		if (!$obj_MemberLanguage->saveAll($data_MemberLanguage)) {
			$db->rollback();
			$temp = array(
				'status' => 999,	
				'message' => __('data_is_not_saved') . " Member Language",
			);
			goto load_data;
		}

		// add register role to Member Role
		$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
	
		$data_MemberRole = array();
		$member_id 	= $model_Member['Member']['id'];
		$role		= Environment::read('role.register');	// 100
		$school_id 	= array();
		$is_exist = $obj_MemberRole->check_exist($member_id, $role, $school_id);
		if (!$is_exist) {
			$data_MemberRole[] = 	array(
				'member_id' => $member_id,
				'role_id' 	=> $role,	
				'school_id' => $school_id,
			);
		}

		$member_id 	= $model_Member['Member']['id'];
		$role		= $data['role_id_link'];
		$school_id 	= $data['school_id_link'];
		$is_exist = $obj_MemberRole->check_exist($member_id, $role, $school_id);
		if (!$is_exist) {
			$data_MemberRole[] = 	array(
				'member_id' => $member_id,
				'role_id' 	=> $role,	
				'school_id' => $school_id,
			);
		}

		if (!$obj_MemberRole->saveAll($data_MemberRole)) {
			$db->rollback();
			$temp = array(
				'status' => 999,	
				'message' => __('data_is_not_saved') . " Member Role",
			);
			goto load_data;
		}

		$data_MemberLoginMethod = array();
		$username 				= $data['username'];
		$school_id				= Environment::read('self_register');	// 0
		$is_exist = $this->check_exist($username, $school_id);
		if (!$is_exist) {
			$data_MemberLoginMethod[] = 	array(
				'username' 	=> $username,
				'password' 	=> $this->set_password($data['password']),
				'member_id'	=> $member_id,
				'school_id'	=> $school_id,
			);
		}

		$username 				= $data['username_link'];
		$school_id				= $data['school_id_link'];
		$is_exist = $this->check_exist($username, $school_id);
		if (!$is_exist) {
			$data_MemberLoginMethod[] = 	array(
				'username' 	=> $username,
				'password' 	=> $this->set_password($data['password']),
				'member_id'	=> $member_id,
				'school_id'	=> $school_id,
			);
		}

		if (!$this->saveAll($data_MemberLoginMethod)) {
			$db->rollback();
			$temp = array(
				'status' => 999,	
				'message' => __('data_is_not_saved') . " Member Login Method",
			);
			goto load_data;
		}


		if (isset($data['username_link']) && !empty($data['username_link']) && 
			isset($data['school_id_link']) && !empty($data['school_id_link']) && 
			isset($data['role_id_link']) && !empty($data['role_id_link']) ) {

			$data['username_link'] = strtolower($data['username_link']);

			$obj_InviteMemberHistory =  ClassRegistry::init('Member.InviteMemberHistory');
			$update = $obj_InviteMemberHistory->updateAll(
				array(
					'InviteMemberHistory.verified' => true,
				), 
				array(
					'InviteMemberHistory.role_id' 	=> $data['role_id_link'],
					'InviteMemberHistory.school_id' => $data['school_id_link'],
					'InviteMemberHistory.email' 	=> $data['username_link'],
				)
			);
			if (!$update) {
				$temp = array(
					'status' => 999,			// invalid_username
					'message' => __('data_is_not_saved') . " Invite Member History",
				);
				goto load_data;
			}
		}

		$db->commit();

		$temp = array(
			'status' => 200,					// succeed,
			'result' => $register_code,
			'message' => '',
		);

		load_data:
		return $temp;
	}

	// register normal flow
	public function register($data) {

		$obj_Member = ClassRegistry::init('Member.Member');
		$data['email'] 		= trim(strtolower($data['email']));
		$data['username'] 	= trim(strtolower($data['username']));

		$result = $obj_Member->find('first', array(
			'fields' => array(
				'Member.*',
			),
			'conditions' => array(
				'Member.email' 			=> $data['email'],
			),
		));

		$temp = array();
		if ($result) {
			if ($result['Member']['email'] == ($data['email'])) {
				$temp = array(
					'status' => 999,	
					'message' => __d('member', 'exist_email'),
				);
				goto load_data;
			}
		}

		// check exist form member login method
		$conditions = array(
			'MemberLoginMethod.username' => $data['username'],
			'MemberLoginMethod.school_id' => Environment::read('self_register'),		// sell register
			
		);
		if ($this->hasAny($conditions)) {
			$temp = array(
				'status' => 999,	
				'message' => __d('member', 'exist_username'),
			);
			goto load_data;
		}

		$db = $this->getDataSource();
		$db->begin();

		// save Member
		$register_code = $this->gen_random_number(4);
		$data_Member = array(
			//'username' 	=> $data['username'],
			'email' 			=> $data['email'],								// gen email
			'phone_number'		=> $data['phone_number'],
			'invitation_code' 	=> isset($data['invitation_code']) ? $data['invitation_code'] : array(),					
			'register_code'		=> $register_code,							// gen register code
			'join_day'			=> date('Y-m-d H:i:s'),
		);
		if (!$model_Member = $obj_Member->save($data_Member)) {
			$db->rollback();
			$temp = array(
				'status' => 999,	
				'message' => __('data_is_not_saved') . " Member",
			);
			goto load_data;
		}

		// save Member Language
		$obj_MemberLanguage = ClassRegistry::init('Member.MemberLanguage');

		$data_MemberLanguage = $obj_MemberLanguage->generate_all_member_language(isset($data['name']) ? $data['name'] : array(), $model_Member['Member']['id']);

		if (!$obj_MemberLanguage->saveAll($data_MemberLanguage)) {
			$db->rollback();
			$temp = array(
				'status' => 999,	
				'message' => __('data_is_not_saved') . " Member Language",
			);
			goto load_data;
		}

		// add register role to Member Role
		$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
		$data_MemberRole = array(
			'member_id' => $model_Member['Member']['id'],
			'role_id' 	=> Environment::read('role.register'),	// 100
			'school_id' 	=> array(),
		);
		if (!$obj_MemberRole->save($data_MemberRole)) {
			$db->rollback();
			$temp = array(
				'status' => 999,	
				'message' => __('data_is_not_saved') . " Member Role",
			);
			goto load_data;
		}

		// save Member Login Methods
		$data_MemberLoginMethod = array(
			'username' 	=> $data['username'],
			'password' 	=> $this->set_password($data['password']),
			'member_id'	=> $model_Member['Member']['id'],
			'school_id'	=> Environment::read('self_register'),	// 0
		);

		if (!$this->save($data_MemberLoginMethod)) {
			$db->rollback();
			$temp = array(
				'status' => 999,	
				'message' => __('data_is_not_saved') . " Member Login Method",
			);
			goto load_data;
		}

		$db->commit();

		$temp = array(
			'status' => 200,					// succeed,
			'result' => $register_code,
			'message' => '',
		);
	
		load_data:
		return $temp;
	}

	public function get_list_teacher($school_id = array(), $language) {
	
		$conditions = array();
		if ($school_id) {
			$conditions = array(
				'MemberLoginMethod.school_id' => $school_id,
			);
		}
		return $this->find('list', array(
			'fields' => array(
				'MemberLoginMethod.member_id',
				'MemberLanguage.name',
			),
			'conditions' => $conditions,
			'joins' => array(
				array(
					'alias' => 'MemberLanguage',
					'table' => Environment::read('table_prefix') . 'member_languages',
					'type' => 'INNER',
					'conditions' => array(
						'MemberLanguage.member_id = MemberLoginMethod.member_id',
						'MemberLanguage.alias' => $language,
					),
				),
				array(
					'alias' => 'MemberRole',
					'table' => Environment::read('table_prefix') . 'member_roles',
					'type' => 'INNER',
					'conditions' => array(
						'MemberRole.member_id = MemberLoginMethod.member_id',
						'MemberRole.role_id' => Environment::read('role.teacher'),
					),
				),
				
			),
 		));
	}

	public function get_list($school_id) {
		$obj_Member = ClassRegistry::init('Member.MemberLoginMethod');
		$result = $obj_Member->find('list', array(
			'conditions' => array(
				'MemberLoginMethod.school_id' => $school_id,
			),
			'fields' => array(
				'MemberLoginMethod.id',
				'MemberLoginMethod.username',
			),
		));
		
		return $result;
	}


	public function confirm_register($data) {	///////////>>>>>>>?????

		$obj_Member = ClassRegistry::init('Member.Member');

		$result_MemberLoginMethod = $this->find('first', array(
			'conditions' => array(
				'MemberLoginMethod.username' 	=> $data['username'],
				'MemberLoginMethod.school_id' 	=> $data['school_id'],
			),
 			'fields' => array(
				'MemberLoginMethod.member_id',
			),
		));

		if (!$result_MemberLoginMethod) {
			$temp = array(
				'status' => 901,				// invalid_username
				'result' => array(),
				'message' => __d('member', 'invalid_username!'),
			);
			goto load_data;
		}

		$result = $obj_Member->find('first', array(
			'conditions' => array(
				'Member.id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
			),
			'fields' => array(
				'Member.register_code',
				'Member.id',
			),
		));

		$temp = array();
		if (!$result) {

			$temp = array(
				'status' => 901,			// invalid_username
				'result' => array(),
				'message' => __d('member', 'invalid_username'),
			);
			goto load_data;
		}

		if ($result['Member']['register_code'] != $data['register_code']) {
			$temp = array(
				'status' => 999,			// invalid_register_code
				'result' => array(),
				'message' => __d('member', 'invalid_register_code'),
			);
			goto load_data;
		}

		// update verified = true;
		$data_Member = array(
			'id' 		=> $result['Member']['id'],
			'verified' 	=> true,
		);

		if (!$obj_Member->save($data_Member)) {
			$temp = array(
				'status' => 999,			
				'result' => array(),
				'message' => __('data_is_not_saved') . "Member",
			);
			goto load_data;
		}

		$temp = array(
			'status' => 200,
			'result' => array(),
			'message' => __('data_is_saved'),
		);

		// return token
		load_data:
		return $temp;
	}

	public function get_school_ids($member_id) {
		$temp = $this->find('list', array(
			'fields' => array(
				'MemberLoginMethod.school_id',
				'MemberLoginMethod.school_id',
			),
			'conditions' => array(
				'MemberLoginMethod.member_id' => $member_id,
			),
		));

		$result = array();
		foreach ($temp as $value) {
			$result[] = $value;
		}
		return $result;
	}

	
	public function get_profile($id, $language) {

		$obj_ImageType = ClassRegistry::init('Dictionary.ImageType');
		$obj_School = ClassRegistry::init('School.School');

		$result = $this->find('first', array(
			'fields' => array(
				'MemberLoginMethod.id',
				'MemberLoginMethod.member_id',
				'MemberLoginMethod.username',
				'MemberLoginMethod.password',
				'MemberLoginMethod.token',
				'MemberLoginMethod.enabled',
				'MemberLoginMethod.school_id',
				'MemberLoginMethod.display_name',
			),
			'conditions' => array(
				'MemberLoginMethod.id' 		=> $id,
			),
			'contain' => array(
				'Member' => array(
					'fields' => array(
						'Member.id',
						'Member.email',
						'Member.verified',
						'Member.register_code',
					),
					'MemberImage' => array(
						'fields' => array(
							'MemberImage.*',
						),
						'conditions' => array(
							'MemberImage.image_type_id' => $obj_ImageType->get_id_by_slug('member-avatar'),
						),
					),
					'MemberLanguage' => array(
						'fields' => array(
							'MemberLanguage.*',
						),
						'conditions' => array(
							'MemberLanguage.alias' => $language,
						),
					),
					'MemberRole' => array(
						'fields' => array(
							'MemberRole.member_id',
							'MemberRole.role_id',
							'MemberRole.school_id',
						),
						'order' => array(
							'MemberRole.school_id DESC',
						), 
						'School' => array(
							'fields' => array(
								'School.id',
								'School.school_code',
								'School.status',
							),
							'SchoolLanguage' => array(
								'conditions' => array(
									'SchoolLanguage.alias' => $language,
								),
								'fields' => array(
									'SchoolLanguage.name',
								),
							),
							'SchoolImage' => array(
								'fields' => array(
									'SchoolImage.path',
									'SchoolImage.image_type_id',
								),
							),
						),
						'conditions' => array(
							'MemberRole.enabled' => true,
						),
					),
				),
			),
		));

		$school_ids = array();
		if ($result['MemberLoginMethod']['school_id'] == Environment::read('self_register')) {
			$school_ids = $this->get_school_ids($result['Member']['id']);
		
		} else {
			$school_ids = $this->get_school_ids_by_id($id);
		}
	
		// get name community;
		$obj_School = ClassRegistry::init('School.School');

		$result['MemberLoginMethod']['access_token'] = $result['MemberLoginMethod']['password'];
		$result['Member']['community'] = $obj_School->get_list_school_by_id($school_ids, $language);
		
		return $result;
	}

	public function check_exist($username, $login_method_id) {
		$result = $this->find('count', array(
			'conditions' => array(
				'MemberLoginMethod.username' 			=> $username,
				'MemberLoginMethod.school_id' 			=> $login_method_id,
			),
			'fields' => array(
				'MemberLoginMethod.id',
			),
		));

		if ($result > 0) {
			return true;
		}
		return false;
	}

	public function get_obj($username, $login_method_id) {
		return $this->find('first', array(
			'conditions' => array(
				'MemberLoginMethod.username' 			=> $username,
				'MemberLoginMethod.school_id' 			=> $login_method_id,
			),
			'fields' => array(
				'MemberLoginMethod.id',
			),
		));

	}

	public function get_obj_by_member_id($member_id) {
		return $this->find('first', array(
			'conditions' => array(
				'MemberLoginMethod.member_id' 			=> $member_id,
			),
			'fields' => array(
				'MemberLoginMethod.*',
			),
		));

	}

	public function get_obj_by_id($id) {
		return $this->find('first', array(
			'conditions' => array(
				'MemberLoginMethod.id' 			=> $id,
			),
			'fields' => array(
				'MemberLoginMethod.*',
			),
		));

	}

	public function get_list_username_by_member_id($member_id) {
		return $this->find('list', array(
			'conditions' => array(
				'MemberLoginMethod.member_id' 			=> $member_id,
			),
			'fields' => array(
				'MemberLoginMethod.id',
				'MemberLoginMethod.username',
			),
		));
	}

	public function get_all_login_method_by_member_id($member_id) {
		return $this->find('all', array(
			'conditions' => array(
				'MemberLoginMethod.member_id' 			=> $member_id,
			),
			'fields' => array(
				'MemberLoginMethod.*',
			),
		));
	}

	public function get_member_belong_school_with_role($school_id, $role_id, $language) {
		$temp = $this->find('all', array(
			'fields' => array(
				'MemberLoginMethod.*',
			),
			'joins' => array(
                array(
                    'alias' => 'School',
                    'table' => Environment::read('table_prefix') . 'schools',
                    'type' => 'INNER',
                    'conditions' => array(
						'School.id = MemberLoginMethod.school_id',
						'School.id' => $school_id,
                    ),
                ),
			),
			'group' => array(
				'MemberLoginMethod.member_id',
			),
			'contain' => array(
				'Member' => array(
					'MemberRole' => array(
						'conditions' => array(
							'MemberRole.role_id' => $role_id,
							'MemberRole.school_id' => $school_id
						)
					),
					'MemberLanguage' => array(
						'fields' => array(
							'MemberLanguage.name'
						),
						'conditions' => array(
							'MemberLanguage.alias' => $language,
						)
					),
				)
			)
		));

		$result = array();
		$no = 1;
		foreach ($temp as $val) {
			if (!empty($val['Member']['MemberRole'])) {
				if (reset($val['Member']['MemberRole'])['role_id'] == Environment::read('role.teacher')) {
					$result[] = array(
						'no'		=> $no,
						'username' 	=> $val['MemberLoginMethod']['username'],
						'name' => reset($val['Member']['MemberLanguage'])['name'],
						'role'	=> __d('member', 'teacher'),
					);

				} elseif (reset($val['Member']['MemberRole'])['role_id'] == Environment::read('role.school-admin')) {
					$result[] = array(
						'no'		=> $no,
						'username' 	=> $val['MemberLoginMethod']['username'],
						'name' => reset($val['Member']['MemberLanguage'])['name'],
						'role'	=> __d('member', 'school_admin'),
					);
				}
			}
			$no++;
		}
		return $result;
	}

	public function get_all() {
		return $this->find('all', array(
			'fields' => array(
				'MemberLoginMethod.*',
			),
		));
	}

	public function get_school_ids_by_id($id) {
		$temp = $this->find('list', array(
			'fields' => array(
				'MemberLoginMethod.school_id',
				'MemberLoginMethod.school_id',
			),
			'conditions' => array(
				'MemberLoginMethod.id' => $id,
			),
		));

		$result = array();
		foreach ($temp as $value) {
			$result[] = $value;
		}
		return $result;
	}

	public function get_obj_with_conditions($conditions) {
		return $this->find('first', array(
			'fields' => array(
				'MemberLoginMethod.*',
			),
			'conditions' => $conditions,
		));
	}

	public function add($username, $password, $display_name, $member_id, $school_id) {
		$cond = array(
			'MemberLoginMethod.username' 	=> $username,
			'MemberLoginMethod.school_id' 	=> $school_id, 		
		);

		if (!$this->hasAny($cond)) {
			$data_MemberLoginMethod = array(
				'username' 				=> $username,
				'password' 				=> $password,
				'display_name' 			=> $display_name,
				'member_id' 			=> $member_id,
				'original_member_id'    => $member_id,
				'school_id' 			=> $school_id, 	
			);

			$this->save($data_MemberLoginMethod);
			$this->clear();
		}
	}
}

