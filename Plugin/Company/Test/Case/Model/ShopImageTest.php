<?php
App::uses('ShopImage', 'Company.Model');

/**
 * ShopImage Test Case
 */
class ShopImageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.company.shop_image',
		'plugin.company.shop',
		'plugin.company.image_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopImage = ClassRegistry::init('Company.ShopImage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopImage);

		parent::tearDown();
	}

}
