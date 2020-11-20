<?php
App::uses('CreditTypeLanguage', 'Credit.Model');

/**
 * CreditTypeLanguage Test Case
 */
class CreditTypeLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.credit.credit_type_language',
		'plugin.credit.credit_type',
		'plugin.credit.administrator',
		'plugin.credit.school',
		'plugin.credit.member',
		'plugin.credit.member_manage_school',
		'plugin.credit.member_image',
		'plugin.credit.image_type',
		'plugin.credit.brand_image',
		'plugin.credit.image_type_language',
		'plugin.credit.member_language',
		'plugin.credit.member_login_method',
		'plugin.credit.login_method',
		'plugin.credit.member_role',
		'plugin.credit.role',
		'plugin.credit.administrators_role',
		'plugin.credit.permission',
		'plugin.credit.roles_permission',
		'plugin.credit.school_class',
		'plugin.credit.school_image',
		'plugin.credit.school_language',
		'plugin.credit.school_subject',
		'plugin.credit.school_subject_language',
		'plugin.credit.school_business_registration',
		'plugin.credit.student_class',
		'plugin.credit.teacher_create_lesson',
		'plugin.credit.student_assignment_submission',
		'plugin.credit.teacher_create_assignment',
		'plugin.credit.teacher_create_assignment_material',
		'plugin.credit.student_assignment_submission_material',
		'plugin.credit.teacher_feedback_assignment_material'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CreditTypeLanguage = ClassRegistry::init('Credit.CreditTypeLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CreditTypeLanguage);

		parent::tearDown();
	}

}
