<?php
App::uses('TeacherCreateLessonAssignment', 'Member.Model');

/**
 * TeacherCreateLessonAssignment Test Case
 */
class TeacherCreateLessonAssignmentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.member.teacher_create_lesson_assignment',
		'plugin.member.teacher_create_lesson',
		'plugin.member.administrator',
		'plugin.member.company',
		'plugin.member.company_language',
		'plugin.member.push',
		'plugin.member.vocabulary',
		'plugin.member.vocabulary_language',
		'plugin.member.member',
		'plugin.member.member_image',
		'plugin.member.image_type',
		'plugin.member.brand_image',
		'plugin.member.image_type_language',
		'plugin.member.member_language',
		'plugin.member.member_login_method',
		'plugin.member.login_method',
		'plugin.member.member_role',
		'plugin.member.role',
		'plugin.member.administrators_role',
		'plugin.member.permission',
		'plugin.member.roles_permission',
		'plugin.member.push_rule',
		'plugin.member.push_language'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TeacherCreateLessonAssignment = ClassRegistry::init('Member.TeacherCreateLessonAssignment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TeacherCreateLessonAssignment);

		parent::tearDown();
	}

}
