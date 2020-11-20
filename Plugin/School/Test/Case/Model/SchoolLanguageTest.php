<?php
App::uses('SchoolLanguage', 'School.Model');

/**
 * SchoolLanguage Test Case
 */
class SchoolLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.school.school_language'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SchoolLanguage = ClassRegistry::init('School.SchoolLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SchoolLanguage);

		parent::tearDown();
	}

}
