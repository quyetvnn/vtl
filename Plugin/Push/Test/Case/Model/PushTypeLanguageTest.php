<?php
App::uses('PushTypeLanguage', 'Push.Model');

/**
 * PushTypeLanguage Test Case
 */
class PushTypeLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.push.push_type_language',
		'plugin.push.push_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PushTypeLanguage = ClassRegistry::init('Push.PushTypeLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PushTypeLanguage);

		parent::tearDown();
	}

}
