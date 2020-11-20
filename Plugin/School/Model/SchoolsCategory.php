<?php
App::uses('SchoolAppModel', 'School.Model');
/**
 * SchoolsCategory Model
 *
 */
class SchoolsCategory extends SchoolAppModel {
	public $actsAs = array('Containable');
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'enabled' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public $hasMany = array(
		'SchoolsCategoriesLanguage' => array(
			'className' => 'School.SchoolsCategoriesLanguage',
			'foreignKey' => 'category_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SchoolsGroup' => array(
			'className' => 'School.SchoolsGroup',
			'foreignKey' => 'category_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function get_item($school_id, $search_text, $offset, $limit, $language) {

		$conditions = array(
			'SchoolsCategory.school_id' => $school_id,
			'SchoolsCategory.enabled' => true, 
		);
		if ($search_text) {
			$conditions['SchoolsCategoriesLanguage.name LIKE'] = '%' . $search_text . '%';
		}

		$content = $this->find('all', array(
			'conditions' => $conditions,
			'fields' => array(
				'SchoolsCategory.id',
				'SchoolsCategoriesLanguage.name',
			),
			'offset' => $offset,
			'limit'	=> $limit,
			'order'	=> array(
				'SchoolsCategory.id DESC',
			),
			'joins' => array(
                array(
                    'table' => Environment::read('table_prefix') . 'schools_categories_languages', 
                    'alias' => 'SchoolsCategoriesLanguage',
                    'type' => 'inner',
                    'conditions'=> array(
					   'SchoolsCategoriesLanguage.alias' =>  $language, 
					   'SchoolsCategoriesLanguage.category_id = SchoolsCategory.id',
                    )
                ),
            ),
		));

		$total = $this->find('count', array(
			'conditions' => $conditions,
			'fields' => array(
				'SchoolsCategory.id',
				'SchoolsCategoriesLanguage.name',
			),
			'order'	=> array(
				'SchoolsCategory.id DESC',
			),
			'joins' => array(
                array(
                    'table' => Environment::read('table_prefix') . 'schools_categories_languages', 
                    'alias' => 'SchoolsCategoriesLanguage',
                    'type' => 'inner',
                    'conditions'=> array(
					   'SchoolsCategoriesLanguage.alias' =>  $language, 
					   'SchoolsCategoriesLanguage.category_id = SchoolsCategory.id',
                    )
                ),
            ),
		));
	
		return array(
			'total' => $total,
			'content' => $content,
		);
	}


	public function add_item($school_id, $name, $member_id) {
		
		$data_SchoolsCategory = array(
			'school_id' 	=> $school_id,
		);
		if (!$model_SchoolsCategory = $this->save($data_SchoolsCategory, array('created_by' => $member_id))) {	// pass param to AppModel Before save
			return false;
		}

		/// add language
		$available_language = $this->get_lang_from_db();
		$data_SchoolsCategoriesLanguage = array();
		foreach ($available_language as $l) {
			$data_SchoolsCategoriesLanguage[] = array(
				'category_id' 			=> $model_SchoolsCategory['SchoolsCategory']['id'],
				'name' 					=> $name,
				'alias'					=> $l,
			);
		}

		if (!$this->SchoolsCategoriesLanguage->saveAll($data_SchoolsCategoriesLanguage)) {
			return array(
				'status' => false,
			);
		}

		return  array(
			'status' => true,
			'schools_category_id'	=> $model_SchoolsCategory['SchoolsCategory']['id'],
		);
		
	}

	public function edit_item($category_id, $name, $language, $member_id) {
		
		$data_SchoolsCategory = array(
			'id' 	=> $category_id,
		);
		if (!$this->save($data_SchoolsCategory, array('updated_by' => $member_id))) {	// pass param to AppModel Before save
			return false;
		}
		$result_SchoolsCategoriesLanguage =  $this->SchoolsCategoriesLanguage->get_language_by_id($category_id, $language);
		$data_SchoolsCategoriesLanguage = array(
			'id'				=> $result_SchoolsCategoriesLanguage['SchoolsCategoriesLanguage']['id'],
			'name' 				=> $name,
		);
		if (!$this->SchoolsCategoriesLanguage->save($data_SchoolsCategoriesLanguage)) {
			return false;
		}
		return true;
	}


}
