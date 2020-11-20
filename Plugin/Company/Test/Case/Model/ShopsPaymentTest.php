<?php
App::uses('ShopsPayment', 'Company.Model');

/**
 * ShopsPayment Test Case
 */
class ShopsPaymentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.company.shops_payment',
		'plugin.company.brand',
		'plugin.company.shop',
		'plugin.company.payment_method'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopsPayment = ClassRegistry::init('Company.ShopsPayment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopsPayment);

		parent::tearDown();
	}

}
