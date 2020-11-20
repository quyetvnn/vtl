<?php
App::uses('SchoolAppModel', 'School.Model');
/**
 * SchoolsCategoriesLanguage Model
 *
 * @property Category $Category
 */
class SchoolsCategoriesLanguage extends SchoolAppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'SchoolsCategory' => array(
			'className' => 'School.SchoolsCategory',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function get_language_by_id($id, $language) {
		return $this->find('first', array(
			'conditions' => array(
				'SchoolsCategoriesLanguage.category_id' => $id,
				'SchoolsCategoriesLanguage.alias' => $language,
			),
			'fields' => array(
				'SchoolsCategoriesLanguage.*'
			),
		));
	} 
}
