<?php
App::uses('DictionaryAppModel', 'Dictionary.Model');
/**
 * ImageTypeLanguage Model
 *
 * @property ImageType $ImageType
 */
class ImageTypeLanguage extends DictionaryAppModel {
	
	// The Associations below have been created with all possible keys, those that are not needed can be removed

	
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ImageType' => array(
			'className' => 'Dictionary.ImageType',
			'foreignKey' => 'image_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
