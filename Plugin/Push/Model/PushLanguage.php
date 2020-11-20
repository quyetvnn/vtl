<?php
App::uses('PushAppModel', 'Push.Model');
/**
 * PushLanguage Model
 *
 * @property Push $Push
 */
class PushLanguage extends PushAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		
		'alias' => array(
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

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Push' => array(
			'className' => 'Push.Push',
			'foreignKey' => 'push_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function get_list($push_id, $language = 'zho') {
		return $this->find('first', array(
			'conditions' => array(
				'PushLanguage.alias' => $language,
				'PushLanguage.push_id' => $push_id
			),
		));
	}
}
