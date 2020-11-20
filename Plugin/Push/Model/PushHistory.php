<?php
App::uses('PushAppModel', 'Push.Model');
/**
 * PushHistory Model
 *
 * @property Push $Push
 * @property PushRule $PushRule
 */
class PushHistory extends PushAppModel {

	public $actsAs = array('Containable');
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
		),
		'PushRule' => array(
			'className' => 'Push.PushRule',
			'foreignKey' => 'push_rule_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
