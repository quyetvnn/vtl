<?php
App::uses('BrandImage', 'Company.Model');

/**
 * BrandImage Test Case
 */
class BrandImageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.company.brand_image',
		'plugin.company.brand',
		'plugin.company.image_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BrandImage = ClassRegistry::init('Company.BrandImage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BrandImage);

		parent::tearDown();
	}

}
