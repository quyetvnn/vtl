<?php
App::uses('MemberAppController', 'Member.Controller');
/**
 * StudentClasses Controller
 *
 * @property StudentClass $StudentClass
 * @property PaginatorComponent $Paginator
 */
class StudentClassesController extends MemberAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	public $current_user;

	public function beforeFilter(){
		parent::beforeFilter();
        $this->set('title_for_layout', __d('member','member') .  " > " . __d('school','student_class') );
  	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$data_search = $this->request->query;
		$conditions = array();

		if (isset($data_search["school_id"]) && $data_search["school_id"]) {
			$conditions['StudentClass.school_id'] = $data_search["school_id"];
		}

		if (isset($data_search["school_class_id"]) && !empty(trim($data_search["school_class_id"]))){
			$conditions['StudentClass.school_class_id'] = $data_search["school_class_id"];
		}
	
		if(isset($data_search["student_id"]) && $data_search["student_id"]){
			$conditions['StudentClass.student_id'] = $data_search["student_id"];
		}

		$joins = array();
		if ($this->school_id) {
			$joins = array(
				array(
					'alias' => 'SchoolT',
					'table' => Environment::read('table_prefix') . 'schools',
					'type' => 'INNER',	// use LEFT
					'conditions' => array(
						'StudentClass.school_id = SchoolT.id',
						'StudentClass.school_id' => $this->school_id,
					),
				),
			);
		}

		$all_settings = array(
			'order' => 'StudentClass.id DESC',
			'joins' => $joins, 
			'conditions' => $conditions,
			'contain' => array(
				'Student' => array(
					'MemberLanguage' => array(
						'conditions' => array(
							'MemberLanguage.alias' => $this->lang18, 
						),
					),
				),
				'School' => array(
					'fields' => array(
						'School.school_code',
					),
					'SchoolLanguage' => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18, 
						),
					),
				),
				'SchoolClass',
			),
		);

		$this->Paginator->settings = $all_settings;
		$studentClasses = $this->paginate();
		$type = $this->StudentClass->type;

		$this->load_edit_data($this->school_id);

		$this->set(compact( 'studentClasses', 'type', 'data_search'));
	}

	/**
	* admin_view method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function admin_view($id = null) {
		if (!$this->StudentClass->exists($id)) {
			throw new NotFoundException(__('Invalid StudentClass'));
		}
		$options = array(
			'conditions' => array(
				'StudentClass.' . $this->StudentClass->primaryKey => $id
			),
			'contain' => array(
				'Student' => array(
					'MemberLanguage' => array(
						'conditions' => array(
							'MemberLanguage.alias' => $this->lang18, 
						),
					),
				),
				'School' => array(
					'SchoolLanguage' => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18, 
						),
					),
				),
				'SchoolClass',
				'CreatedBy', 
				'UpdatedBy'
			),
		);

		$type = $this->StudentClass->type;
		$studentClass = $this->StudentClass->find('first', $options);
		$this->set(compact('type', 'studentClass'));
	}

	/**
	* admin_add method
	*
	* @return void
	*/
	public function admin_add($school_class_id = array()) {

		$db  = $this->StudentClass->getDataSource();
		$db->begin();

		if ($this->request->is('post')) {
			$this->StudentClass->create();

			$data = $this->request->data;
		
			$data_StudentClass = $data_MemberRole = array();

			if (!$data['StudentClass']['student_id']) {
				goto load_data;
			}


			foreach ($data['StudentClass']['student_id'] as $v) {

				if ($v == null || empty($v)) {
					continue;
				}
				
				$data_StudentClass[] = array(
					'school_class_id' => $data['StudentClass']['school_class_id'],
					'student_id' 	=> $v,
					'type' 			=> 0,
					'class_no'	 	=> 0,
					'school_id' 	=> $data['StudentClass']['school_id'],
				);

				$data_MemberRole[] = array(
					'role_id' 		=> Environment::read('role.student'),
					'member_id' 	=> $v,
					'school_id' 	=> $data['StudentClass']['school_id'],
				);
			}

			// filter conditions before save
			$data_StudentClass = $this->filter_student_class_duplicate_data($data_StudentClass);
			$data_MemberRole = $this->filter_member_role_duplicate_data($data_MemberRole);

			$obj_MemberRole  = ClassRegistry::init('Member.MemberRole');

			if ($data_StudentClass) {
				if (!$this->StudentClass->saveAll($data_StudentClass)) {
					$db->rollback();
					$this->Session->setFlash(__('data_is_not_saved') . 'StudentClass', 'flash/error');
				}

			} else {
				$this->Session->setFlash(__d('school', 'student_is_exist'), 'flash/error');
				$this->redirect(array('action' => 'index'));
			}

			if ($data_MemberRole) {
				if ($obj_MemberRole->saveAll($data_MemberRole)) {

					$this->Session->setFlash(__('data_is_saved'), 'flash/success');
					$this->redirect(array('action' => 'index'));
	
				} else {
					$db->rollback();
					$this->Session->setFlash(__('data_is_not_saved') . " Member Role", 'flash/error');
				}
	
			}


			$db->commit();
			$this->Session->setFlash(__('data_is_saved'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		

		// 	if ($data_StudentClass) {
		// 		if ($this->StudentClass->saveAll($data_StudentClass)) {

		// 			if ($obj_MemberRole->saveAll($data_MemberRole)) {

		// 				$db->commit();
		// 				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
		// 				$this->redirect(array('action' => 'index'));

		// 			} else {
		// 				$db->rollback();
		// 				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
		// 			}
	
		// 		} else {
		// 			$db->rollback();
		// 			$this->Session->setFlash(__('data_is_saved'), 'flash/error');
		// 		}

		// 	} else {
		// 		$this->Session->setFlash(__d('school', 'student_is_exist'), 'flash/error');
		// 		$this->redirect(array('action' => 'index'));
		// 	}
			
		}

		load_data:
		$this->load_data();

		$current_user = $this->current_user;
		$is_school_admin = $this->current_user ? $this->current_user['is_school_admin'] : false;
		$this->set(compact('is_school_admin'));
	}

	function filter_student_class_duplicate_data($data) {

		$result = array();

		foreach ($data as &$v) {

			$conditions = array(
				'StudentClass.student_id' 	=> $v['student_id'],
				'StudentClass.school_id' 	=> $v['school_id'],
				'StudentClass.school_class_id' => $v['school_class_id'],
			);

			if (!$this->StudentClass->hasAny($conditions)) {
				$result[] = $v;
			}
		}
	
		return $result;
	}

	function filter_member_role_duplicate_data($data) {

		$result = array();
		$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
		foreach ($data as &$v) {
		
			$conditions = array(
				'MemberRole.member_id' 	=> $v['member_id'],
				'MemberRole.school_id' 	=> $v['school_id'],
				'MemberRole.role_id' 	=> $v['role_id'],
			);
			
			if (!$obj_MemberRole->hasAny($conditions)) {
				$result[] = $v;
			}
		}

		return $result;
	}

	/**
	* admin_edit method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function admin_edit($id = null) {
		$this->StudentClass->id = $id;
		if (!$this->StudentClass->exists($id)) {
			throw new NotFoundException(__('Invalid StudentClass'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {

			$data = $this->request->data;
				
			$data_StudentClass[] = array(
				'id'				=> $id,
				'school_class_id' => $data['StudentClass']['school_class_id'],
				'student_id' 	=> $data['StudentClass']['student_id'],
				'type' 			=> 0,
				'class_no'	 	=> 0,
				'school_id' 	=> $data['StudentClass']['school_id'],
			);

			$data_MemberRole[] = array(
				'role_id' 		=> Environment::read('role.student'),
				'member_id' 	=> $data['StudentClass']['student_id'],
				'school_id' 	=> $data['StudentClass']['school_id'],
			);

			$data_StudentClass = $this->filter_student_class_duplicate_data($data_StudentClass);
			$data_MemberRole = $this->filter_member_role_duplicate_data($data_MemberRole);
			
			$obj_MemberRole  = ClassRegistry::init('Member.MemberRole');

			$db = $this->StudentClass->getDataSource();
			$db->begin();

			if ($data_StudentClass) {
				if (!$this->StudentClass->saveAll($data_StudentClass)) {
					$db->rollback();
					$this->Session->setFlash(__('data_is_not_saved') . 'StudentClass', 'flash/error');
				}

			} else {
				$this->Session->setFlash(__d('school', 'student_is_exist'), 'flash/error');
				$this->redirect(array('action' => 'index'));
			}

			if ($data_MemberRole) {
				if ($obj_MemberRole->saveAll($data_MemberRole)) {

					$this->Session->setFlash(__('data_is_saved'), 'flash/success');
					$this->redirect(array('action' => 'index'));
	
				} else {
					$db->rollback();
					$this->Session->setFlash(__('data_is_not_saved') . " Member Role", 'flash/error');
				}
	
			}
		

			$db->commit();
			$this->Session->setFlash(__('data_is_saved'), 'flash/success');
			$this->redirect(array('action' => 'index'));
			
		} else {
			$options = array('conditions' => array('StudentClass.' . $this->StudentClass->primaryKey => $id));
			$this->request->data = $this->StudentClass->find('first', $options);
		}

		load_data:
		$this->load_edit_data($this->request->data['StudentClass']['school_id']);
	}

	private function load_edit_data($school_id_from_query) {
		$schools = array();
		$students = array();
		$schoolClasses = array();

		$types = $this->StudentClass->type;

		$obj_MemberRole = ClassRegistry::init('Member.MemberRole');

		$school_id = $this->school_id;

		if ($this->school_id){

			$conditions['School.id'] = $this->school_id;
			$schools = $this->StudentClass->School->get_list_school($this->school_id, $this->lang18, true);
			$schoolClasses = $this->StudentClass->SchoolClass->get_list_school_class($this->school_id);
			$students = $obj_MemberRole->get_list_members_by_school_id($this->school_id, $this->lang18, Environment::read('role.student'));
		
		} else {
			$schools = $this->StudentClass->School->get_list_school(array(), $this->lang18);
		
			$schoolClasses = $this->StudentClass->SchoolClass->get_list_school_class($school_id_from_query);
			$students = $obj_MemberRole->get_list_members_by_school_id($school_id_from_query, $this->lang18, Environment::read('role.student'));
		}

		$this->set(compact('students', 'schools', 'schoolClasses', 'school_id', 'types'));
	}

	private function load_data() {
		$schools = array();
		$schoolClasses = array();
		$types = array();
		
		$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
		$school_id = $students = array();
		// $students = $obj_MemberRole->get_all_list_member($this->lang18);

        if ($this->school_id){
			$school_id = $this->school_id;
			$schools = $this->StudentClass->School->get_list_school($this->school_id, $this->lang18);
			$schoolClasses = $this->StudentClass->SchoolClass->get_list_school_class($this->school_id);
			$students = $obj_MemberRole->get_list_members_by_school_id($this->school_id, $this->lang18, Environment::read('role.student'));
				
		} else {
			$schools = $this->StudentClass->School->get_list_school(array(), $this->lang18);
			$types = $this->StudentClass->type;
			$schoolClasses = $this->StudentClass->SchoolClass->get_list_school_class();
			$students = $obj_MemberRole->get_list_members_by_school_id(array(), $this->lang18, Environment::read('role.student'));
		}

	
		$this->set(compact('students', 'schools', 'schoolClasses', 'school_id', 'types'));
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

		$this->StudentClass->id = $id;
		if (!$this->StudentClass->exists()) {
			throw new NotFoundException(__('Invalid StudentClass'));
		}

		// $db = $this->StudentClass->getDataSource();
		// $db->begin();

		// Remove member role
		// $result = $this->StudentClass->find('first', array(
		// 	'conditions' => array(
		// 		'StudentClass.id' => $id,
		// 	),
		// ));

		if ($this->StudentClass->delete()) {

			$this->Session->setFlash(__('data_is_saved'), 'flash/success');
			$this->redirect(array('action' => 'index'));

			// $obj_MemberRole = ClassRegistry::init('Member.MemberRole');
			
			// if ($obj_MemberRole->deleteAll(
			// 	array(
			// 		'MemberRole.school_id' => $result['StudentClass']['school_id'],
			// 		'MemberRole.member_id' => $result['StudentClass']['student_id'],
			// 		'MemberRole.role_id' 	=> Environment::read('role.student'),
			// 	),
			// 	true )) {

			// 		$db->commit();
			// 		$this->Session->setFlash(__('data_is_saved'), 'flash/success');
			// 		$this->redirect(array('action' => 'index'));

			// } else {
			// 	$db->rollback();
			// 	$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			// 	$this->redirect(array('action' => 'index'));
			// }

		} else {
			//$db->rollback();
			$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			$this->redirect(array('action' => 'index'));
		}
	}


/**
 * index method
 *
 * @return void
 */
	public function index() {

		$this->layout = "bootstrap";
		$this->StudentClass->recursive = 0;

		$studentClasses = $this->StudentClass->find('all', array(
			'fields' => array(
				'StudentClass.school_class_id',
				'StudentClass.school_id',
			),
			'conditions' => array(
				'StudentClass.student_id' => $this->current_user['MemberLoginMethod']['member_id'],
			),
		));

		$obj_TeacherCreateLesson = ClassRegistry::init('Member.TeacherCreateLesson');
		$teacherCreateLessons = $obj_TeacherCreateLesson->find('all', array(
			'fields' => array(
				'TeacherCreateLesson.lesson_title',
				'TeacherCreateLesson.list_class',
				'TeacherCreateLesson.list_teacher',
				'TeacherCreateLesson.teacher_id',
				'TeacherCreateLesson.start_time',
				'TeacherCreateLesson.duration_hours',
				'TeacherCreateLesson.duration_minutes',
				'TeacherCreateLesson.meeting',
				'TeacherCreateLesson.host_key',
			),
			'conditions' => array(
				'TeacherCreateLesson.enabled' => true,
				'YEAR(TeacherCreateLesson.start_time)' 	=> date('Y'),
				'MONTH(TeacherCreateLesson.start_time)' => date('m'),
				'DAY(TeacherCreateLesson.start_time)' 	=> date('d'),
				'TeacherCreateLesson.end_time >'		=> date('Y-m-d H:i:s'),
			),
			'contain' => array(
				'Teacher' => array(
					'MemberLanguage' => array(
						'fields' => array(
							'MemberLanguage.name',
						),
						'conditions' => array(
							'MemberLanguage.alias' => $this->lang18,
						),
					),
				),
			),
			'order' => array(
				'TeacherCreateLesson.start_time ASC',
			),
			'limit' => 8,
		));


		$count = 0; 
		foreach($teacherCreateLessons as $val) {
			$is_first_item = true;
			$is_show = false;
			foreach($studentClasses as $student) {
			
				$list_class  = $val['TeacherCreateLesson']['list_class'];
				if (!is_null($list_class) && !empty($list_class)) {
					foreach (json_decode($list_class) as $class) {
						if ($class == $student['StudentClass']['school_class_id']) {
							$is_show = true;
						}
					}
				}
			}

			if (!$is_show) {
				continue;
			}
			$count++;
		}

		$this->set(compact('count', 'studentClasses', 'teacherCreateLessons'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->StudentClass->exists($id)) {
			throw new NotFoundException(__('Invalid student class'));
		}
		$options = array('conditions' => array('StudentClass.' . $this->StudentClass->primaryKey => $id));
		$this->set('studentClass', $this->StudentClass->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->StudentClass->create();
			if ($this->StudentClass->save($this->request->data)) {
				$this->Session->setFlash(__('The student class has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The student class could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$students = $this->StudentClass->Student->find('list');
		$schools = $this->StudentClass->School->find('list');
		$schoolClasses = $this->StudentClass->SchoolClass->find('list');
		$this->set(compact('students', 'schools', 'schoolClasses'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->StudentClass->exists($id)) {
			throw new NotFoundException(__('Invalid student class'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->StudentClass->save($this->request->data)) {
				$this->Session->setFlash(__('The student class has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The student class could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('StudentClass.' . $this->StudentClass->primaryKey => $id));
			$this->request->data = $this->StudentClass->find('first', $options);
		}
		$students = $this->StudentClass->Student->find('list');
		$schools = $this->StudentClass->School->find('list');
		$schoolClasses = $this->StudentClass->SchoolClass->find('list');
		$this->set(compact('students', 'schools', 'schoolClasses'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->StudentClass->id = $id;
		if (!$this->StudentClass->exists()) {
			throw new NotFoundException(__('Invalid student class'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->StudentClass->delete()) {
			$this->Session->setFlash(__('The student class has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The student class could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}


	// ---- SELECT ITEM
	// public function admin_get_member() {
	// 	$this->Api->init_result();

	// 	if( $this->request->is('post') ) {
	// 		$data = $this->request->data;
	// 		$message = "";
	// 		$status = false;
	// 		$result_data = array();
			
	// 		$this->disableCache();

	// 		if (!isset($data['school_id'])) {
	// 			$message = __('missing_parameter') .  'school_id';
				
	// 		} else {
	// 			$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
			
	// 			$result_data = $obj_MemberRole->get_list_members_by_school_id($data['school_id'], $this->lang18, Environment::read('role.student'));

	// 			$status = true;
    //         }   
	// 		$this->Api->set_result($status, $message, $result_data);
	// 	}
	// 	$this->Api->output();
	// }

	public function admin_get_school_class() {
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
				$result_data = $this->StudentClass->SchoolClass->get_list_school_class($data['school_id']);
				$status = true;
            }   
			$this->Api->set_result($status, $message, $result_data);
		}
		$this->Api->output();
	}

}
