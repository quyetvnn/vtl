<?php
App::uses('AdministrationAppController', 'Administration.Controller');
/**
 * Administrators Controller
 *
 * @property Administrator $Administrator
 * @property PaginatorComponent $Paginator
 */
class AdministratorsController extends AdministrationAppController {

    /**
     * Components
     *
     * @var array
     */
	public $components = array('Paginator');

	public function beforeFilter(){
		parent::beforeFilter();
        $this->set('title_for_layout', __d('administration','administrator') .  " > " . __d('administration','administrators') );
  	}

    /**
     * admin_index method
     * vilh - update filter
     * @return void
     */
	public function admin_index() {
        $AdministratorsRole = ClassRegistry::init('Administration.AdministratorsRole');
		$data_search = $this->request->query;
        $conditions = array();

        $contain = array(
           // 'School' => array( 'fields' => array('id', 'enabled') ),
            'Role' => array( 'fields' => array('slug', 'name') ),
            'Member' => array(
                'MemberLanguage' => array(
                    'conditions' => array(
                        'MemberLanguage.alias' => $this->lang18, 
                    ),
                ),
            ),
        );

		if ($data_search){
			if (isset($data_search['cmbRole']) && !empty($data_search['cmbRole'])){
				$user_ids = $AdministratorsRole->get_user_by_role($data_search['cmbRole']);			
				if($user_ids){
					$conditions["Administrator.id IN"] = $user_ids;
				}else{
					$conditions["Administrator.id"] = '-1';
				}
			}
	
			if (isset($data_search['txtName']) && !empty($data_search['txtName'])) {
				$conditions['Administrator.name LIKE'] = '%'. trim($data_search['txtName']) . '%';
			}

			if (isset($data_search['txtEmail']) && !empty($data_search['txtEmail'])) {
				$conditions['Administrator.email LIKE'] = '%'. trim($data_search['txtEmail']) . '%';
            }
        }
        
       // $company_conditions = array();
        if ($this->school_id) {
			$conditions['Administrator.school_id'] = $this->school_id;
			// $company_conditions['School.id'] = $this->school_id;
        }

		$this->Paginator->settings = array(
			'contain' => $contain,
            'conditions' => $conditions,
            'order' => array('Administrator.created' => 'DESC')
		);
        
        $administrators = $this->paginate();
        
        $roles = $this->Administrator->Role->get_list_roles(!$this->school_id);	
        $obj_School = ClassRegistry::init('School.School');
       
        // $column_cache = json_encode($this->Redis->get_cache('booster_column', '_administrators'));
		$this->set(compact('administrators', 'list_index_companies',  'roles', 'data_search', 'column_cache') );
	}


    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
	public function admin_view($id = null) {
		if (!$this->Administrator->exists($id)) {
			throw new NotFoundException(__('invalid_data'));
        }
        
		$options = array(
            'conditions' => array('Administrator.' . $this->Administrator->primaryKey => $id),
            'contain' => array(
                'School' => array(
                    'SchoolLanguage' => array(
                        'conditions' => array(
                            'SchoolLanguage.alias' => $this->lang18
                        ),
                    ),
                ),
                'Role',
                'CreatedBy',
                'UpdatedBy'
            )
        );

        $administrator = $this->Administrator->find('first', $options);
        
        // if($administrator['Administrator']['company_id']){
        //     $objCompany = ClassRegistry::init('Company.Company');
        //     $company_names = $objCompany->get_company_list(array( 'Company.id' => $administrator['Administrator']['company_id'] ), $this->lang18);
        //     if($company_names){
        //         $administrator['Administrator']['company_name'] = $company_names[$administrator['Administrator']['company_id']];
        //     }
        // }

        if($administrator['Administrator']['school_id']){
            $obj_School = ClassRegistry::init('School.School');
            $school_names = $obj_School->get_school_list(array( 'School.id' => $administrator['Administrator']['school_id'] ), $this->lang18);
            if($school_names){
                $administrator['Administrator']['school_name'] = $school_names[$administrator['Administrator']['school_id']];
            }
        }
        
		$this->set('administrator', $administrator);
	}

