<?php
App::uses('MemberAppController', 'Member.Controller');
/**
 * InviteMemberHistories Controller
 *
 * @property InviteMemberHistory $InviteMemberHistory
 * @property PaginatorComponent $Paginator
 */
class InviteMemberHistoriesController extends MemberAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Email');

	public function beforeFilter(){
		parent::beforeFilter();

		if ($this->params['prefix'] == "admin") {
			if ($this->params['action'] == "admin_index") {
				$this->set('title_for_layout', __d('member','member_record') .  " > " .  __d('member','add_invite_member_history') );
			
			
			} elseif ($this->params['action'] == "admin_add" ||  $this->params['action'] == "admin_edit") {
				$this->set('title_for_layout', __d('member','member') .  " > " . __d('member','add_member') .  " > " .  __d('member','add_invite_member_history') );
			}
		}

  	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		
		$conditions = $joins = $school_id = array();

		if ($this->school_id) {
			$school_id = $this->school_id;
			$joins = array(
                array(
                    'table' => Environment::read('table_prefix') . 'schools', 
                    'alias' => 'SchoolT',
                    'type' => 'INNER',
                    'conditions'=> array(
						'SchoolT.id = InviteMemberHistory.school_id',
						'SchoolT.id' => $this->school_id
                    )
                )
			);
		}

		$data_search = $this->request->query;
		if (isset($data_search["school_id"]) && $data_search["school_id"]) {
			$conditions['InviteMemberHistory.school_id'] = $data_search["school_id"];
		}

		if (isset($data_search["role_id"]) && $data_search["role_id"]) {
			$conditions['InviteMemberHistory.role_id'] = $data_search["role_id"];
		}
	
		if (isset($data_search["email"]) && !empty(trim($data_search["email"]))) {
			$conditions['InviteMemberHistory.email LIKE'] = "%" . $data_search["email"] . "%";
		}

		if (isset($data_search["is_status"]) && $data_search["is_status"] != null) {
			$conditions['InviteMemberHistory.verified'] = $data_search["is_status"];
		}

		$all_settings = array(
			'joins' => $joins,
			'contain' => array(
				'School' => array(
					'fields' => array(
						'School.school_code',
					),
					'SchoolLanguage' => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18,
						),
					),
				),
				'Role' => array(
					'RoleLanguage' => array(
						'conditions' => array(
							'RoleLanguage.alias' => $this->lang18,
						),
					),
				),
			),
			'recursive' => 0,
			'order' => 'InviteMemberHistory.id DESC',
			'conditions' => $conditions,
		);
		

		$this->Paginator->settings = $all_settings;
		$inviteMemberHistories = $this->paginate();

		$obj_School = ClassRegistry::init('School.School');
		$schools = $obj_School->get_list_school($school_id, $this->lang18);
		
		$obj_Role = ClassRegistry::init('Administration.Role');
		$roles = $obj_Role->get_list_teacher_student_role($this->lang18);
		
		$this->set(compact('inviteMemberHistories', 'data_search', 'schools', 'roles'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	// public function admin_view($id = null) {
	// 	if (!$this->InviteMemberHistory->exists($id)) {
	// 		throw new NotFoundException(__('Invalid invite member history'));
	// 	}
	// 	$options = array('conditions' => array('InviteMemberHistory.' . $this->InviteMemberHistory->primaryKey => $id));
	// 	$this->set('inviteMemberHistory', $this->InviteMemberHistory->find('first', $options));
	// }

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->InviteMemberHistory->create();

			$data = $this->request->data;

			$result_InviteMemberHistory = $this->InviteMemberHistory->find('first', array(
				'conditions' => array(
					'InviteMemberHistory.role_id' 	=> $data['InviteMemberHistory']['role_id'],
					'InviteMemberHistory.school_id' => $data['InviteMemberHistory']['school_id'],
					'InviteMemberHistory.email' 	=> $data['InviteMemberHistory']['email'],
					'InviteMemberHistory.verified' 	=> true,
				),
			));
			if ($result_InviteMemberHistory) {	// same
				$this->Session->setFlash(__d('member', 'exist_email'), 'flash/error');
				goto load_data;
			}

			if ($this->InviteMemberHistory->save($data['InviteMemberHistory'])) {

				$result_School = $this->InviteMemberHistory->School->get_school_by_id($data['InviteMemberHistory']['school_id']);
				if (!$result_School) {
					$this->Session->setFlash(__('retrieve_data_not_successfully') . " Invite Member History (school code)", 'flash/error');
					goto load_data;
				}

				$link = Router::url('/', true) . 
									'?school_id=' . 	$data['InviteMemberHistory']['school_id'] .
									'&school_code=' . 	trim($result_School['School']['school_code']) . 
									'&role_id=' . 		$data['InviteMemberHistory']['role_id'] . 
									'&email=' . 		trim($data['InviteMemberHistory']['email']);


				// ------- send mail ------
		
				
				$obj_School = ClassRegistry::init('School.School');
				$school_name = $obj_School->get_school_name_by_id($data['InviteMemberHistory']['school_id'], $this->lang18);
	
				
				$data_Email = array(
					'email' 		=> $data['InviteMemberHistory']['email'],
					'school_name'	=> $school_name,
					'link' 			=> $link,
					'school_code' 	=> trim($result_School['School']['school_code']),
				);
		
				if ($data['InviteMemberHistory']['role_id'] == Environment::read('role.teacher')) {
					$template = "become_teacher_" . $this->lang18;
					$result_email = $this->Email->send($data['InviteMemberHistory']['email'], __d('member', 'subject_confirm'), $template, $data_Email);
			
				} elseif ($data['InviteMemberHistory']['role_id'] == Environment::read('role.student')) {
					$template = "become_student_" . $this->lang18;
					$result_email = $this->Email->send($data['InviteMemberHistory']['email'], __d('member', 'subject_confirm'), $template, $data_Email);
			
				}
		
				if($result_email['status']){
					$flag = true;
					$message = __('retrieve_data_successfully');
				}else{
					$message = $result_email['message'];
				}

				$this->redirect(array('action' => 'index'));
				goto load_data;

			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
				goto load_data;
			}
		}

		load_data:

		$school_id = $this->school_id;
		$schools = array();

		if ($this->school_id) {
			$schools = $this->InviteMemberHistory->School->get_list_school($school_id, $this->lang18);
		} else {
			$schools = $this->InviteMemberHistory->School->get_list_school(array(), $this->lang18);
		}
		
		$roles = $this->InviteMemberHistory->Role->get_list_teacher_student_role($this->lang18);
		$this->set(compact('schools', 'roles', 'school_id'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	// public function admin_edit($id = null) {
    //     $this->InviteMemberHistory->id = $id;
	// 	if (!$this->InviteMemberHistory->exists($id)) {
	// 		throw new NotFoundException(__('Invalid invite member history'));
	// 	}
	// 	if ($this->request->is('post') || $this->request->is('put')) {
	// 		if ($this->InviteMemberHistory->save($this->request->data)) {
	// 			$this->Session->setFlash(__('The invite member history has been saved'), 'flash/success');
	// 			$this->redirect(array('action' => 'index'));
	// 		} else {
	// 			$this->Session->setFlash(__('The invite member history could not be saved. Please, try again.'), 'flash/error');
	// 		}
	// 	} else {
	// 		$options = array('conditions' => array('InviteMemberHistory.' . $this->InviteMemberHistory->primaryKey => $id));
	// 		$this->request->data = $this->InviteMemberHistory->find('first', $options);
	// 	}
	// 	$schools = $this->InviteMemberHistory->School->find('list');
	// 	$roles = $this->InviteMemberHistory->Role->find('list');
	// 	$this->set(compact('schools', 'roles'));
	// }

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
		$this->InviteMemberHistory->id = $id;
		if (!$this->InviteMemberHistory->exists()) {
			throw new NotFoundException(__('Invalid invite member history'));
		}
		if ($this->InviteMemberHistory->delete()) {
			$this->Session->setFlash(__('Invite member history deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Invite member history was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
}
