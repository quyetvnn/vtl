<?php
App::uses('CompanyAppController', 'Company.Controller');
/**
 * CompanyLanguages Controller
 *
 * @property CompanyLanguage $CompanyLanguage
 * @property PaginatorComponent $Paginator
 */
class CompanyLanguagesController extends CompanyAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CompanyLanguage->recursive = 0;
		$this->set('companyLanguages', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CompanyLanguage->exists($id)) {
			throw new NotFoundException(__('invalid_data'));
		}
		$options = array('conditions' => array('CompanyLanguage.' . $this->CompanyLanguage->primaryKey => $id));
		$this->set('companyLanguage', $this->CompanyLanguage->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CompanyLanguage->create();
			if ($this->CompanyLanguage->save($this->request->data)) {
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		}
		$companies = $this->CompanyLanguage->Company->find('list');
		$this->set(compact('companies'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->CompanyLanguage->id = $id;
		if (!$this->CompanyLanguage->exists($id)) {
			throw new NotFoundException(__('invalid_data'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CompanyLanguage->save($this->request->data)) {
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('CompanyLanguage.' . $this->CompanyLanguage->primaryKey => $id));
			$this->request->data = $this->CompanyLanguage->find('first', $options);
		}
		$companies = $this->CompanyLanguage->Company->find('list');
		$this->set(compact('companies'));
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
		$this->CompanyLanguage->id = $id;
		if (!$this->CompanyLanguage->exists()) {
			throw new NotFoundException(__('invalid_data'));
		}
		if ($this->CompanyLanguage->delete()) {
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
		$this->CompanyLanguage->recursive = 0;
		$this->set('companyLanguages', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->CompanyLanguage->exists($id)) {
			throw new NotFoundException(__('invalid_data'));
		}
		$options = array('conditions' => array('CompanyLanguage.' . $this->CompanyLanguage->primaryKey => $id));
		$this->set('companyLanguage', $this->CompanyLanguage->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->CompanyLanguage->create();
			if ($this->CompanyLanguage->save($this->request->data)) {
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		}
		$companies = $this->CompanyLanguage->Company->find('list');
		$this->set(compact('companies'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
        $this->CompanyLanguage->id = $id;
		if (!$this->CompanyLanguage->exists($id)) {
			throw new NotFoundException(__('invalid_data'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CompanyLanguage->save($this->request->data)) {
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('CompanyLanguage.' . $this->CompanyLanguage->primaryKey => $id));
			$this->request->data = $this->CompanyLanguage->find('first', $options);
		}
		$companies = $this->CompanyLanguage->Company->find('list');
		$this->set(compact('companies'));
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
		$this->CompanyLanguage->id = $id;
		if (!$this->CompanyLanguage->exists()) {
			throw new NotFoundException(__('invalid_data'));
		}
		if ($this->CompanyLanguage->delete()) {
			$this->Session->setFlash(__('data_is_deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('data_is_not_deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
}
