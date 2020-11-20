<?php
App::uses('Administrator', 'Administration.Model');

/**
 * Administrator Test Case
 */
class AdministratorTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.administration.administrator',
		'plugin.administration.backend_log',
		'plugin.administration.role',
		'plugin.administration.administrators_role'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Administrator = ClassRegistry::init('Administration.Administrator');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Administrator);

		parent::tearDown();
	}

}
