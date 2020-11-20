<?php
App::uses('LogType', 'Log.Model');

/**
 * LogType Test Case
 */
class LogTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.log.log_type',
		'plugin.log.log_type_language'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LogType = ClassRegistry::init('Log.LogType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LogType);

		parent::tearDown();
	}

}
