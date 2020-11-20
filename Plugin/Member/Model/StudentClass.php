<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * StudentClass Model
 *
 * @property Student $Student
 * @property School $School
 * @property Class $Class
 */
class StudentClass extends MemberAppModel {

	public $actsAs = array('Containable');
	// The Associations below have been created with all possible keys, those that are not needed can be removed


	public function __construct($id = false, $table = null, $ds = null) {
		$parent = get_parent_class($this);
		$this->_mergeVars(array('belongsTo'), $parent);	// override belongto parent appmodel
	
		parent::__construct($id, $table, $ds);
	}
	
	public $type = array(
		1 => 'Primary Class',
		0 => 'Second Class'
	);

	
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
		'School' => array(
			'className' => 'School.School',
			'foreignKey' => 'school_id',
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
		)
	);

	public function get_class_from_member ($id) {
		return $this->find('all', array(
			'conditions' => array(
				'StudentClass.student_id' => $id
			),
			'fields' => array(
				'StudentClass.school_class_id',
			),
		));	
	}
}
