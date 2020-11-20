<?php
App::uses('PushAppController', 'Push.Controller');
/**
 * PushRules Controller
 *
 * @property PushRule $PushRule
 * @property PaginatorComponent $Paginator
 */
class PushRulesController extends PushAppController {

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
		$this->PushRule->recursive = 0;

		$this->Paginator->settings = array(
            'order' => array('PushRule.created' => 'DESC')
        );
        $pushRules = $this->paginate();

        $push_type  = $this->PushRule->Push->push_type;
        $status     = $this->PushRule->status;
        $this->set(compact('push_type', 'pushRules', 'status'));
        
       //  $column_cache = json_encode($this->Redis->get_cache('booster_column', '_push_rules'));
       //  $this->set(compact('column_cache'));
	}

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
	public function admin_view($id = null) {
		if (!$this->PushRule->exists($id)) {
			throw new NotFoundException(__d('push', 'invalid_push_rule'));
		}
		$options = array(
			'recursive' => 0, 
			'conditions' => array(
				'PushRule.' . $this->PushRule->primaryKey => $id
            ),
        );
        
        $push_type = $this->PushRule->Push->push_type;
        $pushRule = $this->PushRule->find('first', $options);
        $status     = $this->PushRule->status;

		$this->set(compact('pushRule', 'push_type', 'status'));
	}

/**
 * admin_add method
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
            $data = $this->request->data;

            $dbo = $this->PushRule->getDataSource();
            $dbo->begin();
           
            $this->PushRule->create();
          
            $log_push_data = array();
            $data['PushRule']['push_type'] =  $data['PushRule']['push_type_id'];

			if ($push_rule_save_model = $this->PushRule->save($data)) {

                // log data when add new push
                $params = $this->request->params;
                $log_data = $this->Common->get_log_data_admin();
                
                if (!$this->ObjLog->add_log_admin($log_data, $params, array(), array(), $push_rule_save_model, array())){
                    $this->Session->setFlash('[' . __('log') . ']' . __('data_is_not_saved'), 'flash/error');
                    $dbo->rollback();
                    goto load_data;
                }

                $dbo->commit();
				$this->Session->setFlash(__('saved_succeed'), 'flash/success');
                $this->redirect(array('action' => 'index'));
                
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
        }

        load_data:
		$pushes = $this->PushRule->Push->find('list', array(
            'fields' => array('id'),
            'conditions' => array(
                'Push.enabled' => 1
            ),
        ));

        $pushTypes = $this->PushRule->Push->push_type;
		$this->set(compact('pushes', 'pushTypes'));
	}

/**
 * admin_disable method
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
    public function admin_disable($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        
        $this->PushRule->id = $id;
        if (!$this->PushRule->exists()) {
            throw new NotFoundException(__('invalid_data'));
        }
        $data = array(
            'id' => $id,
            'enabled' => 0,
        );

        if ($this->PushRule->save($data)) {
            $this->Session->setFlash(__('data_is_disabled'), 'flash/success');
            $this->redirect(array('action' => 'index'));
        }
        
        $this->Session->setFlash(__('data_is_not_disabled'), 'flash/error');
        $this->redirect(array('action' => 'index'));
    }
}
