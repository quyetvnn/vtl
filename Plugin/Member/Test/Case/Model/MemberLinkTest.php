<?php
App::uses('MemberLink', 'Member.Model');

/**
 * MemberLink Test Case
 */
class MemberLinkTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.member.member_link',
		'plugin.member.member',
		'plugin.member.administrator',
		'plugin.member.company',
		'plugin.member.company_language',
		'plugin.member.push',
		'plugin.member.vocabulary',
		'plugin.member.vocabulary_language',
		'plugin.member.push_rule',
		'plugin.member.push_language',
		'plugin.member.role',
		'plugin.member.administrators_role',
		'plugin.member.permission',
		'plugin.member.roles_permission',
		'plugin.member.member_login_method'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MemberLink = ClassRegistry::init('Member.MemberLink');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MemberLink);

		parent::tearDown();
	}

}
