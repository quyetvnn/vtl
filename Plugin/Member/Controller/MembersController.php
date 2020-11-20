<?php
App::uses('MemberAppController', 'Member.Controller');
/**
 * Members Controller
 *
 * @property Member $Member
 * @property PaginatorComponent $Paginator
 */
class MembersController extends MemberAppController {


	public function beforeFilter(){
		parent::beforeFilter();
	
		if ($this->params['prefix'] == "admin") {
			if ($this->params['action'] == "admin_import_student") {
				$this->set('title_for_layout', __d('member','member') .  " > " . __d('member','add_member') .  " > " .  __d('member','import_student') );
			
			} elseif ($this->params['action'] == "admin_import_teacher") {
				$this->set('title_for_layout', __d('member','member') .  " > " . __d('member','add_member') .  " > " . __d('member','import_teacher') );
		
			} elseif ($this->params['action'] == "admin_add" ||  $this->params['action'] == "admin_edit") {
				$this->set('title_for_layout', __d('member','member') .  " > " . __d('member','add_member') .  " > " .  __d('member','create_member') );
				 
			} elseif ($this->params['action'] == "admin_index" ) {
				$this->set('title_for_layout', __d('member','member_record') .  " > " .  __d('member','members') );
			
			} elseif ($this->params['action'] == "import_histories") {
				$this->set('title_for_layout', __d('member','member') .  " > " . __d('member','invite_member_histories') );
			}
		}
  	}
/**
 * Components
 *
 * @var array
 */
	public $components = array(
		
		'Paginator', 

		'Email',

		// Enable ExcelReader in PhpExcel plugin
		'PhpExcel.ExcelReader',

		// Enable PhpExcel in PhpExcel plugin
		'PhpExcel.PhpExcel',
	);

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$conditions = array();
		$join_conditions = array();

		if ($this->school_id) {
			$join_conditions = array(
				'MemberLoginMethodT.school_id' => $this->school_id,
			);
		}

		$data_search = $this->request->query;

		if (isset($data_search["school_id"]) && $data_search["school_id"]) {
			$join_conditions['MemberLoginMethodT.login_method_id'] = $data_search["school_id"];
		}

		if (isset($data_search["username"]) && !empty(trim($data_search["username"]))){
			$join_conditions['MemberLoginMethodT.username LIKE'] = '%' . $data_search["username"] . '%';
		}
	
		if (isset($data_search["is_verified"])) {
			$join_conditions['Member.verified'] = $data_search["is_verified"];
		}

		$all_settings = array(
			
			'order' => 'Member.id DESC',
		 	'joins' => array(
				array(
					'alias' => 'MemberLoginMethodT',
					'table' => Environment::read('table_prefix') . 'member_login_methods',
					'type' => 'INNER',	
					'conditions' => array_merge($join_conditions, array(
						'Member.id = MemberLoginMethodT.member_id',
					)),
				),
			),
			'conditions' => $conditions,
			'contain' => array(
				'MemberLoginMethod' => array(
					'conditions' => array(
						'MemberLoginMethod.school_id' => $this->school_id,
					),
				),
				'MemberRole' => array(
					'Role' => array(
						'RoleLanguage' => array(
							'conditions' => array(
								'RoleLanguage.alias' => $this->lang18, 
							),
							'fields' => array(
								'RoleLanguage.name',
							),
						),
					),
				),
			),
			'fields' => array(
				'MemberLoginMethodT.*, Member.*',
			),
		);

		$this->Paginator->settings = $all_settings;
		$members = $this->paginate();

		$obj_School = ClassRegistry::init('School.School');
		$school_id = $this->school_id;

		$schools = array();
		if ($this->school_id) {
			$schools = $obj_School->get_list_school($school_id, $this->lang18);
		} else {
			$schools = $obj_School->get_list_school(array(), $this->lang18);
		}

		$this->set(compact('members', 'schools', 'school_id', 'data_search'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Member->exists($id)) {
			throw new NotFoundException(__('Invalid member'));
		}
		$options = array('conditions' => array('Member.' . $this->Member->primaryKey => $id));
		$this->set('member', $this->Member->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$model = 'Member';
		$images_model = 'MemberImage';
		$languages_model = 'MemberLanguage';

		$db  = $this->Member->getDataSource();
		$db->begin();

		if ($this->request->is('post')) {
			$this->Member->create();
			
			$data = $this->request->data;

			// check exist
			$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');

			$conditions = array(
				'MemberLoginMethod.username' 	=> $data['Member']['username'],
				'MemberLoginMethod.school_id' 	=> $data['Member']['school_id'],
			);
			if ($obj_MemberLoginMethod->hasAny($conditions)) {
				$this->Session->setFlash(__d('member', 'exist_username'), 'flash/error');
				goto load_data;
			}
		
			$result = $this->Member->get_member_info($data['Member']['email'], $data['Member']['phone_number']);
	
			$temp = array();
			if ($result) {
				
				if ($result['Member']['email'] == $data['Member']['email']) {
					$this->Session->setFlash(__d('member', 'exist_email'), 'flash/error');
					goto load_data;
				}
	
				if ($result['Member']['phone_number'] == $data['Member']['phone_number']) {
					$this->Session->setFlash(__d('member', 'exist_phone_number'), 'flash/error');
					goto load_data;
				}
			}

			$data['Member']['join_day'] = date('Y-m-d H:i:s');
			$data['Member']['email'] 		= $data['Member']['email'];
			$data['Member']['phone_number'] = $data['Member']['phone_number'];
			$data['Member']['username'] 	= $data['Member']['username'];
			
			$data['Member']['verified'] 	= true;

			if ($save_model = $this->Member->save($data['Member'])) {
				
				// 0. save member login method
				$data_MemberLoginMethod = array(
					'member_id' => $save_model['Member']['id'],
					'username' 	=> $data['Member']['username'],
					'password' 	=> $this->Member->set_password($data['Member']['password']),
					'school_id' => $data['Member']['school_id'],
				);
				if (!$this->Member->MemberLoginMethod->save($data_MemberLoginMethod)) {
					$db->rollback();
					$this->Session->setFlash(__('data_is_not_saved') . " Member Login Method", 'flash/error');
					goto load_data;
				}

				// 1. save member role
				$data_MemberRole = array(
					'member_id' => $save_model['Member']['id'],
					'role_id' 	=> $data['Member']['role_id'],
					'school_id' => $data['Member']['school_id'],
				);
				if (!$this->Member->MemberRole->save($data_MemberRole)) {
					$db->rollback();
					$this->Session->setFlash(__('data_is_not_saved') . " Member Role", 'flash/error');
					goto load_data;
				}

				// 2,save language
				if (isset($data['MemberLanguage']) && !empty($data['MemberLanguage'])) {
					foreach ($data['MemberLanguage'] as &$language) {
						$language['member_id'] = $save_model['Member']['id'];
					}

					if (!$this->Member->MemberLanguage->saveAll($data['MemberLanguage'])) {
						$db->rollback();
						$this->Session->setFlash(__('data_is_not_saved') . " Member Language", 'flash/error');
						goto load_data;
					}
				}
	
				$save_data = array();
				if (isset($data['MemberImage']) && !empty($data['MemberImage'])) {
					$uploaded_images = $data['MemberImage'];
		
					foreach ($uploaded_images as $key => $image) {

						if( isset($image['image_type_id']) && !empty($image['image_type_id']) ){
							$relative_path = 'uploads' . DS . $images_model;
		
							$file_name_suffix = "image";
		
							$uploaded = $this->Common->upload_images( array($image['image']), $relative_path, $file_name_suffix );
		
							if( isset($uploaded['status']) && ($uploaded['status'] == true) ){
								$success_files = array();
		
								if( isset($uploaded['params']['success']) && !empty($uploaded['params']['success']) ){
									$success_files = $uploaded['params']['success'];
		
									foreach ($success_files as $key => $success_file) {
										$temp = array(

											'image_type_id' => $image['image_type_id'],
											'path' 		=> $success_file['path'],
											'width' 	=> $success_file['width'],
											'height' 	=> $success_file['height'],
											'size' 		=> $success_file['size'],
											'member_id' => $save_model['Member']['id'],
										);
		
										$save_data[] = $temp;
									}
								} else {
									$db->rollback();
									$this->Flash->error(__('Fail to upload '.$model.' image. Please, try again.'));
									return false;
								}
							} else {
								$db->rollback();
								$this->Flash->error(__('Failed to upload '.$model.' image. Please, try again!'));
								return false;
							}
		
						} else {
							$db->rollback();
							$this->Flash->error(__('invalid_image_type'));
							return false;
						}
					} // end foreach
				} 
		
				if (!empty($save_data)) {
					if (!$this->Member->MemberImage->saveAll($save_data) ){
						$db->rollback();
						$this->Flash->error(__('data_is_not_saved') . " Member Image");
						$this->redirect(array('action' => 'index'));
					}
				}

				$db->commit();
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));

			} else {
				$this->Session->setFlash(__('data_is_saved'), 'flash/error');
			}
		}


