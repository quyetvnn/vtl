<?php

App::uses('AppModel', 'Model');

class MemberAppModel extends AppModel {

    public function set_password($password) {
        return hash('sha256', $password . Environment::read('secret_key'));
    }
    
    public function gen_random_number($digits) {    // $digits: length of key
        return rand(pow(10, $digits-1), pow(10, $digits)-1);
    }
    
}
