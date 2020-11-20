<?php
App::uses('CreditAppModel', 'Credit.Model');
/**
 * CreditTypeLanguage Model
 *
 * @property CreditType $CreditType
 */
class CreditTypeLanguage extends CreditAppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'CreditType' => array(
			'className' => 'Credit.CreditType',
			'foreignKey' => 'credit_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function get_obj($credit_type_id, $language) {
		return $this->find('first', array(
			'conditions' => array(
				'CreditTypeLanguage.alias' 			=> $language,
				'CreditTypeLanguage.credit_type_id' => $credit_type_id,
			),
			'fields' => array(
				'CreditTypeLanguage.*',
			),
		));
	}
}
