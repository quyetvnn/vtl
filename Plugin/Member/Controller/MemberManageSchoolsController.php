<?php
App::uses('MemberAppController', 'Member.Controller');
/**
 * MemberManageSchools Controller
 *
 * @property MemberManageSchool $MemberManageSchool
 * @property PaginatorComponent $Paginator
 */
class MemberManageSchoolsController extends MemberAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function beforeFilter(){
		parent::beforeFilter();
        $this->set('title_for_layout', __d('member',	'member') .  " > " . __d('member', 'member_manage_schools') );
  	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
	
		$conditions = array();
		$all_settings = array(
			
			'order' => 'MemberManageSchool.id DESC',
			'conditions' => $conditions,
			'contain' => array(
				'Member',
				'Administration',
				'School' => array(
					'SchoolLanguage' => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18,
						),
					),
				),
			),
		);

		$this->Paginator->settings = $all_settings;
		$memberManageSchools = $this->paginate();

		$this->set(compact('memberManageSchools'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->MemberManageSchool->exists($id)) {
			throw new NotFoundException(__('Invalid member manage school'));
		}
		$options = array(
			'conditions' => array(
				'MemberManageSchool.' . $this->MemberManageSchool->primaryKey => $id
			),
			'contain' => array(
				'Member',
				'Administration',
				'School' => array(
					'SchoolLanguage' => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18,
						),
					),
				),
				'CreatedBy',
				'UpdatedBy',
			),
		);

		$memberManageSchool = $this->MemberManageSchool->find('first', $options);
		$this->set(compact('memberManageSchool'));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$obj_MemberRole 		= ClassRegistry::init('Member.MemberRole');
		
		if ($this->request->is('post')) {
			$this->MemberManageSchool->create();

			$data = $this->request->data;
			$obj_Member			 	= ClassRegistry::init('Member.Member');
			$obj_MemberLoginMethod 	= ClassRegistry::init('Member.MemberLoginMethod');
			$obj_MemberManageSchool = ClassRegistry::init('Member.MemberManageSchool');
			$obj_Administrator 		= ClassRegistry::init('Administration.Administrator');
			$obj_AdministratorRole 	= ClassRegistry::init('Administration.AdministratorsRole');
			$obj_School 			= ClassRegistry::init('School.School');

			$db = $this->MemberManageSchool->getDataSource();
			$db->begin();

			$data_MemberLoginMethod = $data_MemberRole = array();
			$message = array();

			// check exist administrator username
			// if exist => no add again, just add another table
			$administrator_id = $obj_Administrator->get_id_by_email($data['MemberManageSchool']['username'], $data['MemberManageSchool']['member_id']);
		
			foreach ($data['MemberManageSchool']['school_id'] as $school) {

				$flag_MemberRole = $flag_MemberLoginMethod = $flag_AdministratorRole = $flag_Administrator = $flag_MemberManageSchool = false;

				// get school name
				$school_name = $obj_School->get_school_name_by_id($school, $this->lang18);

				$exist_MemberRole = $obj_MemberRole->check_exist($data['MemberManageSchool']['member_id'], Environment::read('role.school-admin'), $school);
				if (!$exist_MemberRole) {
					// add MemberRole
					$data_MemberRole[] = array(
						'school_id'			=> $school,
						'role_id' 			=> Environment::read('role.school-admin'),
						'member_id'			=> $data['MemberManageSchool']['member_id'],
					);
					$data_MemberRole[] = array(
						'school_id'			=> $school,
						'role_id' 			=> Environment::read('role.teacher'),
						'member_id'			=> $data['MemberManageSchool']['member_id'],
					);
					$flag_MemberRole  = true;
				}

				$exist_MemberLoginMethod = $obj_MemberLoginMethod->check_exist($data['MemberManageSchool']['username'], $school);
				if (!$exist_MemberLoginMethod) {
					// add MemberLoginMethod
					$data_MemberLoginMethod[] = array(
						'username' 			=> $data['MemberManageSchool']['username'],
						'password' 			=> $obj_Member->set_password($data['MemberManageSchool']['password']),
						'school_id' 		=> $school,
						'member_id'			=> $data['MemberManageSchool']['member_id'],
					);
					$flag_MemberLoginMethod  = true;
				}
					
				$Model_Administrator = array();
				if (!$administrator_id) {
					// add administrator
					$data_Administrator = array(
						'name'				=> $data['MemberManageSchool']['username'],
						'email'				=> $data['MemberManageSchool']['username'],
						'password'			=> $obj_Member->set_password($data['MemberManageSchool']['password']),
					);

					if (!$Model_Administrator = $obj_Administrator->save($data_Administrator)) {
						$db->rollback();
						$this->Session->setFlash(__('data_is_not_saved') . " Administrator" . json_encode($obj_Administrator->invalidFields()), 'flash/error');
						$this->redirect(array('action' => 'index'));
					}
					$obj_Administrator->clear();
					$flag_Administrator  = true;
				}
			
				// check exist adminstrator_role first
				$exist_AdministratorRole = $obj_AdministratorRole->check_exist($administrator_id ? $administrator_id : $Model_Administrator['Administrator']['id'], 
													Environment::read('role.school-admin'));
				if (!$exist_AdministratorRole) {
					// add administrator roles
					$data_AdministratorRole = array(
						'role_id'			=> Environment::read('role.school-admin'),
						'name'				=> $data['MemberManageSchool']['username'],
						'email'				=> $data['MemberManageSchool']['username'],
						'password'			=> $obj_Member->set_password($data['MemberManageSchool']['password']),
						'administrator_id'	=> $administrator_id ? $administrator_id : $Model_Administrator['Administrator']['id'],
					);
					if (!$obj_AdministratorRole->save($data_AdministratorRole)) {
						$db->rollback();
						$this->Session->setFlash(__('data_is_not_saved') . " Administrator Role", 'flash/error');
						$this->redirect(array('action' => 'index'));
					}
					$obj_AdministratorRole->clear();
					$flag_AdministratorRole = true;
				}
				
				$exist_MemberManageSchool = $this->MemberManageSchool->check_exist($data['MemberManageSchool']['member_id'], $school, 
													$administrator_id ? $administrator_id : $Model_Administrator['Administrator']['id']);
				if (!$exist_MemberManageSchool) {
					// add data MemberManageSchool;
					$data_MemberManageSchool = array(
						'school_id'			=> $school,
						'member_id'			=> $data['MemberManageSchool']['member_id'],
						'administrator_id'	=> $administrator_id ? $administrator_id : $Model_Administrator['Administrator']['id'],
					);

					if (!$this->MemberManageSchool->save($data_MemberManageSchool)) {
						$db->rollback();
						$this->Session->setFlash(__('data_is_not_saved') . " MemberManageSchool", 'flash/error');
						$this->redirect(array('action' => 'index'));
					}
					$this->MemberManageSchool->clear();
					$flag_MemberManageSchool = true;
				}

				if (!$flag_MemberManageSchool && !$flag_AdministratorRole && !$flag_Administrator && !$flag_MemberLoginMethod && !$flag_MemberRole) {
					$message[] = "This member had already become school admin at: " . $school_name . "<br>";
				} else {
					$message[] = "Add School admin to " . $school_name . " Succeed!<br>";
				}
			}

			if ($data_MemberLoginMethod) {
				if (!$obj_MemberLoginMethod->saveAll($data_MemberLoginMethod)) {
					$db->rollback();
					$this->Session->setFlash(__('data_is_not_saved') . " MemberLoginMethod", 'flash/error');
					$this->redirect(array('action' => 'index'));
				}
			}
		
			if ($data_MemberRole) {
				if (!$obj_MemberRole->saveAll($data_MemberRole)) {
					$db->rollback();
					$this->Session->setFlash(__('data_is_not_saved') . " MemberRole", 'flash/error');
					$this->redirect(array('action' => 'index'));
				}
			}

			$db->commit();
			$this->Session->setFlash(implode($message), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}

		$schools = $this->MemberManageSchool->School->get_list_school(array(), $this->lang18);
		$members = $obj_MemberRole->get_list_members_by_school_id(array(), $this->lang18, Environment::read('role.teacher'));

		$this->set(compact('schools', 'members'));
	}


