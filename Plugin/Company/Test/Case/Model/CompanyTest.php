<?php
App::uses('Company', 'Company.Model');

/**
 * Company Test Case
 */
class CompanyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.company.company',
		'plugin.company.administrator',
		'plugin.company.brand',
		'plugin.company.company_language',
		'plugin.company.point_scheme',
		'plugin.company.push',
		'plugin.company.tier'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Company = ClassRegistry::init('Company.Company');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Company);

		parent::tearDown();
	}

}
