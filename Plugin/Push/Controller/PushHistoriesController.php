<?php
App::uses('PushAppController', 'Push.Controller');
/**
 * PushHistories Controller
 *
 * @property PushHistory $PushHistory
 * @property PaginatorComponent $Paginator
 */
class PushHistoriesController extends PushAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->PushHistory->recursive = 0;
		$this->set('pushHistories', $this->paginate());
	}

// /**
//  * admin_view method
//  *
//  * @throws NotFoundException
//  * @param string $id
//  * @return void
//  */
// 	public function admin_view($id = null) {
// 		if (!$this->PushHistory->exists($id)) {
// 			throw new NotFoundException(__('Invalid push history'));
// 		}
// 		$options = array('conditions' => array('PushHistory.' . $this->PushHistory->primaryKey => $id));
// 		$this->set('pushHistory', $this->PushHistory->find('first', $options));
// 	}

// /**
//  * admin_add method
//  *
//  * @return void
//  */
// 	public function admin_add() {
// 		if ($this->request->is('post')) {
// 			$this->PushHistory->create();
// 			if ($this->PushHistory->save($this->request->data)) {
// 				$this->Session->setFlash(__('The push history has been saved'), 'flash/success');
// 				$this->redirect(array('action' => 'index'));
// 			} else {
// 				$this->Session->setFlash(__('The push history could not be saved. Please, try again.'), 'flash/error');
// 			}
// 		}
// 		$pushes = $this->PushHistory->Push->find('list');
// 		$pushRules = $this->PushHistory->PushRule->find('list');
// 		$this->set(compact('pushes', 'pushRules'));
// 	}

// /**
//  * admin_edit method
//  *
//  * @throws NotFoundException
//  * @param string $id
//  * @return void
//  */
// 	public function admin_edit($id = null) {
//         $this->PushHistory->id = $id;
// 		if (!$this->PushHistory->exists($id)) {
// 			throw new NotFoundException(__('Invalid push history'));
// 		}
// 		if ($this->request->is('post') || $this->request->is('put')) {
// 			if ($this->PushHistory->save($this->request->data)) {
// 				$this->Session->setFlash(__('The push history has been saved'), 'flash/success');
// 				$this->redirect(array('action' => 'index'));
// 			} else {
// 				$this->Session->setFlash(__('The push history could not be saved. Please, try again.'), 'flash/error');
// 			}
// 		} else {
// 			$options = array('conditions' => array('PushHistory.' . $this->PushHistory->primaryKey => $id));
// 			$this->request->data = $this->PushHistory->find('first', $options);
// 		}
// 		$pushes = $this->PushHistory->Push->find('list');
// 		$pushRules = $this->PushHistory->PushRule->find('list');
// 		$this->set(compact('pushes', 'pushRules'));
// 	}

// /**
//  * admin_delete method
//  *
//  * @throws NotFoundException
//  * @throws MethodNotAllowedException
//  * @param string $id
//  * @return void
//  */
// 	public function admin_delete($id = null) {
// 		if (!$this->request->is('post')) {
// 			throw new MethodNotAllowedException();
// 		}
// 		$this->PushHistory->id = $id;
// 		if (!$this->PushHistory->exists()) {
// 			throw new NotFoundException(__('Invalid push history'));
// 		}
// 		if ($this->PushHistory->delete()) {
// 			$this->Session->setFlash(__('Push history deleted'), 'flash/success');
// 			$this->redirect(array('action' => 'index'));
// 		}
// 		$this->Session->setFlash(__('Push history was not deleted'), 'flash/error');
// 		$this->redirect(array('action' => 'index'));
// 	}
}
