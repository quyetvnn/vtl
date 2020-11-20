<?php
App::uses('TeacherLessonsSchedulesHistory', 'Member.Model');

/**
 * TeacherLessonsSchedulesHistory Test Case
 */
class TeacherLessonsSchedulesHistoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.member.teacher_lessons_schedules_history',
		'plugin.member.lesson',
		'plugin.member.administrator',
		'plugin.member.member',
		'plugin.member.member_manage_school',
		'plugin.member.school',
		'plugin.member.school_class',
		'plugin.member.school_image',
		'plugin.member.image_type',
		'plugin.member.brand_image',
		'plugin.member.image_type_language',
		'plugin.member.school_language',
		'plugin.member.school_subject',
		'plugin.member.school_subject_language',
		'plugin.member.school_business_registration',
		'plugin.member.student_class',
		'plugin.member.teacher_create_lesson',
		'plugin.member.student_assignment_submission',
		'plugin.member.teacher_create_assignment',
		'plugin.member.teacher_create_assignment_material',
		'plugin.member.student_assignment_submission_material',
		'plugin.member.teacher_feedback_assignment_material',
		'plugin.member.member_image',
		'plugin.member.member_language',
		'plugin.member.member_login_method',
		'plugin.member.member_role',
		'plugin.member.role',
		'plugin.member.role_language',
		'plugin.member.administrators_role',
		'plugin.member.permission',
		'plugin.member.roles_permission'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TeacherLessonsSchedulesHistory = ClassRegistry::init('Member.TeacherLessonsSchedulesHistory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TeacherLessonsSchedulesHistory);

		parent::tearDown();
	}

}
