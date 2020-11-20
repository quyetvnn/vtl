<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * TeacherCreateAssignmentMaterial Model
 *
 */
class TeacherCreateAssignmentMaterial extends MemberAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'type' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public $belongsTo = array(
		'TeacherCreateAssignment' => array(
			'className' => 'Member.TeacherCreateAssignment',
			'foreignKey' => 'teacher_create_assignment_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
