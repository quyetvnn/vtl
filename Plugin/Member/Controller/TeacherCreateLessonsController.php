<?php
App::uses('MemberAppController', 'Member.Controller');
/**
 * TeacherCreateLessons Controller
 *
 * @property TeacherCreateLesson $TeacherCreateLesson
 * @property PaginatorComponent $Paginator
 */
class TeacherCreateLessonsController extends MemberAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Common');

	public $current_user  = array();
	public $log_module = "client_api";

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->layout = "bootstrap";

		$all_settings = array(
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
		);

		$school_id = $this->current_user['MemberLoginMethod']['login_method_id'];
		$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
		$teachers = $obj_MemberLoginMethod->get_list_teacher($school_id, $this->lang18);

		$obj_SchoolClass = ClassRegistry::init('School.SchoolClass');
		$schoolClasses = $obj_SchoolClass->get_list_school_class($school_id);
		
		$this->Paginator->settings = $all_settings;
		$teacherCreateLessons = $this->paginate();


		$current_user = $this->current_user;
		$count = 0;
		foreach ($teacherCreateLessons as $val) {
			$is_show = false;
			if ($val['TeacherCreateLesson']['teacher_id'] == $current_user['MemberLoginMethod']['member_id']) {
				$is_show = true;
			}

			$list_teacher  = $val['TeacherCreateLesson']['list_teacher'];
			if (!is_null($list_teacher) && !empty($list_teacher)) {
				foreach (json_decode($list_teacher) as $tea) {
					if ($tea == $current_user['MemberLoginMethod']['member_id']) {
						$is_show = true;
					}
				}
			}

			if (!$is_show) {
				continue;
			}
			$count++;
		}

		$minutes_setting = $this->TeacherCreateLesson->duration_minutes;

		$this->set(compact(
			'count', 'teacherCreateLessons', 'schoolClasses', 'teachers', 'current_user', 'minutes_setting'));		
	}

	

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TeacherCreateLesson->exists($id)) {
			throw new NotFoundException(__('Invalid teacher create lesson'));
		}
		$options = array('conditions' => array('TeacherCreateLesson.' . $this->TeacherCreateLesson->primaryKey => $id));
		$this->set('teacherCreateLesson', $this->TeacherCreateLesson->find('first', $options));
	}


/**
 * add method
 *
 * @return void
  */
// 	public function add() {
// 		$this->layout = "bootstrap";
// 		if(isset($_COOKIE['currentuser'])){
// 			$current_user = $this->get_profile();
//             $this->current_user = $current_user;
// 		}else{
// 			$this->Session->setFlash('Please login first', 'flash/error');
// 			$this->redirect('/');
// 		}

// 		if(isset($current_user)){
// 			$teacher = $current_user['role']=='role-teacher'?true: false;

// 			if (!$teacher) {
// 				$this->Session->setFlash(__d('member', 'this_account_dont_exist_teacher_role'), 'flash/error');
// 				$this->redirect('/');
// 			}
// 		}

// 		// $teacher = $current_user['role']=='role-teacher'?true: false;
// 		// if (!$current_user ) {
// 		// 	$this->Session->setFlash('Please login first', 'flash/error');
// 		// 	$this->redirect('/');
// 		// }
// 		// $teacher = $current_user['role']=='role-teacher'?true: false;

// 		// if (!$teacher) {
// 		// 	$this->Session->setFlash(__d('member', 'this_account_dont_exist_teacher_role'), 'flash/error');
// 		// 	$this->redirect('/');
// 		// }
// 		$this->set(compact('current_user'));
// 	}


