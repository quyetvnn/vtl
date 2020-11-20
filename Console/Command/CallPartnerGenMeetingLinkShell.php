<?php
	App::uses('ClassRegistry', 'Utility');
	App::uses('CakeTime', 'Utility');
	App::uses('ComponentCollection', 'Controller');

	date_default_timezone_set('Asia/Hong_Kong');
   
    // create meeting link (auto gen)
    class CallPartnerGenMeetingLinkShell extends AppShell {
       
        public $uses = array('Member.TeacherCreateLesson', 'Member.GenMeetingLink');
        public $log_module = "CallPartnerGenMeetingLink";

        public function startup() {
            $collection = new ComponentCollection();
            $this->Common = $collection->load('Common');
        }

        public function main() {

            $db = $this->GenMeetingLink->getDataSource();
            $db->begin();
            
            // get from table and call link
            $result = $this->GenMeetingLink->get_obj();

            if (!$result) { // not found -> completed CRON
                goto data;
            }

            $params = json_decode($result['GenMeetingLink']['params'], true);

            switch($result['GenMeetingLink']['type']) {       // 0: insert, 1: edit, 2: delete

                case 0:     // insert
                    $unqid_no = $params['unqid_no'];
                    $val = $this->TeacherCreateLesson->alert_create_meeting($unqid_no);
				    CakeLog::write($this->log_module, "INSERT | unqid_no = " . $unqid_no . " " .  json_encode($val));
                    break;

                case 1:     // edit
                    $lesson_id = $params['lesson_id'];
				    $val = $this->TeacherCreateLesson->update_meeting($lesson_id, $params['duration'], $params['start_time'],  $params['lesson_title']);
				    CakeLog::write($this->log_module, "UPDATE id = " . $lesson_id  . json_encode($val));
                    break;

                case 2:     // delete
                    $lesson_id = $params['lesson_id'];
                    $val = $this->TeacherCreateLesson->delete_meeting($lesson_id);
			        CakeLog::write($this->log_module, "DELETE: id = " . $lesson_id . " | " . json_encode($val));
                    break;
            }

            // update cron
            $this->GenMeetingLink->id = $result['GenMeetingLink']['id'];
            $this->GenMeetingLink->saveField('enabled',  false);

            $db->commit();
            data: 
            $this->out('Gen Meeting link COMPLETE');
            CakeLog::write($this->log_module, "Call Partner Gen Meeting link COMPLETE");
        }
    }
