<?php
App::uses('PushHistory', 'Push.Model');

/**
 * PushHistory Test Case
 */
class PushHistoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.push.push_history',
		'plugin.push.push',
		'plugin.push.administrator',
		'plugin.push.company',
		'plugin.push.company_language',
		'plugin.push.role',
		'plugin.push.administrators_role',
		'plugin.push.permission',
		'plugin.push.roles_permission',
		'plugin.push.push_rule'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PushHistory = ClassRegistry::init('Push.PushHistory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PushHistory);

		parent::tearDown();
	}

}
