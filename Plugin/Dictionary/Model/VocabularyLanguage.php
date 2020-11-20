<?php
App::uses('DictionaryAppModel', 'Dictionary.Model');
/**
 * VocabularyLanguage Model
 *
 * @property Vocabulary $Vocabulary
 */
class VocabularyLanguage extends DictionaryAppModel {

	// The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
	public $belongsTo = array(
		'Vocabulary' => array(
			'className' => 'Dictionary.Vocabulary',
			'foreignKey' => 'vocabulary_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
    );
}