// /**
//  * edit method
//  *
//  * @throws NotFoundException
//  * @param string $id
//  * @return void
//  */
// 	public function edit($id = null) {
// 		if (!$this->TeacherCreateLesson->exists($id)) {
// 			throw new NotFoundException(__('Invalid teacher create lesson'));
// 		}
// 		if ($this->request->is(array('post', 'put'))) {
// 			if ($this->TeacherCreateLesson->save($this->request->data)) {
// 				$this->Session->setFlash(__('The teacher create lesson has been saved.'), 'default', array('class' => 'alert alert-success'));
// 				return $this->redirect(array('action' => 'index'));
// 			} else {
// 				$this->Session->setFlash(__('The teacher create lesson could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
// 			}
// 		} else {
// 			$options = array('conditions' => array('TeacherCreateLesson.' . $this->TeacherCreateLesson->primaryKey => $id));
// 			$this->request->data = $this->TeacherCreateLesson->find('first', $options);
// 		}
// 		$schools = $this->TeacherCreateLesson->School->find('list');
// 		$schoolClasses = $this->TeacherCreateLesson->SchoolClass->find('list');
// 		$teachers = $this->TeacherCreateLesson->Teacher->find('list');
// 		$this->set(compact('schools', 'schoolClasses', 'teachers'));
// 	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->TeacherCreateLesson->id = $id;
		if (!$this->TeacherCreateLesson->exists()) {
			throw new NotFoundException(__('Invalid teacher create lesson'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->TeacherCreateLesson->delete()) {
			$this->Session->setFlash(__('The teacher create lesson has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The teacher create lesson could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	// public function admin_index() {

	// 	// $this->layout = "bootstrap";
	// 	$this->TeacherCreateLesson->recursive = 0;

	// 	// json search like
	// 	// SELECT * FROM `booster_teacher_create_lessons` 
	// 	// WHERE `list_teacher` LIKE '%"480"%'

	// 	$conditions = array();
	// 	$all_settings = array(
	// 		'contain' => array(
	// 			'Teacher' => array(
	// 				'fields' => array(
	// 					'Teacher.id',
	// 				),
	// 				'MemberLanguage' => array(
	// 					'fields' => array(
	// 						'MemberLanguage.name',
	// 					),
	// 					'conditions' => array(
	// 						'MemberLanguage.alias' => $this->lang18,
	// 					),
	// 				)
	// 			),
	// 			'School' => array(
	// 				'SchoolLanguage' => array(
	// 					'fields' => array(
	// 						'SchoolLanguage.name',
	// 					),
	// 					'conditions' => array(
	// 						'SchoolLanguage.alias' => $this->lang18,
	// 					),
	// 				),
	// 			),
	// 		),
	// 		'recursive' => 1,
	// 		'order' => 'TeacherCreateLesson.id DESC',
			
	// 	);

	// 	// $this->Paginator->settings = $all_settings;
	// 	// $teacherCreateLessons = $this->paginate();

	// 	$teacherCreateLessons = $this->TeacherCreateLesson->find('all', array(
	// 		'fields' => array(
	// 			'TeacherCreateLesson.*'
	// 		),
	// 		'contain' => array(
	// 			'Teacher' => array(
	// 				'fields' => array(
	// 					'Teacher.id',
	// 				),
	// 				'MemberLanguage' => array(
	// 					'fields' => array(
	// 						'MemberLanguage.name',
	// 					),
	// 					'conditions' => array(
	// 						'MemberLanguage.alias' => $this->lang18,
	// 					),
	// 				)
	// 			),
	// 			'School' => array(
	// 				'SchoolLanguage' => array(
	// 					'fields' => array(
	// 						'SchoolLanguage.name',
	// 					),
	// 					'conditions' => array(
	// 						'SchoolLanguage.alias' => $this->lang18,
	// 					),
	// 				),
	// 			),
	// 		),
	// 		'recursive' => 1,
	// 		'order' => 'TeacherCreateLesson.id DESC',
	// 	));

	// 	$obj_SchoolClass = ClassRegistry::init('School.SchoolClass');
	// 	$schoolClasses = $obj_SchoolClass->get_list_school_class();

	// 	$school_id = $this->current_user['MemberLoginMethod']['login_method_id'];
	// 	$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
	// 	$teachers = $obj_MemberLoginMethod->get_list_teacher($school_id, $this->lang18);

	// 	// $this->
	// 	$current_user_id = $this->current_user['MemberLoginMethod']['member_id'];

	// 	$this->set(compact('current_user_id', 'teacherCreateLessons', 'schoolClasses', 'teachers'));
	// }

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->TeacherCreateLesson->exists($id)) {
			throw new NotFoundException(__('Invalid teacher create lesson'));
		}
		$options = array('conditions' => array('TeacherCreateLesson.' . $this->TeacherCreateLesson->primaryKey => $id));
		$this->set('teacherCreateLesson', $this->TeacherCreateLesson->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->TeacherCreateLesson->create();
			if ($this->TeacherCreateLesson->save($this->request->data)) {
				$this->Session->setFlash(__('The teacher create lesson has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The teacher create lesson could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$schools = $this->TeacherCreateLesson->School->find('list');
		$schoolClasses = $this->TeacherCreateLesson->SchoolClass->find('list');
		$teachers = $this->TeacherCreateLesson->Teacher->find('list');
		$this->set(compact('schools', 'schoolClasses', 'teachers'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {

		if (!$this->TeacherCreateLesson->exists($id)) {
			throw new NotFoundException(__('Invalid teacher create lesson'));
		}

		if ($this->request->is(array('post', 'put'))) {

			$data = $this->request->data;

			$data['TeacherCreateLesson']['duration_hours'] 		= $data['TeacherCreateLesson']['duration_hour_id'];
			$data['TeacherCreateLesson']['duration_minutes'] 	= $data['TeacherCreateLesson']['duration_minute_id'];
			$data['TeacherCreateLesson']['list_teacher'] 	= isset($data['list_teacher']) && !empty($data['list_teacher']) ? json_encode($data['list_teacher']) : array();
			$data['TeacherCreateLesson']['list_class'] 		= isset($data['list_class']) && !empty($data['list_class']) 	? json_encode($data['list_class']) : array();
			$data['TeacherCreateLesson']['end_time']  		= $this->get_end_time($data['TeacherCreateLesson']['start_time'], $data['TeacherCreateLesson']['duration_hour_id'], $data['TeacherCreateLesson']['duration_minute_id']);

			if ($this->TeacherCreateLesson->save($data['TeacherCreateLesson'])) {
				$this->Session->setFlash(__('The teacher create lesson has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('plugin' => '', 'controller' => 'teacher_portals', 'action' => 'browse', 'admin' => false));
			} else {
				$this->Session->setFlash(__('The teacher create lesson could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('TeacherCreateLesson.' . $this->TeacherCreateLesson->primaryKey => $id));
			$this->request->data = $this->TeacherCreateLesson->find('first', $options);
		}

		$current_user = $this->Session->read('Member.current');
		
		if (!$current_user) {
			$this->Session->setFlash('Please login first', 'flash/error');
			$this->redirect('/');
		}

		$school_id = $current_user['MemberLoginMethod']['login_method_id'];
		
		$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
		$teachers = $obj_MemberLoginMethod->get_list_teacher(array($school_id), $this->lang18);

		$obj_SchoolClass = ClassRegistry::init('School.SchoolClass');
		$schoolClasses = $obj_SchoolClass->get_list_school_class($school_id);
		
		$durationHours 		= $this->TeacherCreateLesson->duration_hours;
		$durationMinutes 	= $this->TeacherCreateLesson->duration_minutes;
		
		$periods = array(
			0 => '每天',
			1 => '每星期',
		);
		$frequences = array(
			1 => '共1次',
			2 => '共2次',
			3 => '共3次',
			4 => '共4次',
			5 => '共5次',
			6 => '共6次',
			7 => '共7次',
			8 => '共8次',
			9 => '共9次',
			10 => '共10次',
		);

		$this->set(compact(
			'frequences', 'periods',
			'teachers', 'schoolClasses', 'durationHours', 'durationMinutes'));

		$this->set(compact('schools', 'schoolClasses', 'teachers'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->TeacherCreateLesson->id = $id;
		if (!$this->TeacherCreateLesson->exists()) {
			throw new NotFoundException(__('Invalid teacher create lesson'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->TeacherCreateLesson->delete()) {
			$this->Session->setFlash(__('The teacher create lesson has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The teacher create lesson could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	// ------------------------
	// FOR ADMIN ONLY ---------
	// ------------------------

	public function admin_index12345678() {

		$this->TeacherCreateLesson->recursive = 0;

		$conditions = array();
		$all_settings = array(
			'conditions' => array(
//				'TeacherCreateLesson.end_time >'		=> date('Y-m-d H:i:s'),
			),
			'contain' => array(
				'Teacher' => array(
					'fields' => array(
						'Teacher.id',
					),
					'MemberLanguage' => array(
						'fields' => array(
							'MemberLanguage.name',
						),
						'conditions' => array(
							'MemberLanguage.alias' => $this->lang18,
						),
					)
				),
				'School' => array(
					'SchoolLanguage' => array(
						'fields' => array(
							'SchoolLanguage.name',
						),
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18,
						),
					),
				),
			),
			'recursive' => 1,
			'order' => 'TeacherCreateLesson.id DESC',
			
		);

		$this->Paginator->settings = $all_settings;
		$teacherCreateLessons = $this->paginate();


		$obj_SchoolClass = ClassRegistry::init('School.SchoolClass');
		$schoolClasses = $obj_SchoolClass->get_list_school_class();

		$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
		$teachers = $obj_MemberLoginMethod->get_list_teacher(array(), $this->lang18);

		$this->set(compact('teacherCreateLessons', 'schoolClasses', 'teachers'));
	}


	public function admin_edit12345678($id = null) {

		if (!$this->TeacherCreateLesson->exists($id)) {
			throw new NotFoundException(__('Invalid teacher create lesson'));
		}

		if ($this->request->is(array('post', 'put'))) {

			$data = $this->request->data;

			$data['TeacherCreateLesson']['duration_hours'] 		= $data['TeacherCreateLesson']['duration_hour_id'];
			$data['TeacherCreateLesson']['duration_minutes'] 	= $data['TeacherCreateLesson']['duration_minute_id'];
			$data['TeacherCreateLesson']['list_teacher'] 	= isset($data['list_teacher']) && !empty($data['list_teacher']) ? json_encode($data['list_teacher']) : array();
			$data['TeacherCreateLesson']['list_class'] 		= isset($data['list_class']) && !empty($data['list_class']) 	? json_encode($data['list_class']) : array();
			$data['TeacherCreateLesson']['end_time']  		= $this->get_end_time($data['TeacherCreateLesson']['start_time'], $data['TeacherCreateLesson']['duration_hour_id'], $data['TeacherCreateLesson']['duration_minute_id']);
			$lesson_title = isset($data['TeacherCreateLesson']['lesson_title']) ? $data['TeacherCreateLesson']['lesson_title'] : array();

			if ($model_TeacherCreateLesson = $this->TeacherCreateLesson->save($data['TeacherCreateLesson'])) {


				$duration = $data['TeacherCreateLesson']['duration_hours'] * 60 + $data['TeacherCreateLesson']['duration_minutes'] ;
				$start_time = date('Y-m-d\TH:i:s.000', strtotime($data['TeacherCreateLesson']['start_time']));
				$result_client = $this->TeacherCreateLesson->update_meeting($model_TeacherCreateLesson['TeacherCreateLesson']['id'], 
										$duration, $start_time, $lesson_title);

				CakeLog::write($this->log_module, "UPDATE id = " . $model_TeacherCreateLesson['TeacherCreateLesson']['id'] . " | " . json_encode($result_client));



				$this->Session->setFlash(__('data_is_saved'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index12345678'));
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('TeacherCreateLesson.' . $this->TeacherCreateLesson->primaryKey => $id));
			$this->request->data = $this->TeacherCreateLesson->find('first', $options);
		}

		$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
		$teachers = $obj_MemberLoginMethod->get_list_teacher(array(), $this->lang18);

		$obj_SchoolClass = ClassRegistry::init('School.SchoolClass');
		$schoolClasses = $obj_SchoolClass->get_list_school_class();
		
		$durationHours = $this->TeacherCreateLesson->duration_hours;
		$durationMinutes = $this->TeacherCreateLesson->duration_minutes;
		
		$periods = array(
			0 => '每天',
			1 => '每星期',
		);
		$frequences = array(
			1 => '共1次',
			2 => '共2次',
			3 => '共3次',
			4 => '共4次',
			5 => '共5次',
			6 => '共6次',
			7 => '共7次',
			8 => '共8次',
			9 => '共9次',
			10 => '共10次',
		);

		$this->set(compact(
			'frequences', 'periods',
			'teachers', 'schoolClasses', 'durationHours', 'durationMinutes'));

		$this->set(compact('schools', 'schoolClasses', 'teachers'));
	}

	public function admin_delete12345678($id = null) {
		$this->TeacherCreateLesson->id = $id;
		if (!$this->TeacherCreateLesson->exists()) {
			throw new NotFoundException(__('Invalid teacher create lesson'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->TeacherCreateLesson->delete()) {

			// $result_client = $this->TeacherCreateLesson->delete_meeting($id);
			// CakeLog::write($this->log_module, "DELETE: id = " . $id . " | " . json_encode($result_client));

			$params = array(
				'lesson_id'  	=> $id,
			);

			$data_GenMeetingLink = array(
				'params' => json_encode($params),
				'type' 	 => 2,	// delete
			);

			$obj_GenMeetingLink = ClassRegistry::init('GenMeetingLink');
			if (!$obj_GenMeetingLink->save($data_GenMeetingLink)) {
				$this->Session->setFlash(__('data_is_not_saved'), 'default', array('class' => 'alert alert-success'));

			} else {
				$this->Session->setFlash(__('data_is_saved'), 'default', array('class' => 'alert alert-success'));
			}

		} else {
			$this->Session->setFlash(__('data_is_not_saved'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index12345678'));
	}

	

	
	public function api_get_teacher_lesson() {	// web

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
                $message = __('missing_parameter') .  'token';

			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);
			
				$db = $this->TeacherCreateLesson->getDataSource();
				$db->begin();

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);

				if (!$result_MemberLoginMethod) {
					$db->rollback();
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_data_api;
				}

				$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
				$resule_MemberRole = $obj_MemberRole->check_exist_role($result_MemberLoginMethod['Member']['MemberRole'], Environment::read('role.teacher'));
			
				if (!$resule_MemberRole) {
					$db->rollback();
					$status = 999;
					$message = __d('member', 'invalid_role');
					goto load_data_api;
				}

				$result = $this->TeacherCreateLesson->get_teacher_lesson($result_MemberLoginMethod['Member']['id'], $data['language']);

				// get link account here...
				// array_merge two lesson together
				// $obj_MemberLink = ClassRegistry::init('Member.MemberLink');
				// $member_ids = $obj_MemberLink->get_member_id_with_link($result_MemberLoginMethod['Member']['id']);
				
				// foreach ($member_ids as $id) {
				// 	$result = array_merge($result, $this->TeacherCreateLesson->get_teacher_lesson($id, $data['language']));

				// }

				$status = 200;
				$message = __('retrieve_data_successfully');
			}
			
			load_data_api:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}


	public function api_get_lesson() {	// web

		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';

			} elseif (!isset($data['id']) || empty($data['id'])) {
				$message = __('missing_parameter') . "id";

			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);

				$result = $this->TeacherCreateLesson->get_lesson($data['id'], $data['language']);

				$status = 200;
				$message = __('retrieve_data_successfully');
			}

			load_data_api:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}



	public function api_add_lesson() {	// web

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
		   
			} elseif (!isset($data['subject_id']) || empty($data['subject_id'])) {
                $message = __('missing_parameter') .  'subject_id';

			} elseif (!isset($data['lesson_title']) || empty($data['lesson_title'])) {
				$message = __('missing_parameter') . "lesson_title";

			} elseif (!isset($data['token']) || empty($data['token'])) {		// teacher id
				$message = __('missing_parameter') . "token";

			} elseif (!isset($data['list_group']) || empty($data['list_group'])) {		//json ["2", "6"],
				$message = __('missing_parameter') . "list_group";

			} elseif (!isset($data['start_time']) || empty($data['start_time'])) {		
				$message = __('missing_parameter') . "start_time";

			} elseif (!isset($data['duration_hours'])) {		
				$message = __('missing_parameter') . "duration_hours";

			} elseif (!isset($data['duration_minutes'])) {		
				$message = __('missing_parameter') . "duration_minutes";

			} elseif (!isset($data['cycle'])) {			// 0: daily, 1: weekly; 10: no repeat
				$message = __('missing_parameter') . "cycle";

			} elseif (!isset($data['frequency'])) {		
				$message = __('missing_parameter') . "frequency";

			} elseif (!isset($data['allow_playback'])) {			// yes, no
				$message = __('missing_parameter') . "allow_playback";

			} elseif (!isset($data['display_card_subject'])) {			// display => 1: subject, 0: title
				$message = __('missing_parameter') . "display_card_subject";
	
			} elseif (!isset($data['is_allow_overlap'])) {		// 1: true => by pass dont check overlap, 0: false; check overlap message
				$message = __('missing_parameter') . "is_allow_overlap";

			} else {

				try {

					$this->Api->set_post_params($this->request->params, $data);
					$this->Api->set_save_log(true);

					if ($data['frequency'] > 5) {
						$message = __d('member', 'frequency') . " large than 5";
						$status = 999;
						goto load_data_api;
					}

					$this->Api->set_language($data['language']);
				
					$db = $this->TeacherCreateLesson->getDataSource();
					$db->begin();

					if ($data['start_time'] < date('Y-m-d H:i:s')) {
						$message = __d('member', 'start_time_cannot_from_past');
						$status = 999;
						goto load_data_api;
					}

					$data['end_time']  		= $this->get_end_time($data['start_time'], $data['duration_hours'], $data['duration_minutes']);
				
					$day_starttime = date('d', strtotime($data['start_time']));
					$end_starttime = date('d', strtotime($data['end_time']));

					if ($day_starttime != $end_starttime) {
						$message = __d('member', 'cannot_setup_a_class_cross_to_next_day');
						$status = 999;
						goto load_data_api;
					}
					

					// $data['duration_minutes'] 	= $result_format_time['minute'];

					$unqid_no = uniqid(rand(), false);

					$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
					$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);

					if (!$result_MemberLoginMethod) {
						$db->rollback();
						$status = 600;
						$message = __d('member', 'invalid_token');
						goto load_data_api;
					}
					// check overlap time
					$teacher_id 		= $result_MemberLoginMethod['MemberLoginMethod']['member_id'];
				
					if (isset($data['is_allow_overlap']) && !$data['is_allow_overlap']) {	// false => by pass
						$is_overlap = $this->TeacherCreateLesson->get_time_overlap($this->lang18, $data['start_time'], $data['end_time'], $data['cycle'], $data['frequency'], $teacher_id);
						if ($is_overlap['status']) {
							$db->rollback();
							$status 	= 904;
							$message 	= $is_overlap['message'];
							goto load_data_api;
						}
					}

					$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
					$resule_MemberRole = $obj_MemberRole->check_exist_role($result_MemberLoginMethod['Member']['MemberRole'], Environment::read('role.teacher'));
				
					if (!$resule_MemberRole) {
						$db->rollback();
						$status = 999;
						$message = __d('member', 'invalid_role');
						goto load_data_api;
					}

					$obj_School = ClassRegistry::init('School.School');
					$school_valid = $obj_School->is_school_available($data['school_id']);
					if(!$school_valid){
						$db->rollback();
						$status = 999;
						$message = __d('school', 'school_not_available');
						goto load_data_api;
					}

					$id = array();
					$save_data = array();

					if ($data['cycle'] == Environment::read('time.no_repeat')) {
						$start_time = $data['start_time'];
						$end_time 	= $data['end_time'];
						
						$save_data = array(
							'subject_id' 		=> $data['subject_id'],
							'school_id' 		=> $data['school_id'],
							'display_card_subject' => $data['display_card_subject'],
							// 'list_class' 		=> $data['list_class'],
							// 'list_teacher' 			=> isset($data['list_teacher']) ? $data['list_teacher'] : array(),
							// 'list_attend_teacher' 	=> isset($data['list_attend_teacher']) ? $data['list_attend_teacher'] : array(),
							'lesson_title'			=> $data['lesson_title'],
							'lesson_description'	=> isset($data['lesson_description']) ? $data['lesson_description'] : array(),
							'duration_hours'	=> $data['duration_hours'],
							'duration_minutes'	=> $data['duration_minutes'],
							'teacher_id'		=> $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
							'start_time'		=> $start_time,
							'end_time'			=> $end_time,
							'frequency'			=> $data['frequency'],
							'cycle'				=> $data['cycle'],
							'repeat_no'			=> $unqid_no,
							'allow_playback'	=> $data['allow_playback'],
						);

						if (!$model_TeacherCreateLesson = $this->TeacherCreateLesson->save($save_data)) {
							$db->rollback();
							$status = 999;
							$message = __('data_is_not_saved') . " Teacher Create Lesson";
							goto load_data_api;
						}

						if (!$this->save_teacher_lesson_participant_schedule($data, $result_MemberLoginMethod['MemberLoginMethod']['member_id'], $model_TeacherCreateLesson['TeacherCreateLesson']['id'])) {

							$db->rollback();
							$status = 999;
							$message = __('data_is_not_saved') . " Teacher Lessons Participant/Schedule";
							goto load_data_api;
						}

						$id[] = $model_TeacherCreateLesson['TeacherCreateLesson']['id'];

					} elseif ($data['cycle'] == Environment::read('time.daily')) {
						$start_time = $data['start_time'];
						$end_time 	= $data['end_time'];

						$temp = array(
							'subject_id' 		=> $data['subject_id'],
							'school_id' 		=> $data['school_id'],
							'display_card_subject' => $data['display_card_subject'],
							// 'list_class' 		=> $data['list_class'],
							// 'list_teacher' 		=> $data['list_teacher'],
							// 'list_attend_teacher' 	=> isset($data['list_attend_teacher']) ? $data['list_attend_teacher'] : array(),
							'lesson_title'			=> $data['lesson_title'],
							'lesson_description'	=> isset($data['lesson_description']) ? $data['lesson_description'] : array(),
							'duration_hours'	=> $data['duration_hours'],
							'duration_minutes'	=> $data['duration_minutes'],
							'teacher_id'		=> $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
							'start_time'		=> $start_time,
							'end_time'			=> $end_time,
							'frequency'			=> $data['frequency'],
							'cycle'				=> $data['cycle'],
							'repeat_no'			=> $unqid_no,
							'allow_playback'	=> $data['allow_playback'],
						);
						if (!$model_TeacherCreateLesson = $this->TeacherCreateLesson->save($temp)) {
				
							$db->rollback();
							$status = 999;
							$message = __('data_is_not_saved') . " Teacher Create Lesson";
							goto load_data_api;
						}
						$this->TeacherCreateLesson->clear();


						if (!$this->save_teacher_lesson_participant_schedule($data, $result_MemberLoginMethod['MemberLoginMethod']['member_id'], $model_TeacherCreateLesson['TeacherCreateLesson']['id'])) {

							$db->rollback();
							$status = 999;
							$message = __('data_is_not_saved') . " Teacher Lessons Participant/Schedule";
							goto load_data_api;
						}

						$id[] = $model_TeacherCreateLesson['TeacherCreateLesson']['id'];
						$start_time = date('Y-m-d H:i:s', strtotime($start_time . '+7 day'));
						$end_time = date('Y-m-d H:i:s', strtotime($end_time . '+7 day'));
						$data['start_time'] = $start_time;
						$data['end_time'] = $end_time;


						for ($i = 0; $i < $data['frequency']; $i++) {

							$temp = array(
								'subject_id' 		=> $data['subject_id'],
								'school_id' 		=> $data['school_id'],
								'display_card_subject' => $data['display_card_subject'],
								'list_class' 		=> $data['list_class'],
								'list_teacher' 			=> isset($data['list_teacher']) ? $data['list_teacher'] : array(),
								'list_attend_teacher' 	=> isset($data['list_attend_teacher']) ? $data['list_attend_teacher'] : array(),
								'lesson_title'			=> $data['lesson_title'],
								'lesson_description'	=> isset($data['lesson_description']) ? $data['lesson_description'] : array(),
								'duration_hours'	=> $data['duration_hours'],
								'duration_minutes'	=> $data['duration_minutes'],
								'teacher_id'		=> $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
								'start_time'		=> $start_time,
								'end_time'			=> $end_time,
								'frequency'			=> $data['frequency'],
								'cycle'				=> $data['cycle'],
								'repeat_no'			=> $unqid_no,
								'allow_playback'	=> $data['allow_playback'],
							);

							// array_push($save_data, $temp);
							$start_time = date('Y-m-d H:i:s', strtotime($start_time . '+1 day'));
							$end_time = date('Y-m-d H:i:s', strtotime($end_time . '+1 day'));

							if (!$model_TeacherCreateLesson = $this->TeacherCreateLesson->save($temp)) {
					
								$db->rollback();
								$status = 999;
								$message = __('data_is_not_saved') . " Teacher Create Lesson";
								goto load_data_api;
							}
							$this->TeacherCreateLesson->clear();

							$id[] = $model_TeacherCreateLesson['TeacherCreateLesson']['id'];
						}
					
					} elseif ($data['cycle'] == Environment::read('time.weekly')) {

						$start_time = $data['start_time'];
						$end_time 	= $data['end_time'];
					
						for ($i = 0; $i < $data['frequency']; $i++) {
							
							$temp = array(
								'subject_id' 		=> $data['subject_id'],
								'school_id' 		=> $data['school_id'],
								'display_card_subject' => $data['display_card_subject'],
								'list_class' 		=> $data['list_class'],
								'list_teacher' 		=> $data['list_teacher'],
								'list_attend_teacher' 	=> isset($data['list_attend_teacher']) ? $data['list_attend_teacher'] : array(),
								'lesson_title'			=> $data['lesson_title'],
								'lesson_description'	=> isset($data['lesson_description']) ? $data['lesson_description'] : array(),
								'duration_hours'	=> $data['duration_hours'],
								'duration_minutes'	=> $data['duration_minutes'],
								'teacher_id'		=> $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
								'start_time'		=> $start_time,
								'end_time'			=> $end_time,
								'frequency'			=> $data['frequency'],
								'cycle'				=> $data['cycle'],
								'repeat_no'			=> $unqid_no,
								'allow_playback'	=> $data['allow_playback'],
							);
							array_push($save_data, $temp);
							$start_time = date('Y-m-d H:i:s', strtotime($start_time . '+7 day'));
							$end_time = date('Y-m-d H:i:s', strtotime($end_time . '+7 day'));

							if (!$model_TeacherCreateLesson = $this->TeacherCreateLesson->save($temp)) {
					
								$db->rollback();
								$status = 999;
								$message = __('data_is_not_saved') . " Teacher Create Lesson";
								goto load_data_api;
							}
							$this->TeacherCreateLesson->clear();
							$id[] = $model_TeacherCreateLesson['TeacherCreateLesson']['id'];
						}
				}

				// call api inform partner by get all teacher create lesson
				
				// --------------- PUT IN CRON ---------------
				// $result  = $this->TeacherCreateLesson->alert_create_meeting($unqid_no);
				// CakeLog::write($this->log_module, "INSERT | unqid_no = " . $unqid_no . " " .  json_encode($result));

				$params = array(
					'unqid_no' => $unqid_no
				);
				$data_GenMeetingLink = array(
					'params' 	=> json_encode($params),
					'type'		=> 0,	// insert
				);

				$obj_GenMeetingLink = ClassRegistry::init('GenMeetingLink');
				if (!$obj_GenMeetingLink->save($data_GenMeetingLink)) {
					$db->rollback();
					$status = 999;
					$message = __('data_is_not_saved') . " Call Partner Gen Meeting Link";
					goto load_data_api;
				}

				$status = 200;
				$message = __('data_is_saved') . " Teacher Create Lesson";
				$db->commit();
			
				} catch(\Exception $e) {
					$db->rollback();
					$status = 999;
					$message = $e->getMessage();
					goto load_data_api;
				}
			}
		
			load_data_api:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}

	private function save_teacher_lesson_participant_schedule($data, $teacher_id, $lesson_id) {

		$obj_TeacherLessonsParticipant 	= ClassRegistry::init('Member.TeacherLessonsParticipant');
		$obj_TeacherLessonsSchedule 	= ClassRegistry::init('Member.TeacherLessonsSchedule');
		$obj_MembersGroup = ClassRegistry::init('Member.MembersGroup');

		$data_TeacherLessonsParticipant = $data_TeacherLessonsSchedule = array();

		$list_group 		= $data['list_group'];
		$list_teacher 		= $data['list_teacher'];
		$list_student 		= $data['list_student'];
		$start_time 		= $data['start_time'];
		$end_time 			= $data['end_time'];
		$duration_hours 	= $data['duration_hours'];
		$duration_minutes 	= $data['duration_minutes'];

		if ($list_group) {
			$ids = json_decode($list_group);
			foreach ($ids as $grp) {
				$data_TeacherLessonsParticipant[] = array(
					'lesson_id' 		=> $lesson_id,
					'group_id' 			=> $grp,
				);

				// get all member in groups => split and save to schedules
				$result_MembersGroup = $obj_MembersGroup->get_item_by_group_id($grp);
				foreach ($result_MembersGroup['teachers'] as $id) {
					$data_TeacherLessonsSchedule[] = array(
						'lesson_id' 		=> $lesson_id,
						'teacher_id' 		=> $id,
						'start_time' 		=> $start_time,
						'end_time' 			=> $end_time,
						'duration_hours' 	=> $duration_hours,
						'duration_minutes' 	=> $duration_minutes,
					);
				}

				foreach ($result_MembersGroup['students'] as $id) {
					$data_TeacherLessonsSchedule[] = array(
						'lesson_id' 		=> $lesson_id,
						'student_id' 		=> $id,
						'start_time' 		=> $start_time,
						'end_time' 			=> $end_time,
						'duration_hours' 	=> $duration_hours,
						'duration_minutes' 	=> $duration_minutes,
					);
				}
			}
		}

		$data_TeacherLessonsSchedule[] = array(
			'lesson_id' 		=> $lesson_id,
			'teacher_id' 		=> $teacher_id,		/// main teacher
			'start_time' 		=> $start_time,
			'end_time' 			=> $end_time,
			'duration_hours' 	=> $duration_hours,
			'duration_minutes' 	=> $duration_minutes,
		);
		if ($list_teacher) {
			$ids = json_decode($list_teacher);
			foreach ($ids as $grp) {
				$data_TeacherLessonsParticipant[] = array(
					'lesson_id' 		=> $lesson_id,
					'teacher_id' 		=> $grp,
				);
				$data_TeacherLessonsSchedule[] = array(
					'lesson_id' 		=> $lesson_id,
					'teacher_id' 		=> $grp,
					'start_time' 		=> $start_time,
					'end_time' 			=> $end_time,
					'duration_hours' 	=> $duration_hours,
					'duration_minutes' 	=> $duration_minutes,
				);
			}
		}

		if ($list_student) {
			$ids = json_decode($list_student);
			foreach ($ids as $grp) {
				$data_TeacherLessonsParticipant[] = array(
					'lesson_id' 		=> $lesson_id,
					'student_id' 		=> $grp,
				);
				$data_TeacherLessonsSchedule[] = array(
					'lesson_id' 		=> $lesson_id,
					'student_id' 		=> $grp,
					'start_time' 		=> $start_time,
					'end_time' 			=> $end_time,
					'duration_hours' 	=> $duration_hours,
					'duration_minutes' 	=> $duration_minutes,
				);
			}
		}

		if (!$obj_TeacherLessonsParticipant->saveAll($data_TeacherLessonsParticipant)) {
			return false;
		}
		if (!$obj_TeacherLessonsSchedule->saveAll($data_TeacherLessonsSchedule)) {
			return false;
		}
		return true;
	}

	public function api_update_lesson() {	// web

		$this->Api->init_result();
		if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';

			} elseif (!isset($data['token']) || empty($data['token'])) {		// teacher id
				$message = __('missing_parameter') . "token";

			} elseif (!isset($data['lesson_title']) || empty($data['lesson_title'])) {		
				$message = __('missing_parameter') . "lesson_title";

			} elseif (!isset($data['start_time']) || empty($data['start_time'])) {		
				$message = __('missing_parameter') . "start_time";

			} elseif (!isset($data['duration_hours'])) {		
				$message = __('missing_parameter') . "duration_hours";

			} elseif (!isset($data['duration_minutes'])) {		
				$message = __('missing_parameter') . "duration_minutes";

			} elseif (!isset($data['allow_playback'])) {			// yes, no
				$message = __('missing_parameter') . "allow_playback";

			} elseif (!isset($data['display_card_subject'])) {			// display => 1: subject, 0: title
				$message = __('missing_parameter') . "display_card_subject";

			} elseif (!isset($data['is_allow_overlap'])) {		// 1: true => by pass dont check overlap, 0: false; check overlap message
				$message = __('missing_parameter') . "is_allow_overlap";

			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);

				$obj_School = ClassRegistry::init('School.School');
				$school_valid = $obj_School->is_school_available($data['school_id']);
				if(!$school_valid){
					$status = 999;
					$message = __d('school', 'school_not_available');
					goto load_data_api;
				}

				if ($data['start_time'] < date('Y-m-d H:i:s')) {
					$message = __d('member', 'start_time_cannot_from_past');
					$status = 999;
					goto load_data_api;
				}

				$data['end_time']  		= $this->get_end_time($data['start_time'], $data['duration_hours'], $data['duration_minutes']);
			
				$day_starttime = date('d', strtotime($data['start_time']));
				$end_starttime = date('d', strtotime($data['end_time']));

				if ($day_starttime != $end_starttime) {
					$message = __d('member', 'cannot_setup_a_class_cross_to_next_day');
					$status = 999;
					goto load_data_api;
				}
			
				$db = $this->TeacherCreateLesson->getDataSource();
				$db->begin();

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);
				if (!$result_MemberLoginMethod) {
					$db->rollback();
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_data_api;
				}

				// check overlap time
				$teacher_id 		= $result_MemberLoginMethod['MemberLoginMethod']['member_id'];
			
				if (isset($data['is_allow_overlap']) && !$data['is_allow_overlap']) {	// false => by pass
					$is_overlap = $this->TeacherCreateLesson->get_time_overlap($this->lang18, $data['start_time'], $data['end_time'], 0, 0, $teacher_id);
					if ($is_overlap['status']) {
						$db->rollback();
						$status  	= 904;
						$message 	= $is_overlap['message'];
						goto load_data_api;
					}
				}

				$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
				$resule_MemberRole = $obj_MemberRole->check_exist_role($result_MemberLoginMethod['Member']['MemberRole'], Environment::read('role.teacher'));
			
				if (!$resule_MemberRole) {
					$db->rollback();
					$status = 999;
					$message = __d('member', 'invalid_role');
					goto load_data_api;
				}

				$start_time = $data['start_time'];
				$end_time 	= $data['end_time'];
				
				$save_data = array(
					'id' 				=> $data['teacher_create_lesson_id'],
					'lesson_title'		=> $data['lesson_title'], 
					'lesson_description' => $data['lesson_description'], 
					// 'list_class' 		=> $data['list_class'],
					// 'list_teacher' 			=> isset($data['list_teacher']) ? $data['list_teacher'] : array(),
					// 'list_attend_teacher' 	=> isset($data['list_attend_teacher']) ? $data['list_attend_teacher'] : array(),
					'duration_hours'	=> $data['duration_hours'],
					'duration_minutes'	=> $data['duration_minutes'],
					// 'teacher_id'		=> $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
					'start_time'		=> $start_time,
					'end_time'			=> $end_time,
					'allow_playback'	=> $data['allow_playback'],
				);

				if (!$model_TeacherCreateLesson = $this->TeacherCreateLesson->save($save_data)) {
					$db->rollback();
					$status = 999;
					$message = __('data_is_not_saved') . " Teacher Create Lesson";
					goto load_data_api;
				}

				$duration = $data['duration_hours'] * 60 + $data['duration_minutes'];
			
				// Clear all item: from teacher lessons participants and teacher lessons schedules
				$flag = $this->remove_relative_lesson_info($data['teacher_create_lesson_id']);
				if (!$flag) {
					$db->rollback();
					$status = 999;
					$message = __('data_is_not_saved') . " (Remove data)";
					goto load_data_api;
				}

				// reupdate 
				$flag = $this->save_teacher_lesson_participant_schedule($data, $result_MemberLoginMethod['MemberLoginMethod']['member_id'],  $data['teacher_create_lesson_id']);
				if (!$flag) {
					$db->rollback();
					$status = 999;
					$message = __('data_is_not_saved') . " (Schedule)";
					goto load_data_api;
				}

				// Call api inform partner by get all teacher create lesson
				$params = array(
					'lesson_id'  	=> $model_TeacherCreateLesson['TeacherCreateLesson']['id'],
					'duration'		=> $duration,
					'start_time' 	=> date('Y-m-d\TH:i:s.000', strtotime($data['start_time'])),
					'lesson_title' 	=> $data['lesson_title'],
				);

				$data_GenMeetingLink = array(
					'params' => json_encode($params),
					'type' 	 => 1,
				);

				$obj_GenMeetingLink = ClassRegistry::init('GenMeetingLink');
				if (!$obj_GenMeetingLink->save($data_GenMeetingLink)) {
					$db->rollback();
					$status = 999;
					$message = __('data_is_not_saved') . " Call Partner Gen Meeting Link";
					goto load_data_api;
				}
				
				// $start_time = date('Y-m-d\TH:i:s.000', strtotime($data['start_time']));
				// $result_client = $this->TeacherCreateLesson->update_meeting($model_TeacherCreateLesson['TeacherCreateLesson']['id'], 
				// 						$duration, $start_time,  $data['lesson_title']);
				// CakeLog::write($this->log_module, "UPDATE id = " . $model_TeacherCreateLesson['TeacherCreateLesson']['id']  . json_encode($result_client));

				$status = 200;
				$message = __('data_is_saved') . " Teacher Create Lesson ";
				$db->commit();
			}

			load_data_api:
			$this->Api->set_result($status, $message, $result);
		}

		$this->Api->output();
	}

	private function remove_relative_lesson_info($lesson_id) {
		$obj_TeacherLessonsParticipant 	= ClassRegistry::init('Member.TeacherLessonsParticipant');
		$obj_TeacherLessonsSchedule 	= ClassRegistry::init('Member.TeacherLessonsSchedule');

		if (!$obj_TeacherLessonsParticipant->deleteAll(
			array(
				'TeacherLessonsParticipant.lesson_id' => $lesson_id,
			),
			false
		)) {
			return false;
		}

		if (!$obj_TeacherLessonsSchedule->deleteAll(
			array(
				'TeacherLessonsSchedule.lesson_id' => $lesson_id,
			),
			false
		)) {
			return false;
		}

		return true;
	}












	public function api_get_student_lesson() {	

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
                $message = __('missing_parameter') .  'token';

			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);
			
				$db = $this->TeacherCreateLesson->getDataSource();
				$db->begin();

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);

				if (!$result_MemberLoginMethod) {
					$db->rollback();
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_data_api;
				}

				$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
				$resule_MemberRole = $obj_MemberRole->check_exist_role($result_MemberLoginMethod['Member']['MemberRole'], Environment::read('role.student'));
			
				if (!$resule_MemberRole) {
					$db->rollback();
					$status = 999;
					$message = __d('member', 'invalid_role');
					goto load_data_api;
				}

				$result = $this->TeacherCreateLesson->get_student_lesson($result_MemberLoginMethod['Member']['id'], $data['language']);

				// get link account here...
				// array_merge two lesson together
				// $obj_MemberLink = ClassRegistry::init('Member.MemberLink');
				// $member_ids = $obj_MemberLink->get_member_id_with_link($result_MemberLoginMethod['Member']['id']);
				
				// foreach ($member_ids as $id) {
				// 	$result = array_merge($result, $this->TeacherCreateLesson->get_student_lesson($id, $data['language']));
				// }

				$status = 200;
				$message = __('retrieve_data_successfully');
			}
			
			load_data_api:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}


	// for partner
	public function api_update_meeting_link() {	// web

		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['meeting']) || empty($data['meeting'])) {
				$message = __('missing_parameter') .  'meeting';
		   
			} elseif (!isset($data['lesson_id']) || empty($data['lesson_id'])) {
                $message = __('missing_parameter') .  'lesson_id';

			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language('eng');
		
				$result = $this->TeacherCreateLesson->update_meeting_link($data);
				if ($result) {
					$status = 200;
					$message = __('data is saved');
				} else {
					$status = 999;
					$message = __('data is not saved');
				}
			}
			
			load_data_api:
            $this->Api->set_result($status, $message, (object)array());
        }

		$this->Api->output();
	}



	public function api_teacher_create_assignment() {	// web

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
		
			} elseif (!isset($data['teachers']) || empty($data['teachers'])) {		
				$message = __('missing_parameter') . "teachers";

			} elseif (!isset($data['groups']) || empty($data['groups'])) {		
				$message = __('missing_parameter') . "groups";
				
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);
			
				$db = $this->TeacherCreateLesson->getDataSource();
				$db->begin();

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);
				
				if (!$result_MemberLoginMethod) {
					$db->rollback();
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_data_api;
				}

				$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
			

				$role = $obj_MemberRole->check_exist_role($result_MemberLoginMethod['Member']['MemberRole'], Environment::read('role.teacher'));
				if (!$role) {
					$status = 600;
					$message = __d('member', 'invalid_role');
					goto load_data_api;
				}

				$obj_School = ClassRegistry::init('School.School');
				$school_valid = $obj_School->is_school_available($data['school_id']);
				if(!$school_valid){
					$status = 999;
					$message = __d('school', 'school_not_available');
					goto load_data_api;
				}
				
				$obj_TeacherCreateAssignment = ClassRegistry::init('Member.TeacherCreateAssignment');
				$obj_TeacherCreateAssignmentMaterial = ClassRegistry::init('Member.TeacherCreateAssignmentMaterial');
							

				$files_save 	= array();
				$uploaded_files = array();
				$first = true;
				$ids = array();
				$data_TeacherAssignmentsParticipants = array();

				$groups = json_decode($data['groups']);
				foreach ($groups as $cla) {
					
					$data_TeacherCreateAssignment = array(
						'school_id' 	=> $data['school_id'],
						'name' 			=> $data['name'],
						'description' 	=> $data['description'],
						'group_id' 		=> $cla,
						'subject_id' 	=> isset($data['subject_id']) ? $data['subject_id'] : array(),
						'deadline' 		=> $data['deadline'],
						//'teacher_id'	=> $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
					);

					if (!$model_TeacherCreateAssignment = $obj_TeacherCreateAssignment->save($data_TeacherCreateAssignment)) {
						$message = __("data_is_not_saved") . 'Teacher Create Assignment';
						$status = 999;
						$db->rollback();
						goto load_data_api;
					}

					$ids[] = $model_TeacherCreateAssignment['TeacherCreateAssignment']['id'];

					foreach (json_decode($data['teachers'], true) as $teachers) {
						$data_TeacherAssignmentsParticipants[] = array(
							'teacher_id' 	=> $teachers,
							'assignment_id' => $model_TeacherCreateAssignment['TeacherCreateAssignment']['id']
						);
					}
				
					if ($first == true) {
						if (isset($_FILES) && !empty($_FILES)) { 	

							// Upload File
							$files 			= array();
		
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
								
									$relative_path = 'uploads' . DS . 'TeacherCreateAssignment' .  DS .  $model_TeacherCreateAssignment['TeacherCreateAssignment']['id'] . DS . 'lessons' ;
					
									$file_name_suffix = $model_TeacherCreateAssignment['TeacherCreateAssignment']['id'];
									$uploaded_files[] = $this->Common->upload_file($files, $relative_path, $file_name_suffix);
									
								}
							}
						}
					
						$first = false;
					}

					$obj_TeacherCreateAssignment->clear();
				}

				$obj_TeacherAssignmentsParticipants = ClassRegistry::init('Member.TeacherAssignmentsParticipants');
				if (!$obj_TeacherAssignmentsParticipants->saveAll($data_TeacherAssignmentsParticipants)) {
					$message = __("data_is_not_saved") . 'Teacher Assignments Participants';
					$status = 999;
					$db->rollback();
					goto load_data_api;
				}
				
			
				foreach ($uploaded_files as $im) {

					if (isset($im['status']) && $im['status'] == true ) {
						if (isset($im['params']['success']) && !empty($im['params']['success']) ){
							foreach($im['params']['success'] as $key => $val) {
							
								foreach ($ids as $id) {
									$files_save[] = array(
										'name' 				=> $val['ori_name'],
										'path' 				=> str_replace("\\",'/',$val['path']),
										'type' 				=> $val['type'],
										'size' 				=> $val['size'],
										'teacher_create_assignment_id' 	=> $id,
									);
								}
							}
						}
					}
				}

				if (!empty($files_save)) {
					if (!$obj_TeacherCreateAssignmentMaterial->saveAll($files_save) ){
						$status = 999;
						$message = __('data_is_not_saved') . " Teacher Create Assignment";
						goto load_data_api;
					}

				}

				$db->commit();
				$status = 200;
				$message = __('data_is_saved') . " Teacher Create Assignment";
			}
			
			load_data_api:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}




	public function api_get_submission_count_by_assignment_id(){

		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = (object)array();
			
			$data = $this->request->data;
			
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';

			} elseif (!isset($data['teacher_create_assignment_id']) || empty($data['teacher_create_assignment_id'])) {		
				$message = __('missing_parameter') . "teacher_create_assignment_id";

			} elseif (!isset($data['token']) || empty($data['token'])) {		
				$message = __('missing_parameter') . "token";
				
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

				$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
				$role = $obj_MemberRole->check_exist_role($result_MemberLoginMethod['Member']['MemberRole'], Environment::read('role.teacher'));
				if (!$role) {
					$status = 600;
					$message = __d('member', 'invalid_role');
					goto load_data_api;
				}
				
				$obj_StudentAssignmentSubmission = ClassRegistry::init('Member.StudentAssignmentSubmission');
				$studentAssignmentSubmission = $obj_StudentAssignmentSubmission->get_submission_count_by_assignment_id($data['teacher_create_assignment_id']);
				$status 	= 200;
				$message 	= __('retrieved_data_successfully');
				$result		= array('submission_count'=>$studentAssignmentSubmission);
			}
			load_data_api:
            $this->Api->set_result($status, $message, $result);
		}
		$this->Api->output();
	}

	// file name: 1_s191003_20200522_1530_0.pdf
	public function api_student_submit_assignment() {	

		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';

			} elseif (!isset($data['teacher_create_assignment_id']) || empty($data['teacher_create_assignment_id'])) {		
				$message = __('missing_parameter') . "teacher_create_assignment_id";

			} elseif (!isset($data['token']) || empty($data['token'])) {		
				$message = __('missing_parameter') . "token";
				
			} elseif (!isset($data['resubmit'])) {		// 1: yes, 0: no
				$message = __('missing_parameter') . "resubmit";

			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);
			
				$db = $this->TeacherCreateLesson->getDataSource();
				$db->begin();

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);

				if (!$result_MemberLoginMethod) {
					$db->rollback();
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_data_api;
				}

				$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
				$role = $obj_MemberRole->check_exist_role($result_MemberLoginMethod['Member']['MemberRole'], Environment::read('role.student'));
				if (!$role) {
					$status = 600;
					$message = __d('member', 'invalid_role');
					goto load_data_api;
				}

				$obj_StudentAssignmentSubmission 		 = ClassRegistry::init('Member.StudentAssignmentSubmission');
				$obj_StudentAssignmentSubmissionMaterial = ClassRegistry::init('Member.StudentAssignmentSubmissionMaterial');
				$model_StudentAssignmentSubmission 		 = -1;

				$obj_TeacherCreateAssignment 		 	= ClassRegistry::init('Member.TeacherCreateAssignment');
				$result_TeacherCreateAssignment = $obj_TeacherCreateAssignment->get_obj($data['teacher_create_assignment_id']);

				if (!$result_TeacherCreateAssignment['TeacherCreateAssignment']['enabled']) {
					$message = __('invalid_data');
					$status = 999;
					$db->rollback();
					goto load_data_api;
				}

				$obj_School = ClassRegistry::init('School.School');
				$school_valid = $obj_School->is_school_available($result_TeacherCreateAssignment['TeacherCreateAssignment']['school_id']);
				if(!$school_valid){
					$status = 999;
					$message = __d('school', 'assignment_not_available');
					$db->rollback();
					goto load_data_api;
				}

				// get deadline teacher_create_assignment_id;
				$obj_TeacherCreateAssignment = ClassRegistry::init('Member.TeacherCreateAssignment');
				$deadline = $obj_TeacherCreateAssignment->get_deadline($data['teacher_create_assignment_id']);

				if (date('Y-m-d H:i:s', strtotime($deadline)) < date('Y-m-d H:i:s') || !$deadline) {
					$message = __d('member', 'deadline_invalid');
					$status = 999;
					$db->rollback();
					goto load_data_api;
				}

				if ($data['resubmit'] == 0) {	// add
				
					$data_StudentAssignmentSubmission = array(
						'student_id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
						'teacher_create_assignment_id' => $data['teacher_create_assignment_id'],
						'upload_time' => date('y-m-d H:i:s'),
					);

					if (!$model_StudentAssignmentSubmission = $obj_StudentAssignmentSubmission->save($data_StudentAssignmentSubmission)) {
						$message = __("data_is_not_saved") . 'StudentAssignmentSubmission';
						$status = 999;
						$db->rollback();
						goto load_data_api;
					}

				} else {	// resubmit =  yes

					$data_StudentAssignmentSubmission = $obj_StudentAssignmentSubmission->get_obj_with_param($result_MemberLoginMethod['MemberLoginMethod']['member_id'], $data['teacher_create_assignment_id']);

					if (!$data_StudentAssignmentSubmission) {
						$message = __("retrieve_data_not_successfully");
						$status = 999;
						$db->rollback();
						goto load_data_api;
					}

					if ($data_StudentAssignmentSubmission['StudentAssignmentSubmission']['score']) {
						$message = __d("member", "this_score_is_set_cannot_upload_again");
						$status = 999;
						$db->rollback();
						goto load_data_api;
					}

					$data_StudentAssignmentSubmission['StudentAssignmentSubmission']['upload_time'] = date('y-m-d H:i:s');

					if (!$model_StudentAssignmentSubmission = $obj_StudentAssignmentSubmission->save($data_StudentAssignmentSubmission['StudentAssignmentSubmission'])) {
						$message = __("data_is_not_saved") . 'StudentAssignmentSubmission';
						$status = 999;
						$db->rollback();
						goto load_data_api;
					}

					// remove all material;

					$obj_StudentAssignmentSubmissionMaterial = ClassRegistry::init('Member.StudentAssignmentSubmissionMaterial');
					$obj_StudentAssignmentSubmissionMaterial->deleteAll(
						array(
							'StudentAssignmentSubmissionMaterial.student_assignment_submission_id' => $data_StudentAssignmentSubmission['StudentAssignmentSubmission']['id'],
						)
					);
					
				}
				
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
											
							$relative_path = 'uploads' . DS . 'TeacherCreateAssignment' . DS . $data['teacher_create_assignment_id'] . DS . "homework" . DS .  $result_MemberLoginMethod['MemberLoginMethod']['member_id'];
							$file_name_suffix = $data['teacher_create_assignment_id'] . '-' . $result_MemberLoginMethod['MemberLoginMethod']['member_id'];

							$uploaded_images = $this->Common->upload_file($files, $relative_path, $file_name_suffix);

							if (isset($uploaded_images['status']) && ($uploaded_images['status'] == true) ) {
								if (isset($uploaded_images['params']['success']) && !empty($uploaded_images['params']['success']) ){
									foreach($uploaded_images['params']['success'] as $key => $val) {
									
										// create name of file with format
										//$name = $result_MemberLoginMethod['MemberLoginMethod']['username'] . $school_code . "_" . $data['teacher_create_assignment_id'] . '_' . date('Ymd') . "_" . time(). "_" . $i;
										$name =  $data['teacher_create_assignment_id']  . "_" . $result_MemberLoginMethod['MemberLoginMethod']['username'] . "_" . date('Ymd') . "_" . date('Hi') . "_" . $i;
											
										$files_save[] = array(
											'name' 				=> $name . "." . $val['ext'],
											'path' 				=> str_replace("\\",'/',$val['path']),
											'student_id' 		=> $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
											'type' 				=> $val['type'],
											'size' 				=> $val['size'],
											'student_assignment_submission_id' 	=>  $model_StudentAssignmentSubmission['StudentAssignmentSubmission']['id'],
											'upload_time' 		=>  date('Y-m-d H:i:s'),
										);
										
									}
								}
							} else {
								$message = __d('member', "upload_failed");
								$status = 999;
								$db->rollback();
								goto load_data_api;
							}
						}
					}

					// save
					if (!empty($files_save)) {
						if (!$obj_StudentAssignmentSubmissionMaterial->saveAll($files_save) ){
							$status = 999;
							$message = __('data_is_not_saved');
							goto load_data_api;
						}

						$obj_StudentAssignmentSubmissionMaterial->clear();
					}
				}

				$db->commit();
				$status = 200;
				$message = __('data_is_saved') . " Student submission succeed Assginment";
			}
			
			load_data_api:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}






	public function api_teacher_feedback_assignment() {	

		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';

			} elseif (!isset($data['student_assignment_submission_id']) || empty($data['student_assignment_submission_id'])) {		
				$message = __('missing_parameter') . "student_assignment_submission_id";
			
			} elseif (!isset($data['token']) || empty($data['token'])) {		
				$message = __('missing_parameter') . "token";
				
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);
			
				$db = $this->TeacherCreateLesson->getDataSource();
				$db->begin();

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);

				if (!$result_MemberLoginMethod) {
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_data_api;
				}

				$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
			
				$role = $obj_MemberRole->check_exist_role($result_MemberLoginMethod['Member']['MemberRole'], Environment::read('role.teacher'));

				if (!$role) {
					$status = 600;
					$message = __d('member', 'invalid_role');
					goto load_data_api;
				}


				$obj_StudentAssignmentSubmission = ClassRegistry::init('Member.StudentAssignmentSubmission');
				$result_StudentAssignmentSubmission = $obj_StudentAssignmentSubmission->get_obj($data['student_assignment_submission_id']);

				if (!$result_StudentAssignmentSubmission) {
					$status = 999;
					$message = __d('member', 'invalid_data');
					goto load_data_api;
				}

				$obj_School = ClassRegistry::init('School.School');
				$school_valid = $obj_School->is_school_available($result_StudentAssignmentSubmission['TeacherCreateAssignment']['school_id']);
				if(!$school_valid){
					$status = 999;
					$message = __d('school', 'assignment_not_available');
					goto load_data_api;
				}

				// update score, remark
				$data_StudentAssignmentSubmission = array(
					'id' => $data['student_assignment_submission_id'],
					'score' => isset($data['score']) ? $data['score'] : array(),
					'feedback' =>  isset($data['feedback']) ? $data['feedback'] : array(),
					'remark' =>  isset($data['remark']) ? $data['remark'] : array(),
				);

				$saved = $obj_StudentAssignmentSubmission->save($data_StudentAssignmentSubmission);
				if (!$saved) {
					$db->rollback();
					$status = 999;
					$message = __('data_is_not_saved') . 'StudentAssignmentSubmission';
					goto load_data_api;
				}
				
				
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
						

							$data['teacher_create_assignment_id'] = "";


							$relative_path = 'uploads' . DS . 'TeacherCreateAssignment' . DS . $result_StudentAssignmentSubmission['StudentAssignmentSubmission']['teacher_create_assignment_id'] . DS . "feedback" . DS .   $result_StudentAssignmentSubmission['StudentAssignmentSubmission']['student_id'];
							
							$file_name_suffix = "";
							$dont_change_file_name = true;
							$uploaded_files = $this->Common->upload_file($files, $relative_path, $file_name_suffix, $dont_change_file_name);

							if (isset($uploaded_files['status']) && ($uploaded_files['status'] == true) ) {
								if (isset($uploaded_files['params']['success']) && !empty($uploaded_files['params']['success']) ){
									foreach($uploaded_files['params']['success'] as $key => $val) {
									
										$pos = strrpos($val['ori_name'], '.', 0);
										$file_name = substr($val['ori_name'], 0, $pos) . "-updated" . "." . $val['ext'];
										
										$files_save[] = array(
											'name' 				=> $file_name,
											'path' 				=> str_replace("\\",'/',$val['path']),
											'type' 				=> $val['type'],
											'size' 				=> $val['size'],
											'student_assignment_submission_id' 	=>  $data['student_assignment_submission_id'],
										);
										
									}
								}
							} else {
								$message = __d('member', "upload_failed");
								$status = 999;
								$db->rollback();
								goto load_data_api;
							}
						}
					}

					// save
					if (!empty($files_save)) {
						$obj_TeacherFeedbackAssignmentMaterial 	 = ClassRegistry::init('Member.TeacherFeedbackAssignmentMaterial');
				
						if (!$obj_TeacherFeedbackAssignmentMaterial->saveAll($files_save) ){
							$status = 999;
							$message = __('data_is_not_saved') . " TeacherFeedbackAssignmentMaterial";
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



	public function api_student_visit_zoom_link() {	

		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['teacher_create_lesson_id']) || empty($data['teacher_create_lesson_id'])) {
				$message = __('missing_parameter') .  'teacher_create_lesson_id';
				
			} elseif (!isset($data['token']) || empty($data['token'])) {
                $message = __('missing_parameter') .  'token';

			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);
			
				$db = $this->TeacherCreateLesson->getDataSource();
				$db->begin();

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);

				if (!$result_MemberLoginMethod) {
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_data_api;
				}

				$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
				$resule_MemberRole = $obj_MemberRole->check_exist_role($result_MemberLoginMethod['Member']['MemberRole'], Environment::read('role.student'));
			
				if (!$resule_MemberRole) {
					$status = 999;
					$message = __d('member', 'invalid_role');
					goto load_data_api;
				}
				
				$result_TeacherCreateLesson = $this->TeacherCreateLesson->get_lesson_info_by_id($data['teacher_create_lesson_id']);
				if (!$result_TeacherCreateLesson) {
					$status = 999;
					$message = __d('member', 'this lesson not exists');
					goto load_data_api;
				}
				
				// get student joins live logs
				$obj_StudentJoinLiveLog = ClassRegistry::init('Member.StudentJoinLiveLog');
				$flag = $obj_StudentJoinLiveLog->check_condition_member_within_one_month($result_MemberLoginMethod['MemberLoginMethod']['member_id'], $result_TeacherCreateLesson['School']['id']);

				// update StudentJoinLiveLog 
				$data_StudentJoinLiveLog = array(
					'student_id' 				=> $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
					'teacher_create_lesson_id'	=> $data['teacher_create_lesson_id'],
					'school_id' 				=> $result_TeacherCreateLesson['School']['id'],
					'visit_day'					=> date('Y-m-d H:i:s')
				);

			
				if ($result_TeacherCreateLesson['School']['credit'] >= $result_TeacherCreateLesson['School']['credit_charge']) { 	// credit school valid

					if ($flag) { 	// minus money (first time)
						
						// get school credit, charge fee
						$credit_charge 	= $result_TeacherCreateLesson['School']['credit_charge'];
						$credit 		= $result_TeacherCreateLesson['School']['credit'];
						$new_credit 	= $credit - $credit_charge;

						$obj_School = ClassRegistry::init('School.School');
						$obj_School->id = $result_TeacherCreateLesson['School']['id'];
						$obj_School->saveField('credit', $new_credit);

						// add members credit transaction
						$obj_CreditType = ClassRegistry::init('Credit.CreditType');
						$credit_type_id = $obj_CreditType->get_id_by_slug('credit-reduct-visit-zoom-link');

						$obj_MembersCredit = ClassRegistry::init('Member.MembersCredit');
						$data_MembersCredit = array(
							'member_id' 		=> $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
							'credit_type_id'	=> $credit_type_id,
							'credit' 			=> $credit_charge,
							'remark'			=> 'System reduct when student visit zoom link',
							'school_id' 		=> $result_TeacherCreateLesson['School']['id']
						);

						if (!$obj_MembersCredit->save($data_MembersCredit)) {
							$db->rollback();
							$status = 999;
							$message = __('data_is_not_saved') . " Members Credit";
							goto load_data_api;
						}

					}


					$result = $result_TeacherCreateLesson['TeacherCreateLesson'];

					if (!$obj_StudentJoinLiveLog->save($data_StudentJoinLiveLog)) {
						$db->rollback();
						$status = 999;
						$message = __('data_is_not_saved') . "Student Join Live Log";
						goto load_data_api;
					}


				} else {	// not enough credit
					if (!$flag) {	// no need minus credit (second time)
						$result = $result_TeacherCreateLesson['TeacherCreateLesson'];

						if (!$obj_StudentJoinLiveLog->save($data_StudentJoinLiveLog)) {
							$db->rollback();
							$status = 999;
							$message = __('data_is_not_saved') . "Student Join Live Log";
							goto load_data_api;
						}
					}
				} 

				$db->commit();
				$status = 200;
				$message = __('retrieve_data_successfully');

			}
			
			load_data_api:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}





	public function api_get_assignment() {

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

			} elseif (!isset($data['teacher_create_assignment_id']) || empty($data['teacher_create_assignment_id'])) {		
				$message = __('missing_parameter') . "teacher_create_assignment_id";
				
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);
			
				$db = $this->TeacherCreateLesson->getDataSource();
				$db->begin();

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);
				
				if (!$result_MemberLoginMethod) {
					$db->rollback();
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_data_api;
				}

				$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
				$role = $obj_MemberRole->check_exist_role($result_MemberLoginMethod['Member']['MemberRole'], Environment::read('role.teacher'));
				if (!$role) {
					$status = 600;
					$message = __d('member', 'invalid_role');
					goto load_data_api;
				}
				
				$obj_TeacherCreateAssignment = ClassRegistry::init('Member.TeacherCreateAssignment');
				$result = $obj_TeacherCreateAssignment->get_assignment($data['teacher_create_assignment_id'], $data['language'], $result_MemberLoginMethod['MemberLoginMethod']['member_id']);

				
				$db->commit();
				$status = 200;
				$message = __('retrieve_data_successfully');
			}
			
			load_data_api:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}


	public function api_teacher_update_assignment() {	// web

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

			} elseif (!isset($data['teacher_create_assignment_id']) || empty($data['teacher_create_assignment_id'])) {		
				$message = __('missing_parameter') . "teacher_create_assignment_id";

			// $data['class_id']
			// $data['school_id']
			// $data['name'],
				
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);
			
				$db = $this->TeacherCreateLesson->getDataSource();
				$db->begin();

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);
				
				if (!$result_MemberLoginMethod) {
					$db->rollback();
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_data_api;
				}

				$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
				$role = $obj_MemberRole->check_exist_role($result_MemberLoginMethod['Member']['MemberRole'], Environment::read('role.teacher'));
				if (!$role) {
					$status = 600;
					$message = __d('member', 'invalid_role');
					goto load_data_api;
				}

				$obj_School = ClassRegistry::init('School.School');
				$school_valid = $obj_School->is_school_available($data['school_id']);
				if(!$school_valid){
					$status = 999;
					$message = __d('school', 'school_not_available');
					goto load_data_api;
				}
				
				$obj_TeacherCreateAssignment = ClassRegistry::init('Member.TeacherCreateAssignment');
				$obj_TeacherCreateAssignmentMaterial = ClassRegistry::init('Member.TeacherCreateAssignmentMaterial');
						
				$data_TeacherCreateAssignment = array(
					'id'			=> $data['teacher_create_assignment_id'],
					'school_id' 	=> $data['school_id'],
					'name' 			=> $data['name'],
					'description' 	=> $data['description'],
					'class_id' 		=> $data['class_id'],
					'subject_id' 	=> isset($data['subject_id']) ? $data['subject_id'] : array(),
					'deadline' 		=> $data['deadline'],
					'teacher_id'	=> $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
				);

				if (!$obj_TeacherCreateAssignment->save($data_TeacherCreateAssignment)) {
					$message = __("data_is_not_saved") . 'Teacher Create Assignment';
					$status = 999;
					$db->rollback();
					goto load_data_api;
				}
	
				$files_save 	= array();
				$uploaded_files = array();

				if (isset($_FILES) && !empty($_FILES)) { 	

					// Upload File
					$files 			= array();

					// number of files
					if (!isset($data['number_file']) || empty($data['number_file'])) {
						$message = __('missing_parameter') . " number_file";
						goto load_data_api;
					}
					
					for ($i = 0; $i < $data['number_file']; $i++) {
						$_file_name = 'file' . $i;
						$uploaded_files = array();
					
						if (isset($_FILES[$_file_name])) {

							if ($_FILES[$_file_name]['size'] > 0) {
								$files[] = $_FILES[$_file_name];
								
							} else {
								$data[$_file_name] = '';
							}
						
							$relative_path = 'uploads' . DS . 'TeacherCreateAssignment' .  DS .  $data['teacher_create_assignment_id'] . DS . 'lessons' ;
			
							$file_name_suffix = $data['teacher_create_assignment_id'];
							$uploaded_files[] = $this->Common->upload_file($files, $relative_path, $file_name_suffix);

							foreach ($uploaded_files as $im) {

								if (isset($im['status']) && $im['status'] == true ) {
									if (isset($im['params']['success']) && !empty($im['params']['success']) ){
										foreach($im['params']['success'] as $key => $val) {
										
											$files_save[] = array(
												'name' 				=> $val['ori_name'],
												'path' 				=> str_replace("\\",'/',$val['path']),
												'type' 				=> $val['type'],
												'size' 				=> $val['size'],
												'teacher_create_assignment_id' 	=> $data['teacher_create_assignment_id'],
											);
										}
									}
								}
							}
						}
					}

					if (!empty($files_save)) {
						if (!$obj_TeacherCreateAssignmentMaterial->saveAll($files_save) ){
							$db->rollback();
							$status = 999;
							$message = __('data_is_not_saved') . " TeacherCreateAssignmentMaterial";
							goto load_data_api;
						}
						$obj_TeacherCreateAssignmentMaterial->clear();
					}
				}

				if (isset($data['remove_file_id']) && !empty($data['remove_file_id'])) {
					$obj_TeacherCreateAssignmentMaterial->deleteAll(array('TeacherCreateAssignmentMaterial.id' => json_decode($data['remove_file_id']), false));
					$obj_TeacherCreateAssignmentMaterial->clear();
				}

				$db->commit();
				$status = 200;
				$message = __('data_is_updated');
			}
			
			load_data_api:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}


	public function api_teacher_delete_assignment() {	// web

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

			} elseif (!isset($data['teacher_create_assignment_id']) || empty($data['teacher_create_assignment_id'])) {		
				$message = __('missing_parameter') . "teacher_create_assignment_id";
				
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);
			
				$db = $this->TeacherCreateLesson->getDataSource();
				$db->begin();

				$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
				$result_MemberLoginMethod = $obj_MemberLoginMethod->get_data_from_token($data['token']);
				
				if (!$result_MemberLoginMethod) {
					$db->rollback();
					$status = 600;
					$message = __d('member', 'invalid_token');
					goto load_data_api;
				}

				$obj_MemberRole = ClassRegistry::init('Member.MemberRole');
				$role = $obj_MemberRole->check_exist_role($result_MemberLoginMethod['Member']['MemberRole'], Environment::read('role.teacher'));
				if (!$role) {
					$status = 600;
					$message = __d('member', 'invalid_role');
					goto load_data_api;
				}
				
				$obj_TeacherCreateAssignment = ClassRegistry::init('Member.TeacherCreateAssignment');
				$obj_TeacherCreateAssignment->id = $data['teacher_create_assignment_id'];
				$obj_TeacherCreateAssignment->saveField('enabled', false);

				$db->commit();
				$status = 200;
				$message = __('data_is_updated');
			}
			
			load_data_api:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}
}
