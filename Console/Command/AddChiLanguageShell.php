<?php
	App::uses('ClassRegistry', 'Utility');
	App::uses('CakeTime', 'Utility');
	App::uses('ComponentCollection', 'Controller');

	date_default_timezone_set('Asia/Hong_Kong');
   
    // auto import languages to DB
    class AddChiLanguageShell extends AppShell {
       
        public $uses = array('Member.MemberLanguage', 'School.SchoolLanguage', 'School.SchoolSubjectLanguage');
        public $log_module = "AddChiLanguageShell";

        public function startup() {
            $collection = new ComponentCollection();
            $this->Common = $collection->load('Common');
        }

        public function main() {

            $db = $this->MemberLanguage->getDataSource();
            $db->begin();
            // member

            $data_MemberLanguage =  $this->MemberLanguage->find('all', array(
                'fields' => array('MemberLanguage.*'),
            ));

            $language = array();
            foreach ($data_MemberLanguage as $val) {
                if ($val['MemberLanguage']['alias'] == 'zho') {
                    $language[] =  array(
                        'first_name' => $val['MemberLanguage']['first_name'],
                        'last_name' => $val['MemberLanguage']['last_name'],
                        'name'      => $val['MemberLanguage']['name'],
                        'member_id' =>  $val['MemberLanguage']['member_id'],
                        'alias'     => 'chi',
                    );
                }
            }
           
            if (!$this->MemberLanguage->saveAll($language)) {
                $db->rollback();
                $this->out('failed to save Member Language');
                goto  data;
            }


            // school
            $data_SchoolLanguage =  $this->SchoolLanguage->find('all', array(
                'fields' => array('SchoolLanguage.*'),
            ));

            $language = array();
            foreach ($data_SchoolLanguage as $val) {
                if ($val['SchoolLanguage']['alias'] == 'zho') {
                    $language[] =  array(
                        'about_us'      => $val['SchoolLanguage']['about_us'],
                        'description'   => $val['SchoolLanguage']['description'],
                        'name'          => $val['SchoolLanguage']['name'],
                        'school_id'     => $val['SchoolLanguage']['school_id'],
                        'alias'         => 'chi',
                    );
                }
            }
           
            if (!$this->SchoolLanguage->saveAll($language)) {
                $db->rollback();
                $this->out('failed to save School Language');
                goto  data;
            }

            // school subject language
            $data_SchoolSubjectLanguage =  $this->SchoolSubjectLanguage->find('all', array(
                'fields' => array('SchoolSubjectLanguage.*'),
            ));

            $language = array();
            foreach ($data_SchoolSubjectLanguage as $val) {
                if ($val['SchoolSubjectLanguage']['alias'] == 'zho') {
                    $language[] =  array(
                        'name'                  => $val['SchoolSubjectLanguage']['name'],
                        'school_subject_id'     => $val['SchoolSubjectLanguage']['school_subject_id'],
                        'alias'                 => 'chi',
                    );
                }
            }
           
            if (!$this->SchoolSubjectLanguage->saveAll($language)) {
                $db->rollback();
                $this->out('failed to save School Subject Language');
                goto  data;
            }

            $db->commit();
            data: 
            $this->out('ADD CHI LANGUAGE COMPLETE');
        }
    }
