<?php
App::uses('SchoolBusinessRegistration', 'School.Model');

/**
 * SchoolBusinessRegistration Test Case
 */
class SchoolBusinessRegistrationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.school.school_business_registration',
		'plugin.school.school',
		'plugin.school.administrator',
		'plugin.school.role',
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
		$this->SchoolBusinessRegistration = ClassRegistry::init('School.SchoolBusinessRegistration');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SchoolBusinessRegistration);

		parent::tearDown();
	}

}
