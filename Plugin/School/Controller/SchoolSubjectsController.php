<?php
App::uses('SchoolAppController', 'School.Controller');
/**
 * SchoolSubjects Controller
 *
 * @property SchoolSubject $SchoolSubject
 * @property PaginatorComponent $Paginator
 */
class SchoolSubjectsController extends SchoolAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function beforeFilter(){
		parent::beforeFilter();
        $this->set('title_for_layout', __d('school','school') .  " > " . __d('school','school_subjects') );
	  }
	  
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		
		$conditions = array();
		$school_id = array();
		if ($this->school_id) {
			$conditions = array(
				'SchoolSubject.school_id' => $this->school_id,
			);
			$school_id = $this->school_id;
		}

		$data_search = $this->request->query;
		if (isset($data_search["school_id"]) && $data_search["school_id"]) {
			$conditions['SchoolSubject.school_id'] = $data_search["school_id"];
		}
	
		$conditions_schoolsubjectlanguage = array();

		if (isset($data_search["name"]) && $data_search["name"]) {
			$conditions_schoolsubjectlanguage = array(
				'SchoolSubjectLanguage.name LIKE' => '%' . trim($data_search["name"]) . '%',
			);
			
		}
		
		$all_settings = array(
			'contain' => array(
				'School' => array(
					'fields' => array(
						'School.school_code',
					),
					'SchoolLanguage'  => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18,
						),
					),
				),
				'CreatedBy',
			),
			'joins' => array(
				array(
					'table' => Environment::read('table_prefix') . 'school_subject_languages', 
					'alias' => 'SchoolSubjectLanguage',
					'type' => 'INNER',
					'conditions'=> array_merge($conditions_schoolsubjectlanguage, array(
						'SchoolSubject.id = SchoolSubjectLanguage.school_subject_id',
						'SchoolSubjectLanguage.alias' => $this->lang18,
					)),
				),
			),
			'recursive' => 0,
			'order' => 'SchoolSubject.id DESC',
			'conditions' => $conditions,
			'fields' => array(
				'SchoolSubject.*',
				'SchoolSubjectLanguage.*'
			),
		);

		$this->Paginator->settings = $all_settings;
		$this->SchoolSubject->recursive = 0;
		$schoolSubjects = $this->paginate();

		$obj_School = ClassRegistry::init('School.School');
		$schools = $obj_School->get_list_school($school_id, $this->lang18);
		$this->set(compact('schoolSubjects', 'school_id', 'data_search', 'schools'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->SchoolSubject->exists($id)) {
			throw new NotFoundException(__('Invalid school subject'));
		}
		$options = array(
			'conditions' => array('SchoolSubject.' . $this->SchoolSubject->primaryKey => $id),
			'contain' => array(
				'School' => array(
					'SchoolLanguage' => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $this->lang18,
						),
					),
				),
				'SchoolSubjectLanguage' => array(
					'conditions' => array(
						'SchoolSubjectLanguage.alias' => $this->lang18,
					),
					'fields' => array(
						'SchoolSubjectLanguage.name'
					),
				),
			),
		
		);
		$schoolSubject = $this->SchoolSubject->find('first', $options);
		$this->set(compact('schoolSubject'));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$model = 'SchoolSubject';
		$languages_model = 'SchoolSubjectLanguage';

		$db = $this->SchoolSubject->getDataSource();
		$db->begin();

		if ($this->request->is('post')) {
	
			$data = $this->request->data;

			if ($save_model = $this->SchoolSubject->save($data['SchoolSubject'])) {
				// 2,save language
				if (isset($data['SchoolSubjectLanguage']) && !empty($data['SchoolSubjectLanguage'])) {
					foreach ($data['SchoolSubjectLanguage'] as &$language) {
						$language['school_subject_id'] = $save_model['SchoolSubject']['id'];
					}
					if (!$this->SchoolSubject->SchoolSubjectLanguage->saveAll($data['SchoolSubjectLanguage'])) {
						$db->rollback();
						$this->Session->setFlash(__('data_is_not_saved') . " School Subject Language", 'flash/error');
						goto load_data;
					}
				}

				$db->commit();
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));

			} else {
				$db->rollback();
				$this->Session->setFlash(__('data_is_not_saved') .'sdsd', 'flash/error');
			}
		}

		load_data:

		$language_input_fields = array(
			'id',
			'alias',
			'name',
		);

		$objLanguage = ClassRegistry::init('Dictionary.Language');
		$languages_list = $objLanguage->get_languages();

		$school_id = $this->school_id;
		$schools = array();
		if ($this->school_id) {
			$schools = $this->SchoolSubject->School->get_list_school($school_id, $this->lang18);
		} else {
			$schools = $this->SchoolSubject->School->get_list_school(array(), $this->lang18);
		}
		
		$this->set(compact('school_id', 'schools', 'languages_model', 'language_input_fields', 'languages_list'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$model = 'SchoolSubject';
		$languages_model = 'SchoolSubjectLanguage';

        $this->SchoolSubject->id = $id;
		if (!$this->SchoolSubject->exists($id)) {
			throw new NotFoundException(__('Invalid school subject'));
		}

		$db = $this->SchoolSubject->getDataSource();
		$db->begin();

		if ($this->request->is('post') || $this->request->is('put')) {

			$data = $this->request->data;
			
			if ($this->SchoolSubject->save($data['SchoolSubject'])) {

				// 2,save language
				if (isset($data['SchoolSubjectLanguage']) && !empty($data['SchoolSubjectLanguage'])) {
					foreach ($data['SchoolSubjectLanguage'] as &$language) {
						$language['school_subject_id'] = $id;
					}
					
					if (!$this->SchoolSubject->SchoolSubjectLanguage->saveAll($data['SchoolSubjectLanguage'])) {
						$db->rollback();
						$this->Session->setFlash(__('data_is_not_saved') . " SchoolSubjectLanguage", 'flash/error');
						goto load_data;
					}
				}
				
				$db->commit();
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));

			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		} else {
			$options = array(
				'conditions' => array(
					'SchoolSubject.' . $this->SchoolSubject->primaryKey => $id
				),
				'contain' => array(
					'SchoolSubjectLanguage'
				),
			);
			$this->request->data = $this->SchoolSubject->find('first', $options);
		}

		load_data:
		$language_input_fields = array(
			'id',
			'alias',
			'name',
		);

		$objLanguage = ClassRegistry::init('Dictionary.Language');
		$languages_list = $objLanguage->get_languages();

		$school_id = $this->school_id;
		$schools = array();
		if ($this->school_id) {
			$schools = $this->SchoolSubject->School->get_list_school($school_id, $this->lang18);
		} else {
			$schools = $this->SchoolSubject->School->get_list_school(array(), $this->lang18);
		}

		$this->set(compact('school_id', 'schools', 'languages_model', 'language_input_fields', 'languages_list'));
		
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
		$this->SchoolSubject->id = $id;
		if (!$this->SchoolSubject->exists()) {
			throw new NotFoundException(__('Invalid school subject'));
		}
		if ($this->SchoolSubject->delete()) {
			$this->Session->setFlash(__('data_is_saved'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

	public function api_get_list_subject_by_school_id() {	// web
		
		$this->Api->init_result();
        if ($this->request->is('post')) {
			$this->disableCache();

			$status =  999;
			$message = "";
			$result = (object)array();
			
			$data = $this->request->data;
			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';
		   
			} elseif (!isset($data['school_id']) || empty($data['school_id'])) {
                $message = __('missing_parameter') .  'school_id';
			
			} else {

				$this->Api->set_post_params($this->request->params, $data);
				$this->Api->set_save_log(true);

				$this->Api->set_language($data['language']);
				$result = $this->SchoolSubject->get_list_subject_by_school_id($data);
				
				$status = 200;
				$message = __('retrieve_data_successfully');
		
			}
			return_api_data:
            $this->Api->set_result($status, $message, $result);
        }

		$this->Api->output();
	}
}
