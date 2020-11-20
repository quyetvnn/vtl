<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * StudentJoinLiveLog Model
 *
 * @property Student $Student
 * @property TeacherCreateLesson $TeacherCreateLesson
 * @property School $School
 */
class StudentJoinLiveLog extends MemberAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'student_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'teacher_create_lesson_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'school_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'join_day' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Student' => array(
			'className' => 'Member.Member',
			'foreignKey' => 'student_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'TeacherCreateLesson' => array(
			'className' => 'Member.TeacherCreateLesson',
			'foreignKey' => 'teacher_create_lesson_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'School' => array(
			'className' => 'School.School',
			'foreignKey' => 'school_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function check_condition_member_within_one_month($student_id, $school_id) {
		$current_month = date('m');
		$count = $this->find('count', array(
			'conditions' => array(
				'MONTH(StudentJoinLiveLog.visit_day)' 	=> $current_month,
				'(StudentJoinLiveLog.student_id)' 		=> $student_id,
				'(StudentJoinLiveLog.school_id)' 		=> $school_id,
			),	
		));

		if ($count > 0) {		// dont minus money
			return false;
		}

		return true;			// minus money
	}
}
