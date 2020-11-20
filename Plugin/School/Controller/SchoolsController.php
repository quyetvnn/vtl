<?php
App::uses('SchoolAppController', 'School.Controller');
/**
 * Schools Controller
 *
 * @property School $School
 * @property PaginatorComponent $Paginator
 */
class SchoolsController extends SchoolAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Email');

	public function beforeFilter(){
		parent::beforeFilter();
        $this->set('title_for_layout', __d('school','school') .  " > " . __d('school','schools') );
  	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
	
		$conditions = array();
		$school_id = array();
		$data_search = $this->request->query;

		if ($this->school_id) {
			$conditions = array(
				'School.id' => $this->school_id,
			);
			$school_id = $this->school_id;
		}

		if (isset($data_search["school_code"]) && $data_search["school_code"]) {
			$conditions['School.school_code LIKE'] = '%' . $data_search["school_code"] . '%';
		}
	
		if (isset($data_search["email"]) && $data_search["email"]) {
			$conditions['School.email LIKE'] = '%' .$data_search["email"] . '%';
		}

		if (isset($data_search["is_status"]) && $data_search["is_status"] != null) {
			$conditions['School.status'] = $data_search["is_status"];
		}


		
		$obj_ImageType = ClassRegistry::init('Dictionary.ImageType');

		$all_settings = array(
			'contain' => array(
				'SchoolImage' => array(
					'conditions' => array(
						'SchoolImage.image_type_id' => 	$obj_ImageType->get_id_by_slug('school-logo'),
					),
				),
				'SchoolLanguage' => array(
					'conditions' => array(
						'SchoolLanguage.alias' => $this->lang18,
					),
				),
				'CreatedBy',
			),
			'recursive' => 0,
			'order' => 'School.id DESC',
			'conditions' => $conditions,
		);
		

		$this->Paginator->settings = $all_settings;
		$schools = $this->paginate();
		$status = $this->School->status;

		$this->set(compact('schools', 'school_id', 'status', 'data_search'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->School->exists($id)) {
			throw new NotFoundException(__('Invalid school'));
		}
		$options = array(
			'conditions' => array(
				'School.' . $this->School->primaryKey => $id
			),
			'contain' => array(
				'SchoolImage' => array(
					'ImageType' => array(
						'ImageTypeLanguage' => array(
							'fields' => array(
								'ImageTypeLanguage.name',
								'ImageTypeLanguage.description',
							),
							'conditions' => array(
								'ImageTypeLanguage.alias' => $this->lang18
							),
						),
					),
				),
				'SchoolLanguage',
				'CreatedBy',
				'UpdatedBy'
			),
		);

		$language_input_fields = array(
			'name',
			'description'
		);
		$school = $this->School->find('first', $options);
		$languages = isset($school['SchoolLanguage']) ? $school['SchoolLanguage'] : array();

		// images
		$images = array();
		if (isset($school['SchoolImage']) && !empty($school['SchoolImage'])) {
			foreach ($school['SchoolImage'] as $item) {

				// add name
				$item['type'] = isset($item['ImageType']['ImageTypeLanguage']) ? reset($item['ImageType']['ImageTypeLanguage'])['name'] . " " . reset($item['ImageType']['ImageTypeLanguage'])['description'] : array();	// name
				$images[] = $item;
			}
		}


		$status = $this->School->status;
		$this->set(compact('language_input_fields', 'school', 'images', 'languages', 'status'));

	
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {

		$model = 'School';
		$images_model = 'SchoolImage';
		$languages_model = 'SchoolLanguage';

		$db = $this->School->getDataSource();
		$db->begin();

		if ($this->request->is('post')) {
			$this->School->create();

			$data = $this->request->data;
			$data['School']['status'] = $data['School']['status_id'];
			$data['School']['school_code'] = strtoupper($data['School']['school_code']);

			// check same schoolcode.
			$conditions = array(
				'School.school_code' => $data['School']['school_code'],
			);

			if ($this->School->hasAny($conditions)) {
				$this->Session->setFlash(__('school_code_is_exist'), 'flash/error');
				goto load_data;
			}

			if ($save_model = $this->School->save($data['School'])) {

				// save login methods too;
				// $obj_LoginMethod = ClassRegistry::init('Member.LoginMethod');
				// $data_LoginMethod = array(
				// 	'id' => $save_model['School']['id'],
				// 	'name' => strtoupper($data['School']['school_code']),
				// );
				// if (!$obj_LoginMethod->save($data_LoginMethod)) {
				// 	$db->rollback();
				// 	$this->Session->setFlash(__('data_is_not_saved') . " Login Method", 'flash/error');
				// 	goto load_data;
				// }

				// 2,save language
				if (isset($data['SchoolLanguage']) && !empty($data['SchoolLanguage'])) {
					foreach ($data['SchoolLanguage'] as &$language) {
						$language['school_id'] = $save_model['School']['id'];
					}

					if (!$this->School->SchoolLanguage->saveAll($data['SchoolLanguage'])) {
						$db->rollback();
						$this->Session->setFlash(__('data_is_not_saved') . " School Language", 'flash/error');
						goto load_data;
					}
				}

				$save_data = array();

				// 3,save images
				if (isset($data['SchoolImage']) && !empty($data['SchoolImage'])) {
					$uploaded_images = $data['SchoolImage'];

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
											'school_id' => $save_model['School']['id'],
										);
										$save_data[] = $temp;
									}
								} else {
									$db->rollback();
									$this->Flash->error(__('Fail to upload '.$model.' image. Please, try again.'));
									goto load_data;
								}

							} else {
								$db->rollback();
								$this->Flash->error(__('Failed to upload '.$model.' image. Please, try again!'));
								goto load_data;
							}
						}
					}

					if (!empty($save_data)) {
						if (!$this->School->SchoolImage->saveAll($save_data) ){
								
							$db->rollback();
							$this->Session->setFlash(__('The SchoolImage method could not be saved. Please, try again.'), 'flash/error');
							goto load_data;
						}
					}
				}
				
				$db->commit();
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));

			} else {
				$db->rollback();
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
				goto load_data;
			}
		}

		load_data:
		$language_input_fields = array(
			'id',
			'alias',
			// 'name',
			// 'name',
			// 'about_us',
		);

		$objLanguage = ClassRegistry::init('Dictionary.Language');
		$languages_list = $objLanguage->get_languages();
		// Images upload
		$add_new_images_url = Router::url(array('plugin'=>'school','controller'=>'schools','action'=>'add_new_image_with_type'), true);
		
		// display image type
		$objImageType = ClassRegistry::init('Dictionary.ImageType');
		$imageTypes = $objImageType->find_list(array(
			'ImageType.slug LIKE' => "school%",
		), $this->lang18);

		$statuses = $this->School->status;
		$this->set(compact('model', 'images_model', 'add_new_images_url', 'statuses',
						'languages_model', 'languages_list', 'language_input_fields'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		

		$model = 'School';
		$images_model = 'SchoolImage';
		$languages_model = 'SchoolLanguage';
		$obj_Member = ClassRegistry::init('Member.Member');
		
		$model_Administrator = array();

        $this->School->id = $id;
		if (!$this->School->exists($id)) {
			throw new NotFoundException(__('Invalid school'));
		}

		$db = $this->School->getDataSource();
		$db->begin();
		if ($this->request->is('post') || $this->request->is('put')) {

			$data = $this->request->data;
			$image_type_ids = array();
			$save_data = array();

			// image type from upload 
			if (isset($data['SchoolImage']) && !empty($data['SchoolImage'])) {
				$uploaded_images = $data['SchoolImage'];
				foreach ($uploaded_images as $key => $image) {

					if( isset($image['image_type_id']) && !empty($image['image_type_id']) ){
						$image_type_ids[] = $image['image_type_id'];
					}
				}
			}

			// image type from current 
			$obj_SchoolImage = ClassRegistry::init('School.SchoolImage');
			$result_SchoolImage = $obj_SchoolImage->get_obj($id);

			if ($result_SchoolImage) {
				foreach ($result_SchoolImage as $val) {
					$image_type_ids[] = $val['SchoolImage']['image_type_id'];
				}
			}


			for ($i = 0; $i < count($image_type_ids) - 1; $i++) {
				for ($j = $i + 1; $j < count($image_type_ids); $j++) {
					if ($image_type_ids[$i] == $image_type_ids[$j]) { // same
						$this->Session->setFlash(__d('school', 'duplicate_logo_banner'), 'flash/error');
						$options = array(
							'conditions' => array(
								'School.' . $this->School->primaryKey => $id
							),
							'contain' => array(
								'SchoolImage',
								'SchoolLanguage',
							),
						);
						$this->request->data = $this->School->find('first', $options);
						goto load_data;
					}
				}
			}
		
			// check same schoolcode.
			$count = $this->School->find('count', array(
				'conditions' => array(
					'School.school_code' => $data['School']['school_code'],
					'School.id <>' => $id,
				))
			);
			if ($count > 0) {
				$this->Session->setFlash(__('school_code_is_exist'), 'flash/error');
				goto load_data;
			}

			//if (!$this->school_id) {
				$data['School']['status'] = $data['status_id'];
			//}
			
			if ($this->School->save($data['School'])) {

				// save login methods too;
				// $obj_LoginMethod = ClassRegistry::init('Member.LoginMethod');
				// $data_LoginMethod = array(
				// 	'id' => $id,
				// 	'name' => strtoupper($data['School']['school_code']),
				// );
				// if (!$obj_LoginMethod->save($data_LoginMethod)) {
				// 	$db->rollback();
				// 	$this->Session->setFlash(__('data_is_not_saved') . " Login Method", 'flash/error');
				// 	goto load_data;
				// }

				// 2,save language
				$lang = array();
				if (isset($data['SchoolLanguage']) && !empty($data['SchoolLanguage'])) {
					foreach ($data['SchoolLanguage'] as &$language) {
						$language['school_id'] = $id;
						$lang[] = $language;
					}
				
					if (!$this->School->SchoolLanguage->saveAll($lang)) {	//////??? change the structure of SchoolLanguage
						$db->rollback();
						$this->Session->setFlash(__('data_is_not_saved') . " School Language", 'flash/error');
						goto load_data;
					}
				}

				// start save images
				$save_data = array();
				if (isset($data['SchoolImage']) && !empty($data['SchoolImage'])) {
					$uploaded_images = $data['SchoolImage'];

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
											'school_id' => $id,
										);
										
										$save_data[] = $temp;
									}
								} else {
									$this->Flash->error(__('Fail to upload '.$model.' image. Please, try again.'));
									$db->rollback();
									goto load_data;
								}
							} else {
								$this->Flash->error(__('Failed to upload '.$model.' image. Please, try again!'));
								$db->rollback();
								goto load_data;
							}

						} else {
							$this->Flash->error(__('invalid_image_type'));
							$db->rollback();
							goto load_data;
						}
					} // end foreach

					if (!empty($save_data)) {
						if (!$this->School->SchoolImage->saveAll($save_data)) {
							$db->rollback();
							$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
							$this->redirect(array('action' => 'index'));
						}
					}
				} 

				// 4, delete images
				if( isset($data['remove_image']) && !empty($data['remove_image']) ){
					$this->School->remove_uploaded_image('SchoolImage', 'School' , $data['remove_image'] );
				}

				// JUST super admin can do it
				if (!$this->school_id && $data['School']['status'] == array_search('Approved', $this->School->status)) {
					$result_School = $this->School->get_obj($id);

					if ($result_School['School']['member_id'] != NULL) {	// exist member id => send mail and update role
		
						// get login method from member_id
						$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
					
						$result_MemberLoginMethod = $obj_MemberLoginMethod->find('first', array(
							'conditions' => array(
								'MemberLoginMethod.id' => $result_School['School']['member_login_method_id'],
							),
							'fields' => array(
								'MemberLoginMethod.username',
								'MemberLoginMethod.password',
							),
						));

						if ($result_MemberLoginMethod) {
							$count = $obj_MemberLoginMethod->check_exist(
								$result_MemberLoginMethod['MemberLoginMethod']['username'], 
								$id);
			
							if (!$count) {	// add role
								$data_MemberLoginMethod = array(
									'member_id' => $result_School['School']['member_id'],
									'username'	=> $result_MemberLoginMethod['MemberLoginMethod']['username'],
									'password'	=> $result_MemberLoginMethod['MemberLoginMethod']['password'],
									'school_id'	=> $id,	// school id
								);

								if (!$obj_MemberLoginMethod->save($data_MemberLoginMethod)) {
									$db->rollback();
									$this->Session->setFlash(__('data_is_not_saved') . "MemberLoginMethod", 'flash/error');
									$this->redirect(array('action' => 'index'));
								}
							}
						}

						// add adminstration
						$obj_Administrator = ClassRegistry::init('Administration.Administrator');
						$administrator_id = $obj_Administrator->get_id_by_email($result_MemberLoginMethod['MemberLoginMethod']['username'], $result_School['School']['member_id']);
						$model_Administrator = array();

						if (!$administrator_id) {	
							$data_Administrator = array(
								'name' => $result_MemberLoginMethod['MemberLoginMethod']['username'],
								'email' => $result_MemberLoginMethod['MemberLoginMethod']['username'],
								'password' => $result_MemberLoginMethod['MemberLoginMethod']['password'],
								'member_id' => $result_School['School']['member_id'],
							);

							if (!$model_Administrator = $obj_Administrator->save($data_Administrator)) {
								$db->rollback();
								$this->Session->setFlash(__('data_is_not_saved') . " Administrator" . json_encode($obj_Administrator->invalidFields()), 'flash/error');
								$this->redirect(array('action' => 'index'));
							}


							// add role administrator
							$obj_AdministratorRole = ClassRegistry::init('Administration.AdministratorsRole');
							$count = $obj_AdministratorRole->check_exist($model_Administrator['Administrator']['id'], Environment::read('role.school-admin'));
							if (!$count) {	// add role
								$data_AdministratorRole = array(
									'administrator_id' => $model_Administrator['Administrator']['id'],
									'role_id'	=> Environment::read('role.school-admin'),
								);

								if (!$obj_AdministratorRole->save($data_AdministratorRole)) {
									$db->rollback();
									$this->Session->setFlash(__('data_is_not_saved') . " Administrator Role", 'flash/error');
									$this->redirect(array('action' => 'index'));
								}
							}
						}
						
						// add new role
						$data_MemberRole  = array();
						$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
						$count = $obj_MemberRole->check_exist($result_School['School']['member_id'], Environment::read('role.school-admin'), $id);
						if (!$count) {	// add role school admin
							$data_MemberRole[] = array(
								'member_id' => $result_School['School']['member_id'],
								'role_id'	=> Environment::read('role.school-admin'),
								'school_id'	=> $id, 
							);
						}

						$count = $obj_MemberRole->check_exist($result_School['School']['member_id'], Environment::read('role.teacher'), $id);
						if (!$count) {	// add role teacher
							$data_MemberRole[] = array(
								'member_id' => $result_School['School']['member_id'],
								'role_id'	=> Environment::read('role.teacher'),
								'school_id'	=> $id, 
							);
						}
						if ($data_MemberRole) {
							if (!$obj_MemberRole->saveAll($data_MemberRole)) {
								$db->rollback();
								$this->Session->setFlash(__('data_is_not_saved') . " Role", 'flash/error');
								$this->redirect(array('action' => 'index'));
							}
						}
					

						// add member manage school
						$obj_MemberManageSchool = ClassRegistry::init('Member.MemberManageSchool');
						$count = $obj_MemberManageSchool->check_exist($result_School['School']['member_id'], $id, $administrator_id ? $administrator_id : $model_Administrator['Administrator']['id']);
						if (!$count) {	// add role
							$data_MemberManageSchool = array(
								'school_id' 		=> $id,
								'member_id' 		=> $result_School['School']['member_id'],
								'administrator_id' 	=> $administrator_id ? $administrator_id : $model_Administrator['Administrator']['id'],
							);

							if (!$obj_MemberManageSchool->save($data_MemberManageSchool)) {
								$db->rollback();
								$this->Session->setFlash(__('data_is_not_saved') . " Member Manage School", 'flash/error');
								$this->redirect(array('action' => 'index'));
							}
						}

						$result_Member = $obj_Member->get_obj($result_School['School']['member_id']);
	
						// --------- send mail to  .....
						
						$template = "create_school_" . $this->lang18;
						// send mail to school admin 
						$school_name = $this->School->get_school_name_by_id($id, $this->lang18);
				
						$link = Router::url('/', true) . 'school_registration_approved?school=' . $id;
		
						$data_Email = array(
							'username' => $result_Member['Member']['username'],
							'school_name' => $school_name,
							'school_code' => $data['School']['school_code'],
							'link'	=> $link
						);
		
						$result_email = $this->Email->send($data['School']['email'], __d('member', 'school_registration_notification'), $template, $data_Email);
		
						if($result_email['status']){
							$this->Session->setFlash(__('data_is_saved'), 'flash/success');

						}else{
							$db->rollback();
							$this->Session->setFlash($result_email['message'], 'flash/success');
						}
					}
	
				} else {
					$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				}
			
				$db->commit();
				$this->redirect(array('action' => 'index'));

			} else {
				$db->rollback();
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
				goto load_data;
			}
		} else {
			$options = array(
				'conditions' => array(
					'School.' . $this->School->primaryKey => $id
				),
				'contain' => array(
					'SchoolImage',
					'SchoolLanguage',
				),
			);
			$this->request->data = $this->School->find('first', $options);
		}
		

		load_data:
		$language_input_fields = array(
			'id',
			'alias',
			'name',
			'about_us',
			// 'name',
			// 'description',
			// 'about_us',
		);

		$objLanguage = ClassRegistry::init('Dictionary.Language');
		$languages_list = $objLanguage->get_languages();

		// Images upload
		$add_new_images_url = Router::url(array('plugin'=>'school','controller'=>'schools','action'=>'add_new_image_with_type'), true);

		$schoolBusinessRegistrations =  $this->School->SchoolBusinessRegistration->find('all', array(
			'conditions' => array(
				'school_id' => $id,
			),
		));

		// display image type
		$objImageType = ClassRegistry::init('Dictionary.ImageType');
		$imageTypes = $objImageType->find_list(array(
			'ImageType.slug LIKE' => "school%",
		), $this->lang18);

		$statuses = $this->School->status;
	
		$members = $obj_Member->get_full_list($this->lang18);
		$school_id = $this->school_id;

		$this->set(compact('school_id',
			'model', 'images_model', 'add_new_images_url', 'statuses', 'schoolBusinessRegistrations',
						'members', 'languages_model', 'languages_list', 'language_input_fields', 'imageTypes'));
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
		$this->School->id = $id;
		if (!$this->School->exists()) {
			throw new NotFoundException(__('Invalid school'));
		}
		if ($this->School->delete()) {

			// $obj_LoginMethod = ClassRegistry::init('Member.LoginMethod');
			// $obj_LoginMethod->id = $id;
			// if ($obj_LoginMethod->delete()) {
			// 	$this->Session->setFlash(__('data_is_saved'), 'flash/success');
			// 	$this->redirect(array('action' => 'index'));
			// } else {

				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
				$this->redirect(array('action' => 'index'));
			// }
		}
	}

	public function api_get_school_by_id() {	// web

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

	public function api_get_school_by_code() {	// web

		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['school_code']) || empty($data['school_code'])) {
                $message = __('missing_parameter') .  'school_code';
			
			} else {
				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$data['school_code'] = trim(strtolower($data['school_code']));
				$this->Api->set_language($data['language']);
				$result = $this->School->get_list_school_by_code($data['school_code'], $data['language']);
		
				$status 	= 200;
				$message 	= __('retrieve_data_successfully');
			}

			load_api_data:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}



	public function api_create_school() {	// web

		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
				
			} elseif (!isset($data['name']) || empty($data['name'])) {	// school name
				$message = __('missing_parameter') .  'name';
				
			} elseif (!isset($data['contact_person']) || empty($data['contact_person'])) {	// Mr Vi
				$message = __('missing_parameter') .  'contact_person';
				
			} elseif (!isset($data['email']) || empty($data['email'])) {	
				$message = __('missing_parameter') .  'email';

			} elseif (!isset($data['school_code']) || empty($data['school_code'])) {	
				$message = __('missing_parameter') .  'school_code';
				
			} elseif (!isset($data['token']) || empty($data['token'])) {	
                $message = __('missing_parameter') .  'token';
			
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);
				$this->Api->set_language($data['language']);

				$db = $this->School->getDataSource();
				$db->begin();

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);
				if (!$result_MemberLoginMethod) {
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_data_api;
				}
				// check duplicate school code

				$data['school_code'] = trim(strtolower($data['school_code']));
				$data['email'] = trim(strtolower($data['email']));

				// check same schoolcode.
				$conditions = array(
					'School.school_code' => $data['school_code'],
				);

				if ($this->School->hasAny($conditions)) {
					$db->rollback();
					$status = 999;
					$message = __d('school', 'school_code_is_exist');
					goto load_data_api;
				}

			

				// add adminstration
				$obj_Administrator = ClassRegistry::init('Administration.Administrator');
				$administrator_id = $obj_Administrator->get_id_by_email($result_MemberLoginMethod['MemberLoginMethod']['username'], $result_MemberLoginMethod['MemberLoginMethod']['member_id']);
				$model_Administrator = array();

				
				if (!$administrator_id) {	
					$data_Administrator = array(
						'name' 		=> $result_MemberLoginMethod['MemberLoginMethod']['username'],
						'email' 	=> $result_MemberLoginMethod['MemberLoginMethod']['username'],
						'password' 	=> $result_MemberLoginMethod['MemberLoginMethod']['password'],
						'member_id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
					);

					if (!$model_Administrator = $obj_Administrator->save($data_Administrator)) {
						$db->rollback();
						$this->Session->setFlash(__('data_is_not_saved') . " Administrator" . json_encode($obj_Administrator->invalidFields()), 'flash/error');
						$this->redirect(array('action' => 'index'));
					}

					$administrator_id 	= $model_Administrator['Administrator']['id'];

					// add role administrator
					$obj_AdministratorRole = ClassRegistry::init('Administration.AdministratorsRole');

					$con = array(
						'AdministratorsRole.administrator_id' 	=> $administrator_id,
						'AdministratorsRole.role_id' 			=> Environment::read('role.school-admin'),
					);
					if (!$obj_AdministratorRole->hasAny($con)) {
						$data_AdministratorRole = array(
							'administrator_id' 	=> $administrator_id,
							'role_id'			=> Environment::read('role.school-admin'),
						);

						if (!$obj_AdministratorRole->save($data_AdministratorRole)) {
							$db->rollback();
							$this->Session->setFlash(__('data_is_not_saved') . " Administrator Role", 'flash/error');
							$this->redirect(array('action' => 'index'));
						}
					}
				}

				$_data = array(
					'school_code' 		=> $data['school_code'],
					'member_id' 		=> $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
					'member_login_method_id' 	=> $result_MemberLoginMethod['MemberLoginMethod']['id'],
					'name' 				=> $data['name'],
					'phone_number' 		=> isset($data['phone_number']) && !empty($data['phone_number']) ? $data['phone_number'] : array(),
					'contact_person' 	=> $data['contact_person'],
					'email' 			=> $data['email'],
					'address' 			=> isset($data['address']) && !empty($data['address']) ? $data['address'] : array(),
					'created_by'		=> $administrator_id,
					'updated_by'		=> $administrator_id,
				);

				// save school
				$this->School->is_from_frontend = true;
				if (!$model = $this->School->save($_data)) {
					$db->rollback();
					$status = 999;
					$message = __('data_is_not_saved');
					goto load_data_api;
				}

				// create login method
				// $_data_login_method = array(
				// 	'id' 				=> $model['School']['id'],
				// 	'name' 				=> $data['school_code'],	// school code
				// );

				// $obj_LoginMethod = ClassRegistry::init('Member.LoginMethod');
				// if (!$obj_LoginMethod->save($_data_login_method)) {
				// 	$db->rollback();
				// 	$status = 999;
				// 	$message = __('data_is_not_saved') . ' LoginMethod ' .  debug($obj_LoginMethod->invalidFields());
				// 	goto load_data_api;
				// }

				// save language
				$alias = array( 'zho', 'eng', 'chi' );
				$_data_language = array();
				foreach ($alias as $v) {
					$_data_language[] = array(
						'school_id' => $model['School']['id'],
						'name' 		=> $data['name'],
						'alias'		=> $v,
					);
				}

				if (!$this->School->SchoolLanguage->saveAll($_data_language)) {
					$db->rollback();
					$status = 999;
					$message = __('data_is_not_saved') . ' language';
					goto load_data_api;
				}

				// save default SchoolImageBackground
				// get random backgroud
				$rand = rand(1, 4); 

				$obj_ImageType = ClassRegistry::init('Dictionary.ImageType');
				$image_type_id = $obj_ImageType->get_id_by_slug('school-banner');

				$data_SchoolImage = array(
					'school_id' => $model['School']['id'],
					'path' => 'img/school-page/cover-' . $rand . '.jpg',
					'image_type_id' => $image_type_id,
					'width' => 0,
					'height' => 0,
					'size' => 0,
				);
				if (!$this->School->SchoolImage->save($data_SchoolImage)) {
					$db->rollback();
					$status = 999;
					$message = __('data_is_not_saved') . ' school image';
					goto load_data_api;
				}
	
	
				// get login method from member_id
				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');

				$con = array(
					'MemberLoginMethod.username' 		=> $result_MemberLoginMethod['MemberLoginMethod']['username'],
					'MemberLoginMethod.school_id' 		=> $model['School']['id'],
				);
				if (!$obj_MemberLoginMethod->hasAny($con)) {
					$data_MemberLoginMethod = array(
						'member_id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
						'username'	=> $result_MemberLoginMethod['MemberLoginMethod']['username'],
						'password'	=> $result_MemberLoginMethod['MemberLoginMethod']['password'],
						'school_id'	=> $model['School']['id'],
					);

					if (!$obj_MemberLoginMethod->save($data_MemberLoginMethod)) {
						$db->rollback();
						$this->Session->setFlash(__('data_is_not_saved') . "MemberLoginMethod", 'flash/error');
						$this->redirect(array('action' => 'index'));
					}
				}


				
				// add new role
				$data_MemberRole  = array();
				$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
		
				// add school admin
				$roles = array(Environment::read('role.school-admin'), Environment::read('role.teacher'));
				foreach ($roles as $r) {
					$con = array(
						'MemberRole.member_id' 	=> $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
						'MemberRole.school_id' 	=> $model['School']['id'],
						'MemberRole.role_id' 	=> $r,
					);
					if (!$obj_MemberRole->hasAny($con)) {
						$data_MemberRole[] = array(
							'member_id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
							'school_id'	=> $model['School']['id'], 
							'role_id'	=> $r,
						);
					}
				}

				if ($data_MemberRole) {
					if (!$obj_MemberRole->saveAll($data_MemberRole)) {
						$db->rollback();
						$this->Session->setFlash(__('data_is_not_saved') . " Role", 'flash/error');
						$this->redirect(array('action' => 'index'));
					}
				}
			
				// add member manage school
				$obj_MemberManageSchool = ClassRegistry::init('Member.MemberManageSchool');
				$con = array(
					'MemberManageSchool.school_id' 			=> $model['School']['id'], 
					'MemberManageSchool.member_id' 			=> $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
					'MemberManageSchool.administrator_id' 	=> $administrator_id ? $administrator_id : $model_Administrator['Administrator']['id'],
				);
			
				if (!$obj_MemberManageSchool->hasAny($con)) {
					$data_MemberManageSchool = array(
						'school_id' 		=> $model['School']['id'], 
						'member_id' 		=> $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
						'administrator_id' 	=> $administrator_id ? $administrator_id : $model_Administrator['Administrator']['id'],
					);

					if (!$obj_MemberManageSchool->save($data_MemberManageSchool)) {
						$db->rollback();
						$this->Session->setFlash(__('data_is_not_saved') . " Member Manage School", 'flash/error');
						$this->redirect(array('action' => 'index'));
					}
				}

				// upload school business registrations
				if (isset($_FILES) && !empty($_FILES)) { 	
					// Upload File
					$files 			= array();
					$files_save 	= array();

					// number of files
					if (!isset($data['number_file']) || empty($data['number_file'])) {
						$message = __('missing_parameter') . " number_file";
						goto load_data_api;
					}

					for ($i = 0; $i < $data['number_file']; $i++) {
						$_file_name = 'file' . $i;
					
						if (isset($_FILES[$_file_name])) {
	
							if ($_FILES[$_file_name]['size'] > 0) {
								$files[] = $_FILES[$_file_name];
								
							} else {
								$data[$_file_name] = '';
							}
											
							$relative_path = 'uploads' . DS . 'SchoolBusinessRegistration' . DS . $model['School']['id'];
							$file_name_suffix = "file";

							$uploaded_images = $this->Common->upload_file($files, $relative_path, $file_name_suffix);

							if (isset($uploaded_images['status']) && ($uploaded_images['status'] == true) ) {
								if (isset($uploaded_images['params']['success']) && !empty($uploaded_images['params']['success']) ){
									foreach($uploaded_images['params']['success'] as $key => $val) {
											
										$files_save[] = array(
											'name' 				=> $val['ori_name'],
											'path' 				=> str_replace("\\",'/',$val['path']),
											'school_id' 		=> $model['School']['id'],
											'type' 				=> $val['type'],
											'size' 				=> $val['size'],
										);
										
									}
								}
							} else {
								$db->rollback();
								$message = __d('member', "upload_failed");
								$status = 999;
								$db->rollback();
								goto load_data_api;
							}
						}
					}

					// save
					if (!empty($files_save)) {
						if (!$this->School->SchoolBusinessRegistration->saveAll($files_save) ){
							$db->rollback();
							$status = 999;
							$message = __('data_is_not_saved') . ' school business registration';
							goto load_data_api;
						}
					}

				}
				$status = 200;
				$message = __('data_is_saved');
				$result = array(
					'school_id' => 	$model['School']['id'],
				);
				$db->commit();
			}

			load_data_api:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}

	public function api_edit_school() {	// web

		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
				
			} elseif (!isset($data['about_us'])) {	
				$message = __('missing_parameter') .  'about_us';
			
			} elseif (!isset($data['email'])) {	
				$message = __('missing_parameter') .  'email';
				
			} elseif (!isset($data['token']) || empty($data['token'])) {	
                $message = __('missing_parameter') .  'token';
			
			} elseif (!isset($data['id']) || empty($data['id'])) {	
				$message = __('missing_parameter') .  'id';
				
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);
				$this->Api->set_language($data['language']);

				$db = $this->School->getDataSource();
				$db->begin();

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

				// get administrator id
				$list_username = $obj_MemberLoginMethod->get_list_username_by_member_id($result_MemberLoginMethod ['MemberLoginMethod']['member_id']);

				$administrator_id = "";
				if ($list_username) {	// array usernames

					$obj_Administrator = ClassRegistry::init('Administration.Administrator');
					$administrator_id = $obj_Administrator->get_id_by_username($list_username);	
				}


				$this->School->is_from_frontend = true;
				$data_School = array(
					'id' 				=> $data['id'],
					'email' 			=> $data['email'],
					'phone_number' 		=> isset($data['phone_number']) && !empty($data['phone_number']) ? $data['phone_number'] : array(),
					'address' 			=> isset($data['address']) 		&& !empty($data['address']) 	 ? $data['address'] : array(),
					'created_by'		=> $administrator_id,
					'updated_by'		=> $administrator_id,
				);

				if (!$this->School->save($data_School)) {
					$db->rollback();
					$status = 999;
					$message = __('data_is_not_saved');
					goto load_data_api;
				}

				// get language with school id
				$result_SchoolLanguage = $this->School->SchoolLanguage->get_language_by_school_id($data['id'], $data['language']);
				$result_SchoolLanguage['SchoolLanguage']['about_us'] = $data['about_us'];

				if (!$this->School->SchoolLanguage->save($result_SchoolLanguage['SchoolLanguage'])) {
					$db->rollback();
					$status = 999;
					$message = __('data_is_not_saved');
					goto load_data_api;
				}

				// upload images logo/banner
				if (isset($_FILES) && !empty($_FILES)) { 	
					
					$obj_ImageType = ClassRegistry::init('Image.ImageType');
					$logo_type_id = $obj_ImageType->get_id_by_slug('school-logo');
					$banner_type_id = $obj_ImageType->get_id_by_slug('school-banner');

					$image_logo = $this->upload_image('logo0', $data['id'], $logo_type_id);
					if ($image_logo) {
						// clear old first
						if (!$this->School->SchoolImage->deleteAll(
							array(
								'SchoolImage.school_id' => $data['id'],
								'SchoolImage.image_type_id' => $logo_type_id
							), false )) {
							$db->rollback();
							$status = 999;
							$message = __('data_is_not_saved') . " School Image logo";
							goto load_data_api;
						}
						$this->School->SchoolImage->clear();

					}

					$image_banner = $this->upload_image('banner0', $data['id'], $banner_type_id);
					if ($image_banner) {
						// clear old first
						if (!$this->School->SchoolImage->deleteAll(
							array(
								'SchoolImage.school_id' => $data['id'],
								'SchoolImage.image_type_id' => $banner_type_id
							), false)) {
							$db->rollback();
							$status = 999;
							$message = __('data_is_not_saved') . " School Image logo";
							goto load_data_api;
						}
						$this->School->SchoolImage->clear();
					}

					$image_save =  array_merge($image_logo, $image_banner);

					// save
					if (!empty($image_save)) {
						if (!$this->School->SchoolImage->saveAll($image_save) ){
							$db->rollback();
							$status = 999;
							$message = __('data_is_not_saved') . ' school image';
							goto load_data_api;
						}
					}
				}

				$db->commit();
				$status = 200;
				$message = __('data_is_saved');
			}

			load_data_api:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}


	public function upload_image($_file_name,  $school_id, $image_type_id) {
		$image_save = array();
		$images = array();

		if (isset($_FILES[$_file_name])) {

			if ($_FILES[$_file_name]['size'] > 0) {
				$images[] = $_FILES[$_file_name];
				
			} else {
				$data[$_file_name] = '';
			}
							
			$relative_path = 'uploads' . DS . 'SchoolImage';
			$file_name_suffix = "image";

			$uploaded_images = $this->Common->upload_images($images, $relative_path, $file_name_suffix);

			if (isset($uploaded_images['status']) && ($uploaded_images['status'] == true) ) {
				if (isset($uploaded_images['params']['success']) && !empty($uploaded_images['params']['success']) ){
					foreach($uploaded_images['params']['success'] as $key => $val) {
						$image_save[] = array(
							'path' 				=> str_replace("\\",'/',$val['path']),
							'school_id' 		=> $school_id,
							'image_type_id'		=> $image_type_id,
							'width' 			=> $val['width'],
							'height' 			=> $val['height'],
							'size' 				=> $val['size'],
						);
					}
				}
			} 
		}
		return $image_save;
	}
}
