<?php
App::uses('SchoolImage', 'School.Model');

/**
 * SchoolImage Test Case
 */
class SchoolImageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.school.school_image'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SchoolImage = ClassRegistry::init('School.SchoolImage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SchoolImage);

		parent::tearDown();
	}

}
