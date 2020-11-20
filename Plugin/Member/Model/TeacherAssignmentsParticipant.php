<?php
App::uses('memberAppModel', 'member.Model');
/**
 * TeacherAssignmentsParticipant Model
 *
 * @property Teacher $Teacher
 * @property Assignment $Assignment
 */
class TeacherAssignmentsParticipant extends memberAppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Teacher' => array(
			'className' => 'Member.Member',
			'foreignKey' => 'teacher_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'TeacherCreateAssignment' => array(
			'className' => 'Member.TeacherCreateAssignment',
			'foreignKey' => 'assignment_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
