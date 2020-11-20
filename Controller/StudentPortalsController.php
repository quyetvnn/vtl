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
class StudentPortalsController extends AppController {

	public $components = array('Paginator');
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	// public $current_user = array();

	public function beforeFilter() {
		parent::beforeFilter();
		$this->layout = "bootstrap";
		$is_student  = false;

		$current_user =  $this->current_user;

		if (!isset($current_user) || empty($current_user)) {
			$this->Session->setFlash(__d('member', 'please_login_first'), 'flash/error');
			$this->redirect('/');
		}

		if (!$current_user['is_student']) {
			$this->Session->setFlash(__d('member', 'this_account_dont_exist_student_role'), 'flash/error');
			$this->redirect('/');
		}
	}

	public function index() {

		$this->layout = "bootstrap";
		$current_user = $this->current_user;
		$teacherLessons      = array();
		$lst_active_lesson 	 = array();
		$lst_inactive_lesson = array();
		$lst_nearly_active_lesson = array();
		$lst_overlapped_id 	 = array();
		$base_api_url =Router::url('/', true);
		$request_body = array(
			"token" => $current_user['token'],
			"language" => $this->lang18
		);
		$resp_lesson = $this->Common->curl_post('api/member/teacher_create_lessons/get_student_lesson.json', $request_body);
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

	public function assignment_submit($id = null, $resubmit = null){
			
		$this->set(compact('id', 'resubmit'));	
	}

	public function browse($school_code=null){
		$this->layout = "bootstrap";
		$current_user_id = '';
		$teachers = array();
		$studentClasses = array();
		$obj_School = ClassRegistry::init('School.School');
		$school_valid = $obj_School->is_school_code_available($school_code);
		if(!$school_valid){
			$this->Session->setFlash(__d('school', 'school_not_available'), 'flash/error');
			$this->redirect('/');
		}

		$obj_TeacherCreateLesson = ClassRegistry::init('Member.TeacherCreateLesson') ;

		// json search like
		// SELECT * FROM `booster_teacher_create_lessons` 
		// WHERE `list_teacher` LIKE '%"480"%'

		$conditions = array();
		$teacherCreateLessons = array();

		$temp = $obj_TeacherCreateLesson->find('all', array(
			'fields' => array(
				'TeacherCreateLesson.*'
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
					'fields' => array(
						'School.id',
					),
					'SchoolLanguage' => array(
						'fields' => array(
							'SchoolLanguage.name',
						),
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18,
						),
					),
				),
				'SchoolSubject' => array(
					'SchoolSubjectLanguage' => array(
						'fields' => array(
							'SchoolSubjectLanguage.name',
						),
						'conditions' => array(
							'SchoolSubjectLanguage.alias' => $this->lang18,
						),
					)
				),
			),
			'conditions' => array(
				'TeacherCreateLesson.end_time >=' => date('Y-m-d H:i:s'),
				'School.school_code' => $school_code,
			),
			'recursive' => 1,
			'order' => 'TeacherCreateLesson.start_time ASC',
		));
		if(!empty($temp)){
			$school_id = reset($temp)['School']['id'] ;
			$obj_StudentClasses = ClassRegistry::init('Member.StudentClass');
			$studentClasses = $obj_StudentClasses->find('all', array(
				'fields' => array(
					'StudentClass.school_class_id',
					'StudentClass.school_id'
				),
				'contain' => array(
					'SchoolClass' => array(
						'fields' => array(
							'SchoolClass.name'
						)
					),
					'School' => array(
						'fields' => array(
							'School.school_code'
						)
					),
				),
				'conditions' => array(
					'StudentClass.student_id' => $this->current_user['member_id'],
					'StudentClass.school_id' => $school_id,
				),
			));

			
			$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
			$teachers = $obj_MemberLoginMethod->get_list_teacher($school_id, $this->lang18);

			$current_user_id = $this->current_user['member_id'];

			

			if(count($studentClasses)>0){
				foreach ($temp as $val) {
					$val['TeacherCreateLesson']['class_name'] = array();
					$list_class  = $val['TeacherCreateLesson']['list_class'];
					if (!is_null($list_class) && !empty($list_class)) {
						$list_class  = json_decode($list_class);
						foreach($studentClasses as $student){
							if(in_array($student['StudentClass']['school_class_id'], $list_class)){
								if(!in_array($student['SchoolClass']['name'], $val['TeacherCreateLesson']['class_name'])) {
									array_push($val['TeacherCreateLesson']['class_name'], $student['SchoolClass']['name']);
								}
							}
						}
					}
					if(count($val['TeacherCreateLesson']['class_name'])>0){
						$teacherCreateLessons[] = $val;
					}
				}
			}
		}

