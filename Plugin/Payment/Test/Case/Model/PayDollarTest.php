<?php
App::uses('PayDollar', 'Payment.Model');

/**
 * PayDollar Test Case
 */
class PayDollarTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.payment.pay_dollar',
		'plugin.payment.member',
		'plugin.payment.administrator',
		'plugin.payment.school',
		'plugin.payment.member_manage_school',
		'plugin.payment.school_class',
		'plugin.payment.school_image',
		'plugin.payment.image_type',
		'plugin.payment.brand_image',
		'plugin.payment.image_type_language',
		'plugin.payment.school_language',
		'plugin.payment.school_subject',
		'plugin.payment.school_subject_language',
		'plugin.payment.school_business_registration',
		'plugin.payment.student_class',
		'plugin.payment.teacher_create_lesson',
		'plugin.payment.student_assignment_submission',
		'plugin.payment.teacher_create_assignment',
		'plugin.payment.teacher_create_assignment_material',
		'plugin.payment.student_assignment_submission_material',
		'plugin.payment.teacher_feedback_assignment_material',
		'plugin.payment.role',
		'plugin.payment.administrators_role',
		'plugin.payment.permission',
		'plugin.payment.roles_permission'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PayDollar = ClassRegistry::init('Payment.PayDollar');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PayDollar);

		parent::tearDown();
	}

}
