<?php
App::uses('TeacherClass', 'Member.Model');

/**
 * TeacherClass Test Case
 */
class TeacherClassTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.member.teacher_class',
		'plugin.member.teacher',
		'plugin.member.class',
		'plugin.member.school'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TeacherClass = ClassRegistry::init('Member.TeacherClass');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TeacherClass);

		parent::tearDown();
	}

}
