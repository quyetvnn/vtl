<?php
App::uses('SchoolAppModel', 'School.Model');
/**
 * SchoolsGroupsLanguage Model
 *
 * @property Group $Group
 */
class SchoolsGroupsLanguage extends SchoolAppModel {

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'SchoolsGroup' => array(
			'className' => 'School.SchoolsGroup',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	public function get_language_by_id($id, $language) {
		return $this->find('first', array(
			'conditions' => array(
				'SchoolsGroupsLanguage.group_id' => $id,
				'SchoolsGroupsLanguage.alias' => $language,
			),
			'fields' => array(
				'SchoolsGroupsLanguage.*'
			),
		));
	} 
}
