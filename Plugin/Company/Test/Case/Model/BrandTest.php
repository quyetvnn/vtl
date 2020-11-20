<?php
App::uses('Brand', 'Company.Model');

/**
 * Brand Test Case
 */
class BrandTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.company.brand',
		'plugin.company.company',
		'plugin.company.administrator',
		'plugin.company.brand_image',
		'plugin.company.brand_language',
		'plugin.company.menu',
		'plugin.company.point_scheme',
		'plugin.company.promotion',
		'plugin.company.shop',
		'plugin.company.shops_currency',
		'plugin.company.shops_payment'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Brand = ClassRegistry::init('Company.Brand');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Brand);

		parent::tearDown();
	}

}
