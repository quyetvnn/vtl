<?php
App::uses('StudentAssignmentSubmission', 'Member.Model');

/**
 * StudentAssignmentSubmission Test Case
 */
class StudentAssignmentSubmissionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.member.student_assignment_submission',
		'plugin.member.student',
		'plugin.member.administrator',
		'plugin.member.school',
		'plugin.member.school_class',
		'plugin.member.school_image',
		'plugin.member.image_type',
		'plugin.member.brand_image',
		'plugin.member.image_type_language',
		'plugin.member.school_language',
		'plugin.member.school_subject',
		'plugin.member.school_subject_language',
		'plugin.member.student_class',
		'plugin.member.member',
		'plugin.member.member_image',
		'plugin.member.member_language',
		'plugin.member.member_login_method',
		'plugin.member.login_method',
		'plugin.member.member_role',
		'plugin.member.role',
		'plugin.member.administrators_role',
		'plugin.member.permission',
		'plugin.member.roles_permission',
		'plugin.member.teacher_create_lesson',
		'plugin.member.teacher_create_lesson_assignment'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->StudentAssignmentSubmission = ClassRegistry::init('Member.StudentAssignmentSubmission');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->StudentAssignmentSubmission);

		parent::tearDown();
	}

}
