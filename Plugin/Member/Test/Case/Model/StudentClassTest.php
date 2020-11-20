<?php
App::uses('StudentClass', 'Member.Model');

/**
 * StudentClass Test Case
 */
class StudentClassTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.member.student_class',
		'plugin.member.student',
		'plugin.member.school',
		'plugin.member.class'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->StudentClass = ClassRegistry::init('Member.StudentClass');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->StudentClass);

		parent::tearDown();
	}

}
