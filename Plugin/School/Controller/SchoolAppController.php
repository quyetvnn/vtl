<?php

App::uses('AppController', 'Controller');

class SchoolAppController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->theme = 'CakeAdminLTE';
        $this->layout = 'default';
    }

}
