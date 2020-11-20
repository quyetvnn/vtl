<?php
	App::uses('ClassRegistry', 'Utility');
	App::uses('CakeTime', 'Utility');
	App::uses('ComponentCollection', 'Controller');

    date_default_timezone_set('Asia/Hong_Kong');
    
    // 0 2 * * * cd /Applications/XAMPP/htdocs/all4learn && Console/cake ReportMembersCredits
   
    // daily transaction report for each school (2:00:00)
    class ReportMembersCreditsShell extends AppShell {
       
        public $uses = array('School.School', 'Member.MembersCredit', 'Member.MemberManageSchool');
        public $log_module = "ReportMembersCredits";

        public function startup() {
            $collection = new ComponentCollection();
            $this->Common = $collection->load('Common');
            $this->Email = $collection->load('Email');
        }

        public function send_mail($data, $school_id, $school_credit, $school_name, $school_code) {
            // send to school admin + A4Learn system admin
            $status = true;
            $send_failed = array();
            $template = 'report_members_credit';

            if (Environment::is('development') && $school_id != 22) {
                return array(
                    'status' =>  $status,
                    'send_failed' =>  $send_failed,
                );
            }

            // get school admin email
            $result_MemberManageSchool = $this->MemberManageSchool->get_obj_by_school_id($school_id);
            $today =  date('Y-m-d', strtotime(date('Y-m-d') . "-1 day"));

            $data_email = array(
                'today'         => $today,
                'school_name'   => $school_name,
                'school_code'   => $school_code,
                'data'          => $data,
                'school_credit' => $school_credit,
            );

            $title = "";
            if (Environment::is('development')) {
                $title = "[Development]";

            } elseif (Environment::is('demo')) {
                $title = "[Demo]";
            
            }

            $title = $title . "Daily Transaction Summary for: " . $school_name . ' (' . $school_code . ") Date: " . $today . "(00:00:00 - 23:59:59)";

            foreach ($result_MemberManageSchool as $mms) {
                $send_to =  $mms['Member']['email'];
                if ($send_to && !empty($send_to)) {

                    $data_email['email'] = $send_to;
                    // $path_of_file = WWW_ROOT .'uploads' . DS . 'daily_transaction_summary_report' . DS . 'jrgps.xlsx';
                    // $result_email = $this->Email->send_attachments($send_to, $title , $template, $data_email, $path_of_file);
                    $result_email = $this->Email->send($send_to, $title , $template, $data_email);
                    
                    if ($result_email['status']) {
                        CakeLog::write($this->log_module, __d('member', 'send_mail_succeed') . " " . $send_to);

                    } else {
                        CakeLog::write($this->log_module, $result_email['message'] . " " . $send_to);
                        $status  = false;
                        $send_failed[] = $send_to;
                    }
                }  
            }

            // send to system admin
            $send_to =  Environment::read('all4learn.email');
            if ($send_to && !empty($send_to)) {
                
                $data_email['email'] = $send_to;
                $result_email = $this->Email->send($send_to, $title , $template, $data_email);
            
                if ($result_email['status']) {
                    CakeLog::write($this->log_module, __d('member', 'send_mail_succeed') . " " . $send_to);

                } else {
                    CakeLog::write($this->log_module, $result_email['message'] . " " . $send_to);
                    $status  = false;
                    $send_failed[] = $send_to;
                }
            }

            return array(
                'status' => $status,
                'send_failed' =>  $send_failed,
            );
        }

        public function main() {

            return;
            
            $language = 'zho';

            // temporarily using the "development" DB config
            Environment::set('development');		

            // set new setting if have
            if (!$this->set_enviroment_language()) {
                goto end_cronjob;
            }

            // Get number of school all system
            $result_School = $this->School->get_full_obj($language);
          
            // conditions for gen report
            $previous_date = date('Y-m-d', strtotime(date('Y-m-d') . "-1 day"));

            foreach ($result_School as $school) {
                // get previous daily transaction of members credits

                $result_MembersCredit = $this->MembersCredit->get_list($school['School']['id'], $previous_date,  $language);
                
                // send mail
                $result_SendEmail = $this->send_mail($result_MembersCredit, $school['School']['id'], $school['School']['credit'], reset($school['SchoolLanguage'])['name'], $school['School']['school_code']);  
                if (!$result_SendEmail['status']) {
                    $this->out('Send mail failed: ' . json_encode($result_SendEmail['send_failed']));
                }
            }
 
            end_cronjob:
            $this->out('Execute Reports Members Credits successfully!');
        }
    }
