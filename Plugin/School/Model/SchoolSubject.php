<?php
App::uses('SchoolAppModel', 'School.Model');
/**
 * SchoolSubject Model
 *
 * @property School $School
 */
class SchoolSubject extends SchoolAppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed
	public $actsAs = array('Containable');


	// Override belongto parent appmodel
	public function __construct($id = false, $table = null, $ds = null) {
		$parent = get_parent_class($this);
		$this->_mergeVars(array('belongsTo'), $parent);	// override belongto parent appmodel
	
		parent::__construct($id, $table, $ds);
	}
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
		)
	);

	public $hasMany = array(
		'SchoolSubjectLanguage' => array(
			'className' => 'School.SchoolSubjectLanguage',
			'foreignKey' => 'school_subject_id',
			'dependent' => false,
			'conditions' =>  '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

	public function get_list_subject_by_school_id($data) {
		$result = $this->find('list', array(
			'conditions' => array(
				'SchoolSubject.school_id' => $data['school_id'],
				'SchoolSubject.enabled' => true,
			),
			'fields' => array(
				'SchoolSubject.id',
				'SchoolSubjectLanguage.name',
			),
			'joins' => array(
                array(
					'alias' => 'SchoolSubjectLanguage',
                    'table' => Environment::read('table_prefix') . 'school_subject_languages', 
                    'type' => 'INNER',
                    'conditions'=> array(
						'SchoolSubjectLanguage.school_subject_id = SchoolSubject.id',
						'SchoolSubjectLanguage.alias' => $data['language'],
                    )
                ),
            ),
		));

		if (!$result) {
			return (object)array();
		}
		return $result;
	}
}
