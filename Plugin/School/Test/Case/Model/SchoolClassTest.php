<?php
App::uses('SchoolClass', 'School.Model');

/**
 * SchoolClass Test Case
 */
class SchoolClassTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.school.school_class',
		'plugin.school.school'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SchoolClass = ClassRegistry::init('School.SchoolClass');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SchoolClass);

		parent::tearDown();
	}

}
