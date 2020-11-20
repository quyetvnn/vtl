<?php
App::uses('Shop', 'Company.Model');

/**
 * Shop Test Case
 */
class ShopTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.company.shop',
		'plugin.company.brand',
		'plugin.company.menu',
		'plugin.company.point_scheme',
		'plugin.company.promotion',
		'plugin.company.shop_image',
		'plugin.company.shop_language',
		'plugin.company.currency',
		'plugin.company.shops_currency'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Shop = ClassRegistry::init('Company.Shop');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Shop);

		parent::tearDown();
	}

}
