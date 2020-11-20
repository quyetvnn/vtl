<?php
App::uses('Role', 'Administration.Model');

/**
 * Role Test Case
 */
class RoleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.administration.role',
		'plugin.administration.administrator',
		'plugin.administration.administrators_role',
		'plugin.administration.permission',
		'plugin.administration.aro',
		'plugin.administration.aco',
		'plugin.administration.roles_permission'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Role = ClassRegistry::init('Administration.Role');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Role);

		parent::tearDown();
	}

}
