<?php
App::uses('SchoolAppModel', 'School.Model');
/**
 * SchoolLanguage Model
 *
 */
class SchoolLanguage extends SchoolAppModel {


    public $belongsTo = array(
		'School' => array(
			'className' => 'School.School',
			'foreignKey' => 'school_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	public function get_all_language_by_school_id($id) {
		return $this->find('all', array(
			'conditions' => array(
				'SchoolLanguage.school_id' => $id,
			),
			'fields' => array(
				'SchoolLanguage.*'
			),
		));
	} 

	public function get_language_by_school_id($id, $language) {
		return $this->find('first', array(
			'conditions' => array(
				'SchoolLanguage.school_id' => $id,
				'SchoolLanguage.alias' => $language,
			),
			'fields' => array(
				'SchoolLanguage.*'
			),
		));
	} 

}
