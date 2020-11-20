<?php
App::uses('ImageType', 'Dictionary.Model');

/**
 * ImageType Test Case
 */
class ImageTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dictionary.image_type',
		'plugin.dictionary.brand_image',
		'plugin.dictionary.image_type_language',
		'plugin.dictionary.menu_image',
		'plugin.dictionary.payment_method_image',
		'plugin.dictionary.promotion_image',
		'plugin.dictionary.shop_image'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ImageType = ClassRegistry::init('Dictionary.ImageType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ImageType);

		parent::tearDown();
	}

}
