<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * ImportHistory Model
 *
 * @property School $School
 */
class ImportHistory extends MemberAppModel {
	
	public $actsAs = array('Containable');

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'School' => array(
			'className' => 'School.School',
			'foreignKey' => 'school_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Role' => array(
			'className' => 'Administrator.Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
