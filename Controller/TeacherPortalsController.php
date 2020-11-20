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
class TeacherPortalsController extends AppController {

	public $components = array('Paginator', 'Common');

	public $log_module = "client_api";
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Cookie->httpOnly = false;
		$this->layout = "bootstrap";
		$current_user =  $this->current_user;
		

		if (!isset($current_user) || empty($current_user)) {
			$this->Session->setFlash(__d('member', 'please_login_first'), 'flash/error');
			$this->redirect('/');
		}

		if (!$current_user['is_teacher']) {
			$this->Session->setFlash(__d('member', 'this_account_dont_exist_teacher_role'), 'flash/error');
			$this->redirect('/');
		}
	}

	public function index(){
		$this->layout = "bootstrap";
		$current_user = $this->current_user;
		$teacherLessons      = array();
		$lst_active_lesson 	 = array();
		$lst_inactive_lesson = array();
		$lst_overlapped_id 	 = array();
		$lst_nearly_active_lesson = array();
		$base_api_url =Router::url('/', true);
		$request_body = array(
			"token" => $current_user['token'],
			"language" => $this->lang18
		);
		$resp_lesson = $this->Common->curl_post('api/member/teacher_create_lessons/get_teacher_lesson.json', $request_body);
		if($resp_lesson!=false){
			$resp_lesson = json_decode($resp_lesson, true);
			if( $resp_lesson['status']==200){
				$teacherLessons = $resp_lesson['params'];
				$lst_active_lesson = array_filter($teacherLessons, function($obj){
									    if (isset($obj['TeacherCreateLesson'])) {
									        if ($obj['TeacherCreateLesson']['is_active'] == true) return true;
									    }
									    return false;
									});

				$lst_nearly_active_lesson = array_filter($teacherLessons, function($obj){
									    if (isset($obj['TeacherCreateLesson'])) {
									        if ($obj['TeacherCreateLesson']['is_active'] == false && $obj['TeacherCreateLesson']['is_nearly_active']==true) return true;
									    }
									    return false;
									});

				$lst_inactive_lesson = array_filter($teacherLessons, function($obj){
									    if (isset($obj['TeacherCreateLesson'])) {
									        if ($obj['TeacherCreateLesson']['is_active'] == false && 
									        	$obj['TeacherCreateLesson']['is_nearly_active']==false) 
									        	return true;
									    }
									    return false;
									});
				foreach ($teacherLessons as $i) {
					foreach ($teacherLessons as $j) {
						if( $i['TeacherCreateLesson']['id'] != $j['TeacherCreateLesson']['id'] ){
							
							$start_time1 = strtotime($i['TeacherCreateLesson']['start_time']);
							$end_time1 = strtotime($i['TeacherCreateLesson']['end_time']);

							$start_time2 = strtotime($j['TeacherCreateLesson']['start_time']);
							$end_time2 = strtotime($j['TeacherCreateLesson']['end_time']);

							if($start_time1 <=  $end_time2 && $start_time2 <= $end_time1){
								array_push($lst_overlapped_id, $i['TeacherCreateLesson']['id']);
								break;
							}
						} 
					}
				}
			}
		}
		$count = count($teacherLessons);
		$this->set(compact('count', 'lst_active_lesson', 'lst_nearly_active_lesson', 'lst_inactive_lesson', 'current_user', 'base_api_url', 'lst_overlapped_id'));	
	}

	public function assignment_create(){}

	public function assignment_edit($id=null){
		$obj_TeacherCreateAssignment = ClassRegistry::init('Member.TeacherCreateAssignment');
		$assignment = $obj_TeacherCreateAssignment->get_assignment($id, $this->lang18, $this->current_user['member_id']);

		if (!isset($assignment) || empty($assignment)) {

			$this->Session->setFlash(__d('member', 'page_not_found'), 'flash/error');
			$this->redirect('/');
		}
		$this->set(compact('assignment'));
	}

	public function browse($school_code=null){
		$this->layout = "bootstrap";
		$current_user_id = '';
		$schoolClasses = array();
		$teachers = array();

		$role_teacher = $this->current_user['member_role'][Environment::read('role.teacher')];
		$contains_school = 	array_filter($role_teacher, function($obj) use ($school_code) {
							    if ($obj['School']['school_code']==$school_code) return true;
							    return false;
							});
		if (empty($contains_school)) {
		    $this->Session->setFlash(__d('school', 'school_not_available'), 'flash/error');
			$this->redirect('/');
		}

		$obj_TeacherCreateLesson = ClassRegistry::init('Member.TeacherCreateLesson') ;

		// json search like
		// SELECT * FROM `booster_teacher_create_lessons` 
		// WHERE `list_teacher` LIKE '%"480"%'

		$conditions = array();
		$all_settings = array(
			'conditions' => array(
				'TeacherCreateLesson.end_time >=' => date('Y-m-d H:i:s'),
				'School.school_code' => $school_code,
				'OR' => array(
					array('TeacherCreateLesson.teacher_id' => $this->current_user['member_id']),
					array('TeacherCreateLesson.list_teacher LIKE' => '%"' . $this->current_user['member_id'] . '"%')
				),
			),
			'contain' => array(
				// 'TeacherCreateLessonAssignment',
				// 'StudentAssignmentSubmission',
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
			'order' => 'TeacherCreateLesson.start_time ASC',
		);

		$this->Paginator->settings = $all_settings;
		$teacherCreateLessons = $this->paginate($obj_TeacherCreateLesson);
		if(!empty($teacherCreateLessons)){
			$school_id = reset($teacherCreateLessons)['School']['id'];
			$obj_SchoolClass = ClassRegistry::init('School.SchoolClass');
			$schoolClasses = $obj_SchoolClass->get_list_school_class($school_id);
			$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
			$teachers = $obj_MemberLoginMethod->get_list_teacher($school_id, $this->lang18);
			$current_user_id = $this->current_user['member_id'];
		}

		
		$this->set(compact('current_user_id', 'teacherCreateLessons', 'schoolClasses', 'teachers'));
	}

	public function delete($id = null, $school_code = null) {

		$obj_TeacherCreateLesson = ClassRegistry::init('Member.TeacherCreateLesson');

		$obj_TeacherCreateLesson->id = $id;

		if (!$obj_TeacherCreateLesson->exists()) {
			throw new NotFoundException(__('Invalid teacher create lesson'));
		}

		if ($obj_TeacherCreateLesson->delete()) {

			// $result_client = $obj_TeacherCreateLesson->delete_meeting($id);
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
		return $this->redirect(array('action' => 'browse', $school_code));
	}



	public function add() {
		$this->layout = "bootstrap";
		$current_user = $this->current_user;
		$obj_TeacherCreateLesson = ClassRegistry::init('Member.TeacherCreateLesson');

		$durationHours = $obj_TeacherCreateLesson->duration_hours;
		$durationMinutes = $obj_TeacherCreateLesson->duration_minutes;
		$this->set(compact('current_user', 'durationHours', 'durationMinutes'));
	}



	public function edit($id = null) {
		$teacherLesson 				= array();
		$list_subject_full 			= array();
		$subject_name 				= '';
		$list_class_full 			= array();
		$list_teacher_full 			= array();
		$list_class_name 			= array();
		$list_teacher_name 		 	= array();
		$list_attend_teacher_name 	= array();

		$obj_TeacherCreateLesson = ClassRegistry::init('Member.TeacherCreateLesson');

		$durationHours = $obj_TeacherCreateLesson->duration_hours;
		$durationMinutes = $obj_TeacherCreateLesson->duration_minutes;

		$request_body = array(
			"token" => $this->current_user['token'],
			"language" => $this->lang18,
			"id" => $id
		);
		$resp_lesson = $this->Common->curl_post('api/member/teacher_create_lessons/get_lesson.json', $request_body);

		if($resp_lesson!=false){
			$resp_lesson = json_decode($resp_lesson, true);
			if( $resp_lesson['status']==200){
				$teacherLesson = $resp_lesson['params'];

				$obj_School = ClassRegistry::init('School.School');
				$school_valid = $obj_School->is_school_available($teacherLesson['TeacherCreateLesson']['school_id']);
				if(!$school_valid){
					$this->Session->setFlash(__d('school', 'school_not_available'), 'flash/error');
					$this->redirect('/');
				}

				$teacherLesson['TeacherCreateLesson']['list_class'] = json_decode($teacherLesson['TeacherCreateLesson']['list_class'], true);
				$teacherLesson['TeacherCreateLesson']['list_teacher'] = json_decode($teacherLesson['TeacherCreateLesson']['list_teacher'], true);
				$teacherLesson['TeacherCreateLesson']['list_attend_teacher'] = json_decode($teacherLesson['TeacherCreateLesson']['list_attend_teacher'], true);
			}
		}
		if(!$teacherLesson){
			$this->Session->setFlash('Lesson not exist', 'default', array('class' => 'alert alert-danger'));
			$this->redirect(array('action' => 'browse'));
		}

		// pr($teacherLesson);

		/*Get list subject*/

		$request_get_subject = array(
			"token" => $this->current_user['token'],
			"language" => $this->lang18,
			"school_id" => $teacherLesson['TeacherCreateLesson']['school_id']
		);
		$resp_subject = $this->Common->curl_post('api/school/school_subjects/get_list_subject_by_school_id.json', $request_get_subject);
		if($resp_subject!=false){
			$resp_subject = json_decode($resp_subject, true);
			if( $resp_subject['status']==200){
				$list_subject_full = $resp_subject['params'];
				if(isset($teacherLesson['TeacherCreateLesson']['subject_id']) && $teacherLesson['TeacherCreateLesson']['subject_id']!=''){
					$allowed = $teacherLesson['TeacherCreateLesson']['subject_id'];

					$subject_name = array_filter($list_subject_full, function ($key) use ($allowed) {
											        return $key == $allowed;
											    },
											    ARRAY_FILTER_USE_KEY
											);
					if(count($subject_name)>0){
						$subject_name = $subject_name[$teacherLesson['TeacherCreateLesson']['subject_id']];
					}else{
						$subject_name = '';
					}
				}
				
			}
		}

		$teacherLesson['TeacherCreateLesson']['subject_name'] = $subject_name;
		$teacherLesson['TeacherCreateLesson']['list_subject_full'] = $list_subject_full;

		/*Get list subject*/

		/*Get list class*/

		$request_get_class = array(
			"token" => $this->current_user['token'],
			"language" => $this->lang18,
			"school_id" => $teacherLesson['TeacherCreateLesson']['school_id']
		);
		$resp_class = $this->Common->curl_post('api/school/school_classes/get_list_class_by_school_id.json', $request_get_class);
		if($resp_class!=false){
			$resp_class = json_decode($resp_class, true);
			if( $resp_class['status']==200){
				$list_class_full = $resp_class['params'];
				if(isset($teacherLesson['TeacherCreateLesson']['list_class']) && $teacherLesson['TeacherCreateLesson']['list_class']!=''){
					$allowed = $teacherLesson['TeacherCreateLesson']['list_class'];
					$list_class_name = array_filter($list_class_full, function ($key) use ($allowed) {
											        return in_array($key, $allowed);
											    },
											    ARRAY_FILTER_USE_KEY
											);
				}
				
			}
		}

		$teacherLesson['TeacherCreateLesson']['list_class_full'] = $list_class_full;
		$teacherLesson['TeacherCreateLesson']['list_class_name'] = $list_class_name;

		/*Get list class*/

		/*Get list teacher / attend teacher*/

		$request_get_teacher = array(
			"token" => $this->current_user['token'],
			"language" => $this->lang18,
			"school_id" => $teacherLesson['TeacherCreateLesson']['school_id']
		);
		$resp_teacher = $this->Common->curl_post('api/member/member_login_methods/get_list_teacher.json', $request_get_teacher);
		if($resp_teacher!=false){
			$resp_teacher = json_decode($resp_teacher, true);
			if( $resp_teacher['status']==200){
				$list_teacher_full = $resp_teacher['params'];
				if(isset($teacherLesson['TeacherCreateLesson']['list_teacher']) && $teacherLesson['TeacherCreateLesson']['list_teacher']!=''){
					$allowed = $teacherLesson['TeacherCreateLesson']['list_teacher'];
					$list_teacher_name = array_filter($list_teacher_full, function ($key) use ($allowed) {
											        return in_array($key, $allowed);
											    },
											    ARRAY_FILTER_USE_KEY
											);
				}
				
				if(isset($teacherLesson['TeacherCreateLesson']['list_attend_teacher']) && $teacherLesson['TeacherCreateLesson']['list_attend_teacher']!=''){
					$allowed = $teacherLesson['TeacherCreateLesson']['list_attend_teacher'];
					$list_attend_teacher_name = array_filter($list_teacher_full, function ($key) use ($allowed) {
												        return in_array($key, $allowed);
												    },
												    ARRAY_FILTER_USE_KEY
												);
				}
				
				
			}
		}

		$teacherLesson['TeacherCreateLesson']['list_teacher_full'] = $list_teacher_full;
		$teacherLesson['TeacherCreateLesson']['list_teacher_name'] = $list_teacher_name;

		$teacherLesson['TeacherCreateLesson']['list_attend_teacher_name'] = $list_attend_teacher_name;
		/*Get list teacher / attend teacher*/

		$this->set(compact('teacherLesson', 'durationHours', 'durationMinutes'));
	}

	public function assignments($school_code=null) {

		$this->layout = "bootstrap";

		$role_teacher = $this->current_user['member_role'][Environment::read('role.teacher')];
		$contains_school = 	array_filter($role_teacher, function($obj) use ($school_code) {
							    if ($obj['School']['school_code']==$school_code) return true;
							    return false;
							});
		if (empty($contains_school)) {
		    $this->Session->setFlash(__d('school', 'school_not_available'), 'flash/error');
			$this->redirect('/');
		}

		$obj_TeacherCreateAssignment = ClassRegistry::init('Member.TeacherCreateAssignment');

		$all_settings = array(
			'conditions' => array(
				// 'TeacherCreateAssignment.teacher_id' => $this->current_user['member_id'],
				'School.school_code' => $school_code,
				'TeacherCreateAssignment.enabled' => true, 
			),
			'contain' => array(
				'TeacherAssignmentsParticipant' => array(
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
				'TeacherCreateAssignmentMaterial',
				'School' => array(
					'SchoolLanguage' => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18,
						),
					), 
				),
				// 'SchoolClass',
				'SchoolsGroup' => 	array(
					'SchoolsGroupsLanguage' =>  array(
						'conditions' => array(
							'SchoolsGroupsLanguage.alias' => $this->lang18,
						),
					),
				),
				'SchoolSubject' => array(
					'SchoolSubjectLanguage' =>  array(
						'conditions' => array(
							'SchoolSubjectLanguage.alias' => $this->lang18,
						),
					),
				),
			),
			'order' => 'TeacherCreateAssignment.id DESC',
		);


		$this->Paginator->settings = $all_settings;
		$teacherCreateAssignments = $this->paginate($obj_TeacherCreateAssignment);

		$this->set(compact('teacherCreateAssignments'));
	}
	
	public function student_submission($id) {

		$this->layout = "bootstrap";
		$obj_School = ClassRegistry::init('School.School');
		$obj_TeacherCreateAssignment = ClassRegistry::init('Member.TeacherCreateAssignment');
		$obj_StudentAssignmentSubmission = ClassRegistry::init('Member.StudentAssignmentSubmission');
		$obj_StudentAssignmentSubmissionMaterial = ClassRegistry::init('Member.StudentAssignmentSubmissionMaterial');

		$teacherCreateAssignment = $obj_TeacherCreateAssignment->find('first',  array(
			'conditions' => array(
				'TeacherCreateAssignment.id' => $id,
				'TeacherCreateAssignment.enabled' => true,
				'School.status' => array_search('Normal', $obj_School->status),
			),
			'contain' => array(
				'Teacher' => array(
					'MemberLanguage' => array(
						'conditions' => array(
							'MemberLanguage.alias' => $this->lang18,
						),
					), 
				),
				'School' => array(
					'fields' => array(
						'School.id',
					)
				)
			)
		));

		if(!isset($teacherCreateAssignment) || empty($teacherCreateAssignment)){
			$this->Session->setFlash(__d('school', 'assignment_not_available'), 'flash/error');
			$this->redirect('/');
		}

		$studentAssignmentSubmissions = $obj_StudentAssignmentSubmission->find('all',  array(
			'conditions' => array(
				'StudentAssignmentSubmission.teacher_create_assignment_id' => $id,
			),
			'contain' => array(
				'Student' => array(
					'MemberLanguage' => array(
						'conditions' => array(
							'MemberLanguage.alias' => $this->lang18,
						),
					), 
				),
				'StudentAssignmentSubmissionMaterial',
				'TeacherFeedbackAssignmentMaterial',
			),
		));

		// $this->Paginator->settings = $all_settings;
		// $studentAssignmentSubmissions = $this->paginate($obj_StudentAssignmentSubmission);
		$this->set(compact('studentAssignmentSubmissions', 'teacherCreateAssignment'));
	}

	public function library() {


		$this->layout = "bootstrap";
		$current_user = $this->current_user;

		$day_begin = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "-" . Environment::read('playback_view_time') . " day"));
		$day_end = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));


		$obj_TeacherCreateLesson = ClassRegistry::init('Member.TeacherCreateLesson');
		$obj_School = ClassRegistry::init('School.School');
		$teacherCreateLessonsRecordings = array();
		$teacher_CreateLessonsRecordings = $obj_TeacherCreateLesson->find('all', array(
			'fields' => array(
				'TeacherCreateLesson.*'
			),
			'conditions' => array(
				'School.status' => array_search('Normal', $obj_School->status),
				'OR' => array(
					array('TeacherCreateLesson.teacher_id' => $this->current_user['member_id']),
					array('TeacherCreateLesson.list_teacher LIKE' => '%"' . $this->current_user['member_id'] . '"%')
				),
				
				'TeacherCreateLesson.enabled' => true,
				'AND' => array(
					array('TeacherCreateLesson.recording_video <>' => NULL),
					array('TeacherCreateLesson.recording_video <>' => ""),		// https://youtu.be/IUAerh3bgZw
				),
				'TeacherCreateLesson.allow_playback' => true,
				'DATE(TeacherCreateLesson.start_time) >='		=> $day_begin,
			),
			'contain' => array(
				'SchoolSubject' => array(
					'fields' => array(
						'SchoolSubject.id',
					),
					'SchoolSubjectLanguage' => array(
						'fields' => array(
							'SchoolSubjectLanguage.*',
						),
						'conditions' => array(
							'SchoolSubjectLanguage.alias' => $this->lang18,
						),
					),
				),
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
				'School' => array(
					'SchoolImage' => array(),
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
			'order' => array(
				'TeacherCreateLesson.start_time ASC',
			),
		));
		$count = count($teacher_CreateLessonsRecordings);
		foreach ($teacher_CreateLessonsRecordings as $val) {

			$val['TeacherCreateLesson']['start_hour'] = date('H:i', strtotime($val['TeacherCreateLesson']['start_time']));
			$val['TeacherCreateLesson']['end_hour']  =  date('H:i', strtotime($val['TeacherCreateLesson']['end_time']));

			$teacherCreateLessonsRecordings[] = $val;
		}

		$this->set(compact('count', 'current_user', 'teacherCreateLessonsRecordings'));
	}

	public function submission_feedback_create($id = null, $resubmit = null){
		$obj_StudentAssignmentSubmission = ClassRegistry::init('Member.StudentAssignmentSubmission');
		$studentAssignmentSubmission = $obj_StudentAssignmentSubmission->find('first', array(
			'conditions' => array(
				'StudentAssignmentSubmission.id' => $id,
			)
		));
		$this->set(compact('studentAssignmentSubmission', 'id', 'resubmit'));
	}
}
