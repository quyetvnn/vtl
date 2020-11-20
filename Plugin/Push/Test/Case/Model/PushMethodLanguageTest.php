<?php
App::uses('PushMethodLanguage', 'Push.Model');

/**
 * PushMethodLanguage Test Case
 */
class PushMethodLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.push.push_method_language',
		'plugin.push.push_method'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PushMethodLanguage = ClassRegistry::init('Push.PushMethodLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PushMethodLanguage);

		parent::tearDown();
	}

}
