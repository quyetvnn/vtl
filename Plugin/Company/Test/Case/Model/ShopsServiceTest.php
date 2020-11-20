<?php
App::uses('ShopsService', 'Company.Model');

/**
 * ShopsService Test Case
 */
class ShopsServiceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.company.shops_service',
		'plugin.company.shop',
		'plugin.company.service'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopsService = ClassRegistry::init('Company.ShopsService');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopsService);

		parent::tearDown();
	}

}
