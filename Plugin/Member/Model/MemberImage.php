<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * MemberImage Model
 *
 * @property Member $Member
 * @property ImageType $ImageType
 */
class MemberImage extends MemberAppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Member' => array(
			'className' => 'Member.Member',
			'foreignKey' => 'member_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ImageType' => array(
			'className' => 'Image.ImageType',
			'foreignKey' => 'image_type_id',
			'conditions' => array(
				'ImageType.enabled' => true,
			),
			'fields' => '',
			'order' => ''
		)
	);


	public function get_id_from_image_type_id_member_id ($image_type_id, $member_id) {
		return $this->find('first', array(
			'conditions' => array(
				'MemberImage.member_id' 	=> $member_id,	//
				'MemberImage.image_type_id' => $image_type_id, //
			),
			'fields' => array(
				'MemberImage.id'
			),
		));
	}
}
