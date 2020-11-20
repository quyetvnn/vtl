<?php
App::uses('MemberLoginMethod', 'Member.Model');

/**
 * MemberLoginMethod Test Case
 */
class MemberLoginMethodTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.member.member_login_method',
		'plugin.member.member',
		'plugin.member.login_method'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MemberLoginMethod);

		parent::tearDown();
	}

}
