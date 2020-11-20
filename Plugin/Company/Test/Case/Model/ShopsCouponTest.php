<?php
App::uses('ShopsCoupon', 'Company.Model');

/**
 * ShopsCoupon Test Case
 */
class ShopsCouponTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.company.shops_coupon',
		'plugin.company.coupon',
		'plugin.company.brand',
		'plugin.company.shop'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopsCoupon = ClassRegistry::init('Company.ShopsCoupon');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopsCoupon);

		parent::tearDown();
	}

}
