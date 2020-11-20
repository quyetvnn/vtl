<?php
App::uses('SchoolsGroupsLanguage', 'School.Model');

/**
 * SchoolsGroupsLanguage Test Case
 */
class SchoolsGroupsLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.school.schools_groups_language',
		'plugin.school.group',
		'plugin.school.administrator',
		'plugin.school.member',
		'plugin.school.member_manage_school',
		'plugin.school.school',
		'plugin.school.school_class',
		'plugin.school.school_image',
		'plugin.school.image_type',
		'plugin.school.brand_image',
		'plugin.school.image_type_language',
		'plugin.school.school_language',
		'plugin.school.school_subject',
		'plugin.school.school_subject_language',
		'plugin.school.school_business_registration',
		'plugin.school.student_class',
		'plugin.school.teacher_create_lesson',
		'plugin.school.student_assignment_submission',
		'plugin.school.teacher_create_assignment',
		'plugin.school.teacher_create_assignment_material',
		'plugin.school.student_assignment_submission_material',
		'plugin.school.teacher_feedback_assignment_material',
		'plugin.school.member_image',
		'plugin.school.member_language',
		'plugin.school.member_login_method',
		'plugin.school.member_role',
		'plugin.school.role',
		'plugin.school.role_language',
		'plugin.school.administrators_role',
		'plugin.school.permission',
		'plugin.school.roles_permission'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SchoolsGroupsLanguage = ClassRegistry::init('School.SchoolsGroupsLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SchoolsGroupsLanguage);

		parent::tearDown();
	}

}
