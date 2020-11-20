<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * StudentAssignmentSubmission Model
 *
 * @property Student $Student
 * @property TeacherCreateLesson $TeacherCreateLesson
 */
class StudentAssignmentSubmission extends MemberAppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed
	public $actsAs = array('Containable');
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
		
		'TeacherCreateAssignment' => array(
			'className' => 'Member.TeacherCreateAssignment',
			'foreignKey' => 'teacher_create_assignment_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),

	);

	public $hasMany = array(
			
		'StudentAssignmentSubmissionMaterial' => array(
			'className' => 'Member.StudentAssignmentSubmissionMaterial',
			'foreignKey' => 'student_assignment_submission_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),

		'TeacherFeedbackAssignmentMaterial' => array(
			'className' => 'Member.TeacherFeedbackAssignmentMaterial',
			'foreignKey' => 'student_assignment_submission_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),

	);

	public function get_submission_count_by_assignment_id($teacher_create_assignment_id){
		return $this->find('count', array(
			'conditions' => array(
				'StudentAssignmentSubmission.teacher_create_assignment_id' => $teacher_create_assignment_id,
			),
			'fields' => array(
				'StudentAssignmentSubmission.*',
			),
		));
	}

	public function get_obj($id) {
		return $this->find('first', array(
			'conditions' => array(
				'StudentAssignmentSubmission.id' => $id,
			),
			'fields' => array(
				'StudentAssignmentSubmission.*',
			),
			'contain' => array(
				'TeacherCreateAssignment' => array(
					'fields' => 'school_id'
				),
			),
		));
	}

	public function get_obj_with_param($student_id, $teacher_create_assignment_id) {
		return $this->find('first', array(
			'conditions' => array(
				'StudentAssignmentSubmission.student_id' => $student_id,
				'StudentAssignmentSubmission.teacher_create_assignment_id' => $teacher_create_assignment_id,
			),
			'fields' => array(
				'StudentAssignmentSubmission.*',
			),
		));
	}
}