    /**
     * admin_add method
     *
     * @return void
     */
	public function admin_add() {
        $this->Administrator->validate['email']['uniqueEmailRule']['message'] = __('duplicate_email_exists');

		if ($this->request->is('post')) {
            $data = $this->request->data;

            // check company is allow
            if ($this->school_id) {
                if(!(isset($data['Administrator']['school_id']) && $data['Administrator']['school_id'])){
                    $this->Session->setFlash('[' . __d('school', 'school') . ']' . __('invalid_permission'), 'flash/error');
                    goto load_data;
                }

                if($this->school_id != $data['Administrator']['school_id']){
                    $this->Session->setFlash('[' . __d('school', 'school') . ']' . __('invalid_permission'), 'flash/error');
                    goto load_data;

                }
            }

            $obj_Member = ClassRegistry::init('Member.Member');
           

			if( isset($data['Administrator']['password']) && !empty($data['Administrator']['password']) ){
				$data['Administrator']['password'] =  $obj_Member->set_password($data['Administrator']['password']); //$this->Administrator->hash( $data['Administrator']['password'] );
			}

			if( !isset($data['Administrator']['token']) || empty($data['Administrator']['token']) ){
				$data['Administrator']['token'] = $this->Administrator->generateToken(8);
			}

            $data['Administrator']['is_admin'] = true;
            $this->Administrator->create();

            $updated = $this->Administrator->update_administrator( $data );
            if( isset($updated['status']) && $updated['status'] ){
                $this->Session->setFlash(__('data_is_saved'), 'flash/success');
                $this->redirect(array('action' => 'index'));

            } else {
                $this->Session->setFlash($updated['message'], 'flash/error');
            }
        }

        load_data:

        $roles = $this->Administrator->Role->get_list_roles_for_add_administrator();
        $this->set(compact('roles'));

        // $this->load_data();

        // if($this->school_id){
        //     $this->set('company_selected', $this->school_id);
        // }
	}

