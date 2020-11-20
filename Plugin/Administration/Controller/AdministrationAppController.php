<?php

App::uses('AppController', 'Controller');

class AdministrationAppController extends AppController {

    public function   beforeFilter() {
        parent::beforeFilter();
        $this->theme = "CakeAdminLTE";
        $this->layout = "default";

        $params = $this->request->params;
        if ($params['action'] == 'admin_logout') {
            setcookie("currentuser", "", time() - 3600, "/");
            return;
        }

        if (isset($_COOKIE['currentuser'])) {

            $current_user = json_decode($_COOKIE['currentuser'], true);
            $this->current_user = $current_user;
            if(isset($current_user['token']) && !empty($current_user['token'])){
                $current_user = $this->get_profile();
                $this->current_user = $current_user;
            }
            
            if(isset($current_user) && !empty($current_user)){
                
                $obj_Administrator = ClassRegistry::init('Administration.Administrator');
                $logged_user = $obj_Administrator->get_admin_user_by_member_email($current_user['username'], $current_user['member_id']);
                if($logged_user['status']==true){
                    $current_admin = $logged_user['params'];
                    $this->Session->write('Administrator.id', $current_admin['id']);
                    $this->Session->write('Administrator.current', $current_admin);
                    if($current_admin['role_school_admin']){
                        $this->redirect(array(
                            'plugin' => 'school',
                            'controller' => 'schools',
                            'action' => 'index',
                            'admin' => true
                        ));
                    }
                }
            }
        }
       
    }
  
}