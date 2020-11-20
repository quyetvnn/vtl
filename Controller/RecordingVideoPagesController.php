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
class RecordingVideoPagesController extends AppController {

	public $components = array('Paginator');
	/**
	 * This controller does not use a model
	 *
	 * @var array
	 */
	public $uses = array();
	public $current_user = array();

	public function beforeFilter() {
		parent::beforeFilter();
		$this->layout = "bootstrap";
		$current_user = $this->current_user;

		if (empty($current_user)) {
			$this->Session->setFlash(__d('member', 'please_login_first'), 'flash/error');
			$this->redirect('/');
		}

		$student = $current_user['role']=='role-student' ? true: false;

		if (!$student) {
			$this->Session->setFlash(__d('member', "this_account_dont_exist_student_role") , 'flash/error');
			$this->redirect('/');
		}
	}

	// public function index() {

	// 	$this->layout = "bootstrap";
	// 	$current_user = $this->current_user;
	// 	$obj_StudentClasses = ClassRegistry::init('Member.StudentClass');
	// 	$studentClasses = $obj_StudentClasses->find('all', array(
	// 		'fields' => array(
	// 			'StudentClass.school_class_id',
	// 			'StudentClass.school_id',
	// 		),
	// 		'conditions' => array(
	// 			'StudentClass.student_id' => $this->current_user['member_id'],
	// 		),
	// 	));

	// 	$obj_TeacherCreateLesson = ClassRegistry::init('Member.TeacherCreateLesson');
	// 	// $day_begin = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "-4 day"));
	// 	// $day_end = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+4 day"));
	// 	$teacherCreateLessonsRecordings = array();
	// 	$teacher_CreateLessonsRecordings = $obj_TeacherCreateLesson->find('all', array(
	// 		'fields' => array(
	// 			'TeacherCreateLesson.*'
	// 		),
	// 		'conditions' => array(
	// 			'TeacherCreateLesson.enabled' => true,
	// 			'AND' => array(
	// 				array('TeacherCreateLesson.recording_video <>' => NULL),
	// 				array('TeacherCreateLesson.recording_video <>' => ""),		// https://youtu.be/IUAerh3bgZw
	// 			),
	// 			'TeacherCreateLesson.allow_playback' => true,
	// 			// 'TeacherCreateLesson.start_time >='		=> $day_begin,
	// 			// 'TeacherCreateLesson.end_time <='		=> $day_end
	// 		),
	// 		'contain' => array(
	// 			'SchoolSubject' => array(
	// 				'fields' => array(
	// 					'SchoolSubject.id',
	// 				),
	// 				'SchoolSubjectLanguage' => array(
	// 					'fields' => array(
	// 						'SchoolSubjectLanguage.*',
	// 					),
	// 					'conditions' => array(
	// 						'SchoolSubjectLanguage.alias' => $this->lang18,
	// 					),
	// 				),
	// 			),
	// 			'Teacher' => array(
	// 				'MemberLanguage' => array(
	// 					'fields' => array(
	// 						'MemberLanguage.name',
	// 					),
	// 					'conditions' => array(
	// 						'MemberLanguage.alias' => $this->lang18,
	// 					),
	// 				),
	// 			),
	// 			'School' => array(
	// 				'SchoolImage' => array(),
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
	// 		'order' => array(
	// 			'TeacherCreateLesson.start_time ASC',
	// 		),
	// 	));

	// 	// pr ($teacher_CreateLessonsRecordings);
	// 	// exit;

	// 	// pr ($teacher_CreateLessonsRecordings);
	// 	// pr ($studentClasses);
	// 	// exit;

	// 	$teacherCreateLessons = array();
	// 	$count = 0;
	// 	foreach ($teacher_CreateLessonsRecordings as $val) {

	// 		foreach($studentClasses as $student){

	// 			// just study that class can view the video
	// 			$list_class  = $val['TeacherCreateLesson']['list_class'];
	// 			if (!is_null($list_class) && !empty($list_class)) {
	// 				foreach (json_decode($list_class) as $class) {
	// 					if ($class == $student['StudentClass']['school_class_id']) {
	// 						$val['TeacherCreateLesson']['start_hour'] = date('H:i', strtotime($val['TeacherCreateLesson']['start_time']));
	// 						$val['TeacherCreateLesson']['end_hour']  =  date('H:i', strtotime($val['TeacherCreateLesson']['end_time']));
			
	// 						$teacherCreateLessonsRecordings[] = $val;
	// 						$count++;
	// 					}
	// 				}
	// 			}
	// 		}
	// 	}

	// 	$this->set(compact('count', 'current_user', 'studentClasses', 'teacherCreateLessonsRecordings'));
	// }
}
