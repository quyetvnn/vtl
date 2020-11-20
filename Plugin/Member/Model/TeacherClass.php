<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * TeacherClass Model
 *
 * @property Teacher $Teacher
 * @property Class $Class
 * @property School $School
 */
class TeacherClass extends MemberAppModel {

	public $actsAs = array('Containable');
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
		'SchoolClass' => array(
			'className' => 'School.SchoolClass',
			'foreignKey' => 'school_class_id',
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
}
