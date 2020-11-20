<?php
App::uses('ShopsCurrency', 'Company.Model');

/**
 * ShopsCurrency Test Case
 */
class ShopsCurrencyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.company.shops_currency',
		'plugin.company.brand',
		'plugin.company.shop',
		'plugin.company.currency'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopsCurrency = ClassRegistry::init('Company.ShopsCurrency');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopsCurrency);

		parent::tearDown();
	}

}
