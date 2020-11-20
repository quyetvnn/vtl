<?php
App::uses('ShopLanguage', 'Company.Model');

/**
 * ShopLanguage Test Case
 */
class ShopLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.company.shop_language',
		'plugin.company.shop'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopLanguage = ClassRegistry::init('Company.ShopLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopLanguage);

		parent::tearDown();
	}

}