    /**
     * admin_editPassword method
     * vilh - edit password administrator
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_editPassword($id) {
        $this->Administrator->id = $id;
        if (!$this->Administrator->exists($id)) {
            throw new NotFoundException(__('invalid_data'));
        }


        $obj_Member = ClassRegistry::init('Member.Member');
        // post
        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;
            $old_password  =  $obj_Member->set_password( $data['Administrator']['old_password'] );
            $administrator = $this->Administrator->find('first', array(
                'conditions' => array(
                    'Administrator.id = ' => $data['Administrator']['id'], 
                    'Administrator.password = ' => $old_password, 
                ),
                'recursive' => -1
            ));

            if (!$administrator) {
                $this->Session->setFlash(__('username_password_not_found'), 'flash/error');
            } else {

                $administrator['Administrator']['password'] = $obj_Member->set_password( $data['Administrator']['new_password'] );

              //  $administrator['Administrator']['password'] = $this->Administrator->hash( $data['Administrator']['new_password'] );
                if( $this->Administrator->save( $administrator['Administrator'] ) ){
                    $this->Session->setFlash(__('update_password_succeed'), 'flash/success');

                    //session == current user -> force relogin
                    if ($this->Session->read('Administrator.id') == $administrator['Administrator']['id']) {
                        $this->admin_logout();
                    } else {
                        $this->redirect(
                            array(
                            'plugin' => 'administration',
                            'controller' => 'administrators',
                            'action' => 'index',
                            'admin' => true
                        ));
                    }
                } else {
                    $this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
                }
            }
        } else {
            $this->request->data = $this->Administrator->get_user_by_id($id);
        }
    }

	public function admin_edit($id = null) {
        $this->Administrator->validate['email']['uniqueEmailRule']['message'] = __('duplicate_email_exists');
        
        $current_item = $this->Administrator->get_user_by_id($id);
		if (!$current_item) {
			throw new NotFoundException(__('invalid_data'));
        }

        if($this->company_id && $this->company_id != $current_item['Administrator']['company_id']){
			throw new NotFoundException(__('invalid_permission'));
        }

		if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;

            // check company is allow
            if ($this->school_id){
                if(!(isset($data['Administrator']['school_id']) && $data['Administrator']['school_id'])){
                    $this->Session->setFlash('[' . __d('school', 'school') . ']' . __('invalid_permission'), 'flash/error');
                    goto load_data;
                }

                if($this->school_id != $data['Administrator']['school_id']){
                    $this->Session->setFlash('[' . __d('school', 'school') . ']' . __('invalid_permission'), 'flash/error');
                    goto load_data;

                }
                
            }
            
			if( !isset($data['Administrator']['token']) || empty($data['Administrator']['token']) ){
				$data['Administrator']['token'] = $this->Administrator->generateToken(8);
			}

            $updated = $this->Administrator->update_administrator($data);
			if( isset($updated['status']) && ($updated['status'] == true) ){
                $this->Session->setFlash(__('data_is_saved'), 'flash/success');
                
               //  $this->Common->force_logout_affected_user_by_user_ids(array($id));
                $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		} else {
			$this->request->data = $current_item;
        }
        
        load_data:
        $this->load_data();
        $current_roles = array();
        foreach($this->request->data['Role'] as $item){
            array_push($current_roles, $item['id']);
        }

        $old_administrator = $this->request->data['Administrator'];
        // $brands = array();
        $company_selected = '';
        if($old_administrator['school_id']){
            $company_selected = $old_administrator['school_id'];
          //  $brands = $this->Administrator->Brand->get_available_brand_list(array('Brand.company_id' => $old_administrator['company_id']), $this->lang18);
        } else if($this->school_id){
            $company_selected = $this->school_id;
            // $brands = $this->Administrator->Brand->get_available_brand_list(array('Brand.company_id' => $this->company_id), $this->lang18);
        }

        $this->set( compact('current_roles', 'company_selected') );
    }

    private function load_data(){
		$roles =  $this->Administrator->Role->get_list_roles(!$this->school_id);	

        $company_conditions = array();
        if($this->school_id){
            $company_conditions['School.id'] = $this->school_id;
        }
        
        $schools = $this->Administrator->School->get_school_list($company_conditions, $this->lang18, true);
		$this->set( compact('roles', 'schools') );
    }

	public function admin_login(){
        $this->theme = "CakeAdminLTE";
		$this->layout = "full";
		
		if( $this->request->is('post') ){
			$data = $this->request->data['Administrator'];

            $logged_user = $this->Administrator->login($data['emails'], $data['password']);
        
			if( isset($logged_user['status']) && ($logged_user['status'] == true) ){
                $current_user = $logged_user['params'];
				$this->Session->write('Administrator.id', $current_user['id']);
				$this->Session->write('Administrator.current', $current_user);
                
                // $sess_id = $this->Session->id();
                // $session_cache = $this->Redis->set_cache('booster', '_sessionid', $sess_id, 10000);

                if(isset($this->request->query['last_url']) && $this->request->query['last_url'] != ''){
                    $this->redirect($this->request->query['last_url']);

                } else {
                  
                    // if (reset($current_user['Role'])['slug'] == Environment::read('web.super_role')) {
                      
                    //     $this->redirect(array(
                    //         'plugin' => 'company',
                    //         'controller' => 'companies',
                    //         'action' => 'index',
                    //         'admin' => true
                    //     ));

                    // } else {
                        $this->redirect(array(
                            'plugin' => 'school',
                            'controller' => 'schools',
                            'action' => 'index',
                            'admin' => true
                        ));
                    // }
                }
			} else {
				$this->Session->setFlash($logged_user['message'], 'flash/error');
			}
        }
    }
    
    public function admin_forgot_password(){
		$this->layout = "full";
		if( $this->request->is('post') ){
			$data = $this->request->data['Administrator'];

            $params = $this->request->params;
            $log_data = $this->Common->get_log_data_admin();
            $objLog = ClassRegistry::init('Log.Log');
            $dbo = $this->Administrator->getDataSource();
            $dbo->begin();
            try{
                $get_code_forgot = $this->Administrator->forgot_password( $data['email'] );
                
                if( isset($get_code_forgot['status']) && ($get_code_forgot['status'] == true) ){
                    // save to log data
                    $administrator = $get_code_forgot['params']['new_data'];
                    $code = '$2a$10.' . time() .'/'. $administrator['id'] .'/'. $administrator['code_forgot'];
                    $code = base64_encode($code);
                    if(!$objLog->add_log_admin($log_data, $params, array(__d('administration', 'forgot_password_success'), $code), array(), $get_code_forgot['params']['new_data'], $get_code_forgot['params']['old_data'])){
                        $dbo->rollback();
                        $this->Session->setFlash('[' . __('log') . ']' . __('data_is_not_saved'), 'flash/error');
                    }

                    $dbo->commit();
                    // Start send mail to member by email of member
                    $subject = "[" . Environment::read('company.title') . "]" . __('email_subject_forgot_password');
                    $template = "forgot_password_admin";
                    $data = array(
                        'name' => $administrator['name'],
                        'link' => Router::url(array(
                                'plugin' => 'administration',
                                'controller' => 'administrators',
                                'action' => 'change_password',
                                'admin' => true,
                            ), true) . '?code=' . $code,
                    );
                    $this->Email->send($administrator['email'], $subject, $template, $data);
                    // END send mail to member by email of member
    
                    $this->Session->setFlash($get_code_forgot['message'], 'flash/success');
                } else {
                    $this->Session->setFlash($get_code_forgot['message'], 'flash/error');
                    $objLog->add_log_admin($log_data, $params, array(), array(
                        $get_code_forgot['message'],
                        json_encode($get_code_forgot['params'])
                    ), array(), array());
                }
            }catch(Exception $e){
                $objLog->add_log_admin($log_data, $params, array(), array($e->getMessage()), array(), array());
            }
            
            $this->redirect(array(
                'plugin' => 'administration',
                'controller' => 'administrators',
                'action' => 'login',
                'admin' => true
            ));
        }
    }
    
    public function admin_change_password(){
        $this->layout = "full";
        $status = true;
        $query = $this->request->query;
        if( !isset($query['code']) || $query['code'] == '' ){
            $this->Session->setFlash(__('missing_parameter') . __('code'), 'flash/error');
            $status = false;
            goto redirect_link;
        }

        // decode code
        $str_code = base64_decode($query['code']);
        $str_code = str_replace('$2a$10.', '', $str_code);
        $arr_code = explode('/', $str_code);
        if(count($arr_code) != 3){
            $this->Session->setFlash(__d('member', 'invalid_code'), 'flash/error');
            $status = false;
            goto redirect_link;
        }
        
        $administrator_change = $this->Administrator->find('first', array(
            'conditions' => array(
                'Administrator.id' => $arr_code[1],
                'Administrator.code_forgot' => $arr_code[2],
                'Administrator.created_code_forgot >=' => date('Y-m-d h:i:s', strtotime('-30 minutes'))
            )
        ));

        if(!$administrator_change){
            $this->Session->setFlash(__d('member', 'invalid_code'), 'flash/error');
            $status = false;
            goto redirect_link;
        }

        if( $this->request->is('post') ){
            $data = $this->request->data['Administrator'];
            if($data['password'] != $data['confirm_password']){
                $this->Session->setFlash(__d('administration', 'confirm_password_is_not_match'), 'flash/error');
                goto redirect_link;
            }

            $params = $this->request->params;
            $log_data = $this->Common->get_log_data_admin();
            $objLog = ClassRegistry::init('Log.Log');
            $dbo = $this->Administrator->getDataSource();
            $dbo->begin();
            try{
                $administrator_data = $administrator_change['Administrator'];
                $administrator_data['password'] = $this->Administrator->hash( $data['password'] );
                $saved_admin = $this->Administrator->save( $administrator_data );
                if( $saved_admin ){
                    // save to log data
                    if(!$objLog->add_log_admin($log_data, $params, array(__d('administration', 'change_password_success')), array(), $saved_admin, $administrator_change)){
                        $dbo->rollback();
                        $this->Session->setFlash('[' . __('log') . ']' . __('data_is_not_saved'), 'flash/error');
                    }

                    $dbo->commit();

                    $this->Session->setFlash(__d('member', 'change_password_success'), 'flash/success');
                    $this->redirect(array(
                        'plugin' => 'administration',
                        'controller' => 'administrators',
                        'action' => 'login',
                        'admin' => true
                    ));
                } else {
                    $this->Session->setFlash(__d('member', 'change_password_fail'), 'flash/error');
                    $objLog->add_log_admin($log_data, $params, array(), $this->Administrator->invalidFields(), array(), array());
                }
            } catch(Exception $e){
                $objLog->add_log_admin($log_data, $params, array(), array($e->getMessage()), array(), array());
            }
        }

        redirect_link:
        if(!$status){
            $this->redirect(array(
                'plugin' => 'administration',
                'controller' => 'administrators',
                'action' => 'login',
                'admin' => true
            ));
        }
	}

	public function admin_logout(){
		$this->layout = $this->autoRender = false;

		if( $this->Session->check('Administrator.id') ){
			$this->Session->delete('Administrator.id');
			$this->Session->destroy();

            $this->Session->setFlash(__d('administration', 'user_is_logged_out'), 'flash/success');
        
			$this->redirect(array(
				'plugin' => '',         //'administration',
				'controller' => 'pages', // 'administrators',
				'action' => 'landing',   //'login',
				'admin' => false,       //true
			));
		} else {
			$this->Session->setFlash(__d('administration', 'logout_error'), 'flash/error');
        }
        
		$this->redirect('/');
	}

}
