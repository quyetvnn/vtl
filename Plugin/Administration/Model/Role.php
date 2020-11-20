<?php
App::uses('AdministrationAppModel', 'Administration.Model');
/**
 * Role Model
 *
 * @property Administrator $Administrator
 * @property Permission $Permission
 */
class Role extends AdministrationAppModel {
	public $actsAs = array('Containable');
    /**
     * Validation rules
     *
     * @var array
     */
	public $validate = array(
		'slug' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
                'required' => true,
			),
		),
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
                'required' => true,
			),
		),
	);

	public $belongsTo = array(
		'CreatedBy' => array(
			'className' => 'Administration.Administrator',
			'foreignKey' => 'created_by',
			'conditions' => '',
			'fields' => array('email','name'),
			'order' => ''
		),
		'UpdatedBy' => array(
			'className' => 'Administration.Administrator',
			'foreignKey' => 'updated_by',
			'conditions' => '',
			'fields' => array('email','name'),
			'order' => ''
		),
	);


	public $hasMany = array(
		'RoleLanguage' => array(
			'className' => 'Administration.RoleLanguage',
			'foreignKey' => 'role_id',
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
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

	public $display_fields = array(
		'Role.id', 'Role.slug', 'Role.name',
	);

    /**
     * hasAndBelongsToMany associations
     * @var array
     */
	public $hasAndBelongsToMany = array(
		'Administrator' => array(
			'className' => 'Administration.Administrator',
			'joinTable' => 'administrators_roles',
			'foreignKey' => 'role_id',
			'associationForeignKey' => 'administrator_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Permission' => array(
			'className' => 'Administration.Permission',
			'joinTable' => 'roles_permissions',
			'foreignKey' => 'role_id',
			'associationForeignKey' => 'permission_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

	public function get_list_roles($is_admin){

		$conditions = array( 'Role.slug LIKE' => 'role-%' );

        if(!$is_admin){
            $conditions['Role.slug <> '] = Environment::read('web.super_role');
        }

		$roles = $this->find('list', array(
            'fields' => array('id', 'name'),
            'conditions' => $conditions,
			'recursive' => -1
		));

		
		return $roles;
	}

	public function update_roles( $role = array() ){
		$params = array();

		$updated = array( 
			'status' => false, 
			'message' => __('data_is_not_saved'), 
			'params' => $params
		);

		if( empty($role) ){
			$updated = array( 
				'status' => false, 
				'message' => __d('administration','missing_parameter'), 
				'params' => $params
			);
		} else {
			$data['Role'] = $role['Role'];

			if (!isset($data['Role']['id'])) {	// add
				$this->create();
				$temp = $role;
				if( isset($temp['Permission']['rules']) && !empty($temp['Permission']['rules']) ){
					foreach ($temp['Permission']['rules'] as $key => $rule) {
						if( !empty($temp) ){
							$data['Permission'][] = array(
								'role_id' => "",
								'permission_id' => $rule,
							);
						}
					}
                }
                
				unset($data['Permission']['rules']);
			}else{	
				if( isset($role['Permission']['rules']) && !empty($role['Permission']['rules']) ){
					foreach ($role['Permission']['rules'] as $key => $rule) {
						if( !empty($role) ){
							$role_id = "";
							if( isset($role['Role']['id']) && !empty($role['Role']['id']) ){
								$role_id = $role['Role']['id'];
							}

							$data['Permission'][] = array(
								'role_id' => $role_id,
								'permission_id' => $rule,
							);
						}
					}
				}
            }
            
			if( $this->saveAll( $data ) ){
				$updated = array( 
					'status' => true, 
					'message' => __('data_is_saved'), 
					'params' => $params
				);
			} else {
				if( Environment::is('development') ){
					// if it is the developement environment, show the debug message
					$params = $role;
				}

				$updated = array( 
					'status' => false, 
					'message' => __('data_is_not_saved'), 
					'params' => $params
				);
			}
		}

		return $updated;
	}

	public function get_role( $role_id ){
        $role = $this->find('first', array(
            'fields' => $this->display_fields,
            'conditions' => array('Role.id' => $role_id),
            'recursive' => -1
        ));

        return $role;
    }
    

	public function get_list_teacher_student_role($language = 'zho') {

		$result = $this->find('list', array(
			'fields' => array(
				'Role.id',
				'RoleLanguage.name',
			),
			'conditions' => array(
				'OR' => array(
					array('Role.slug LIKE' => '%teacher%'),
					array('Role.slug LIKE' => '%student%'),
				),
			),
			'joins' => array(
                array(
                    'table' => Environment::read('table_prefix') . 'role_languages', 
                    'alias' => 'RoleLanguage',
                    'type' => 'inner',
                    'conditions'=> array(
                        'Role.id = RoleLanguage.role_id',
                        'RoleLanguage.alias' => $language,
                    )
                ),
            ),
		));

		// foreach ($result as $key => &$val) {

		// 	if ($key == Environment::read('role.student')) {
		// 		$val = __d('member', 'student');

		// 	} else if ($key == Environment::read('role.teacher')) {
		// 		$val = __d('member', 'teacher');
		// 	}
		// }

		return $result;
	}

	// just show 2 role, admin + system admin
	public function get_list_roles_for_add_administrator() {
		return $this->find('list', array(
			'fields' => array(
				'Role.id',
				'Role.slug',
			),
			'conditions' => array(
				'OR' => array(
					array('Role.slug LIKE' => 'role-system-admin'),
					array('Role.slug LIKE' => 'role-vtl-admin'),
				),
			),
		));
	}
}

