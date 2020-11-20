<?php
App::uses('SchoolAppController', 'School.Controller');
/**
 * SchoolsCategoriesController Controller
 */
class SchoolsCategoriesController extends SchoolAppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;

	public function api_get_item() {	// web
		
		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['school_id']) || empty($data['school_id'])) {
				$message = __('missing_parameter') .  'school_id';
				
			} elseif (!isset($data['token']) || empty($data['token'])) {
				$message = __('missing_parameter') .  'token';
				
			} elseif (!isset($data['search_text'])) {
				$message = __('missing_parameter') .  'search_text';

			} elseif (!isset($data['offset'])) {
				$message = __('missing_parameter') .  'offset';
				
			} elseif (!isset($data['limit'])) {
				$message = __('missing_parameter') .  'limit';
				
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

				$temp = $this->SchoolsCategory->get_item($data['school_id'], $data['search_text'], $data['offset'], $data['limit'], $data['language']);
				$result['content'] 	= $temp['content'];
				$result['total'] 	= $temp['total'];
			
				$status = 200;
				$message = __('retrieve_data_successfully');
		
			}
			load_data_api:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}

	public function api_add_item() {	// web
		
		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['school_id']) || empty($data['school_id'])) {
				$message = __('missing_parameter') .  'school_id';
				
			} elseif (!isset($data['name']) || empty($data['name'])) {
				$message = __('missing_parameter') .  'name';

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

				$obj_MemberManageSchool = ClassRegistry::init('Member.MemberManageSchool');
				$cond = array(
					'MemberManageSchool.school_id' => $data['school_id'],
					'MemberManageSchool.member_id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
				);
				$result_MemberManageSchool = $obj_MemberManageSchool->get_obj_by_cond($cond);
				if (!$result_MemberManageSchool) {		// this school admin not manage this school -> 
					$status = 600;
					$message = __d('member', 'invalid_role');
					goto load_data_api;
				}
				
				$temp = $this->SchoolsCategory->add_item($data['school_id'], $data['name'], $result_MemberLoginMethod['MemberLoginMethod']['member_id']);
				
				if ($temp['status']) {
					$status = 200;
					$result['schools_category_id'] = $temp['schools_category_id'];
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


	public function api_edit_item() {	// web
		
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
		   
			} elseif (!isset($data['category_id']) || empty($data['category_id'])) {
				$message = __('missing_parameter') .  'category_id';

			} elseif (!isset($data['name']) || empty($data['name'])) {
				$message = __('missing_parameter') .  'name';

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

				$obj_MemberManageSchool = ClassRegistry::init('Member.MemberManageSchool');
				$cond = array(
					'MemberManageSchool.school_id' => $data['school_id'],
					'MemberManageSchool.member_id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
				);
				$result_MemberManageSchool = $obj_MemberManageSchool->get_obj_by_cond($cond);
				if (!$result_MemberManageSchool) {		// this school admin not manage this school -> 
					$status = 600;
					$message = __d('member', 'invalid_role');
					goto load_data_api;
				}

				if (!$this->SchoolsCategory->exists($data['category_id'])) {
					$status = 999;
					$message = __('Invalid category id');
					goto load_data_api;
				}
				
				$result = $this->SchoolsCategory->edit_item($data['category_id'], $data['name'], $data['language'], $result_MemberLoginMethod['MemberLoginMethod']['member_id']);

				if ($result) {
					$status = 200;
					$message = __('data_is_saved');

				} else {
					$status = 999;
					$message = __('data_is_not_saved');
				}
				
			}
			load_data_api:
            $this->Api->set_result($status, $message, (object)array());
        }

		$this->Api->output();
	}
}
