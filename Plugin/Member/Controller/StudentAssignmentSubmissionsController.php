<?php
App::uses('MemberAppController', 'Member.Controller');
/**
 * StudentAssignmentSubmissions Controller
 *
 * @property StudentAssignmentSubmission $StudentAssignmentSubmission
 * @property PaginatorComponent $Paginator
 */
class StudentAssignmentSubmissionsController extends MemberAppController {

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
		$this->StudentAssignmentSubmission->recursive = 0;
		$this->set('studentAssignmentSubmissions', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->StudentAssignmentSubmission->exists($id)) {
			throw new NotFoundException(__('Invalid student assignment submission'));
		}
		$options = array('conditions' => array('StudentAssignmentSubmission.' . $this->StudentAssignmentSubmission->primaryKey => $id));
		$this->set('studentAssignmentSubmission', $this->StudentAssignmentSubmission->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->StudentAssignmentSubmission->create();
			if ($this->StudentAssignmentSubmission->save($this->request->data)) {
				$this->Session->setFlash(__('The student assignment submission has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The student assignment submission could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$students = $this->StudentAssignmentSubmission->Student->find('list');
		$teacherCreateAssignments = $this->StudentAssignmentSubmission->TeacherCreateAssignment->find('list');
		$this->set(compact('students', 'teacherCreateAssignments'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
        $this->StudentAssignmentSubmission->id = $id;
		if (!$this->StudentAssignmentSubmission->exists($id)) {
			throw new NotFoundException(__('Invalid student assignment submission'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->StudentAssignmentSubmission->save($this->request->data)) {
				$this->Session->setFlash(__('The student assignment submission has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The student assignment submission could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('StudentAssignmentSubmission.' . $this->StudentAssignmentSubmission->primaryKey => $id));
			$this->request->data = $this->StudentAssignmentSubmission->find('first', $options);
		}
		$students = $this->StudentAssignmentSubmission->Student->find('list');
		$teacherCreateAssignments = $this->StudentAssignmentSubmission->TeacherCreateAssignment->find('list');
		$this->set(compact('students', 'teacherCreateAssignments'));
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
		$this->StudentAssignmentSubmission->id = $id;
		if (!$this->StudentAssignmentSubmission->exists()) {
			throw new NotFoundException(__('Invalid student assignment submission'));
		}
		if ($this->StudentAssignmentSubmission->delete()) {
			$this->Session->setFlash(__('Student assignment submission deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Student assignment submission was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
}
