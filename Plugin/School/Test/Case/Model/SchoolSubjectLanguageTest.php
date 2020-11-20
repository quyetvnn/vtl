<?php
App::uses('SchoolSubjectLanguage', 'school.Model');

/**
 * SchoolSubjectLanguage Test Case
 */
class SchoolSubjectLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.school.school_subject_language',
		'plugin.school.school_subject',
		'plugin.school.administrator',
		'plugin.school.school',
		'plugin.school.school_class',
		'plugin.school.school_image',
		'plugin.school.image_type',
		'plugin.school.brand_image',
		'plugin.school.image_type_language',
		'plugin.school.school_language',
		'plugin.school.student_class',
		'plugin.school.member',
		'plugin.school.member_image',
		'plugin.school.member_language',
		'plugin.school.member_login_method',
		'plugin.school.login_method',
		'plugin.school.member_role',
		'plugin.school.role',
		'plugin.school.administrators_role',
		'plugin.school.permission',
		'plugin.school.roles_permission',
		'plugin.school.teacher_create_lesson',
		'plugin.school.teacher_create_lesson_assignment'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SchoolSubjectLanguage = ClassRegistry::init('school.SchoolSubjectLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SchoolSubjectLanguage);

		parent::tearDown();
	}

}
