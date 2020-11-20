<?php
App::uses('DictionaryAppModel', 'Dictionary.Model');
/**
 * Currency Model
 *
 * @property CurrencyLanguage $CurrencyLanguage
 * @property Shop $Shop
 */
class Currency extends DictionaryAppModel {
	// The Associations below have been created with all possible keys, those that are not needed can be removed
	public $actsAs = array('Containable');
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CurrencyLanguage' => array(
			'className' => 'Dictionary.CurrencyLanguage',
			'foreignKey' => 'currency_id',
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
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Shop' => array(
			'className' => 'Company.Shop',
			'joinTable' => 'shops_currencies',
			'foreignKey' => 'currency_id',
			'associationForeignKey' => 'shop_detail_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

	/**
	 * fung edit 2018年01月11日16:46:43
	 * find（'list'）, if has multi language
	 * */
	public function find_list($conditions = array() ,$language = 'eng'){
		$data = array();

		$model = $this->name;

		$fields = array(
			$model.'.id','language.name'
		);

		$conditions[$model.'.enabled'] = true;

		$data = $this->find('all', array(
			'fields' => $fields,
			'conditions' => $conditions,
			'recursive' => -1,
			'joins' => array(
                array(
                    'table' => Environment::read('table_prefix') . 'currency_languages', 
                    'alias' => 'language',
                    'type' => 'inner',
                    'conditions'=> array(
                        $model.'.id = language.currency_id',
                        'language.alias = \'' . $language . '\'',
                    )
                ),
            ),
            'order' => array('language.name ASC')
        ));
        
		if ($data) {
			$data = Hash::combine($data, '{n}.'.$model.'.id', '{n}.language.name');
		}else{
			$data = array();
		}

		return $data;
	}
}
