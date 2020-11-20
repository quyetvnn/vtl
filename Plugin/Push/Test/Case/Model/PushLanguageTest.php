<?php
App::uses('PushLanguage', 'Push.Model');

/**
 * PushLanguage Test Case
 */
class PushLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.push.push_language',
		'plugin.push.push',
		'plugin.push.administrator',
		'plugin.push.company',
		'plugin.push.company_language',
		'plugin.push.role',
		'plugin.push.administrators_role',
		'plugin.push.permission',
		'plugin.push.roles_permission'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PushLanguage = ClassRegistry::init('Push.PushLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PushLanguage);

		parent::tearDown();
	}

}
