<?php
App::uses('PushAppController', 'Push.Controller');
/**
 * Pushes Controller
 *
 * @property Push $Push
 * @property PaginatorComponent $Paginator
 */
class PushesController extends PushAppController {

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
	public function admin_index() 
	{
		
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
	
	}

    /**
     * admin_add method
     *
     * @return void
     */
	public function admin_add() {
        
    }

}
