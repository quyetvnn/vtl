<?php
App::uses('MemberManageSchool', 'Member.Model');

/**
 * MemberManageSchool Test Case
 */
class MemberManageSchoolTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.member.member_manage_school',
		'plugin.member.school',
		'plugin.member.administrator',
		'plugin.member.role',
		'plugin.member.administrators_role',
		'plugin.member.permission',
		'plugin.member.roles_permission',
		'plugin.member.member'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MemberManageSchool = ClassRegistry::init('Member.MemberManageSchool');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MemberManageSchool);

		parent::tearDown();
	}

}
