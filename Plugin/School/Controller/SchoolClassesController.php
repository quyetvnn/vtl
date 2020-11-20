<?php
App::uses('SchoolAppController', 'School.Controller');
/**
 * SchoolClasses Controller
 *
 * @property SchoolClass $SchoolClass
 * @property PaginatorComponent $Paginator
 */
class SchoolClassesController extends SchoolAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function beforeFilter(){
		parent::beforeFilter();
        $this->set('title_for_layout', __d('school','school') .  " > " . __d('school','school_classes') );
  	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
	
		$conditions = array();
		$school_id = array();
		if ($this->school_id) {
			$conditions = array(
				'School.id' => $this->school_id,
			);
			$school_id = $this->school_id;
		}

		$data_search = $this->request->query;

		if (isset($data_search["school_id"]) && $data_search["school_id"]) {
			$conditions['SchoolClass.school_id'] = $data_search["school_id"];
		}
	
		if (isset($data_search["name"]) && $data_search["name"]) {
			$conditions['SchoolClass.name LIKE'] = '%' . trim($data_search["name"]) . '%';
		}

		if (isset($data_search["level"]) && $data_search["level"] != null) {
			$conditions['SchoolClass.level LIKE'] = '%' . trim($data_search["level"]) . '%';
		}

		$all_settings = array(
			'contain' => array(
				'School' => array(
					'fields' => array(
						'School.school_code',
					),
					'SchoolLanguage' => array(
						'fields' => array(
							'SchoolLanguage.*'
						),
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18,
						),
					),
				),
				'CreatedBy',
			),
			'recursive' => 0,
			'order' => 'SchoolClass.id DESC',
			'conditions' => $conditions,
		);

		$this->Paginator->settings = $all_settings;
		$schoolClasses = $this->paginate();

		$obj_School = ClassRegistry::init('School.School');
		$schools = $obj_School->get_list_school($school_id, $this->lang18);

		$this->set(compact('schoolClasses', 'school_id', 'data_search', 'schools'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {

		if (!$this->SchoolClass->exists($id)) {
			throw new NotFoundException(__('Invalid school class'));
		}
		$options = array(
			'conditions' => array(
				'SchoolClass.' . $this->SchoolClass->primaryKey => $id
			),
			'contain' => array(
				'School' => array(
					'SchoolLanguage' => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18
						),
					),
				),
			),
		);

		$result_SchoolClass = $this->SchoolClass->get_obj($id);
		$obj_StudentClass = ClassRegistry::init('Member.StudentClass');

		$studentClasses = $obj_StudentClass->find('all', array(
			'order' => 'StudentClass.id DESC',
			'conditions' => array(
				'StudentClass.school_id' 		=> $result_SchoolClass['SchoolClass']['school_id'],
				'StudentClass.school_class_id' 	=> $result_SchoolClass['SchoolClass']['id'],
			),
			'contain' => array(
				'Student' => array(
					'MemberLanguage' => array(
						'conditions' => array(
							'MemberLanguage.alias' => $this->lang18, 
						),
					),
				),
				'SchoolClass',
			),

		));

		$schoolClass = $this->SchoolClass->find('first', $options);
		$classes = $this->SchoolClass->get_list_class_by_school_id_not_include_myself($result_SchoolClass['SchoolClass']['school_id'], $result_SchoolClass['SchoolClass']['id']);

		$this->set(compact('schoolClass', 'studentClasses', 'classes'));
		
	
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->SchoolClass->create();

			$data = $this->request->data;

			if ($this->SchoolClass->save($data['SchoolClass'])) {
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		}

		$school_id = $this->school_id;
		$schools = array();
		if ($this->school_id) {
			$schools = $this->SchoolClass->School->get_list_school($school_id, $this->lang18);
		} else {
			$schools = $this->SchoolClass->School->get_list_school(array(), $this->lang18);
		}
		$this->set(compact('schools', 'school_id'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
        $this->SchoolClass->id = $id;
		if (!$this->SchoolClass->exists($id)) {
			throw new NotFoundException(__('Invalid school class'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {

			$data  =$this->request->data;
			if ($this->SchoolClass->save($data['SchoolClass'])) {

				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('SchoolClass.' . $this->SchoolClass->primaryKey => $id));
			$this->request->data = $this->SchoolClass->find('first', $options);
		}

		$school_id = $this->school_id;
		$schools = array();
		if ($this->school_id) {
			$schools = $this->SchoolClass->School->get_list_school($school_id, $this->lang18);
		} else {
			$schools = $this->SchoolClass->School->get_list_school(array(), $this->lang18);
		}
		$this->set(compact('schools', 'school_id'));
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

		$this->SchoolClass->id = $id;
		if (!$this->SchoolClass->exists()) {
			throw new NotFoundException(__('Invalid school class'));
		}

		if ($this->SchoolClass->delete()) {
			$this->Session->setFlash(__('data_is_saved'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}

		$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

	public function api_get_list_class_by_school_id($id = null) {

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
				$result = $this->SchoolClass->get_list_class_by_school_id($data['school_id']);
		
				$status 	= 200;
				$message 	= __('retrieve_data_successfully');
			}

			load_api_data:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}


	public function admin_add_student_to_class() {

		$this->disableCache();

        if ($this->request->is('get')) {
			$students = $this->request->students;
			$class_id = $this->request->class_id;
			$school_id = $this->request->school_id;

			// add this student 
			$obj_StudentClass = ClassRegistry::init('Member.StudentClass');
			$data_StudentClass = array();

			foreach ($students as $student) {
				$cond = array(
					'StudentClass.school_id' 		=> $school_id,
					'StudentClass.school_class_id' 	=> $class_id,
					'StudentClass.student_id' 		=> $student,
					'StudentClass.type' 			=> 1,
					'StudentClass.class_no' 		=> 1,
				);
		
				
				if (!$obj_StudentClass->hasAny($cond)) {
					$data_StudentClass[] = array(
						'school_id' 		=> $school_id,
						'school_class_id' 	=> $class_id,
						'student_id' 		=> $student,
						'type' 				=> 1,
						'class_no' 			=> 1,
					);
				}
			}

			if ($data_StudentClass) {
				if ($obj_StudentClass->saveAll($data_StudentClass)) {
					$this->Session->setFlash(__('data_is_saved'), 'flash/success');
					$this->redirect(array('plugin' => 'school', 'controller' => 'school_classes', 'action' => 'view', $class_id));
		
				} else {
					$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
					$this->redirect(array('plugin' => 'school', 'controller' => 'school_classes', 'action' => 'view', $class_id));
			
				}
			
			} else {
				$this->Session->setFlash(__d('school', 'student_is_exist'), 'flash/error');
				$this->redirect(array('plugin' => 'school', 'controller' => 'school_classes', 'action' => 'view', $class_id));
	
			}
			
		}
	
	}


	// public function admin_add_all_student_to_class() {
	// 	$this->disableCache();

    //     if ($this->request->is('get')) {
	// 		$students = $this->request->students;
	// 		$class_id = $this->request->class_id;
	// 		$school_id = $this->request->school_id;

	// 		// add this student 
	// 		$obj_StudentClass = ClassRegistry::init('Member.StudentClass');
	// 		$data_StudentClass = array();

	// 		foreach ($students as $student) {
	// 			$cond = array(
	// 				'StudentClass.school_id' 		=> $school_id,
	// 				'StudentClass.school_class_id' 	=> $class_id,
	// 				'StudentClass.student_id' 		=> $student,
	// 				'StudentClass.type' 			=> 1,
	// 				'StudentClass.class_no' 		=> 1,
	// 			);
		
				
	// 			if (!$obj_StudentClass->hasAny($cond)) {
	// 				$data_StudentClass[] = array(
	// 					'school_id' 		=> $school_id,
	// 					'school_class_id' 	=> $class_id,
	// 					'student_id' 		=> $student,
	// 					'type' 				=> 1,
	// 					'class_no' 			=> 1,
	// 				);
	// 			}
	// 		}

	// 		if ($data_StudentClass) {
	// 			if ($obj_StudentClass->saveAll($data_StudentClass)) {
	// 				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
	// 				$this->redirect(array('plugin' => 'school', 'controller' => 'school_classes', 'action' => 'view', $class_id));
		
	// 			} else {
	// 				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
	// 				$this->redirect(array('plugin' => 'school', 'controller' => 'school_classes', 'action' => 'view', $class_id));
			
	// 			}
			
	// 		} else {
	// 			$this->Session->setFlash(__d('school', 'student_is_exist'), 'flash/error');
	// 			$this->redirect(array('plugin' => 'school', 'controller' => 'school_classes', 'action' => 'view', $class_id));
	
	// 		}
	// 	}
	// }



	public function admin_upgrade_class($id) {

		if (!$this->SchoolClass->exists($id)) {
			throw new NotFoundException(__('Invalid school class'));
		}
		$result_SchoolClass = $this->SchoolClass->get_obj($id);
		$obj_StudentClass = ClassRegistry::init('Member.StudentClass');

		$studentClasses = $obj_StudentClass->find('all', array(
			'order' => 'StudentClass.id DESC',
			'conditions' => array(
				'StudentClass.school_id' 		=> $result_SchoolClass['SchoolClass']['school_id'],
				'StudentClass.school_class_id' 	=> $result_SchoolClass['SchoolClass']['id'],
			),
			'contain' => array(
				'Student' => array(
					'MemberLanguage' => array(
						'conditions' => array(
							'MemberLanguage.alias' => $this->lang18, 
						),
					),
				),
				'SchoolClass',
			),

		));

		$classes = $this->SchoolClass->get_list_class_by_school_id_not_include_myself($result_SchoolClass['SchoolClass']['school_id'], $result_SchoolClass['SchoolClass']['id']);

		$this->set(compact('studentClasses', 'classes'));
		
		$data_search = $this->request->query;
	
		
		// if (isset($data_search['add_student_to_class']) && !empty($data_search['add_student_to_class'])) {


		// 	if (isset($data_search['choose_id']) && $data_search['choose_id']){
		// 		$this->requestAction(array(
		// 			'plugin' => 'school',
		// 			'controller' => 'school_classes',
		// 			'action' => 'add_student_to_class',
		// 			'admin' => true,
		// 			'prefix' => 'admin',
		// 			'ext' => 'json'
		// 		), array(
		// 			'students' 	=> $data_search['choose_id'],
		// 			'class_id' 	=> $data_search['class_id'],
		// 			'school_id' => $result_SchoolClass['SchoolClass']['school_id'],
		// 		));
		// 	}
		// }

		if (isset($data_search['add_student_to_class']) && !empty($data_search['add_student_to_class'])) {
	
			if (isset($data_search['choose_id']) && !empty($data_search['choose_id'])) {
				$this->requestAction(array(
					'plugin' => 'school',
					'controller' => 'school_classes',
					'action' => 'add_student_to_class',
					'admin' => true,
					'prefix' => 'admin',
					'ext' => 'json'
				), array(
					// 'students'	=> $studentClasses,
					'students' 	=> $data_search['choose_id'],
					'class_id' 	=> $data_search['class_id'],
					'school_id' => $result_SchoolClass['SchoolClass']['school_id'],
				));
			
			} else {
				$this->Session->setFlash(__d('school', 'please_choose_student'), 'flash/error');
				$this->redirect(array('plugin' => 'school', 'controller' => 'school_classes', 'action' => 'view', $id));
			}
		}
	}
}