		load_data:

		$obj_Role = ClassRegistry::init('Administration.Role');
		$roles = $obj_Role->get_list_teacher_student_role($this->lang18);

		$obj_School = ClassRegistry::init('School.School');

		$schools = $obj_School->get_list_school($this->school_id, $this->lang18);

		$language_input_fields = array(
			'id',
			'alias',
			'first_name',
			'last_name',
			'name',
		);

		$objLanguage = ClassRegistry::init('Dictionary.Language');
		$languages_list = $objLanguage->get_languages();
		$languages_model = 'MemberLanguage';

		// Images upload
		$add_new_images_url = Router::url(array('plugin'=>'member','controller'=>'members','action'=>'add_new_image_with_type'), true);

		// display image type
		$objImageType = ClassRegistry::init('Dictionary.ImageType');
		$imageTypes = $objImageType->find_list(array(
			'ImageType.slug' => "member-avatar",
		), $this->lang18);


		$this->set(compact('roles', 'schools',
			'languages_list', 'language_input_fields',  'languages_model', 
			'model', 'imageTypes', 'images_model', 'add_new_images_url'));

	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
       
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
		
	}

	public function api_update_profile() {	

		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$results = (object)array();

			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';

			} elseif (!isset($data['token']) || empty($data['token'])) {
				$message = __('missing_parameter') .  'token';
		   
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);

				if (!$result_MemberLoginMethod) {
					$status =  600;
					$message = __d('member', 'invalid_token');
					goto load_api_data;
				}

				$email_confirm_key = strtoupper(md5(uniqid(time())));
				if (isset($data['email']) && !empty($data['email'])) {				// edit email

					$data['email'] = strtolower($data['email']);
					$obj_Member = ClassRegistry::init('Member.Member');
					// check email is exists in system?
					$result_Member = $obj_Member->find('first', array(
						'fields' => array(
							'Member.*',
						),
						'conditions' => array(
							'Member.email' 			=> $data['email'],
						),
					));
			
					if ($result_Member) {
					
						if ($result_Member['Member']['email'] == $data['email']) {
							$status = 999;
							$message = __d('member', 'exist_email');
							goto load_api_data;
						}
					}

				
					$update = $this->Member->updateAll(
						array(
							'Member.email' =>  '"' . $data['email'] . '"',
							'Member.email_confirm_key' => '"' . $email_confirm_key . '"',
						), array(
							'Member.id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'], 
						)
					);
					if (!$update) {
						$status = 999;
						$message = __('data_is_not_saved') . " Member (email)";
						goto load_api_data;
					}

					// https://all4learn.com/email_confirm?key=2FHIOHFOAKASDHWHCHGFJJOJFOGKCB
					$link = Router::url('/', true) . "email_confirm?key=" . $email_confirm_key;
					// send mail to confirm
					$send_to = $data['email'];
					$data_email = array(
						'link'  => $link,
					); 
					$template = 'confirm_change_email_address_' . $data['language'];
                    $result_email = $this->Email->send($send_to, __d('member', 'confirm_change_email_address'), $template, $data_email);
                    
                    if (!$result_email['status']) {
						$status = 999;
						$message = $result_email['message'];
						goto load_api_data;
					}

				}

				if (isset($data['nick_name']) && !empty($data['nick_name'])  ) {	// update nick name
					$update = $obj_MemberLoginMethod->updateAll(
						array(
							'MemberLoginMethod.display_name' =>  '"' . $data['nick_name'] . '"',
						), array(
							'MemberLoginMethod.id' => $result_MemberLoginMethod['MemberLoginMethod']['id'], 
						)
					);
					if (!$update) {
						$message = __('data_is_not_saved') . " Member (update nick name)";
						goto load_api_data;
					}
				}

				$obj_ImageType = ClassRegistry::init('Dictionary.ImageType');

				if (isset($_FILES) && !empty($_FILES)) { 	

					// remove old avatar
					$image_type_id 		= $obj_ImageType->get_id_by_slug('member-avatar');
					$member_id			= $result_MemberLoginMethod['MemberLoginMethod']['member_id'];
					$old_MemberAvatar 	= $this->Member->MemberImage->get_id_from_image_type_id_member_id ($image_type_id, $member_id);
				

					if ($old_MemberAvatar) {
						$this->Member->MemberImage->deleteAll(array(
							'MemberImage.id' => $old_MemberAvatar['MemberImage']['id'],
						));
					}

					// Upload File
					$images_save 	= array();
					$images 		= array();

					$_file_name = 'avatar';

					if ($_FILES[$_file_name]['size'] > 0) {
						$images[] = $_FILES[$_file_name];	// miss this row will failed ...
						
					} else {
						$data[$_file_name] = '';
					}
					
					$relative_path = 'uploads' . DS . 'MemberImage';
					$file_name_suffix = "image";
					$uploaded_images = $this->Common->upload_images($images, $relative_path, $file_name_suffix);

					if (isset($uploaded_images['status']) && ($uploaded_images['status'] == true) ) {
						if (isset($uploaded_images['params']['success']) && !empty($uploaded_images['params']['success']) ){
							foreach($uploaded_images['params']['success'] as $key => $val) {
									
								$images_save[] = array(
									'path' 			=> str_replace("\\",'/',$val['path']),
									'width' 		=> $val['width'],
									'height' 		=> $val['height'],
									'size' 			=> $val['size'],
									'image_type_id' => $obj_ImageType->get_id_by_slug('member-avatar'),
									'member_id' 	=> $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
								);
							}
						}
					} else {
						$message = __d('member', "upload_image_failed");
						goto load_api_data;
					}
					
					// save
					if (!empty($images_save)) {

						$results = $images_save[0]['path'];
						if (!$this->Member->MemberImage->saveAll($images_save) ){
							$message = __('data_is_not_saved') . " Member Image";
							goto load_api_data;
						}
					}
				}
			}

			$status = 200;
			$message = __('data_is_saved');

			if (Environment::is('development') && isset($data['email']) && !empty($data['email'])) {
				$message = $message . " " . $email_confirm_key;
			}

			load_api_data:
            $this->Api->set_result($status, $message, $results);
        }

		$this->Api->output();
	}

	public function api_use_link_confirm_email_address() {
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
			
			} else {
				$this->Api->set_language($data['language']);

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$obj_Member 			= ClassRegistry::init('Member.Member');

				$conditions = array(
					'Member.email_confirm_key' => $data['key'],
				);
				if ($result_Member = $obj_Member->get_obj_with_conditions($conditions)) {

					// get member login method;
					$obj_MemberLoginMethod			= ClassRegistry::init('Member.MemberLoginMethod');
					$result_MemberLoginMethod = $obj_MemberLoginMethod->get_all_login_method_by_member_id($result_Member['Member']['id']);

					if ($result_MemberLoginMethod) {
						// remove key from member 
						$obj_Member->id = $result_Member['Member']['id'];
						$obj_Member->save('email_confirm_key', array());

						$status = 200;
						$message = __d('member', 'email_is_confirm');

					} else {
						$status = 999;
						$message = __('data_not_change');
					}
					
				} else {
					$status = 999;
					$message = __('invalid_data') . ' (key)';
				}
			}

			load_data_api:
            $this->Api->set_result($status, $message,  (object)array());
        }

		$this->Api->output();
	}


	public function admin_import_student() {

		if ($this->request->is('post')) {

			$data = $this->request->data;

			if (isset($_FILES) && !empty($_FILES)) { 	
				
				$files 		= array();
				$_file_name = 'file';

				$files[] = array(
					'name' => $_FILES['data']['name']['Member'][0][0]['file'],
					'type' => $_FILES['data']['type']['Member'][0][0]['file'],
					'tmp_name' => $_FILES['data']['tmp_name']['Member'][0][0]['file'],
					'error' => 0,
					'size' => 0,
				);
				
				$relative_path = 'uploads' . DS . 'import';
				$file_name_suffix = "excel";
				$uploaded_files = $this->Common->upload_file($files, $relative_path, $file_name_suffix);

				$obj_ImportHistory = ClassRegistry::init('Member.ImportHistory');

				if (isset($uploaded_files['status']) && ($uploaded_files['status'] == true) ) {

					if (isset($uploaded_files['params']['success']) && !empty($uploaded_files['params']['success']) ){
						foreach($uploaded_files['params']['success'] as $key => $value) {
							$path = WWW_ROOT .  DS . $value['path'];
							
							// get all data from database with school id: $data['Member']['school_id']
							$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
							$result_MemberLoginMethod = $obj_MemberLoginMethod->get_list($data['Member']['school_id']);

							$this->ExcelReader->loadExcelFile($value['path']);

							// if read successfully, get the result array
							$data_excel = $this->ExcelReader->dataArray;

							// $result  = $this->check_data($data_excel, Environment::read('role.student'), $result_MemberLoginMethod, $data['Member']['school_id']);


							$result  = $this->check_data_before_import($data_excel, $data['Member']['school_id'], Environment::read('role.student'), $data['Member']['group_id']);

							$color 		 = $result['color'];
							$data_result = $result['data'];
							$message	 = $result['message'];
							$data_MemberLoginMethod = $result['data_MemberLoginMethod'];
							$data_MemberLanguage 	= $result['data_MemberLanguage'];
							$data_MembersGroup		= $result['data_MembersGroup'];

							$data_Member = $data_MemberLanguage = $data_MemberLoginMethod = array();

							$obj_Member = ClassRegistry::init('Member.Member');
							$obj_MemberLanguage = ClassRegistry::init('Member.MemberLanguage');
							$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
							//$obj_StudentClass = ClassRegistry::init('Member.StudentClass');
							$obj_MemberRole 	= ClassRegistry::init('Member.MemberRole');
							$obj_MembersGroup 	= ClassRegistry::init('Member.MembersGroup');

							// edit first
							if ($data_MemberLoginMethod) {
								$obj_MemberLoginMethod->saveAll($data_MemberLoginMethod);
								$obj_MemberLoginMethod->clear();
							}

							if ($data_MemberLanguage) {
								$obj_MemberLanguage->saveAll($data_MemberLanguage);
								$obj_MemberLanguage->clear();
							}

							// upgrade student to new group
							if ($data_MembersGroup) {
								$obj_MembersGroup->saveAll($data_MembersGroup);
								$obj_MembersGroup->clear();
							}

							$content_username = array();

							// add new
							foreach ($data_result as $val) {
								$data_MemberLanguage = array();
								$content_username[] = $val[0];
								$name 		= $val[2];

								$val[0] = strtolower($val[0]);
								$val[3] = strtolower($val[3]);

								$data_Member = array(
									'username' 		=> $data['Member']['school_id'] . "_" . $val[0],
									'verified' 		=> true,
									'email'     	=> $val[3],
									'phone_number' 	=> $val[4],
								);
								$model_Member = $obj_Member->save($data_Member);

								$data_MemberLoginMethod = array(
									'username' 		=> $val[0],
									'password' => $obj_Member->set_password($val[1]),
									'verified' => true,
									'display_name' 	=> $val[3] . $val[2],
									'member_id' 	=> $model_Member['Member']['id'],
									'school_id' 	=> $data['Member']['school_id'],
								);
								$obj_MemberLoginMethod->save($data_MemberLoginMethod);
								
								$member_id 	= $model_Member['Member']['id'];
				
								// member language
								$data_MemberLanguage = $this->Member->MemberLanguage->generate_all_member_language($name, $member_id);
								$obj_MemberLanguage->saveAll($data_MemberLanguage);

								// members groups
								$data_MembersGroup = array(
									'member_id' 		=> $model_Member['Member']['id'],
									'school_id'			=> $data['Member']['school_id'],
									'role_id'			=> Environment::read('role.student'),
									'group_id'			=> $data['Member']['group_id'],
								);

								$obj_MembersGroup->save($data_MembersGroup);

								// member role
								$data_MemberRole = array(
									'member_id' 		=> $model_Member['Member']['id'],
									'role_id'			=> Environment::read('role.student'),
									'school_id'			=> $data['Member']['school_id'],
								);
								$obj_MemberRole->save($data_MemberRole);

								$obj_Member->clear();
								$obj_MemberLanguage->clear();
								$obj_MemberLoginMethod->clear();
								$obj_MembersGroup->clear();
								$obj_MemberRole->clear();
							}
							
							$data_ImportStudentHistory = array();

							// save import student history table
							$data_ImportStudentHistory = array(
								'school_id'			=> $data['Member']['school_id'],
								'content'			=> $content_username ? json_encode($content_username) : array(),
								'path'				=>  $value['path'],
								'type'				=>  1,	// student
								'message'			=>  $message,
							);
							$obj_ImportHistory->save($data_ImportStudentHistory);

							if ($color == "green") {
								$this->Session->setFlash($message, 'flash/success');
							} else {
								$this->Session->setFlash($message, 'flash/error');
							}
						}
					}
				} else {
					$this->Session->setFlash(__('file_not_found'), 'flash/error');
					$this->redirect(array('action' => 'import_student'));
				}
			}
		}

		load_data:
		$obj_School = ClassRegistry::init('School.School');

		$school_id = $this->school_id;
		$schools = $obj_School->get_list_school($school_id, $this->lang18);
		
		$this->set(compact('schools', 'school_id'));
	}

	public function api_get_member_school_by_id(){
		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$results = (object)array();

			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';

			} elseif (!isset($data['member_id']) || empty($data['member_id'])) {
				$message = __('missing_parameter') .  'member_id';
		   
			} elseif (!isset($data['school_id']) || empty($data['school_id'])) {
				$message = __('missing_parameter') .  'school_id';
		   
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);

				$result_Member = $this->Member->get_member_school_by_id($data['member_id'], $data['school_id'], $data['language']);

				if(empty($result_Member)){
					$status = 999;
					$message = __d('member', 'member_not_found');
					goto load_api_data;
				}
				$message = 'success';
				$results = $result_Member;
			}
			$status = 200;
			load_api_data:
            $this->Api->set_result($status, $message, $results);
        }

		$this->Api->output();
	}

	public function api_resend_email() {	

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
		   
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);

				$data['school_id'] = Environment::read('self_register');	// 0
				$result_Member = $this->Member->get_register_code($data['username'], $data['school_id']);

				$status = $result_Member['status'];
				$message = $result_Member['status'];

				if ($status  == 200) {
					$template = "register_confirm_" . $data['language'];
					$data_email = array(
						'username' => $data['username'],
						'code' => $result_Member['register_code'],
						'email' => $result_Member['email']
					);

					//Environment::read('company_name') . 
					$result_email = $this->Email->send($result_Member['email'],  __d('member', 'active_register_code'), $template, $data_email);
				
					if ($result_email['status'])  {
						$status = 200;
						$email_filter = $this->filter_email_info($result_Member['email']);
						$message = sprintf (__d('member', 'send_mail_register_success_with_member'), $email_filter) . ": " . $result_Member['register_code'];

					} else {
						$status = 999;
						$message = $result_email['message'];
					}
				}

			}
			$status = 200;

			load_api_data:
            $this->Api->set_result($status, $message, $results);
        }

		$this->Api->output();
	}

	public function admin_import_teacher() {

		if ($this->request->is('post')) {

			$data = $this->request->data;
			
			if (isset($_FILES) && !empty($_FILES)) { 	
				
				$files 		= array();
				$_file_name = 'file';

				$files[] = array(
					'name' => $_FILES['data']['name']['Member'][0][0]['file'],
					'type' => $_FILES['data']['type']['Member'][0][0]['file'],
					'tmp_name' => $_FILES['data']['tmp_name']['Member'][0][0]['file'],
					'error' => 0,
					'size' => 0,
				);
				
				$relative_path = 'uploads' . DS . 'import';
				$file_name_suffix = "excel";
				$uploaded_files = $this->Common->upload_file($files, $relative_path, $file_name_suffix);

				$obj_ImportHistory = ClassRegistry::init('Member.ImportHistory');

				if (isset($uploaded_files['status']) && ($uploaded_files['status'] == true) ) {

					if (isset($uploaded_files['params']['success']) && !empty($uploaded_files['params']['success']) ){
						foreach($uploaded_files['params']['success'] as $key => $value) {
							$path = WWW_ROOT .  DS . $value['path'];
							
							// get all data from database with $data['Member']['school_id']
							$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
							$result_MemberLoginMethod = $obj_MemberLoginMethod->get_list($data['Member']['school_id']);
							
							$this->ExcelReader->loadExcelFile($value['path']);

							// if read successfully, get the result array
							$data_excel = $this->ExcelReader->dataArray;

							$result  = $this->check_data($data_excel, Environment::read('role.teacher'), $result_MemberLoginMethod, $data['Member']['school_id']);

							$color 			= $result['color'];
							$message 		= $result['message'];
							$data_result 	= $result['data'];
						
							$data_Member = $data_MemberLanguage = $data_MemberLoginMethod = array();

							$obj_Member = ClassRegistry::init('Member.Member');
							$obj_MemberLanguage = ClassRegistry::init('Member.MemberLanguage');
							$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
							$obj_StudentClass = ClassRegistry::init('Member.StudentClass');
							$obj_MemberRole = ClassRegistry::init('Member.MemberRole');


							$content_username = array();

							foreach ($data_result as $val) {
								$data_MemberLanguage = array();
								$content_username[] = strtolower($val[0]);
								$val[0] = strtolower($val[0]);
								$val[3] = strtolower($val[3]);
					
								$data_Member = array(
									//'username' => $data['Member']['school_id'] . "_" . strtolower($val[0]),
									'verified' 		=> true,
									'email'     	=> strtolower($val[4]),
									'phone_number' 	=> $val[5],
								);
								$model_Member = $obj_Member->save($data_Member);
								
								// check username exist, if exist => not add to member again
								$data_MemberLoginMethod = array(
									'username' => $val[0],
									'password' => $obj_Member->set_password($val[1]),
									'verified' => true,
									'display_name' 	=> $val[3] . $val[2],
									'member_id' 	=> $model_Member['Member']['id'],
									'school_id' 	=> $data['Member']['school_id'],
								);
								$obj_MemberLoginMethod->save($data_MemberLoginMethod);
				
								$name = $val[2];
								$member_id = $model_Member['Member']['id'];

								$data_MemberLanguage = $this->Member->MemberLanguage->generate_all_member_language($name, $member_id);

								$obj_MemberLanguage->saveAll($data_MemberLanguage);

								$data_MemberRole = array(
									'member_id' 		=> $model_Member['Member']['id'],
									'role_id'			=> Environment::read('role.teacher'),
									'school_id'			=> $data['Member']['school_id'],
								);
								$obj_MemberRole->save($data_MemberRole);

								$obj_Member->clear();
								$obj_MemberLanguage->clear();
								$obj_MemberLoginMethod->clear();
								$obj_MemberRole->clear();
							}
							
							$data_ImportStudentHistory = array();

							// save import history table
							$data_ImportStudentHistory = array(
								'school_id'			=> $data['Member']['school_id'],
								'content'			=> $content_username ? json_encode($content_username) : array(),
								'path'				=> $value['path'],
								'type'				=> 2,	// teacher
								'message'			=> $message,
							);
							$obj_ImportHistory->save($data_ImportStudentHistory);

							if ($color == "green") {
								$this->Session->setFlash($message, 'flash/success');
							} else {
								$this->Session->setFlash($message, 'flash/error');
							}

						}
					}
				} else {
					$this->Session->setFlash(__('file_not_found'), 'flash/error');
					$this->redirect(array('action' => 'import_student'));
				}
			}
		}

		load_data:
		$obj_School = ClassRegistry::init('School.School');

		$school_id = $this->school_id;
		$schools = $obj_School->get_list_school($school_id, $this->lang18);
		
		// $schools = array();
		// if ($this->school_id) {
		// 	$schools = $obj_School->get_list_school($school_id, $this->lang18);
		// } else {
		// 	$schools = $obj_School->get_list_school(array(), $this->lang18);
		// }
 		
		$this->set(compact('schools', 'school_id'));
	}


	public function admin_get_list_teacher() {
		$this->Api->init_result();

		if( $this->request->is('post') ) {
			$data = $this->request->data;
			$message = "";
			$status = false;
			$result_data = array();
			
			$this->disableCache();

			if (!isset($data['school_id'])) {
				$message = __('missing_parameter') .  'school_id';

			} else {
				$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
				$result_data = $obj_MemberRole->get_list_members_by_school_id($data['school_id'], $this->lang18, Environment::read('role.teacher'));
				$status = true;
            }   
			$this->Api->set_result($status, $message, $result_data);
		}
		$this->Api->output();
	}

	public function admin_get_list_student() {
		$this->Api->init_result();

		if( $this->request->is('post') ) {
			$data = $this->request->data;
			$message = "";
			$status = false;
			$result_data = array();
			
			$this->disableCache();

			if (!isset($data['school_id'])) {
				$message = __('missing_parameter') .  'school_id';

			} else {
				$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
				//$result_data = $obj_MemberRole->get_all_list_member($this->lang18);

				$result_data = $obj_MemberRole->get_list_members_by_school_id($data['school_id'], $this->lang18, Environment::read('role.student'));
				$status = true;
            }   
			$this->Api->set_result($status, $message, $result_data);
		}
		$this->Api->output();
	}

	public function admin_get_list_member() {
		$this->Api->init_result();

		if( $this->request->is('post') ) {
			$data = $this->request->data;
			$message = "";
			$status = false;
			$result_data = array();
			
			$this->disableCache();

			if (!isset($data['school_id'])) {
				$message = __('missing_parameter') .  'school_id';

			} else {
				$role = isset($data['role']) && $data['role'] ? $data['role'] : array();

				$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
				$result_data = $obj_MemberRole->get_list_members_by_school_id($data['school_id'], $this->lang18, $role );
				$status = true;
            }   
			$this->Api->set_result($status, $message, $result_data);
		}
		$this->Api->output();
	}
	

	public function api_import_member() {	

		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$results = (object)array();

			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';

			} elseif (!isset($data['role']) || empty($data['role'])) {	// 1: teacher, 2: student.
				$message = __('missing_parameter') .  'role';

			} elseif (!isset($data['school_id']) || empty($data['school_id'])) {	
				$message = __('missing_parameter') .  'school_id';

			} elseif (!isset($data['group_id']) || empty($data['group_id'])) {	
				$message = __('missing_parameter') .  'group_id';

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
					goto load_api_data;
				}

				$obj_MemberManageSchool = ClassRegistry::init('Member.MemberManageSchool');
				$cond = array(
					'MemberManageSchool.school_id' => $data['school_id'],
					'MemberManageSchool.member_id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
				);
				if (!$obj_MemberManageSchool->hasAny($cond)) {
					$status = 600;
					$message = __d('member', 'invalid_role');
					goto load_api_data;
				}

				if (isset($_FILES) && !empty($_FILES)) { 	
				
					$files 		= array();
					$_file_name = 'file';

					if ($_FILES[$_file_name]['size'] > 0) {
						$files[] = $_FILES[$_file_name];	// miss this row will failed ...
					} 
					
					$relative_path = 'uploads' . DS . 'import';
					$file_name_suffix = "excel";
					$uploaded_files = $this->Common->upload_file($files, $relative_path, $file_name_suffix);

					if (isset($uploaded_files['status']) && ($uploaded_files['status'] == true) ) {

						if (isset($uploaded_files['params']['success']) && !empty($uploaded_files['params']['success']) ){
							foreach($uploaded_files['params']['success'] as $key => $value) {
								$path = WWW_ROOT .  DS . $value['path'];
								
								// get all data from database with $data['Member']['school_id']
								$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
								$result_MemberLoginMethod = $obj_MemberLoginMethod->get_list($data['school_id']);
								
								$this->ExcelReader->loadExcelFile($value['path']);

								// if read successfully, get the result array
								$data_excel = $this->ExcelReader->dataArray;
								$result = array();

								if ($data['role'] == Environment::read('role.teacher')) {
									// $result  = $this->check_data($data_excel, Environment::read('role.teacher'), $result_MemberLoginMethod, $data['school_id']);
									$result  = $this->check_data_before_import($data_excel, $data['school_id'], Environment::read('role.teacher'), $data['group_id']);
									$color 			= $result['color'];
									$message 		= $result['message'];
									$data_result 	= $result['data'];
									$this->create_teacher_role($data_result, $data['school_id'], $data['group_id'], $value['path'], $message);
								
								} elseif ($data['role'] == Environment::read('role.student')) {
									// $result  = $this->check_data($data_excel, Environment::read('role.student'), $result_MemberLoginMethod, $data['school_id']);


									$result  = $this->check_data_before_import($data_excel, $data['school_id'], Environment::read('role.student'), $data['group_id']);
									$color 			= $result['color'];
									$message 		= $result['message'];
									$data_result 	= $result['data'];

									$this->create_student_role($data_result, $data['school_id'], $data['group_id'], $value['path'], $message);
								}	

								$data_Member				= $result['data_Member'];
								$data_MemberLoginMethod 	= $result['data_MemberLoginMethod'];
								$data_MemberLanguage 		= $result['data_MemberLanguage'];
								$data_MembersGroup 			= $result['data_MembersGroup'];
								$data_MemberRole 			= $result['data_MemberRole'];

								$this->add_new_member_groups($data_MembersGroup);
								$this->edit_old_member($data_Member, $data_MemberLoginMethod, $data_MemberLanguage, $data_MemberRole);

							}
						}

						if ($color == "green") {
							$status = 200;
						} else {
							$status = 999;
						}
						// $message = array_diff(explode("<br>", $message), array(""));
					} else {

						$status = 888;
						$message = __('file_not_found');
					}
				}
			}

			load_api_data:
            $this->Api->set_result($status, $message, $results);
        }

		$this->Api->output();
	}

	private function add_new_member_groups($data) {
		if ($data) {
			$obj_MembersGroup = ClassRegistry::init('Member.MembersGroup');
			$obj_MembersGroup->saveAll($data);
		}
	}

	private function edit_old_member($data_Member, $data_MemberLoginMethod, $data_MemberLanguage, $data_MemberRole) {
		if ($data_Member) {
			$obj_Member = ClassRegistry::init('Member.Member');
			$obj_Member->saveAll($data_Member);
		}
		
		if ($data_MemberLoginMethod) {
			$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
			$obj_MemberLoginMethod->saveAll($data_MemberLoginMethod);
		}

		if ($data_MemberLanguage) {
			$obj_MemberLanguage = ClassRegistry::init('Member.MemberLanguage');
			$obj_MemberLanguage->saveAll($data_MemberLanguage);
		}

		if ($data_MemberRole) {
			$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
			$obj_MemberRole->saveAll($data_MemberRole);
		}
	}

	private function create_student_role($data_result, $school_id, $group_id, $import_file, $message) {
		$data_MemberLanguage = array();

		$obj_Member 			= ClassRegistry::init('Member.Member');
		$obj_MemberLanguage 	= ClassRegistry::init('Member.MemberLanguage');
		$obj_MemberLoginMethod 	= ClassRegistry::init('Member.MemberLoginMethod');
		$obj_MembersGroup		= ClassRegistry::init('Member.MembersGroup');
		$obj_MemberRole 		= ClassRegistry::init('Member.MemberRole');
		$obj_ImportHistory		= ClassRegistry::init('Member.ImportHistory');

		$content_username = array();

		$db = $obj_Member->getDataSource();
		$db->begin();

		foreach ($data_result as $val) {
			$data_MemberLanguage = array();
			$content_username[] = $val[0];
		
			$val[0] = strtolower($val[0]);
			$val[3] = strtolower($val[3]);	// email
			$name 		= $val[2];

			// add member
			$member_id = $obj_Member->add($val[3], $val[4]);
			
			if (!$member_id) {
				$db->rollback();
			}

			// add member login method
			$obj_MemberLoginMethod->add($val[0], 				// username
										$obj_Member->set_password($val[1]),	// password
										$name, 								// display name
										$member_id, 		// member id
										$school_id);

			$data_MemberLanguage = $this->Member->MemberLanguage->generate_all_member_language($name, $member_id);
			$obj_MemberLanguage->saveAll($data_MemberLanguage);
			$obj_MemberLanguage->clear();

			// add member group
			$obj_MembersGroup->add($member_id, Environment::read('role.student'), $school_id, $group_id);
		
			// add member role
			$obj_MemberRole->add($member_id, Environment::read('role.student'), $school_id);

		}
		
		// save import student history table
		$data_ImportHistory = array(
			'school_id'			=>  $school_id,
			'content'			=>  $content_username ? json_encode($content_username) : array(),
			'path'				=>  $import_file,
			'role_id'			=>  Environment::read('role.student'),
			'message'			=>  $message,
		);
		$obj_ImportHistory->save($data_ImportHistory);
		$db->commit();
	}

	private function create_teacher_role($data_result, $school_id, $group_id, $import_file, $message) {	// data_result: from excel file
		$data_MemberLanguage = array();

		$obj_Member 			= ClassRegistry::init('Member.Member');
		$obj_MemberLanguage 	= ClassRegistry::init('Member.MemberLanguage');
		$obj_MemberLoginMethod 	= ClassRegistry::init('Member.MemberLoginMethod');
		$obj_MemberRole 		= ClassRegistry::init('Member.MemberRole');
		$obj_ImportHistory 		= ClassRegistry::init('Member.ImportHistory');
		$obj_MembersGroup		= ClassRegistry::init('Member.MembersGroup');

		$content_username = array();

		$db = $obj_Member->getDataSource();
		$db->begin();

		foreach ($data_result as $val) {
			$data_MemberLanguage = array();
			$content_username[] = strtolower($val[0]);
			$val[0] = strtolower($val[0]);
			$val[3] = strtolower($val[3]);
			$name = $val[2];

			// add member
			$member_id = $obj_Member->add($val[3], $val[4]);
			if (!$member_id) {
				$db->rollback();
			}

			// add member login method
			$obj_MemberLoginMethod->add($val[0], 				// username
										$obj_Member->set_password($val[1]),	// password
										$name, 								// display name
										$member_id, 		// member id
										$school_id);

			$data_MemberLanguage = $this->Member->MemberLanguage->generate_all_member_language($name, $member_id);
			$obj_MemberLanguage->saveAll($data_MemberLanguage);
			$obj_MemberLanguage->clear();

			// add member group
			$obj_MembersGroup->add($member_id, Environment::read('role.teacher'), $school_id, $group_id);
			
			// add member role
			$obj_MemberRole->add($member_id, Environment::read('role.teacher'), $school_id);
		}
		
		$data_ImportHistory = array(
			'school_id'			=> $school_id,
			'content'			=> $content_username ? json_encode($content_username) : array(),
			'path'				=> $import_file,
			'role'				=> Environment::read('role.teacher'),
			'message'			=> $message,
		);
		$obj_ImportHistory->save($data_ImportHistory);
		$db->commit();
	}

	public function api_create_member() {	

		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$results = (object)array();

			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';

			} elseif (!isset($data['role']) || empty($data['role'])) {	// json role id ["1", "3"]
				$message = __('missing_parameter') .  'role';

			} elseif (!isset($data['school_id']) || empty($data['school_id'])) {	
				$message = __('missing_parameter') .  'school_id';

			} elseif (!isset($data['token']) || empty($data['token'])) {	
				 $message = __('missing_parameter') .  'token';
				 
			} elseif (!isset($data['username']) || empty($data['username'])) {	
				$message = __('missing_parameter') .  'username';

			} elseif (!isset($data['password']) || empty($data['password'])) {	
				$message = __('missing_parameter') .  'password';

			} elseif (!isset($data['name']) || empty($data['name'])) {	
				$message = __('missing_parameter') .  'name';

			} elseif (!isset($data['phone_number']) || empty($data['phone_number'])) {	
				$message = __('missing_parameter') .  'phone_number';
		   
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);
				if (!$result_MemberLoginMethod) {
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_api_data;
				}

				$obj_MemberManageSchool = ClassRegistry::init('Member.MemberManageSchool');
				$cond = array(
					'MemberManageSchool.school_id' => $data['school_id'],
					'MemberManageSchool.member_id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
				);
				if (!$obj_MemberManageSchool->hasAny($cond)) {
					$status = 600;
					$message = __d('member', 'invalid_role');
					goto load_api_data;
				}

				// validate username, email, phone
				// check exist

				$conditions = array(
					'MemberLoginMethod.username' 	=> $data['username'],
					'MemberLoginMethod.school_id' 	=> $data['school_id'],
				);
				if ($obj_MemberLoginMethod->hasAny($conditions)) {
					$status = 999;
					$message = __d('member', 'exist_username');
					goto load_api_data;
				}
			
				$result = $this->Member->get_member_info($data['email'], $data['phone_number']);
		
				if ($result) {
					if ($result['Member']['email'] == $data['email']) {
						$status = 999;
						$message = __d('member', 'exist_email');
						goto load_api_data;
					}
		
					if ($result['Member']['phone_number'] == $data['phone_number']) {
						$status = 999;
						$message = __d('member', 'exist_phone_number');
						goto load_api_data;
					}
				}

				$db = $this->Member->getDataSource();
				$db->begin();
				$data_Member = array(
					'join_day' 		=> date('Y-m-d H:i:s'),
					'email' 		=> $data['email'],
					'phone_number' 	=> $data['phone_number'],
					'username' 		=> $data['username'],
				
					'verified' 		=> true,
				);
			
				if ($save_model = $this->Member->save($data_Member)) {
					
					// 0. save member login method
					$data_MemberLoginMethod = array(
						'member_id' => $save_model['Member']['id'],
						'username' 	=> $data['username'],
						'password'		=> $this->Member->set_password($data['password']),
						'school_id' => $data['school_id'],
					);
					if (!$this->Member->MemberLoginMethod->save($data_MemberLoginMethod)) {
						$db->rollback();
						$status = 999;
						$message = __('data_is_not_saved') . " Member Login Method";
						goto load_api_data;
					}

					$data_MemberRole = array();
					$roles = json_decode($data['role']);
					foreach ($roles as $role) {

						if ($role != Environment::read('role.teacher') && $role != Environment::read('role.school-admin')) {
							$db->rollback();
							$status = 999;
							$message = __('just_accept_teacher_school_admin');
							goto load_api_data;
						}

						$data_MemberRole[] = array(
							'member_id' => $save_model['Member']['id'],
							'role_id' 	=> $role,
							'school_id' => $data['school_id'],
						);
					}

					// 1. save member role
					if (!$this->Member->MemberRole->saveAll($data_MemberRole)) {
						$db->rollback();
						$status = 999;
						$message = __('data_is_not_saved') . " Member Role";
						goto load_api_data;
					}

					// 2,save language
					// $lang = ['zho', 'eng', 'chi'];
					// $data_MemberLanguage = array();
					// foreach ($lang as $l) {
					// 	$data_MemberLanguage[] = array(
					// 		'member_id' => $save_model['Member']['id'],
					// 		'name' 		=> $data['name'],
					// 		'alias'		=> $l,
					// 	);
					// }

					$data_MemberLanguage = $this->Member->MemberLanguage->generate_all_member_language($data['name'], $save_model['Member']['id']);
					if (!$this->Member->MemberLanguage->saveAll($data_MemberLanguage)) {
						$db->rollback();
						$status = 999;
						$message = __('data_is_not_saved') . " Member Language";
						goto load_api_data;
					}
	
					$db->commit();
					$status = 200;
					$message = __('data_is_saved');
				}
			}

			load_api_data:
            $this->Api->set_result($status, $message, $results);
        }

		$this->Api->output();
	}

	public function api_edit_member() {	

		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$results = (object)array();

			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';

			} elseif (!isset($data['member_id']) || empty($data['member_id'])) {	
				$message = __('missing_parameter') .  'member_id';

			} elseif (!isset($data['role']) || empty($data['role'])) {	// json role id ["1", "3"]
				$message = __('missing_parameter') .  'role';

			} elseif (!isset($data['school_id']) || empty($data['school_id'])) {	
				$message = __('missing_parameter') .  'school_id';

			} elseif (!isset($data['token']) || empty($data['token'])) {	
				 $message = __('missing_parameter') .  'token';
				 
			} elseif (!isset($data['name']) || empty($data['name'])) {	
				$message = __('missing_parameter') .  'name';

			} elseif (!isset($data['phone_number']) || empty($data['phone_number'])) {	
				$message = __('missing_parameter') .  'phone_number';
		   
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);
				if (!$result_MemberLoginMethod) {
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_api_data;
				}

				if (!$this->Member->exists($data['member_id'])) {
					$status = 999;
					$message = __d('member', 'invalid_member');
					goto load_api_data;
				}

				$obj_MemberManageSchool = ClassRegistry::init('Member.MemberManageSchool');
				$cond = array(
					'MemberManageSchool.school_id' => $data['school_id'],
					'MemberManageSchool.member_id <>' => $data['member_id'],
				);
				if (!$obj_MemberManageSchool->hasAny($cond)) {
					$status = 600;
					$message = __d('member', 'invalid_role');
					goto load_api_data;
				}

				// validate username, email, phone
				// check exist

				$conditions = array(
					'Member.email' 	=> $data['email'],
					'Member.id <>' 	=> $data['member_id'],
				);
				if ($this->Member->hasAny($conditions)) {
					$status = 999;
					$message = __d('member', 'exist_email') . "!";
					goto load_api_data;
				}

				$conditions = array(
					'Member.phone_number' 	=> $data['phone_number'],
					'Member.id <>' 			=> $data['member_id'],
				);
				if ($this->Member->hasAny($conditions)) {
					$status = 999;
					$message = __d('member', 'exist_phone_number');
					goto load_api_data;
				}
		
				$db = $this->Member->getDataSource();
				$db->begin();
				$data_Member = array(
					'id'			=> $data['member_id'],
					'email' 		=> $data['email'],
					'phone_number' 	=> $data['phone_number'],
				);
			
				if ($save_model = $this->Member->save($data_Member)) {
				
					$roles = json_decode($data['role']);

					// remove all role first ====>> push to member roles model
					$member_id 	= $save_model['Member']['id'];
					$school_id 	= $data['school_id'];

					$role_id 	= Environment::read('role.teacher');
					if (!$this->Member->MemberRole->clear_role_by_school($member_id, $role_id, $school_id)) {
						$db->rollback();
						$status = 999;
						$message = __('data_is_not_saved') . " Clear Member Role (Teacher)";
						goto load_api_data;
					}

					$role_id 	= Environment::read('role.school-admin');
					if (!$this->Member->MemberRole->clear_role_by_school($member_id, $role_id, $school_id)) {
						$db->rollback();
						$status = 999;
						$message = __('data_is_not_saved') . " Clear Member Role (School Admin)";
						goto load_api_data;
					}

					foreach ($roles as $role) {

						if ($role != Environment::read('role.teacher') && $role != Environment::read('role.school-admin')) {
							$db->rollback();
							$status = 999;
							$message = __('just_accept_teacher_school_admin');
							goto load_api_data;
						}

						$data_MemberRole[] = array(
							'member_id' => $data['member_id'],
							'role_id' 	=> $role,
							'school_id' => $data['school_id'],
						);
					}

					// 1. save member role
					if (!$this->Member->MemberRole->saveAll($data_MemberRole)) {
						$db->rollback();
						$status = 999;
						$message = __('data_is_not_saved') . " Member Role";
						goto load_api_data;
					}

					// 2,save language
					$data_MemberLanguage = $this->Member->MemberLanguage->get_info_by_language($data['member_id'], $data['language']);
					$data_MemberLanguage['MemberLanguage']['name'] = $data['name'];

					if (!$this->Member->MemberLanguage->save($data_MemberLanguage['MemberLanguage'])) {
						$db->rollback();
						$status = 999;
						$message = __('data_is_not_saved') . " Member Language";
						goto load_api_data;
					}
	
					$db->commit();
					$status = 200;
					$message = __('data_is_saved');
				}
			}

			load_api_data:
            $this->Api->set_result($status, $message, $results);
        }

		$this->Api->output();
	}

	public function api_export_member() {	
		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$results = (object)array();

			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		
			} elseif (!isset($data['role']) || empty($data['role'])) {	// 1: teacher, 2: student.
				$message = __('missing_parameter') .  'role';

			} elseif (!isset($data['school_id']) || empty($data['school_id'])) {	
				$message = __('missing_parameter') .  'school_id';

			} elseif (!isset($data['token']) || empty($data['token'])) {	
				$message = __('missing_parameter') .  'token';

			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(false);

				$this->Api->set_language($data['language']);

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);
				if (!$result_MemberLoginMethod) {
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_api_data;
				}

				$obj_MemberManageSchool = ClassRegistry::init('Member.MemberManageSchool');
				$cond = array(
					'MemberManageSchool.school_id' => $data['school_id'],
					'MemberManageSchool.member_id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
				);
				if (!$obj_MemberManageSchool->hasAny($cond)) {
					$status = 600;
					$message = __d('member', 'invalid_role');
					goto load_api_data;
				}

				$header = array(
					__('id'),
					__d('member', 'member'),
					__d('administration', 'role'),
					__d('member', 'name'),
					// __('created'),
					// __('created_by'),
					// __('updated'),
					// __('updated_by'),
				);

				// get school code
				$obj_School = ClassRegistry::init('School.School');
				$result_School = $obj_School->get_school_by_id($data['school_id']);

				$file_name = 'members_' . date('Ymdhis');


				// data;
				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$role = json_decode($data['role']);
				$results = $obj_MemberLoginMethod->get_member_belong_school_with_role($data['school_id'], $role, $data['language']);


				$today = date('Y_m_d');
				$file_name = $today . "_" . $result_School['School']['school_code'] . '_teacher.xlsx';
				$path_of_file = WWW_ROOT . 'uploads' . DS . 'export' . DS . $file_name;

				$this->ExcelSpout->export_excel($header, $results, $path_of_file);								

				$status = 200;
				$message = "Export file successfully!!!";
			}

			load_api_data:
            $this->Api->set_result($status, $message, $results);
        }

		$this->Api->output();
	}
}
