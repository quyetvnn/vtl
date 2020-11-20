<?php
App::uses('SchoolAppModel', 'School.Model');
/**
 * SchoolClass Model
 *
 * @property School $School
 */
class SchoolClass extends SchoolAppModel {


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

	// get full list school class with school id
	public function get_list_school_class($school_id = array()){

		$conditions = array();
		if ($school_id) {
			$conditions = array(
				'SchoolClass.school_id' => $school_id,
			);
		}
		
		$result = $this->find('list', array(
			'fields' => array(
				'SchoolClass.id',
				'SchoolClass.name',
			),
			'conditions' => array_merge($conditions, array(
				'SchoolClass.enabled' => true
			)),
		));

		if (!$result) {
			return (object)array();
		}
		return $result;
		
	}

	public function get_name($school_id, $list_class){
		
		$result = $this->find('list', array(
			'fields' => array(
				'SchoolClass.id',
				'SchoolClass.name',
			),
			'conditions' => array(
				'SchoolClass.school_id' => $school_id,
				'SchoolClass.id' => $list_class,
			),
		));

		if (!$result) {
			return (object)array();
		}
		return $result;
		
	}


	public function get_list_class_by_school_id($school_id) {
		$conditions = array();
		if ($school_id) {
			$conditions = array(
				'SchoolClass.school_id' => $school_id,
			);
		}
		
		$result = $this->find('list', array(
			'fields' => array(
				'SchoolClass.id',
				'SchoolClass.name',
			),
			'conditions' => array_merge($conditions, array(
				'SchoolClass.enabled' => true
			)),
		));

		if (!$result) {
			return (object)array();
		}
		return $result;
	}

	public function get_obj($id) {
		return $this->find('first', array(
			'fields' => array(
				'SchoolClass.*',
			),
			'conditions' => array(
				'SchoolClass.id' => $id,
			),
		));
	}

	public function get_list_class_by_school_id_not_include_myself($school_id, $class_id) {
		$conditions = array(
			'SchoolClass.school_id' 			=> $school_id,
			'SchoolClass.id <>' 	=> $class_id,
		);

		$result = $this->find('list', array(
			'fields' => array(
				'SchoolClass.id',
				'SchoolClass.name',
			),
			'conditions' => array_merge($conditions, array(
				'SchoolClass.enabled' => true
			)),
		));

		if (!$result) {
			return (object)array();
		}
		return $result;
	}
}
