<?php
App::uses('AdministrationAppModel', 'Administration.Model');
/**
 * RoleLanguage Model
 *
 * @property Role $Role
 */
class RoleLanguage extends AdministrationAppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Role' => array(
			'className' => 'Administration.Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
