<?php
	App::uses('ClassRegistry', 'Utility');
	App::uses('CakeTime', 'Utility');
	App::uses('ComponentCollection', 'Controller');

    date_default_timezone_set('Asia/Hong_Kong');
    
    // 0 2 * * * cd /Applications/XAMPP/htdocs/all4learn && Console/cake ReportMembersCredits
   
    // daily transaction report for each school (2:00:00)
    class ReportMembersCreditsv2Shell extends AppShell {
       
        public $uses = array('School.School', 'Member.MembersCredit', 'Member.MemberManageSchool');
        public $log_module = "ReportMembersCredits";

        public function startup() {
            $collection = new ComponentCollection();
            $this->ExcelSpout = $collection->load('ExcelSpout');
            $this->Common = $collection->load('Common');
            $this->Email = $collection->load('Email');
        }

        public function send_mail($data, $conditions, $school_id, $school_credit, $school_name, $school_code) {
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

            // save to excel file
            $file_name = $today . '_daily_transaction_summary_' . $school_name . '_' . $school_code . '.xlsx';
            $path_of_file = WWW_ROOT .'uploads' . DS . 'daily_transaction_summary_report' . DS . $file_name;


            if ($data) {
                $this->save_to_file($conditions, $path_of_file);
            }
          
            // Send mail with attachment;
            foreach ($result_MemberManageSchool as $mms) {
                $send_to =  $mms['Member']['email'];
                if ($send_to && !empty($send_to)) {

                    $data_email['email'] = $send_to;
                    
                    $result_email = array();
                    if ($data) {
                        $result_email = $this->Email->send_attachments($send_to, $title, $template, $data_email, $path_of_file); // send mail attachment failed because wrong attachment file
                    } else {
                        $result_email = $this->Email->send($send_to, $title, $template, $data_email);
                    }

                    if ($result_email['status']) {
                        CakeLog::write($this->log_module, __d('member', 'send_mail_succeed') . " " . $send_to);

                    } else {
                        CakeLog::write($this->log_module, $result_email['message'] . " " . $send_to);
                        $status  = false;
                        $send_failed[] = $send_to;
                    }
                }  
            }
            // ALTER TABLE `booster_member_login_methods` ADD `display_name` VARCHAR(255) NULL COMMENT 'nick_name' AFTER `token`;

            // // send to system admin
            $send_to =  Environment::read('all4learn.email');
            if ($send_to && !empty($send_to)) {
                
                $data_email['email'] = $send_to;

                if ($data) {
                    $result_email = $this->Email->send_attachments($send_to, $title, $template, $data_email, $path_of_file);
                } else {
                    $result_email = $this->Email->send($send_to, $title, $template, $data_email);
                }
            
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

        public function save_to_file($conditions, $path_of_file) {
            $excel_readable_header = array(
                "No",
                "Credit Type / 類型",
                "Payment Ref / 支付收據",
                "Credit / 充值",
                "Remark / 備註",
                "Created / 創建時間"
            );

            $limit = 2000;
            $this->ExcelSpout->setup_export_excel($excel_readable_header, 'Member.MembersCredit', 
                array(), $conditions, $limit, $path_of_file, 'zho');
           
            return true;
        }
        
        public function main() {
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

                if ($school['School']['id'] != 22) {
                    continue;
                }

                $result_MembersCredit = $this->MembersCredit->get_list($school['School']['id'], $previous_date,  $language);

                $conditions = array(
                    'MembersCredit.school_id' 		=> $school['School']['id'],
                    'YEAR(MembersCredit.created)' 	=> date('Y', strtotime($previous_date)),
                    'MONTH(MembersCredit.created)' 	=> date('m', strtotime($previous_date)),
                    'DAY(MembersCredit.created)' 	=> date('d', strtotime($previous_date)),
                );
                // send mail
                $result_SendEmail = $this->send_mail($result_MembersCredit, $conditions, $school['School']['id'], $school['School']['credit'], reset($school['SchoolLanguage'])['name'], $school['School']['school_code']);  
                if (!$result_SendEmail['status']) {
                    $this->out('Send mail failed: ' . json_encode($result_SendEmail['send_failed']));
                }
            }
 
            end_cronjob:
            $this->out('Execute Reports Members Credits successfully!');
        }
    }
