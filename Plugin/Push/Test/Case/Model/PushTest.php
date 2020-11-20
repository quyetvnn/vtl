<?php
App::uses('Push', 'Push.Model');

/**
 * Push Test Case
 */
class PushTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.push.push',
		'plugin.push.company',
		'plugin.push.section',
		'plugin.push.push_method',
		'plugin.push.tier',
		'plugin.push.gender',
		'plugin.push.age',
		'plugin.push.district',
		'plugin.push.push_rule',
		'plugin.push.member',
		'plugin.push.members_push'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Push = ClassRegistry::init('Push.Push');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Push);

		parent::tearDown();
	}

}
