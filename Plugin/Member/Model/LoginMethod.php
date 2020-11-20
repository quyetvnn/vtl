<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * LoginMethod Model
 *
 */
class LoginMethod extends MemberAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		
		'is_private' => array(
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

	public function get_school_code_id($school_code) {
		// JRGPS / s191001
		$result = $this->find('first', array(
			'fields' => array(
				'LoginMethod.id'
			),
			'conditions' => array(
				'LoginMethod.name' => strtoupper($school_code)
			),
		));

		return $result ? $result['LoginMethod']['id'] : array();
	}

	public function get_list_school_code_id() {
		$result = $this->find('list', array(
			'fields' => array(
				'LoginMethod.id',
				'LoginMethod.name'
			),
			'conditions' => array(
				'LoginMethod.is_private' => true,
			),
		));

		return $result;
	}

	public function get_obj($school_id) {
		$result = $this->find('list', array(
			'fields' => array(
				'LoginMethod.id',
				'LoginMethod.name'
			),
			'conditions' => array(
				'LoginMethod.id' => $school_id,
				'LoginMethod.is_private' => true,
			),
		));

		return $result;
	}

	public function get_id_by_name($name) {
		$result = $this->find('first', array(
			'fields' => array(
				'LoginMethod.id',
			),
			'conditions' => array(
				'LoginMethod.name' => $name,
			),
		));

		return $result ? $result['LoginMethod']['id'] : array();
	}

}
