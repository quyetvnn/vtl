<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * TeacherFeedbackAssignmentMaterial Model
 *
 * @property StudentAssignmentSubmission $StudentAssignmentSubmission
 */
class TeacherFeedbackAssignmentMaterial extends MemberAppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'StudentAssignmentSubmission' => array(
			'className' => 'Member.StudentAssignmentSubmission',
			'foreignKey' => 'student_assignment_submission_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
