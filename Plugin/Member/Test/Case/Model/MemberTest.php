<?php
App::uses('Member', 'Member.Model');

/**
 * Member Test Case
 */
class MemberTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.member.member',
		'plugin.member.member_langugage',
		'plugin.member.member_login_method',
		'plugin.member.member_role'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Member = ClassRegistry::init('Member.Member');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Member);

		parent::tearDown();
	}

}
