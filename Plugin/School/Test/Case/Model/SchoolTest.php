<?php
App::uses('School', 'School.Model');

/**
 * School Test Case
 */
class SchoolTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.school.school',
		'plugin.school.school_class',
		'plugin.school.student_class',
		'plugin.school.teacher_class',
		'plugin.school.teacher_create_lesson'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->School = ClassRegistry::init('School.School');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->School);

		parent::tearDown();
	}

}
