<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * MembersGroup Model
 *
 * @property Member $Member
 * @property School $School
 * @property Role $Role
 * @property Group $Group
 */
class MembersGroup extends MemberAppModel {

	public $actsAs = array('Containable');
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'updated_by' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
		'Member' => array(
			'className' => 'Member.Member',
			'foreignKey' => 'member_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'School' => array(
			'className' => 'School.School',
			'foreignKey' => 'school_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Role' => array(
			'className' => 'Administration.Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SchoolsGroup' => array(
			'className' => 'School.SchoolsGroup',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function get_item_by_group_id($group_id) {
		$result_MembersGroup =  $this->find('all', array(
			'conditions' => array(
				'MembersGroup.group_id' => $group_id,
			),
			'fields' => array(
				'MembersGroup.*'
			),
		));

		$teachers = $students = array();
		
		foreach ($result_MembersGroup as $val) {
			if ($val['MembersGroup']['role_id'] == Environment::read('role.teacher')) {
				$teachers[] = $val['MembersGroup']['member_id'];
			
			} elseif ($val['MembersGroup']['role_id'] == Environment::read('role.student')) {
				$students[] = $val['MembersGroup']['member_id'];
			}
		}

		return array(
			'teachers' => $teachers,
			'students' => $students,
		);
	}
	
	public function get_member($school_id, $group_id, $language) {
		return $this->find('list', array(
			'conditions' => array(
				'MembersGroup.school_id'	=> $school_id,
				'MembersGroup.group_id' 	=> $group_id,
			),
			'fields' => array(
				'MembersGroup.member_id',
				'MemberLanguage.name'
			),
			'joins' => array(
				array(
					'table' => Environment::read('table_prefix') . 'member_languages', 
					'alias' => 'MemberLanguage',
					'type' => 'INNER',
					'conditions'=> array(
						'MemberLanguage.member_id = MembersGroup.member_id',
						'MemberLanguage.alias' => $language,
					)
				),
			),
		));
	}

	public function add_member($member_id, $school_id, $role_id, $group_id) {
		
		$data = array(
			'member_id' 	=> $member_id,
			'school_id' 	=> $school_id,
			'role_id' 		=> $role_id,
			'group_id' 		=> $group_id,
		);

		if (!$this->save($data, array('created_by' => $member_id))) {
			return false;
		}
		return true;
	}

	public function remove_member($member_id, $school_id, $role_id, $group_id) {

		$result = $this->deleteAll(
			array(
				'member_id' 	=> $member_id,
				'school_id' 	=> $school_id,
				'role_id' 		=> $role_id,
				'group_id' 		=> $group_id,
			), 
			false
		);

		if (!$result) {
			return false;
		}
		return true;
	}

	public function get_obj_with_conditions($conditions) {
		return $this->find('first', array(
			'conditions' => $conditions,
			'fields' => 'MembersGroup.*',
		));
	}

	public function add($member_id,  $role_id, $school_id, $group_id) {
		$cond = array(
			'MembersGroup.member_id' 		=> $member_id,
			'MembersGroup.school_id'		=> $school_id,
			'MembersGroup.group_id'			=> $group_id,
			'MembersGroup.role_id'			=> $role_id,
		);
		if (!$this->hasAny($cond)) {
			$data_MembersGroup = array(
				'member_id' 		=> $member_id,
				'school_id'			=> $school_id,
				'group_id'			=> $group_id,
				'role_id'			=> $role_id,
			);
			$this->save($data_MembersGroup);
			$this->clear();
		}
	}
}
