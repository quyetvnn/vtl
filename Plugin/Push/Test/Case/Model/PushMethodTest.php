<?php
App::uses('PushMethod', 'Push.Model');

/**
 * PushMethod Test Case
 */
class PushMethodTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.push.push_method',
		'plugin.push.push_method_language',
		'plugin.push.push'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PushMethod = ClassRegistry::init('Push.PushMethod');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PushMethod);

		parent::tearDown();
	}

}
