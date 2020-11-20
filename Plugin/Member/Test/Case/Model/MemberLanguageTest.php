<?php
App::uses('MemberLanguage', 'Member.Model');

/**
 * MemberLanguage Test Case
 */
class MemberLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.member.member_language',
		'plugin.member.member'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MemberLanguage = ClassRegistry::init('Member.MemberLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MemberLanguage);

		parent::tearDown();
	}

}
