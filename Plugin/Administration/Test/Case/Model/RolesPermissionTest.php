<?php
App::uses('RolesPermission', 'Administration.Model');

/**
 * RolesPermission Test Case
 */
class RolesPermissionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.administration.roles_permission',
		'plugin.administration.role',
		'plugin.administration.permission',
		'plugin.administration.aro',
		'plugin.administration.aco'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RolesPermission = ClassRegistry::init('Administration.RolesPermission');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RolesPermission);

		parent::tearDown();
	}

}
