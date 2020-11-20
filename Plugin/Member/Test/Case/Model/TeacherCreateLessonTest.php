<?php
App::uses('TeacherCreateLesson', 'Member.Model');

/**
 * TeacherCreateLesson Test Case
 */
class TeacherCreateLessonTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.member.teacher_create_lesson',
		'plugin.member.school',
		'plugin.member.class',
		'plugin.member.teacher'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TeacherCreateLesson = ClassRegistry::init('Member.TeacherCreateLesson');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TeacherCreateLesson);

		parent::tearDown();
	}

}
