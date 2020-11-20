<?php
App::uses('DictionaryAppModel', 'Dictionary.Model');
/**
 * Language Model
 *
 */
class Language extends DictionaryAppModel {
	public $actsAs = array('Containable');
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
		'is_default' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
 
	public $belongsTo = array(
		// 'CreatedBy' => array(
		// 	'className' => 'Administration.Administrator',
		// 	'foreignKey' => 'created_by',
		// 	'conditions' => '',
		// 	'fields' => array('email','name'),
		// 	'order' => ''
		// ),
		// 'UpdatedBy' => array(
		// 	'className' => 'Administration.Administrator',
		// 	'foreignKey' => 'updated_by',
		// 	'conditions' => '',
		// 	'fields' => array('email','name'),
		// 	'order' => ''
		// ),
    );
    
    public function get_languages(){
		$languages = $this->find('all',array(
			'fields' => array(
				'Language.id',
				'Language.alias',
				'Language.name',
				'Language.is_default',
			),
			'conditions' => array( 'Language.enabled' => true, ),
		));
		if ($languages) {
			$languages = Hash::extract($languages, '{n}.Language');
		}

		return $languages;
	}
}
