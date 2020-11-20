<?php
App::uses('CreditAppModel', 'Credit.Model');
/**
 * CreditType Model
 *
 * @property CreditTypeLanguage $CreditTypeLanguage
 * @property MembersCredit $MembersCredit
 */
class CreditType extends CreditAppModel {


	public $actsAs = array('Containable');
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'is_add_point' => array(
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
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CreditTypeLanguage' => array(
			'className' => 'Credit.CreditTypeLanguage',
			'foreignKey' => 'credit_type_id',
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
		'MembersCredit' => array(
			'className' => 'Member.MembersCredit',
			'foreignKey' => 'credit_type_id',
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


	public function get_id_by_slug($slug) {
		$result = $this->find('first', array(
			'conditions' => array(
				'CreditType.slug' => $slug,
			),
			'fields' => array(
				'CreditType.id'
			),
		));

		return $result ? $result['CreditType']['id'] : array();
	}

	public function get_full_list($language) {
		$result = $this->find('list', array(
			'joins' => array(
                array(
                    'alias' => 'CreditTypeLanguage',
                    'table' => Environment::read('table_prefix') . 'credit_type_languages',
                    'type' => 'INNER',
                    'conditions' => array(
						'CreditTypeLanguage.credit_type_id = CreditType.id',
						'CreditTypeLanguage.alias' => $language,
                    ),
                ),
            ),
 			'fields' => array(
				'CreditType.id',
				'CreditTypeLanguage.name'
			),
		));

		return $result;
	}

	public function get_all() {
		$result = $this->find('all', array(
 			'fields' => array(
				'CreditType.*',
			),
		));

		return $result;
	}

}
