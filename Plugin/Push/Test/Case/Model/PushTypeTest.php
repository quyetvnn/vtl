<?php
App::uses('PushType', 'Push.Model');

/**
 * PushType Test Case
 */
class PushTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.push.push_type',
		'plugin.push.push_rule',
		'plugin.push.push_type_language'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PushType = ClassRegistry::init('Push.PushType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PushType);

		parent::tearDown();
	}

}
