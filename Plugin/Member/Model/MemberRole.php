<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * MemberRole Model
 *
 * @property Member $Member
 * @property Role $Role
 */
class MemberRole extends MemberAppModel {

	public $actsAs = array('Containable');
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
		'Role' => array(
			'className' => 'Administration.Role',
			'foreignKey' => 'role_id',
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
		)
	);

	public function get_member_role() {
		return $this->find('all', array(
			'conditions' => array(
				'MemberRole.member_id'
			),
		));
	}

	// get member by role 
	public function get_list_members_by_school_id($school_id = array(), $language, $role = array()) {

		$conditions = array();
		if ($school_id) {
			if ($role) {

				$conditions = array(
					'OR' => array(
						// array(
						// 	'MemberRole.school_id' 	=> array(),
						// 	'MemberRole.role_id' 	=> $role,
						// ),
						// array(
						// 	'MemberRole.school_id' 	=> array(),
						// 	'MemberRole.role_id' 	=>  Environment::read('role.register'),
						// ),
						// array(
						// 	'MemberRole.school_id' 	=> $school_id,
						// 	'MemberRole.role_id' 	=> Environment::read('role.register'),
						// ),
						array(
							'MemberRole.school_id' 	=> $school_id,
							'MemberRole.role_id' 	=> $role
						),
					),
				);
				
			}  else {
				$conditions = array(
					'MemberRole.school_id' 	=> $school_id,
				);
			}

		} else {

			if ($role) {
				$conditions['OR'] = array(
					array('MemberRole.role_id' => $role),
					array('MemberRole.role_id' => Environment::read('role.register')), 			// get register role 
				);
			}
		}


		return $this->find('list', array(
			'fields' => array(
				'MemberLanguage.member_id',
				'MemberLanguage.name'
			),
			'conditions' => $conditions,
			'joins' => array(
				array(
					'table' => Environment::read('table_prefix') . 'member_languages', 
					'alias' => 'MemberLanguage',
					'type' => 'INNER',
					'conditions'=> array(
						'MemberLanguage.member_id = MemberRole.member_id',
						'MemberLanguage.alias' => $language,
					)
				),
			),
		));
	}

	public function check_exist_role($member_roles, $role) {

		foreach ($member_roles as $val) {
			if ($val['role_id'] == $role) {
				return true;
			}
		}

		return false;
	}
			
	public function check_exist($member_id, $role, $school_id) {
		$result = $this->find('count', array(
			'conditions' => array(
				'MemberRole.member_id' 	=> $member_id,
				'MemberRole.role_id' 	=> $role,
				'MemberRole.school_id' 	=> $school_id,
			),
			'fields' => array(
				'MemberRole.id',
			),
		));

		if ($result > 0) {
			return true;
		}
		return false;
	}

	public function get_obj($member_id, $role_id, $school_id) {

		return $this->find('first', array(
			'conditions' => array(
				'MemberRole.member_id' 	=> $member_id,
				'MemberRole.role_id' 	=> $role_id,
				'MemberRole.school_id' 	=> $school_id,
			),
			'fields' => array(
				'MemberRole.*',
			),
		));
	}

	public function get_member_id($role_id, $school_id) {

		return $this->find('all', array(
			'conditions' => array(
				'MemberRole.role_id' 	=> $role_id,
				'MemberRole.school_id' 	=> $school_id,
			),
			'fields' => array(
				'MemberRole.member_id',
			),
		));
	}

	public function clear_role_by_school($member_id, $role_id, $school_id) {

		$result = $this->deleteAll(
			array(
				'member_id' 	=> $member_id,
				'role_id' 		=> $role_id,
				'school_id' 	=> $school_id,
			), 
			false
		);

		if (!$result) {
			return false;
		}
		return true;
	}



	public function add($member_id, $role_id, $school_id) {

		$cond = array(
			'MemberRole.member_id' 				=> $member_id,
			'MemberRole.original_member_id'    	=> $member_id,
			'MemberRole.role_id'				=> $role_id,
			'MemberRole.school_id'				=> $school_id,
		);
		if (!$this->hasAny($cond)) {
			$data_MemberRole = array(
				'member_id' 			=> $member_id,
				'original_member_id'    => $member_id,
				'role_id'				=> $role_id,
				'school_id'				=> $school_id,
			);
			$this->save($data_MemberRole);
			$this->clear();
		}
	}

}
