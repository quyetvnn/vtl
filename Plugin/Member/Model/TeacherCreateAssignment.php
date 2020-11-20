<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * TeacherCreateLessonAssignment Model
 *
 * @property TeacherCreateLesson $TeacherCreateLesson
 */
class TeacherCreateAssignment extends MemberAppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed
	public $actsAs = array('Containable');
		
	/**
	 * belongsTo associations
	 *
	 * @var array
	 */

	public $hasMany = array(
			
		'TeacherCreateAssignmentMaterial' => array(
			'className' => 'Member.TeacherCreateAssignmentMaterial',
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
		'TeacherAssignmentsParticipant' => array(
			'className' => 'Member.TeacherAssignmentsParticipant',
			'foreignKey' => 'assignment_id',
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


	public $belongsTo = array(
		'Teacher' => array(
			'className' => 'Member.Member',
			'foreignKey' => 'teacher_id',
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

		'SchoolClass' => array(
			'className' => 'School.SchoolClass',
			'foreignKey' => 'class_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),

		'SchoolsGroup' => array(
			'className' => 'School.SchoolsGroup',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),

		'SchoolSubject' => array(
			'className' => 'School.SchoolSubject',
			'foreignKey' => 'subject_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	public function get_deadline($id) {
		$result = $this->find('first', array(
			'conditions' => array(
				'TeacherCreateAssignment.id' => $id
			),
			'fields' => array(
				'TeacherCreateAssignment.deadline',
			),
		));

		return $result ? $result['TeacherCreateAssignment']['deadline'] : array();
	}

	public function get_assignment($id, $language, $teacher_id) {
		$obj_School = ClassRegistry::init('School.School');
		$result = $this->find('first', array(
			'conditions' => array(
				'TeacherCreateAssignment.id' => $id,
				'TeacherCreateAssignment.enabled' => true,
				'School.status' => array_search('Normal', $obj_School->status),
			),
			'contain' => array(
				'TeacherAssignmentsParticipant' => array(
					'conditions' => array(
						'TeacherAssignmentsParticipant.teacher_id' => $teacher_id,
					),
					'Teacher' => array(
						'MemberLanguage' => array(
							'conditions' => array(
								'MemberLanguage.alias' => $language,
							),
						),
					),
				),
				'TeacherCreateAssignmentMaterial',
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
				'School' => array(
					'fields' => array(
						'School.id',
					),
					'SchoolLanguage' => array(
						'fields' => array(
							'SchoolLanguage.name',
						),
						'conditions' => array(
							'SchoolLanguage.alias' => $language,
						),
					),
				),
				'SchoolClass' => array(
					'fields' => array(
						'SchoolClass.id',
						'SchoolClass.name'
					)
				)
			),
		));

		return $result;
	}

	public function get_obj($id) {
		$result = $this->find('first', array(
			'conditions' => array(
				'TeacherCreateAssignment.id' => $id
			),
			'fields' => array(
				'TeacherCreateAssignment.*',
			),
		));

		return $result;
	}
	
}
