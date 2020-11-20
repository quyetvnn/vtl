<?php
App::uses('CurrencyLanguage', 'Dictionary.Model');

/**
 * CurrencyLanguage Test Case
 */
class CurrencyLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dictionary.currency_language',
		'plugin.dictionary.currency'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CurrencyLanguage = ClassRegistry::init('Dictionary.CurrencyLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CurrencyLanguage);

		parent::tearDown();
	}

}
