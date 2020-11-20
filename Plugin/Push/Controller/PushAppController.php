<?php

App::uses('AppController', 'Controller');

class PushAppController extends AppController {
    public function beforeFilter(){
		parent::beforeFilter();
		$this->set('title_for_layout', __('push'));
	}
}
