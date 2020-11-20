<?php
App::uses('MemberAppController', 'Member.Controller');
/**
 * ImportHistories Controller
 *
 * @property ImportHistory $ImportStudentHistory
 * @property PaginatorComponent $Paginator
 */
class ImportHistoriesController extends MemberAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function beforeFilter(){
		parent::beforeFilter();
		$this->set('title_for_layout', __d('member','member_record') .  " > " .  __d('member','import_histories') );
		
  	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {

		$joins = array();
		if ($this->school_id) {
			$joins = array(
                array(
                    'table' => Environment::read('table_prefix') . 'schools', 
					'alias' => 'SchoolT',
                    'type' => 'INNER',
                    'conditions'=> array(
						'SchoolT.id = ImportHistory.school_id',
						'SchoolT.id' => $this->school_id
                    )
                )
			);
		}
	
		$all_settings = array(
			'joins' => $joins,
			'contain' => array(
				'School' => array(
					'fields' => array(
						'School.id',
						'School.school_code',
					),
					'SchoolLanguage' => array(
						'fields' => array(
							'SchoolLanguage.name',
						),
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18,
						),
					),
				),
				'Role' => array(
					'RoleLanguage' => array(
						'fields' => array(
							'RoleLanguage.name',
						),
						'conditions' => array(
							'RoleLanguage.alias' => $this->lang18,
						),
					),
				),
			),
			'order' => 'ImportHistory.id DESC',
		);

		$this->Paginator->settings = $all_settings;
		$importStudentHistories = $this->paginate();

		$this->set(compact('importStudentHistories'));
	}


}
