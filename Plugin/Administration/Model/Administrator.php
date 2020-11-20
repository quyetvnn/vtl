<?php

App::uses('AdministrationAppModel', 'Administration.Model');
/**
 * Administrator Model
 *
 * @property BackendLog $BackendLog
 * @property Role $Role
 */
class Administrator extends AdministrationAppModel {

	var $name = 'Administrator';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
	
		// 'email' => array(
		// 	'notBlank' => array(
		// 		'rule' => 'notBlank',
		// 		'required' => true,
		// 		'message' => 'Provide an email address'
		// 	),
		// 	'validEmailRule' => array(
		// 		'rule' => array('email'),
		// 		'message' => 'Invalid email address'
		// 	),
		// 	'uniqueEmailRule' => array(
		// 		'rule' => 'isUnique',
		// 		'message' =>  'Email already registered',
		// 	)
		// ),
		// 'phone' => array(
		// 	'notBlank' => array(
		// 		'rule' => array('notBlank'),
		// 		'required' => true,
		// 	),
		// ),
	);

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
		'MemberManageSchool' => array(
			'className' => 'Member.MemberManageSchool',
			'foreignKey' => 'administrator_id',
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
/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Role' => array(
			'className' => 'Administration.Role',
			'joinTable' => 'administrators_roles',
			'foreignKey' => 'administrator_id',
			'associationForeignKey' => 'role_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
	
		// 	FULL VERSION
		// 'MemberManageSchool' => array(
		// 	'className' => 'Member.MemberManageSchool',
		// 	'joinTable' => 'administrators_roles',
		// 	'foreignKey' => 'administrator_id',
		// 	'associationForeignKey' => 'role_id',
		// 	'unique' => 'keepExisting',
		// 	'conditions' => '',
		// 	'fields' => '',
		// 	'order' => '',
		// 	'limit' => '',
		// 	'offset' => '',
		// 	'finderQuery' => '',
		// )
	);

	public $display_fields = array(
		'Administrator.id',  'Administrator.name', 'Administrator.enabled', 'Administrator.member_id',
		'Administrator.is_admin', 'Administrator.email', 'Administrator.phone', 'Administrator.last_logged_in', 'Administrator.token',
	);

	public function find_list($conditions = array()){
		$data = array();

		$data = $this->find('all', array(
            'fields' => array('id', 'email'),
			'conditions' => $conditions,
			'recursive' => -1,
        ));

		if ($data) {
			$data = Hash::combine($data, '{n}.Administrator.id', '{n}.Administrator.email');
		}else{
			$data = array();
		}

		return $data;
	}

	public function update_administrator( $administrator ){
		$params = array();

		$updated = array( 
			'status' => false, 
			'message' => __d('administration', 'Fail to update administrator info. Please try again.'), 
			'params' => $params
		);

		if( empty($administrator) ){
			$updated = array( 
				'status' => false, 
				'message' => __d('administration', 'Not enough data.'), 
				'params' => $params
			);
		} else {
			$data['Administrator'] = $administrator['Administrator'];
			
			if ( empty($administrator['Role']['roles']) ) {
				return $updated = array( 
					'status' => false, 
					'message' => __d('administration','please_select_role'), 
					'params' => $params
				);
			}

			if (!isset($data['Administrator']['id'])) { // add function
				$this->create();
				$data = $administrator;

				unset($data['Role']['roles']);

				if( isset($administrator['Role']['roles']) && !empty($administrator['Role']['roles']) ){
					foreach ($administrator['Role']['roles'] as $key => $role) {
						if( !empty($role) ){
							$data['Role'][] = array(
								'administrator_id' => "",
								'role_id' => $role,		// vilh
							);
						}
					}
				}
			} else {
				if( isset($administrator['Role']['roles']) && !empty($administrator['Role']['roles']) ){
					foreach ($administrator['Role']['roles'] as $key => $role) {
						if( !empty($role) ){
							$administrator_id = "";
							if( isset($administrator['Administrator']['id']) && !empty($administrator['Administrator']['id']) ){
								$administrator_id = $administrator['Administrator']['id'];
							}

							$data['Role'][] = array(
								'administrator_id' => $administrator_id,
								'role_id' => $role,
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
					$params = $administrator;
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

	public function login($email = "", $raw_password = "") { 
        $params = array();

		if (!isset($email) || empty($email)) {
			if (Environment::is('development')) {
				$params = array( 'Missing' => 'email' );
			}
			$logged_user = array( 
				'status' => false, 
				'message' => __( 'missing_parameter' ), 
				'params' => $params
			);

		} else if (!isset($raw_password) || empty($raw_password)) {
			if (Environment::is('development')) {
				// if it is the developement environment, show the debug message
				$params = array( 'Missing' => 'raw_password' );
			}
			$logged_user = array( 
				'status' => false, 
				'message' => __( 'missing_parameter' ),
				'params' => $params
			);
		} else {

			$obj_Member = ClassRegistry::init('Member.Member');

            $encrypted_password =  $obj_Member->set_password($raw_password);	//$this->hash($raw_password);
            $administrator = $this->find('first', array(
                'fields' => $this->display_fields,
                'conditions' => array(
                    'Administrator.email' => $email, 
					'Administrator.password' => $encrypted_password,
					'Administrator.enabled' => true,
                ),
                'contain' => array(
					'MemberManageSchool' => array(
						'conditions' => array(
							'MemberManageSchool.enabled' => true,
						),
						'fields' => array(
							'MemberManageSchool.school_id'
						),
					)
                ),
                'recursive' => -1
			));

			if (!empty($administrator)) {
               

				$result = $this->generate_login_info($administrator);
				$logged_user = array( 
					'status' => true, 
					'message' => __d('administration','login_success'), 
					'params' => $result
				);



			} else {

				$logged_user = array( 
					'status' => false, 
					'message' => __d('administration','login_fail'), 
				);
			}
		}

        return_result:
		return $logged_user;
	}

	public function update_last_logged_user($administrator_id) {
        $current = date('Y-m-d H:i:s');

        $data = array(
            'id' => $administrator_id,
            'last_logged_in' => $current
        );

        if ($this->save($data)) {
            return array( 
                'status' => true, 
                'last_logged_in' => $current
            );
        } else {
            return array( 
                'status' => false, 
            );
        }
	}
    
    public function get_user_by_id($user_id){
        return $this->find('first', array(
            'fields' => $this->display_fields,
            'conditions' => array(
                'Administrator.id' => $user_id, 
            ),
            'contain' => array('Role' => array('id', 'slug', 'name'))
        ));
    }

    public function get_admin_user_by_member_email($email, $member_id) {
    	$logged_user = array();
        $administrator = $this->find('first', array(
	        'fields' => $this->display_fields,
	        'conditions' => array(
				'Administrator.email' 		=> $email,
				'Administrator.member_id' 	=> $member_id
	        ),
	        'contain' => array(
				'MemberManageSchool' => array(
					'conditions' => array(
						'MemberManageSchool.enabled' => true,
					),
					'fields' => array(
						'MemberManageSchool.school_id'
					),
				)
	        ),
	        'recursive' => -1
		));

		if (!empty($administrator)) {
	       
			$result = $this->generate_login_info($administrator);
			$logged_user = array( 
				'status' => true, 
				'message' => __d('administration','login_success'), 
				'params' => $result
			);

		}else {
			$logged_user = array( 
				'status' => false, 
				'message' => __d('administration','login_fail'), 
			);
		}
		return_result:
		return $logged_user;
    }

	public function hash( $string ){
		App::uses('Security', 'Utility');
		return Security::hash($string, 'sha1', true);
    }

    private function generate_code(){
        $digits = 6;
        return rand(pow(10, $digits-1), pow(10, $digits)-1);
	}
	
	public function check_exist($email) {
		$count = $this->find('count', array(
			'conditions' => array(
				'Administrator.email' => $email
			),
		));
		
		if ($count > 0) {
			return true;
		} 
		return false;
	}

	public function get_id_by_email($email, $member_id) {
		$result = $this->find('first', array(
			'conditions' => array(
				'Administrator.email' 		=> trim($email),
				'Administrator.member_id' 	=> $member_id,
			),
		));

		return $result ? $result['Administrator']['id'] : array();
	}

	public function get_obj($id) {
		$result = $this->find('first', array(
			'conditions' => array(
				'Administrator.id' => $id,
			),
			'fields' => array(
				'Administrator.*',
			),
		));

		return $result;
	}

	public function generate_login_info($administrator) {
		$result = array();
		foreach ($administrator['MemberManageSchool'] as $member_manage_school) {
			$result['school_id'][] = $member_manage_school['school_id'];
		}

		//$result = $administrator['Administrator'];
		$result['id'] 		= $administrator['Administrator']['id'];
		$result['name'] 	= $administrator['Administrator']['name'];
		$result['enabled'] 	= $administrator['Administrator']['enabled'];
		$result['is_admin'] = $administrator['Administrator']['is_admin'];
		$result['email'] 	= $administrator['Administrator']['email'];
		$result['phone'] 	= $administrator['Administrator']['phone'];
		$result['Role'] = array();
		$result['Permission'] = array();
		// update last logged of this user.
		$last_logged_user = $this->update_last_logged_user($result['id']);
		if (isset($last_logged_user['status']) && ($last_logged_user['status'] == true)) {
			$result['last_logged_in'] = $last_logged_user['last_logged_in'];
		}
	

		$objAdministratorsRole = ClassRegistry::init('Administration.AdministratorsRole');
		$roles = $objAdministratorsRole->get_administrator_roles($result['id']);
		
		if (!empty($roles)) {
			$result['Role'] = $roles;
			
			foreach ($roles as $val) {
				if ($val['slug'] == 'role-school-admin') {
					$result['role_school_admin'] = true;
				}
			} 

			$role_ids = Hash::extract ($roles, "{n}.id");
			$objRolesPermission = ClassRegistry::init("Administration.RolesPermission");
			$result['Permission'] = $objRolesPermission->get_permissions_by_role( $role_ids );
		}

		return $result;
	}

	public function get_id_by_username($username) {
		$result = $this->find('first', array(
			'conditions' => array(
				'Administrator.email' => $username,
			),
			'fields' => array(
				'Administrator.id',
			),
		));
		return $result['Administrator']['id'];
	}

}
