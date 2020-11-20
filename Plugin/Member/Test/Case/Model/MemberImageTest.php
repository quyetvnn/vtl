<?php
App::uses('MemberImage', 'Member.Model');

/**
 * MemberImage Test Case
 */
class MemberImageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.member.member_image',
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
		'plugin.member.image_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MemberImage = ClassRegistry::init('Member.MemberImage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MemberImage);

		parent::tearDown();
	}

}
