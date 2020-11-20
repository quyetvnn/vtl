<?php
App::uses('LogTypeLanguage', 'Log.Model');

/**
 * LogTypeLanguage Test Case
 */
class LogTypeLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.log.log_type_language',
		'plugin.log.log_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LogTypeLanguage = ClassRegistry::init('Log.LogTypeLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LogTypeLanguage);

		parent::tearDown();
	}

}
