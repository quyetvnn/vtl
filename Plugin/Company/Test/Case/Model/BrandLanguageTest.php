<?php
App::uses('BrandLanguage', 'Company.Model');

/**
 * BrandLanguage Test Case
 */
class BrandLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.company.brand_language',
		'plugin.company.brand'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BrandLanguage = ClassRegistry::init('Company.BrandLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BrandLanguage);

		parent::tearDown();
	}

}
