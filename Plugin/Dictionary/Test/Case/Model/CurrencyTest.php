<?php
App::uses('Currency', 'Dictionary.Model');

/**
 * Currency Test Case
 */
class CurrencyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dictionary.currency',
		'plugin.dictionary.coupon',
		'plugin.dictionary.currency_language',
		'plugin.dictionary.shop',
		'plugin.dictionary.shops_currency'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Currency = ClassRegistry::init('Dictionary.Currency');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Currency);

		parent::tearDown();
	}

}
