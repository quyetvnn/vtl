<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * TeacherCreateLesson Model
 *
 * @property School $School
 * @property Class $Class
 * @property Teacher $Teacher
 */
class TeacherCreateLesson extends MemberAppModel {

	public $actsAs = array('Containable');
	// The Associations below have been created with all possible keys, those that are not needed can be removed

	public $duration_hours = array(
		0 => 0,
		1 => 1,
		2 => 2,
        3 => 3,
		4 => 4,
		5 => 5,
		6 => 6,
		7 => 7,
		8 => 8,
	);

	public $duration_minutes = array(
		0 => 0,
		5 => 5,
		10 => 10,
        15 => 15,
		20 => 20,
		25 => 25,
		30 => 30,
		35 => 35,
		40 => 40,
		45 => 45,
		50 => 50,
		55 => 55,
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'SchoolSubject' => array(
			'className' => 'School.SchoolSubject',
			'foreignKey' => 'subject_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'School' => array(
			'className' => 'School.School',
			'foreignKey' => 'school_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Teacher' => array(
			'className' => 'Member.Member',
			'foreignKey' => 'teacher_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	public $hasMany = array(
		
		'StudentAssignmentSubmission' => array(
			'className' => 'Member.StudentAssignmentSubmission',
			'foreignKey' => 'teacher_create_assignment_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'TeacherLessonsParticipant' => array(
			'className' => 'Member.TeacherLessonsParticipant',
			'foreignKey' => 'lesson_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

	public function get_teacher_lesson($member_id, $language) {
		$obj_School = ClassRegistry::init('School.School');
		$temp = $this->find('all', array(
			'conditions' => array(
				'TeacherCreateLesson.enabled' => true,
				'TeacherCreateLesson.end_time >= ' => date('Y-m-d H:i:s'),
				'YEAR(TeacherCreateLesson.start_time)' 	=> date('Y'),
				'MONTH(TeacherCreateLesson.start_time)' => date('m'),
				'DAY(TeacherCreateLesson.start_time)' 	=> date('d'),
				'School.status' 	=>array_search('Normal', $obj_School->status),
				'OR' => array(
					array('TeacherCreateLesson.teacher_id' => $member_id),
					array('TeacherCreateLesson.list_teacher LIKE' => '%"' . $member_id . '"%'),
				),
			),
			'contain' => array(
				'SchoolSubject' => array(
					'fields' => array(
						'SchoolSubject.id',
					),
					'SchoolSubjectLanguage' => array(
						'fields' => array(
							'SchoolSubjectLanguage.*',
						),
						'conditions' => array(
							'SchoolSubjectLanguage.alias' => $language,
						),
					),
				),
				'Teacher' => array(
					'fields' => array(
						'Teacher.id',
					),
					'MemberLanguage' => array(
						'fields' => array(
							'MemberLanguage.name',
						),
						'conditions' => array(
							'MemberLanguage.alias' => $language,
						),
					)
				),
				'School' => array(
					'SchoolImage' => array(),
					'SchoolLanguage' => array(
						'fields' => array(
							'SchoolLanguage.name',
						),
						'conditions' => array(
							'SchoolLanguage.alias' => $language,
						),
					),
				),
			),
			'order' => 'TeacherCreateLesson.start_time ASC',
		));

		foreach ($temp as &$val) {

			// get list teacher name
			$json_teacher = $val['TeacherCreateLesson']['list_teacher'];
			if ($json_teacher) {
				$list_teacher = json_decode($json_teacher);
				$obj_MemberLanguage = ClassRegistry::init('Member.MemberLanguage');
				$val['TeacherCreateLesson']['list_teacher_name'] = $obj_MemberLanguage->get_name($list_teacher, $language);
			}

			$json_class = $val['TeacherCreateLesson']['list_class'];
			if ($json_class) {
				$list_class = json_decode($json_class);
				$obj_SchoolClass = ClassRegistry::init('School.SchoolClass');
				$val['TeacherCreateLesson']['list_class_name'] = $obj_SchoolClass->get_name($val['TeacherCreateLesson']['school_id'], $list_class);
			}

			// show active yellow course
			$is_active = false;
			$is_nearly_active = false;


			$current = strtotime($val['TeacherCreateLesson']['start_time']) - strtotime(date('Y-m-d H:i:s'));
			
			
			if ($current <= 3600 && $current > 0 ) {
				$is_nearly_active = true;
			}
	
			$current = strtotime(date('Y-m-d H:i:s'));
			if (strtotime($val['TeacherCreateLesson']['start_time']) <= $current &&
				$current <= strtotime($val['TeacherCreateLesson']['end_time']) ) {
				$is_active = true;
			}

			$val['TeacherCreateLesson']['is_active'] = $is_active;
			$val['TeacherCreateLesson']['is_nearly_active'] = $is_nearly_active;

			$val['TeacherCreateLesson']['start_hour'] = date('H:i', strtotime($val['TeacherCreateLesson']['start_time']));
			$val['TeacherCreateLesson']['end_hour']  =  date('H:i', strtotime($val['TeacherCreateLesson']['end_time']));
		}


		return $temp;
	}

	public function get_student_lesson($member_id, $language) {

		$obj_StudentClasses = ClassRegistry::init('Member.StudentClass');
		$studentClasses = $obj_StudentClasses->find('all', array(
			'fields' => array(
				'StudentClass.school_class_id',
				'StudentClass.school_id',
			),
			'conditions' => array(
				'StudentClass.student_id' => $member_id, 
			),
		));
		$obj_School = ClassRegistry::init('School.School');
		$teacherCreateLessons = $this->find('all', array(
			'fields' => array(
				'TeacherCreateLesson.*',
			),
			'conditions' => array(
				'TeacherCreateLesson.enabled' => true,
				'TeacherCreateLesson.end_time >= ' => date('Y-m-d H:i:s'),
				'YEAR(TeacherCreateLesson.start_time)' 	=> date('Y'),
				'MONTH(TeacherCreateLesson.start_time)' => date('m'),
				'DAY(TeacherCreateLesson.start_time)' 	=> date('d'),
				'School.status' 	=>array_search('Normal', $obj_School->status)
			),
			'contain' => array(
				'SchoolSubject' => array(
					'fields' => array(
						'SchoolSubject.id',
					),
					'SchoolSubjectLanguage' => array(
						'fields' => array(
							'SchoolSubjectLanguage.*',
						),
						'conditions' => array(
							'SchoolSubjectLanguage.alias' => $language,
						),
					),
				),
				'Teacher' => array(
					'fields' => array(
						'Teacher.id',
					),
					'MemberLanguage' => array(
						'fields' => array(
							'MemberLanguage.name',
						),
						'conditions' => array(
							'MemberLanguage.alias' => $language,
						),
					)
				),
				'School' => array(
					'SchoolImage' => array(),
					'SchoolLanguage' => array(
						'fields' => array(
							'SchoolLanguage.name',
						),
						'conditions' => array(
							'SchoolLanguage.alias' => $language,
						),
					),
				),
			),
			'order' => array(
				'TeacherCreateLesson.start_time ASC',
			),
			// 'limit' => 8,
		));

		$result = array();
		foreach($teacherCreateLessons as $val) {
			$is_show = false;
			foreach($studentClasses as $student) {
				$list_class  = $val['TeacherCreateLesson']['list_class'];
				if (!is_null($list_class) && !empty($list_class)) {
					foreach (json_decode($list_class) as $class) {
						if ($class == $student['StudentClass']['school_class_id']) {
							$is_show = true;
						}
					}
				}
			}

			if (!$is_show) {
				continue;
			}

			// get list teacher name
			$json_teacher = $val['TeacherCreateLesson']['list_teacher'];
			if ($json_teacher) {
				$list_teacher = json_decode($json_teacher);
				$obj_MemberLanguage = ClassRegistry::init('Member.MemberLanguage');
				$val['TeacherCreateLesson']['list_teacher_name'] = $obj_MemberLanguage->get_name($list_teacher, $language);
			}

			// show active yellow course
			$is_active = false;
			$is_nearly_active = false;

			$current = strtotime($val['TeacherCreateLesson']['start_time']) - strtotime(date('Y-m-d H:i:s'));
			
			if ($current <= 3600 && $current > 0 ) {
				$is_nearly_active = true;
			}
	
			$current = strtotime(date('Y-m-d H:i:s'));
			if (strtotime($val['TeacherCreateLesson']['start_time']) <= $current &&
				$current <= strtotime($val['TeacherCreateLesson']['end_time']) ) {
				$is_active = true;
			}

			
			$val['TeacherCreateLesson']['is_active'] = $is_active;
			$val['TeacherCreateLesson']['is_nearly_active'] = $is_nearly_active;
			$val['TeacherCreateLesson']['start_hour'] = date('H:i', strtotime($val['TeacherCreateLesson']['start_time']));
			$val['TeacherCreateLesson']['end_hour']  =  date('H:i', strtotime($val['TeacherCreateLesson']['end_time']));
			$result[] = $val;
		}

		return $result;
	}


	public function update_meeting_link($data) {

		$model = array(
			'id' => $data['lesson_id'],
			'meeting' => $data['meeting'],
		);

		if (!$this->save($model)) {
			return false;
		}

		return true;
	}

	public function alert_create_meeting($repeat_no) {

		$result = array();
		$temp = $this->find('all', array(
			'conditions' => array(
				'TeacherCreateLesson.repeat_no' => $repeat_no,
			),
			'fields' => array(
				'TeacherCreateLesson.id',
				'TeacherCreateLesson.start_time',
				'TeacherCreateLesson.end_time',
				'TeacherCreateLesson.lesson_title',
			),
		));

		if ($temp) {

			foreach ($temp as $val) {

				$duration = strtotime($val['TeacherCreateLesson']['end_time']) - strtotime($val['TeacherCreateLesson']['start_time']);

				$start_time = date('Y-m-d\TH:i:s.000', strtotime($val['TeacherCreateLesson']['start_time']));
				$result[] = $this->create_meeting($val['TeacherCreateLesson']['id'], $duration/60, $start_time, $val['TeacherCreateLesson']['lesson_title']);
			}
		}	

		return $result;
	}

	public function get_lesson($id, $language) {
		return $this->find('first', array(
			'conditions' => array(
				'TeacherCreateLesson.id' => $id, 
			),
			'fields' => array(
				'TeacherCreateLesson.*'
			),
			'contain' => array(
				'SchoolSubject' => array(
					'SchoolSubjectLanguage' => array(
						'conditions' => array(
							'SchoolSubjectLanguage.alias' => $language,
						),
					)
				),
				'TeacherLessonsParticipant' => array(
					'Teacher' => array(
						'MemberLanguage' => array(
							'conditions' => array(
								'MemberLanguage.alias' => $language,
							),
						),
					),
					'Student' => array(
						'MemberLanguage' => array(
							'conditions' => array(
								'MemberLanguage.alias' => $language,
							),
						),
					),
					'SchoolsGroup' => array(
						'SchoolsGroupsLanguage' => array(
							'conditions' => array(
								'SchoolsGroupsLanguage.alias' => $language,
							),
						),
					),
				),
			),
		));

	}

	public function get_lesson_info_by_id($id) {
		return $this->find('first', array(
			'conditions' => array(
				'TeacherCreateLesson.id' => $id, 
			),
			'fields' => array(
				'TeacherCreateLesson.*',
				'School.*'
			),
			'joins' => array(
                array(
                    'alias' => 'School',
                    'table' => Environment::read('table_prefix') . 'schools',
                    'type' => 'INNER',
                    'conditions' => array(
						'School.id 	= TeacherCreateLesson.school_id',
                    ),
                ),
            ),
		));
	}

	public function get_time_overlap($language, $start_time, $end_time, $cycle, $frequency, $teacher_id) {
		// $cycle: 0 daily, 1: weekly;
		// $frequency: time

		$result = $this->find('all', array(
			'conditions' => array(
				'OR' => array(
					array('TeacherCreateLesson.teacher_id' => $teacher_id),
					array('TeacherCreateLesson.list_teacher LIKE' => '%"' . $teacher_id . '"%'),
				),
				'TeacherCreateLesson.start_time >=' => date('Y-m-d H:i:s'),
			),
			'fields' => array(
				'TeacherCreateLesson.lesson_title',
				'TeacherCreateLesson.start_time',
				'TeacherCreateLesson.end_time',
				'TeacherCreateLesson.duration_hours',
				'TeacherCreateLesson.display_card_subject',
				'TeacherCreateLesson.duration_minutes' 
			),
			'contain' => array(
				'SchoolSubject' => array(
					'SchoolSubjectLanguage' => array(
						'fields' => array(
							'SchoolSubjectLanguage.name'
						),
						'conditions' => array(
							'SchoolSubjectLanguage.alias' => $language,
						),
					),
				),
			),
		));
		foreach($result as $rel) {

			if ($this->check_time_overlap($rel['TeacherCreateLesson']['start_time'], $rel['TeacherCreateLesson']['end_time'], $start_time, $end_time)) {


				$lesson_title = $rel['TeacherCreateLesson']['lesson_title'];
				if ($rel['TeacherCreateLesson']['display_card_subject'] == 1) {
					$lesson_title = isset($rel['SchoolSubject']['SchoolSubjectLanguage']) ? reset($rel['SchoolSubject']['SchoolSubjectLanguage'])['name'] : array();
				}
	
				return array(
					'status' => true,	// same, duplicate
					'message' => sprintf(__d('member', 'overlap_message'), $lesson_title, $rel['TeacherCreateLesson']['start_time'], $rel['TeacherCreateLesson']['duration_hours'], $rel['TeacherCreateLesson']['duration_minutes']),
						
				);
			}
			$start_time0 	= strtotime($start_time);
			$end_time0 		= strtotime($end_time);

			for ($i = 0; $i < $frequency; $i++) {
				if ($cycle == Environment::read('time.daily')) {
					
					$start_time0 = date('Y-m-d H:i:s', strtotime($start_time0 . '+1 day'));
					$end_time0 	= date('Y-m-d H:i:s', strtotime($end_time0 . '+1 day'));
				
				} elseif ($cycle == Environment::read('time.weekly')) {
					
					$start_time0 = date('Y-m-d H:i:s', strtotime($start_time0 . '+7 day'));
					$end_time0 	= date('Y-m-d H:i:s', strtotime($end_time0 . '+7 day'));
				}

				if ($this->check_time_overlap($rel['TeacherCreateLesson']['start_time'], $rel['TeacherCreateLesson']['end_time'], $start_time0, $end_time0)) {

					$lesson_title = $rel['TeacherCreateLesson']['lesson_title'];
					if ($rel['TeacherCreateLesson']['display_card_subject'] == 1) {
						$lesson_title = isset($rel['SchoolSubject']['SchoolSubjectLanguage']) ? reset($rel['SchoolSubject']['SchoolSubjectLanguage'])['name'] : array();
					}
					return array(
						'status' => true,	// same, duplicate
						'message' => sprintf(__d('member', 'overlap_message'), $lesson_title, $rel['TeacherCreateLesson']['start_time'], $rel['TeacherCreateLesson']['duration_hours'], $rel['TeacherCreateLesson']['duration_minutes']),
					);
				}
			}
		}
		return array(
			'status' => false,	// not duplicate
		);
	}

}
