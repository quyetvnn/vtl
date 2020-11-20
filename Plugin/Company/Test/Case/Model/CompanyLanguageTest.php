<?php
App::uses('CompanyLanguage', 'Company.Model');

/**
 * CompanyLanguage Test Case
 */
class CompanyLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.company.company_language',
		'plugin.company.company'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CompanyLanguage = ClassRegistry::init('Company.CompanyLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CompanyLanguage);

		parent::tearDown();
	}

}
