<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * InviteMemberHistory Model
 *
 * @property School $School
 * @property Role $Role
 */
class InviteMemberHistory extends MemberAppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed
	public $actsAs = array('Containable');
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
			'className' => 'Administration.Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function get_obj($role_id_link, $school_id_link, $username_link) {
		return $this->find('first', array(
			'conditions' => array(
				'InviteMemberHistory.role_id' 	=> $role_id_link,
				'InviteMemberHistory.school_id' => $school_id_link,
				'InviteMemberHistory.email' 	=> $username_link,
			),
			'fields' => array(
				'InviteMemberHistory.*',
			),
		));
	}	
}
