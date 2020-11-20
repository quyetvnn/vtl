<?php
App::uses('DictionaryAppModel', 'Dictionary.Model');
/**
 * Vocabulary Model
 *
 * @property Vocabulary $ParentVocabulary
 * @property Vocabulary $ChildVocabulary
 * @property VocabularyLanguage $VocabularyLanguage
 */
class Vocabulary extends DictionaryAppModel {

	public $actsAs = array('Containable');

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ParentVocabulary' => array(
			'className' => 'Dictionary.Vocabulary',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CreatedBy' => array(
			'className' => 'Administration.Administrator',
			'foreignKey' => 'created_by',
			'conditions' => '',
			'fields' => array('email','name'),
			'order' => ''
		),
		'UpdatedBy' => array(
			'className' => 'Administration.Administrator',
			'foreignKey' => 'updated_by',
			'conditions' => '',
			'fields' => array('email','name'),
			'order' => ''
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ChildVocabulary' => array(
			'className' => 'Dictionary.Vocabulary',
			'foreignKey' => 'parent_id',
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
		'VocabularyLanguage' => array(
			'className' => 'Dictionary.VocabularyLanguage',
			'foreignKey' => 'vocabulary_id',
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


    /**
     * Coupon Available Type
     * coupon-available-xxxx
     */
	public function available_type_list($language = 'eng', $is_get_slug = false){
		$data = array();

		$fields = array(
			'Vocabulary.id', 'Vocabulary.slug', 'language.name'
		);

		$conditions = array(
			'Vocabulary.enabled' => true,
			'Vocabulary.slug like' => '%coupon-available-%',
		);
        
		$data = $this->find('all', array(
			'fields' => $fields,
			'conditions' => $conditions,
			'recursive' => -1,
			'joins' => array(
                array(
                    'table' => Environment::read('table_prefix') . 'vocabulary_languages', 
                    'alias' => 'language',
                    'type' => 'inner',
                    'conditions'=> array(
                        'Vocabulary.id = language.vocabulary_id',
                        'language.alias = \'' . $language . '\'',
                    )
                ),
            ),
            'order' => array('language.name ASC')
        ));

        $result = array();
        if ($data) {
            if($is_get_slug){
                foreach($data as $item){
                    $result[] = array(
                        'id' => $item['Vocabulary']['id'],
                        'slug' => $item['Vocabulary']['slug'],
                        'name' => $item['language']["name"],
                    );
                }
            }else{
			    $data = Hash::combine($data, '{n}.Vocabulary.id', '{n}.language.name');
            }
		}

		return $result;
	}

    /**
     * find list
     **/
	public function find_list($model, $conditions = array(), $language = 'eng', $is_get_slug = false){
		$data = array();
		$fields = array(
			$model.'.id', $model.'.slug',  'language.name'
		);

		if (isset($conditions) && !empty($conditions)) {
			$conditions = array_merge($conditions, array($model.'.enabled' => true));
		}else{
			$conditions = array(
				$model.'.enabled' => true,
			);
		}

		$data = $this->find('all', array(
			'fields' => $fields,
            'conditions' => $conditions,
            'recursive' => -1,
			'joins' => array(
                array(
                    'table' => Environment::read('table_prefix') . 'vocabulary_languages', 
                    'alias' => 'language',
                    'type' => 'inner',
                    'conditions'=> array(
                        $model . '.id = language.vocabulary_id',
                        'language.alias = \'' . $language . '\'',
                    )
                ),
            ),
            'order' => array('language.name ASC')
        ));

        $result = array();
		if ($data) {
            if($is_get_slug){
                foreach($data as $item){
                    $result[] = array(
                        'id' => $item[$model]['id'],
                        'slug' => $item[$model]['slug'],
                        'name' => $item['language']["name"],
                    );
                }
            }else{
                $result = Hash::combine($data, '{n}.' . $model . '.id', '{n}.language.name');
            }
        }
        
		return $result;
	}

	public function get_names_by_ids($ids, $language = 'zho') {

		$vocabularies = $this->find('list', array(
            'fields' => array('language.name'),
			'conditions' => array('Vocabulary.id' => $ids),
			'recursive' => -1,
			'joins' => array(
                array(
                    'table' => Environment::read('table_prefix') . 'vocabulary_languages', 
                    'alias' => 'language',
                    'type' => 'inner',
                    'conditions'=> array(
                        'Vocabulary.id = language.vocabulary_id',
                        'language.alias = \'' . $language . '\'',
                    )
                ),
            ),
        ));

        $result = "";
		if ($vocabularies) {
            $result = implode(', ', $vocabularies);
		}

		return $result;
	}

    public function get_list($language = 'eng', $slug=''){
		$fields = array(
			'Vocabulary.id',
			'Vocabulary.parent_id',
		);

		$conditions = array(
			'Vocabulary.slug LIKE' => $slug."%",
			'Vocabulary.enabled' => 1,
		);

		$contain = array(
			'VocabularyLanguage' => array(
				'fields' => array(
					'VocabularyLanguage.name',
					'VocabularyLanguage.description'
				),
				'conditions' => array(
					'VocabularyLanguage.alias' => $language
				),
			)
		);

		$data = $this->find('all',array(
			'fields' => $fields,
			'conditions' => $conditions,
			'contain' => $contain,
			'recursive' => -1
		));

		$result = array();
		if ($data) {
            foreach($data as $vocabulary){
                $item = $vocabulary['Vocabulary'];
                if(reset($vocabulary['VocabularyLanguage'])){
                    $item = array_merge($item, reset($vocabulary['VocabularyLanguage']));
                }
                $result[] = $item;
            }

			if ($slug == "district") {
				$category = array();
            	foreach ($result as $key => $value) {
            		if ($value['parent_id'] == "") {
            			$value['child'] = array();
            			array_push($category, $value);
            		}
            	}

            	foreach ($result as $key => $value) {
            		if ($value['parent_id'] != "") {
            			for ($i=0;$i<count($category);$i++) {
            				if ($category[$i]['id'] == $value['parent_id']) {
            					array_push($category[$i]['child'], $value);
            				}
            			}
            		}
            	}

            	$result = $category;
			}
		}
		
		return $result;
	}

	
    /**
     * Thong add funcion to get id by slug
     */
    public function get_id_by_slug($slug) {
        $vocabulary = $this->find('first', array(
            'fields' => array('Vocabulary.id'),
            'conditions' => array(
                'Vocabulary.slug' => $slug,
                'Vocabulary.enabled' => true
            ),
            'recursive' => -1,
		));
		
        if ($vocabulary) {
            return (int)$vocabulary['Vocabulary']['id'];
        } else {
            return 0;
        }
	}

	public function get_full_district_region_list($language = 'eng', $is_region, $condition = array()) {		// show on combobox

		if ($is_region) {
			$condition['Vocabulary.parent_id'] =  null;

		} else {
			$condition['Vocabulary.parent_id <>'] =  null;
		}

		return $this->find('list', array(
            'fields' => array('language.name'),
			'recursive' => -1,
			'joins' => array(
                array(
                    'table' => Environment::read('table_prefix') . 'vocabulary_languages', 
                    'alias' => 'language',
                    'type' => 'inner',
                    'conditions'=> array_merge($condition, array(
                        'Vocabulary.id = language.vocabulary_id',
						'language.alias = \'' . $language . '\'',
						'Vocabulary.slug LIKE' => 'district%',
					)),
                ),
            ),
		));
	}
}