		$this->set(compact('current_user_id', 'teacherCreateLessons', 'teachers', 'studentClasses'));
	}





	public function assignments($school_code=null) {

		$this->layout = "bootstrap";

		$obj_School = ClassRegistry::init('School.School');
		$school_valid = $obj_School->is_school_code_available($school_code);
		if(!$school_valid){
			$this->Session->setFlash(__d('school', 'school_not_available'), 'flash/error');
			$this->redirect('/');
		}
		
		$obj_StudentAssignmentSubmission = ClassRegistry::init('Member.StudentAssignmentSubmission');
		$obj_TeacherCreateAssginment = ClassRegistry::init('Member.TeacherCreateAssignment');


		$obj_StudentClass = ClassRegistry::init('Member.StudentClass');

		$classes = $obj_StudentClass->get_class_from_member($this->current_user['member_id']);

		$teacherCreateAssginments = array();
		$result_TeacherCreateAssginment = $obj_TeacherCreateAssginment->find('all', array(
			'conditions' => array(
				'School.school_code' => $school_code,
				'TeacherCreateAssignment.enabled' => true, 
			),
			'contain' => array(
				'School' => array(
					'SchoolLanguage' => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18,
						),
					), 
				),
				'SchoolClass',
				'SchoolSubject' => array(
					'SchoolSubjectLanguage' =>  array(
						'conditions' => array(
							'SchoolSubjectLanguage.alias' => $this->lang18,
						),
					),
				),
				'TeacherCreateAssignmentMaterial',
				'StudentAssignmentSubmission' => array(
					'conditions' => array(
						'StudentAssignmentSubmission.student_id' => $this->current_user['member_id'],	// remark, feedback, score
					),
					'StudentAssignmentSubmissionMaterial',
					'TeacherFeedbackAssignmentMaterial',
				),
			),
			'order' => array(
				'TeacherCreateAssignment.id DESC',
			),
		));

		$teacherCreateAssignments = array();
		foreach ($result_TeacherCreateAssginment as $val) {
			foreach ($classes as $class) {
				if ($val['TeacherCreateAssignment']['class_id'] == $class['StudentClass']['school_class_id']) {
					$teacherCreateAssignments[] = $val;
				}
			}
		}
		$this->set(compact('teacherCreateAssignments'));
	}

	public function library() {

		$this->layout = "bootstrap";
		$current_user = $this->current_user;
		$obj_StudentClasses = ClassRegistry::init('Member.StudentClass');
		$studentClasses = $obj_StudentClasses->find('all', array(
			'fields' => array(
				'StudentClass.school_class_id',
				'StudentClass.school_id',
			),
			'conditions' => array(
				'StudentClass.student_id' => $this->current_user['member_id'],
			),
		));

		$obj_TeacherCreateLesson = ClassRegistry::init('Member.TeacherCreateLesson');
		$obj_School = ClassRegistry::init('School.School');
		$day_begin = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "-4 day"));
		$day_end = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+4 day"));
		$teacherCreateLessonsRecordings = array();
		$teacher_CreateLessonsRecordings = $obj_TeacherCreateLesson->find('all', array(
			'fields' => array(
				'TeacherCreateLesson.*'
			),
			'conditions' => array(
				'TeacherCreateLesson.enabled' => true,
				'School.status' => array_search('Normal', $obj_School->status),
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

		$teacherCreateLessons = array();
		$count = 0;
		foreach ($teacher_CreateLessonsRecordings as $val) {

			foreach($studentClasses as $student){

				// just study that class can view the video
				$list_class  = $val['TeacherCreateLesson']['list_class'];
				if (!is_null($list_class) && !empty($list_class)) {
					foreach (json_decode($list_class) as $class) {
						if ($class == $student['StudentClass']['school_class_id']) {
							$val['TeacherCreateLesson']['start_hour'] = date('H:i', strtotime($val['TeacherCreateLesson']['start_time']));
							$val['TeacherCreateLesson']['end_hour']  =  date('H:i', strtotime($val['TeacherCreateLesson']['end_time']));
			
							$teacherCreateLessonsRecordings[] = $val;
							$count++;
						}
					}
				}
			}
		}

		$this->set(compact('count', 'current_user', 'studentClasses', 'teacherCreateLessonsRecordings'));
	}
	
}
