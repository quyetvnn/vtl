<?php
App::uses('PushRule', 'Push.Model');

/**
 * PushRule Test Case
 */
class PushRuleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.push.push_rule',
		'plugin.push.push',
		'plugin.push.push_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PushRule = ClassRegistry::init('Push.PushRule');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PushRule);

		parent::tearDown();
	}

}
