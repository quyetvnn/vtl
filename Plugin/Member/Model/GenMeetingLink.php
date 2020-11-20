<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * GenMeetingLink Model
 *
 */
class GenMeetingLink extends MemberAppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
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

	public function get_obj() {
		return $this->find('first', array(
			'conditions' => array(
				'GenMeetingLink.enabled' => true, 
			),
			'order' => array(
				'GenMeetingLink.id',
			),
			'fields' => array(
				'GenMeetingLink.*',
			),
		));
	}
}
