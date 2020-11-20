<?php
App::uses('MemberRole', 'Member.Model');

/**
 * MemberRole Test Case
 */
class MemberRoleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.member.member_role',
		'plugin.member.member',
		'plugin.member.role'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MemberRole = ClassRegistry::init('Member.MemberRole');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MemberRole);

		parent::tearDown();
	}

}
