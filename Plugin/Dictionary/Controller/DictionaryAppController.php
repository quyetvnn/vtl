<?php

App::uses('AppController', 'Controller');

class DictionaryAppController extends AppController {
 
    public function beforeFilter() {
        parent::beforeFilter();
        $this->theme = "CakeAdminLTE";
        $this->layout = "default";
    }
}
