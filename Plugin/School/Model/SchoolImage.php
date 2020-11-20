<?php
App::uses('SchoolAppModel', 'School.Model');
/**
 * SchoolImage Model
 *
 */
class SchoolImage extends SchoolAppModel {
	


    public $belongsTo = array(
		'School' => array(
			'className' => 'School.School',
			'foreignKey' => 'school_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ImageType' => array(
			'className' => 'Dictionary.ImageType',
			'foreignKey' => 'image_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	public function get_obj($school_id) {
		return $this->find('all', array(
			'conditions' => array(
				'SchoolImage.school_id' => $school_id
			),
			'fileds' => array(
				'SchoolImage.*'
			),
		));
	}

}
