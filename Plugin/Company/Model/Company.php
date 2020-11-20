<?php
App::uses('CompanyAppModel', 'Company.Model');
/**
 * Company Model
 *
 * @property Administrator $Administrator
 * @property Brand $Brand
 * @property CompanyLanguage $CompanyLanguage
 * @property PointScheme $PointScheme
 * @property Push $Push
 * @property Tier $Tier
 */
class Company extends CompanyAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'contact_person' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'contact_phone' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

    public $actsAs = array('Containable');

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Administrator' => array(
			'className' => 'Administration.Administrator',
			'foreignKey' => 'company_id',
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
		'CompanyLanguage' => array(
			'className' => 'Company.CompanyLanguage',
			'foreignKey' => 'company_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Push' => array(
			'className' => 'Push.Push',
			'foreignKey' => 'company_id',
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

/**
 * find('list') by language
 */
	public function get_company_list($where = array(), $language = 'eng'){

		$data = array();

		$fields = array(
			'Company.id',
		);
		$conditions = array(
			'Company.enabled' => true,
		);
		if (!empty($where)) {
			$conditions = array_merge($conditions,$where);
		}
		$contain = array(
			'CompanyLanguage' => array(
				'fields' => array(
					'CompanyLanguage.name',
				),
				'conditions' => array(
					'CompanyLanguage.alias' => $language
				),
			),
		);

		$data = $this->find('all',array(
			'fields' => $fields,
			'conditions' => $conditions,
			'contain' => $contain,
		));

		if ($data) {
			$data = Hash::combine($data, '{n}.Company.id', '{n}.CompanyLanguage.0.name');
		}else{
			$data = array();
		}

		return $data;
	}
}
