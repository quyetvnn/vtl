<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * Member Model
 *
 * @property MemberLangugage $MemberLangugage
 * @property MemberLoginMethod $MemberLoginMethod
 * @property MemberRole $MemberRole
 */
class Member extends MemberAppModel {

	public $actsAs = array('Containable');
	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'MemberManageSchool' => array(
			'className' => 'Member.MemberManageSchool',
			'foreignKey' => 'member_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'MemberImage' => array(
			'className' => 'Member.MemberImage',
			'foreignKey' => 'member_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'MemberLanguage' => array(
			'className' => 'Member.MemberLanguage',
			'foreignKey' => 'member_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'MemberLoginMethod' => array(
			'className' => 'Member.MemberLoginMethod',
			'foreignKey' => 'member_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'MemberRole' => array(
			'className' => 'Member.MemberRole',
			'foreignKey' => 'member_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


	public function get_member_info($email, $phone_number) {
		return $this->find('first', array(
			'fields' => array(
				'Member.*',
			),
			'conditions' => array(
				'OR' => array(
					'Member.email' 			=> $email,
					'Member.phone_number' 	=> $phone_number,
				),
			),
		));
	}

	public function get_member_school_by_id($member_id, $school_id, $language) {
		return $this->find('first', array(
			'fields' => array(
				'Member.*',
			),
			'conditions' => array(
				'Member.id' 		=> $member_id,
			),
			'contain' => array(
				'MemberRole' => array(
					'conditions' => array(
						'MemberRole.school_id' 		=> $school_id,
					),
					'Role' => array(
						'RoleLanguage' => array(
							'fields' => array(
								'RoleLanguage.name',
							),
							'conditions' => array(
								'RoleLanguage.alias' => $language,
							),
						),
					),
				),
				'MemberLanguage' => array(
					'conditions' => array(
						'MemberLanguage.alias' => $language,
					)
				),
				'MemberImage' => array(
					'conditions' => array(
						'MemberImage.image_type_id' => 2,
					)
				)
			)
		));
	}


	public function get_register_code($username, $school_id) {

		$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
		$result_MemberLoginMethod = $obj_MemberLoginMethod->find('first', array(
			'conditions' => array(
				'MemberLoginMethod.username' 	=> $username,
				'MemberLoginMethod.school_id' 	=> $school_id
			),
			'fields' => array(
				'MemberLoginMethod.member_id',
			),
		));

		if (!$result_MemberLoginMethod) {
			$temp = array(
				'status' => 999,	
				'message' => __('retrieve_data_not_successfully') . $username . "!",
			);
			goto load_data;
		}

		$result_Member =  $this->find('first', array(
			'conditions' => array(
				'Member.id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
			),
			'fields' => array(
				'Member.id',
				'Member.email',
			),
		));

		if (!$result_Member) {
			$temp = array(
				'status' => 999,	
				'message' => __('retrieve_data_not_successfully') . $username,
			);
			goto load_data;
		}

		$db = $this->getDataSource();
		$db->begin();

		// save Member
		$register_code = $this->gen_random_number(4);
		$data_Member = array(
			'id'			=> $result_Member['Member']['id'],
			'register_code'	=> $register_code,	
		);

		if (!$this->save($data_Member)) {
			$db->rollback();
			$temp = array(
				'status' => 999,	
				'message' => __('data_is_not_saved') . " Member",
			);
			goto load_data;
		}

		$db->commit();
		$temp = array(
			'status' 			=> 200,	
			'message' 			=> __('retrieve_data_successfully'),
			'register_code' 	=> $register_code,
			'email'			 	=> $result_Member['Member']['email']
		);

		load_data:
		return $temp;
	}
	

	public function get_full_list($language) {
		return $this->find('list', array(
			'fields' => array(
				'Member.id',
				'MemberLanguage.name',
			),
			'joins' => array(
                array(
                    'alias' => 'MemberLanguage',
                    'table' => Environment::read('table_prefix') . 'member_languages',
                    'type' => 'INNER',
                    'conditions' => array(
						'Member.id = MemberLanguage.member_id',
						'MemberLanguage.alias' => $language,
                    ),
                ),
            ),
			'order' => array(
				'Member.id DESC',
			),
		));
	}


	public function get_obj($id) {
		return $this->find('first', array(
			'conditions' => array(
				'Member.id' => $id,
			),
			'fields' => array(
				'Member.*'
			),
		));
	}

	public function get_list_member($school_id = array()) {

		if ($school_id) {
			$result = $this->find('list', array(
				'fields' => array(
					'Member.id',
					'MemberLoginMethod.username'
				),
				'joins' => array(
					array(
						'alias' => 'MemberLoginMethod',
						'table' => Environment::read('table_prefix') . 'member_login_methods',
						'type' => 'INNER',
						'conditions' => array(
							'MemberLoginMethod.member_id = Member.id',
							'MemberLoginMethod.school_id' => $school_id,
						),
					),
				),
			));

			$result = array_unique($result);

		} else {
			$result = $this->find('list', array(
				'fields' => array(
					'Member.id',
					'MemberLoginMethod.username',
				),
				'joins' => array(
					array(
						'alias' => 'MemberLoginMethod',
						'table' => Environment::read('table_prefix') . 'member_login_methods',
						'type' => 'INNER',
						'conditions' => array(
							'MemberLoginMethod.member_id = Member.id',
							'MemberLoginMethod.school_id' => Environment::read('self_register'),
						),
					),
				),
			));

		}

		return $result;
	}

	public function get_obj_with_conditions($conditions) {
		return $this->find('first', array(
			'conditions' => $conditions,
			'fields' => array(
				'Member.*',
			),
		));
	}

	public function add($email, $phone_number) {

		$cond = array();
		if ($email && $phone_number) {
			$cond = array(
				'Member.email' 			=> $email,
				'Member.phone_number' 	=> $phone_number,
			);

		}  elseif ($email) {
			$cond = array(
				'Member.email' => $email,
			);
			
		} elseif ($phone_number) {
			$cond = array(
				'Member.phone_number' => $phone_number,
			);
		} 

		$model = array();
		if (!$email && !$phone_number) {	// no need check
			$data_Member = array(
				'verified' 		=> true,
				'email'     	=> $email,
				'phone_number' 	=> $phone_number,
			);
			if ($model = $this->save($data_Member)) {
				$this->clear();
				return $model['Member']['id'];
			}

		} else {
			if (!$this->hasAny($cond)) {
				$data_Member = array(
					'verified' 		=> true,
					'email'     	=> $email,
					'phone_number' 	=> $phone_number,
				);
				if ($model = $this->save($data_Member)) {
					$this->clear();
					return $model['Member']['id'];
				}
			}
		}
		return array();
	}



	public function get_member_belong_school_with_role_pagination($member_id, $school_id, $role_id, $group_id, $language, $offset, $limit, $search_text = array()) {

		$cond = array(
			'Member.id = MemberLanguage.member_id',
			'MemberLanguage.alias' => $language,
			
		);

		if ($search_text) {
			$cond = array(
				'Member.id = MemberLanguage.member_id',
				'MemberLanguage.alias' 		=> $language,
				'MemberLanguage.name LIKE' 	=> '%' . ($search_text) . '%',
			);
		}

		$join = array(
			array(
				'alias' => 'MemberLoginMethod',
				'table' => Environment::read('table_prefix') . 'member_login_methods',
				'type' => 'INNER',
				'conditions' => array(
					'Member.id = MemberLoginMethod.member_id',
					'MemberLoginMethod.school_id' => $school_id,
				),
			),
			array(
				'alias' => 'MemberLanguage',
				'table' => Environment::read('table_prefix') . 'member_languages',
				'type' => 'INNER',
				'conditions' => $cond,
			),
		);

		if ($group_id) {
			$temp =  array(
					array(
					'alias' => 'MembersGroup',
					'table' => Environment::read('table_prefix') . 'members_groups',
					'type' => 'INNER',
					'conditions' => array(
						'Member.id = MembersGroup.member_id',
						'MembersGroup.school_id' 	=> $school_id,
						'MembersGroup.group_id' 	=> $group_id,
						'MembersGroup.role_id' 		=> $role_id,
					),
				)
			);
			$join = array_merge($join, $temp);
		}

	

		$obj_ImageType = ClassRegistry::init('Dictionary.ImageType');

		$temp = $this->find('all', array(
			'fields' => array(
				'Member.id',
				'MemberLanguage.name',
				'MemberLoginMethod.username',
				'MemberLanguage.alias',
			),
			'conditions' => array(
				'Member.id <>' => $member_id,
			),
			'limit' => $limit, 
			'offset' => $offset,				// get from the row offset 
			'order' => array(
				'Member.id DESC',
			),
			'joins' => $join,
			'contain' => array(
				'MemberRole' => array(
					'conditions' => array(
						'MemberRole.role_id' 		=> $role_id,
						'MemberRole.school_id' 		=> $school_id,
					),
					'Role' => array(
						'RoleLanguage' => array(
							'fields' => array(
								'RoleLanguage.name',
							),
							'conditions' => array(
								'RoleLanguage.alias' => $language,
							),
						),
					),
				),
				'MemberImage' => array(
					'fields' => array(
						'MemberImage.path',
					),
					'conditions' => array(
						'MemberImage.image_type_id' 		=> $obj_ImageType->get_id_by_slug('member-avatar'),
					),
				),
			),
		));

	
		$result = array();
		$no = 1;
		foreach ($temp as $val) {
			if (!empty($val['MemberRole'])) {

				$role = array();
				foreach ($val['MemberRole'] as $r) {
					$role[$r['role_id']] = reset($r['Role']['RoleLanguage'])['name'];
				}

				$result[] = array(
					'no'		=> $no,
					'member_id' => $val['Member']['id'],
					'username' 	=> $val['MemberLoginMethod']['username'],
					'name' 		=> isset($val['MemberLanguage']) ? $val['MemberLanguage']['name'] : '',
					'avatar'    => isset($val['MemberImage']) ? reset($val['MemberImage'])['path'] : '',
					'role'		=> $role,
				);
				$no++;
			}
		}

		$c = array();
		$count = $this->find('all', array(
			'conditions' => array(
				'Member.id <>' => $member_id,
			),
			'joins' => $join,
			'contain' => array(
				'MemberRole' => array(
					'conditions' => array(
						'MemberRole.role_id' 		=> $role_id,
						'MemberRole.school_id' 	=> $school_id,
					),
				),
			),
		));
		foreach ($count as $val) {
			if (!empty($val['MemberRole'])) {
				$c[] = array(
					'no'		=> $no,
				);
				$no++;
			}
		}

		return array(
			'total' => count($c),
			'content' => $result,
		);
	}
}
