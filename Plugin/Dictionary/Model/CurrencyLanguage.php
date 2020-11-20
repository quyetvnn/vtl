<?php
App::uses('DictionaryAppModel', 'Dictionary.Model');
/**
 * CurrencyLanguage Model
 *
 * @property Currency $Currency
 */
class CurrencyLanguage extends DictionaryAppModel {

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Currency' => array(
			'className' => 'Dictionary.Currency',
			'foreignKey' => 'currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
