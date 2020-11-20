<?php
App::uses('RoleLanguage', 'Administration.Model');

/**
 * RoleLanguage Test Case
 */
class RoleLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.administration.role_language',
		'plugin.administration.role',
		'plugin.administration.administrator',
		'plugin.administration.member',
		'plugin.administration.member_manage_school',
		'plugin.administration.school',
		'plugin.administration.school_class',
		'plugin.administration.school_image',
		'plugin.administration.image_type',
		'plugin.administration.brand_image',
		'plugin.administration.image_type_language',
		'plugin.administration.school_language',
		'plugin.administration.school_subject',
		'plugin.administration.school_subject_language',
		'plugin.administration.school_business_registration',
		'plugin.administration.student_class',
		'plugin.administration.teacher_create_lesson',
		'plugin.administration.student_assignment_submission',
		'plugin.administration.teacher_create_assignment',
		'plugin.administration.teacher_create_assignment_material',
		'plugin.administration.student_assignment_submission_material',
		'plugin.administration.teacher_feedback_assignment_material',
		'plugin.administration.member_image',
		'plugin.administration.member_language',
		'plugin.administration.member_login_method',
		'plugin.administration.member_role',
		'plugin.administration.administrators_role'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RoleLanguage = ClassRegistry::init('Administration.RoleLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RoleLanguage);

		parent::tearDown();
	}

}
