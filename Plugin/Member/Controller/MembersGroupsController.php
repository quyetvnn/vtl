<?php
App::uses('MemberAppController', 'Member.Controller');
/**
 * MembersGroups Controller
 */
class MembersGroupsController extends MemberAppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;

	public function api_get_member() {	// web
		
		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['group_id']) || empty($data['group_id'])) {
				$message = __('missing_parameter') .  'group_id';

			} elseif (!isset($data['school_id']) || empty($data['school_id'])) {
				$message = __('missing_parameter') .  'school_id';
				
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);

				// $obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				// $result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);

				// if (!$result_MemberLoginMethod) {
				// 	$status = 600;
				// 	$message = __d('member', 'invalid_token');
				// 	goto load_data_api;
				// }

				// $obj_MemberRole = ClassRegistry::init('Member.MemberRole');
				// $resule_MemberRole = $obj_MemberRole->check_exist_role($result_MemberLoginMethod['Member']['MemberRole'], Environment::read('role.student'));
			
				// if (!$resule_MemberRole) {
				// 	$status = 999;
				// 	$message = __d('member', 'invalid_role');
				// 	goto load_data_api;
				// }

				$result = $this->MembersGroup->get_member($data['school_id'], $data['group_id'], $data['language']);

				$status = 200;
				$message = __('retrieve_data_successfully');
		
			}
			load_data_api:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}

	public function api_add_member() {	// web
		
		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['group_id']) || empty($data['group_id'])) {
				$message = __('missing_parameter') .  'group_id';

			} elseif (!isset($data['school_id']) || empty($data['school_id'])) {
				$message = __('missing_parameter') .  'school_id';

			} elseif (!isset($data['member_id']) || empty($data['member_id'])) {
				$message = __('missing_parameter') .  'member_id';

			} elseif (!isset($data['role_id']) || empty($data['role_id'])) {
				$message = __('missing_parameter') .  'role_id';

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

				// Is this member manage this school??? if yes -> allow permission add members to members groups
				$obj_MemberManageSchool = ClassRegistry::init('Member.MemberManageSchool');
				$conditions = array(
					'MemberManageSchool.school_id' => $data['school_id'],
					'MemberManageSchool.member_id' => $data['member_id'],
				);
				if (!$obj_MemberManageSchool->hasAny($conditions)) {
					$status = 999;
					$message = __d('member', 'invalid_role');	// member manage school
					goto load_data_api;
				}

				// check member exist in members groups??
				$obj_MembersGroup = ClassRegistry::init('Member.MembersGroup');
				$cond = array(
					'MembersGroup.member_id' 	=> $data['member_id'],
					'MembersGroup.school_id' 	=> $data['school_id'],
					'MembersGroup.role_id' 		=> $data['role_id'],
					'MembersGroup.group_id' 	=> $data['group_id'],
				);
				if ($obj_MembersGroup->hasAny($cond)) {
					$status = 999;
					$message = __d('member', 'exist_username_in_group');	// member manage school
					goto load_data_api;
				}

				// $obj_MemberRole = ClassRegistry::init('Member.MemberRole');
				// $resule_MemberRole = $obj_MemberRole->check_exist_role($result_MemberLoginMethod['Member']['MemberRole'], Environment::read('role.school-admin'));
			
				// if (!$resule_MemberRole) {
				// 	$status = 999;
				// 	$message = __d('member', 'invalid_role');
				// 	goto load_data_api;
				// }

				$result = $this->MembersGroup->add_member($data['member_id'], $data['school_id'], $data['role_id'], $data['group_id']);

				if ($result) {
					$status = 200;
					$message = __('data_is_saved');
			
				} else {
					$status = 999;
					$message = __('data_is_not_saved');
				}
			}
			load_data_api:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}

	public function api_remove_member() {	// web
		
		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['group_id']) || empty($data['group_id'])) {
				$message = __('missing_parameter') .  'group_id';

			} elseif (!isset($data['school_id']) || empty($data['school_id'])) {
				$message = __('missing_parameter') .  'school_id';

			} elseif (!isset($data['member_id']) || empty($data['member_id'])) {
				$message = __('missing_parameter') .  'member_id';

			} elseif (!isset($data['role_id']) || empty($data['role_id'])) {
				$message = __('missing_parameter') .  'role_id';

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

				// Is this member manage this school??? if yes -> allow permission add members to members groups
				$obj_MemberManageSchool = ClassRegistry::init('Member.MemberManageSchool');
				$conditions = array(
					'MemberManageSchool.school_id' => $data['school_id'],
					'MemberManageSchool.member_id' => $data['member_id'],
				);
				if (!$obj_MemberManageSchool->hasAny($conditions)) {
					$status = 999;
					$message = __d('member', 'invalid_role');	// member manage school
					goto load_data_api;
				}
				

				// $obj_MemberRole = ClassRegistry::init('Member.MemberRole');
				// $resule_MemberRole = $obj_MemberRole->check_exist_role($result_MemberLoginMethod['Member']['MemberRole'], Environment::read('role.student'));
			
				// if (!$resule_MemberRole) {
				// 	$status = 999;
				// 	$message = __d('member', 'invalid_role');
				// 	goto load_data_api;
				// }

				$result = $this->MembersGroup->remove_member($data['member_id'], $data['school_id'], $data['role_id'], $data['group_id']);

				if ($result) {
					$status = 200;
					$message = __('data_is_saved');
			
				} else {
					$status = 999;
					$message = __('data_is_not_saved');
				}
			}
			load_data_api:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}
}
