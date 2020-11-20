<?php
App::uses('CompanyAppController', 'Company.Controller');
/**
 * Companies Controller
 *
 * @property Company $Company
 * @property PaginatorComponent $Paginator
 */
class CompaniesController extends CompanyAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function beforeFilter(){
		parent::beforeFilter();
		$this->set('title_for_layout', __d('company','company'));
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Company->recursive = 0;
		$this->set('companies', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Company->exists($id)) {
			throw new NotFoundException(__('invalid_data'));
		}
		$options = array('conditions' => array('Company.' . $this->Company->primaryKey => $id));
		$this->set('company', $this->Company->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Company->create();
			if ($this->Company->save($this->request->data)) {
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->Company->id = $id;
		if (!$this->Company->exists($id)) {
			throw new NotFoundException(__('invalid_data'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Company->save($this->request->data)) {
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('Company.' . $this->Company->primaryKey => $id));
			$this->request->data = $this->Company->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Company->id = $id;
		if (!$this->Company->exists()) {
			throw new NotFoundException(__('invalid_data'));
		}
		if ($this->Company->delete()) {
			$this->Session->setFlash(__('data_is_deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('data_is_not_deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		
        $this->theme = "CakeAdminLTE";
		$this->layout = "default";

		$this->Company->recursive = 0;
		$this->set('companies', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Company->exists($id)) {
			throw new NotFoundException(__('invalid_data'));
		}
		$options = array(
			'conditions' => array('Company.id' => $id),
			'contain' => array(
				'CompanyLanguage',
			),
		);

		$company = $this->Company->find(
			'first', $options
		);
		$this->set('company', $company);

		// language
		$language_input_fields = array(
			'name',
			'description',
			'address',
			'about',
			'terms',
			'privacy',
			'hotline',
			'service_time',
		);

		$languages = $company['CompanyLanguage'];

		$this->set(compact('language_input_fields','languages'));

		// brand
		if (isset($company['Brand']) && !empty($company['Brand'])) {
			$brands = array();
			$brand_ids = Hash::extract($company['Brand'], '{n}.id');
			$brands = $this->Company->Brand->get_brand_languages($brand_ids, array('eng'));
			$brand_input_fields = array(
				'description',
				'content',
			);

			$this->ImageType = ClassRegistry::init('Dictionary.ImageType');
			$image_type_id = $this->ImageType->field('id',array(
				'ImageType.slug like' => '%brand-logo%'
			));
		
			$this->set(compact('brands','brand_input_fields'));
		}
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Company->create();
			if ($this->Company->saveAll($this->request->data)) {
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		}
		//Company languages fields
		$language_input_fields = array(
			'id',
			'company_id',
			'alias',
			'name',
			'description',
			'address',
			'about',
			'terms',
			'privacy',
			'hotline',
		);

		$objLanguage = ClassRegistry::init('Dictionary.Language');
		$languages_list = $objLanguage->get_languages();

		$languages_model = 'CompanyLanguage';

		$this->set(compact('language_input_fields','languages_list','languages_model'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
        $this->Company->id = $id;
		if (!$this->Company->exists($id)) {
			throw new NotFoundException(__('invalid_data'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Company->saveAll($this->request->data)) {
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		} else {
			$options = array(
				'conditions' => array('Company.' . $this->Company->primaryKey => $id),
				'contain' => array(
					'CompanyLanguage',
				),
			);
			$this->request->data = $this->Company->find(
				'first', 
				$options
			);

			//Company languages fields
			$language_input_fields = array(
				'id',
				'company_id',
				'alias',
				'name',
				'description',
				'address',
				'about',
				'terms',
				'privacy',
				'hotline',
			);


			$objLanguage = ClassRegistry::init('Dictionary.Language');
			$languages_list = $objLanguage->get_languages();

			$languages_model = 'CompanyLanguage';

			$this->set(compact('language_input_fields','languages_list','languages_model'));
		}
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
		$this->Company->id = $id;
		if (!$this->Company->exists()) {
			throw new NotFoundException(__('invalid_data'));
		}
		if ($this->Company->delete()) {
			$this->Session->setFlash(__('data_is_deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('data_is_not_deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
}
