<?php
App::uses('DictionaryAppModel', 'Dictionary.Model');
/**
 * ImageType Model
 *
 * @property BrandImage $BrandImage
 * @property ImageTypeLanguage $ImageTypeLanguage
 * @property MenuImage $MenuImage
 * @property PaymentMethodImage $PaymentMethodImage
 * @property PromotionImage $PromotionImage
 * @property ShopImage $ShopImage
 */
class ImageType extends DictionaryAppModel {

	// The Associations below have been created with all possible keys, those that are not needed can be removed
	public $actsAs = array('Containable');
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		
		'ImageTypeLanguage' => array(
			'className' => 'Dictionary.ImageTypeLanguage',
			'foreignKey' => 'image_type_id',
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
	);



	public $belongsTo = array(
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
	 * fung edit 2018年01月11日16:46:43
	 find（'list'）, if has multi language
	 */
	public function find_list($conditions = array(), $language = 'eng'){
		$data = array();

		$model = $this->name;

		$fields = array(
			$model.'.id', 'language.name', 'language.description'
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
                    'table' => Environment::read('table_prefix') . 'image_type_languages', 
                    'alias' => 'language',
                    'type' => 'INNER',
                    'conditions'=> array(
                        'ImageType.id = language.image_type_id',
                        'language.alias = \'' . $language . '\'',
                    )
                ),
            ),
			//'order' => array('language.name ASC')
			'order' => array($model.'.id ASC'),
			
		));

		if ($data) {
			$data = Hash::combine($data, '{n}.'.$model.'.id', array('%s (%s)', '{n}.language.name', '{n}.language.description'));
		}else{
			$data = array();
		}

		return $data;
	}

	public function find_id_by_condition($language = 'eng', $conditions = array()){
		$data = array();

		$fields = array(
			'ImageType.id', //'Language.name', 'Language.description',
		);

		$data = $this->find('first', array(
			'fields' => $fields,
			'conditions' => array_merge($conditions, array('ImageType.enabled' => true)),
			'joins' => array(
                array(
                    'table' => Environment::read('table_prefix') . 'image_type_languages', 
                    'alias' => 'Language',
                    'type' => 'INNER',
                    'conditions'=> array(
                        'ImageType.id = Language.image_type_id',
                        'Language.alias' => $language,
                    )
                ),
			),
           'order' => array('Language.name ASC')
		));
		
		return $data;
	}

    public function get_data_select($prefix_slug = ''){
        $model = $this->name;
        $fields = array(
            $model.'.id',
        );

        $conditions = array(
			$model.'.slug LIKE' => strtolower($prefix_slug) . '-%',
            $model.'.enabled' => 1,
        );

        $contain = array(
            'ImageTypeLanguage' => array(
                'fields' => array(
                    'ImageTypeLanguage.name',
                    'ImageTypeLanguage.description',
                ),
                'conditions' => array(
                    'ImageTypeLanguage.alias' => 'eng'
                ),
            ),
        );
        
        $data = $this->find('all', array(
            'fields' => $fields,
            'conditions' => $conditions,
            'contain' => $contain,
		));
		
        $result = array();
        if ($data) {
            foreach ($data as $value) {
                $result[$value[$model]["id"]] = isset($value["ImageTypeLanguage"]) ? reset($value["ImageTypeLanguage"])["description"] : '';
            }
        }

        return $result;
	}
	
	public function find_id_by_slug($slug) {
		return $this->find('first', array(
			'conditions' => array(
				'ImageType.slug' => $slug,
			),
			'fields' => array(
				'ImageType.id',
			),
		));
	}

	public function get_name_by_image_type_id($id) {
		$temp =  $this->find('first', array(
			'conditions' => array(
				'ImageType.id' => $id,
			),
			'contain' => array(
				'ImageTypeLanguage' => array(
					'fields' => array(
						'ImageTypeLanguage.name',
						'ImageTypeLanguage.description',
					),
				),
			),
		));

		if ($temp) {
			return reset($temp['ImageTypeLanguage'])['name'] . " " . reset($temp['ImageTypeLanguage'])['description'];
		}

	}
	

    
    public function get_data_export($conditions, $page, $limit, $lang){
        $all_settings = array(
            'conditions' => $conditions,
            'contain' => array(
                'ImageTypeLanguage' => array(
                    'fields' => array(
                        'ImageTypeLanguage.name',
                    ),
                    'conditions' => array(
                        'ImageTypeLanguage.alias' => $lang
                    ),
                ),
                'CreatedBy',
                'UpdatedBy',
            ), 
            'order' => array( 'ImageType.id' => 'desc' ),
            'limit' => $limit,
            'page' => $page
        );

        return $this->find('all', $all_settings);
    }

    public function format_data_export($data, $row){
        return array(
            !empty($row['ImageType']["id"]) ? $row['ImageType']["id"] : ' ',
            !empty($row['ImageType']["slug"]) ? $row['ImageType']["slug"] : ' ',
            isset($row['ImageTypeLanguage']) && reset($row['ImageTypeLanguage']) ? reset($row['ImageTypeLanguage'])["name"] : '',
            $row['ImageType']['enabled'] == 1 ? 'Y' : 'N',
            !empty($row['ImageType']["created"]) ? $row['ImageType']["created"] : ' ',
            !empty($row['CreatedBy']["email"]) ? $row['CreatedBy']["email"] : ' ',
            !empty($row['ImageType']["updated"]) ? $row['ImageType']["updated"] : ' ',
            !empty($row['UpdatedBy']["email"]) ? $row['UpdatedBy']["email"] : ' ',
        );
	}
	
	public function get_list_image_type_with_course_slug($data) {
		$all_settings = array(
            'conditions' => array(
				'ImageType.slug LIKE ' => 'course%',
			),
            'contain' => array(
                'ImageTypeLanguage' => array(
                    'fields' => array(
						'ImageTypeLanguage.name',
						'ImageTypeLanguage.description',
                    ),
                    'conditions' => array(
                        'ImageTypeLanguage.alias' => $data['language']
                    ),
                ),
            ), 
            'order' => array( 
				'ImageType.id ASC' 
			),
        );
		$temp = $this->find('all', $all_settings);

		$result = array();
		foreach ($temp as $t) {
			$result[] = array(
				'id' => $t['ImageType']['id'],
				'name' => reset($t['ImageTypeLanguage'])['name'] . "-" . reset($t['ImageTypeLanguage'])['description'],
			);
		}

		return $result;
	}






	public function get_id_by_slug($slug) {
		// display image type
		$result = $this->find('first', array(
			'conditions' => array(
				'ImageType.slug LIKE' => '%' .   $slug . '%',
			),
			'fields' => array(
				'ImageType.id',
			),
		));

		return $result ? $result['ImageType']['id'] : array();
	}
}
