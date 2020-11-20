<?php
App::uses('AdministratorsRole', 'Administration.Model');

/**
 * AdministratorsRole Test Case
 */
class AdministratorsRoleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.administration.administrators_role',
		'plugin.administration.administrator',
		'plugin.administration.role'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AdministratorsRole = ClassRegistry::init('Administration.AdministratorsRole');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AdministratorsRole);

		parent::tearDown();
	}

}