/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->MemberManageSchool->id = $id;
		if (!$this->MemberManageSchool->exists()) {
			throw new NotFoundException(__('Invalid member manage school'));
		}

		// delete MemberRoles
		// delete MemberManageSchool 1 row
		// delete adminstrator 1 row
		// delete adminstratorRole
		// delete adminstratorRole

		$obj_MemberRole 		= ClassRegistry::init('Member.MemberRole');
		$obj_MemberLoginMethod 	= ClassRegistry::init('Member.MemberLoginMethod');
		$obj_Administrator 		= ClassRegistry::init('Administration.Administrator');
		$obj_AdministratorRole 	= ClassRegistry::init('Administration.AdministratorsRole');

		$result_MemberManageSchool = $this->MemberManageSchool->get_obj($id);

		$db = $this->MemberManageSchool->getDataSource();
		$db->begin();

		// delete member manage school;
		if (!$this->MemberManageSchool->delete()) {
			$db->rollback();
			$this->Session->setFlash(__('data_is_not_saved') . " MemberManageSchool", 'flash/error');
			$this->redirect(array('action' => 'index'));
		}
		$this->MemberManageSchool->clear();

		$administrator_id = $result_MemberManageSchool['MemberManageSchool']['administrator_id'];
		$school_id = $result_MemberManageSchool['MemberManageSchool']['school_id'];
		$member_id = $result_MemberManageSchool['MemberManageSchool']['member_id'];
		$role_id = Environment::read('role.school-admin');

		// delete Administrator;
		$result_Administrator = $obj_Administrator->get_obj($administrator_id);

		if ($result_Administrator) {
			$username = $result_Administrator['Administrator']['name'];

			// delete MemberLoginMethod 
			$result_MemberLoginMethod = $obj_MemberLoginMethod->get_obj($username, $school_id);

			if ($result_MemberLoginMethod) {
				$obj_MemberLoginMethod->id = $result_MemberLoginMethod['MemberLoginMethod']['id'];
				if (!$obj_MemberLoginMethod->delete()) {
					$db->rollback();
					$this->Session->setFlash(__('data_is_not_saved') . " MemberLoginMethod", 'flash/error');
					$this->redirect(array('action' => 'index'));
				}
				$obj_MemberLoginMethod->clear();
			}
		}
	

		$obj_Administrator->id = $result_MemberManageSchool['MemberManageSchool']['administrator_id'];
		if (!$obj_Administrator->delete()) {
			$db->rollback();
			$this->Session->setFlash(__('data_is_not_saved') . " Administrator", 'flash/error');
			$this->redirect(array('action' => 'index'));
		}

		// delete Administrator Role;
		$result_AdministratorRole  = $obj_AdministratorRole->get_obj($administrator_id, $role_id);
		
		if ($result_AdministratorRole) {
			$obj_AdministratorRole->id = $result_AdministratorRole['AdministratorRole']['id'];
			if (!$obj_Administrator->delete()) {
				$db->rollback();
				$this->Session->setFlash(__('data_is_not_saved') . " AdministratorRole", 'flash/error');
				$this->redirect(array('action' => 'index'));
			}
			$obj_Administrator->clear();
		}


		// delete MemberRole 
		$result_MemberRole = $obj_MemberRole->get_obj($member_id, $role_id, $school_id);
		if ($result_MemberRole) {
			$obj_MemberRole->id = $result_MemberRole['MemberRole']['id'];
			if (!$obj_MemberRole->delete()) {
				$db->rollback();
				$this->Session->setFlash(__('data_is_not_saved') . " Member Role", 'flash/error');
				$this->redirect(array('action' => 'index'));
			}
			$obj_MemberRole->clear();
		}

		// delete role teacher 
		$result_MemberRole = $obj_MemberRole->get_obj($member_id, Environment::read('role.teacher'), $school_id);
		if ($result_MemberRole) {
			$obj_MemberRole->id = $result_MemberRole['MemberRole']['id'];
			if (!$obj_MemberRole->delete()) {
				$db->rollback();
				$this->Session->setFlash(__('data_is_not_saved') . " Member Role", 'flash/error');
				$this->redirect(array('action' => 'index'));
			}
			$obj_MemberRole->clear();
		}

		$db->commit();
		$this->Session->setFlash(__('data_is_saved'), 'flash/success');
		$this->redirect(array('action' => 'index'));
	}
}
