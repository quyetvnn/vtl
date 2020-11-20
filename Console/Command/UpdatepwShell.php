<?php
	App::uses('ClassRegistry', 'Utility');
	App::uses('CakeTime', 'Utility');
	App::uses('ComponentCollection', 'Controller');

	date_default_timezone_set('Asia/Hong_Kong');
    // This cronjob after 5 minutes will auto call and check table PushRule, check and run push to device

    class UpdatepwShell extends AppShell {
       
        public $uses = array('Member.Member', 'Member.MemberLoginMethod');
        public $log_module = "HelloShell";

        public function startup() {
            $collection = new ComponentCollection();
            //$this->Common = $collection->load('Common');
            //$this->Notification = $collection->load('Notification');
        }

        public function main() {

           // $obj_Member = ClassRegistry::init('Member.Member');
            $data_Member =  $this->Member->find('all', array(
                'fields' => array('Member.*'),
            ));
           
            
            // foreach ($data_Member as &$member) {
            //     $member['Member']['password'] = $this->Member->set_password($member['Member']['current_password']);
            // }

            if (!$this->Member->saveAll($data_Member)) {
                $this->out('failed to save Member');
                goto  data;
            }
        
            $data_MemberLoginMethod =  $this->MemberLoginMethod->find('all', array(
                'fields' => array('MemberLoginMethod.*'),
            ));
            foreach ($data_MemberLoginMethod as &$member) {
                $member['MemberLoginMethod']['password'] = $this->Member->set_password($member['MemberLoginMethod']['current_password']);
            }
            if (!$this->MemberLoginMethod->saveAll($data_MemberLoginMethod)) {
                $this->out('failed to save Member Login Method');
                goto  data;
            }
           
            data: 
            $this->out('done');
        }
    }
