<?php
App::uses('schoolAppModel', 'school.Model');
/**
 * SchoolSubjectLanguage Model
 *
 * @property SchoolSubject $SchoolSubject
 */
class SchoolSubjectLanguage extends schoolAppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'SchoolSubject' => array(
			'className' => 'School.SchoolSubject',
			'foreignKey' => 'school_subject_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
}
