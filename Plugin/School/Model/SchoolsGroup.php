<?php
App::uses('SchoolAppModel', 'School.Model');
/**
 * SchoolsGroup Model
 *
 * @property School $School
 */
class SchoolsGroup extends SchoolAppModel {

	public $actsAs = array('Containable');
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'enabled' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

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

	public $hasMany = array(
		'SchoolsGroupsLanguage' => array(
			'className' => 'School.SchoolsGroupsLanguage',
			'foreignKey' => 'group_id',
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


	public function get_item($category_id, $search_text, $offset, $limit, $language) {
		$conditions = array(
			'SchoolsGroup.category_id' => $category_id,
			'SchoolsGroup.enabled' => true, 
		);
		if ($search_text) {
			$conditions['SchoolsGroupsLanguage.name LIKE'] = '%' . $search_text . '%';
		}

		$content = $this->find('all', array(
			'conditions' => $conditions,
			'fields' => array(
				'SchoolsGroup.id',
				'SchoolsGroupsLanguage.name',
			),
			'offset' => $offset,
			'limit'	=> $limit,
			'order'	=> array(
				'SchoolsGroup.id DESC',
			),
			'joins' => array(
                array(
                    'table' => Environment::read('table_prefix') . 'schools_groups_languages', 
                    'alias' => 'SchoolsGroupsLanguage',
                    'type' => 'INNER',
                    'conditions'=> array(
					   'SchoolsGroupsLanguage.alias' =>  $language, 
					   'SchoolsGroupsLanguage.group_id = SchoolsGroup.id',
                    )
                ),
			),
		));

		$total = $this->find('count', array(
			'conditions' => $conditions,
			'fields' => array(
				'SchoolsGroup.id',
				'SchoolsGroupsLanguage.name',
			),
			'order'	=> array(
				'SchoolsGroup.id DESC',
			),
			'joins' => array(
                array(
                    'table' => Environment::read('table_prefix') . 'schools_groups_languages', 
                    'alias' => 'SchoolsGroupsLanguage',
                    'type' => 'INNER',
                    'conditions'=> array(
					   'SchoolsGroupsLanguage.alias' =>  $language, 
					   'SchoolsGroupsLanguage.group_id = SchoolsGroup.id',
                    )
                ),
			),
		));

		return array(
			'total' => $total,
			'content' => $content,
		);
	}

	public function add_item($category_id, $name, $member_id) {
		
		$data_SchoolsGroup = array(
			'category_id' 	=> $category_id,
		);
		if (!$model_SchoolsGroup = $this->save($data_SchoolsGroup, array('created_by' => $member_id))) {	// pass param to AppModel Before save
			return false;
		}

		// add language
		$available_language = $this->get_lang_from_db();
		$data_SchoolsGroupsLanguage = array();
		foreach ($available_language as $v) {
			$data_SchoolsGroupsLanguage[] = array(
				'group_id' 			=> $model_SchoolsGroup['SchoolsGroup']['id'],
				'name' 				=> $name,
				'alias'				=> $v,
			);
		}
		if (!$this->SchoolsGroupsLanguage->saveAll($data_SchoolsGroupsLanguage)) {
			return false;
		}

		return true;
	}

	public function edit_item($group_id, $name, $language, $member_id) {
		
		$data = array(
			'id'			=> $group_id, 
		);
		if (!$this->save($data, array('updated_by' => $member_id))) {	// pass param to AppModel Before save
			return false;
		}

		$result_SchoolsGroupsLanguage =  $this->SchoolsGroupsLanguage->get_language_by_id($group_id, $language);
		$data_SchoolsGroupsLanguage = array(
			'id'				=> $result_SchoolsGroupsLanguage['SchoolsGroupsLanguage']['id'],
			'name' 				=> $name,
		);
		if (!$this->SchoolsGroupsLanguage->save($data_SchoolsGroupsLanguage)) {
			return false;
		}
		return true;
	}

}
