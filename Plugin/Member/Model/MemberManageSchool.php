<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * MemberManageSchool Model
 *
 * @property School $School
 * @property Member $Member
 */
class MemberManageSchool extends MemberAppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed
	public $actsAs = array('Containable');

	public function __construct($id = false, $table = null, $ds = null) {
		$parent = get_parent_class($this);
		$this->_mergeVars(array('belongsTo'), $parent);	// override belongto parent appmodel
	
		parent::__construct($id, $table, $ds);
	}
	
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'School' => array(
			'className' => 'School.School',
			'foreignKey' => 'school_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Member' => array(
			'className' => 'Member.Member',
			'foreignKey' => 'member_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Administration' => array(
			'className' => 'Administration.Administrator',
			'foreignKey' => 'administrator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function check_exist($member_id, $school_id, $administrator_id) {
		$result = $this->find('count', array(
			'conditions' => array(
				'MemberManageSchool.member_id' 			=> $member_id,
				'MemberManageSchool.school_id' 			=> $school_id,
				'MemberManageSchool.administrator_id' 	=> $administrator_id,
			),
			'fields' => array(
				'MemberManageSchool.id',
			),
		));

		if ($result > 0) {
			return true;
		}
		return false;
	}

	public function get_list_manage_school($member_id, $language) {
		$result = $this->find('all', array(
			'conditions' => array(
				'MemberManageSchool.member_id' 	=> $member_id,
			),
			'fields' => array(
				'MemberManageSchool.id',
			),
			'contain' => array(
				'School' => array(
					'SchoolLanguage' => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $language,	
						),
					),
					'SchoolImage',
				),
			),
		));

		return $result;
	}

	public function get_obj($id) {
		return $this->find('first', array(
			'conditions' => array(
				'MemberManageSchool.id' => $id,
			),
			'fields' => array(
				'MemberManageSchool.*',
			),
		));
	}

	public function get_obj_by_school_id($school_id) {
		return $this->find('all', array(
			'conditions' => array(
				'MemberManageSchool.school_id' => $school_id,
			),
			'fields' => array(
				'MemberManageSchool.*',
			),
			'contain' => array(
				'Member' => array(
					'fields' => array(
						'Member.email',
					),
				),
			),
		));
	}

	public function get_obj_by_cond($cond) {
		return $this->find('all', array(
			'conditions' => $cond,
			'fields' => array(
				'MemberManageSchool.*',
			),
		));
	}
}