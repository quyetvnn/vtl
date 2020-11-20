<?php
App::uses('InviteMemberHistory', 'Member.Model');

/**
 * InviteMemberHistory Test Case
 */
class InviteMemberHistoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.member.invite_member_history',
		'plugin.member.school',
		'plugin.member.administrator',
		'plugin.member.role',
		'plugin.member.administrators_role',
		'plugin.member.permission',
		'plugin.member.roles_permission'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->InviteMemberHistory = ClassRegistry::init('Member.InviteMemberHistory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->InviteMemberHistory);

		parent::tearDown();
	}

}
