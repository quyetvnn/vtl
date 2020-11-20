<?php
App::uses('SchoolsController', 'School.Controller');

/**
 * SchoolsController Test Case
 */
class SchoolsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.school.school',
		'plugin.school.administrator',
		'plugin.school.company',
		'plugin.school.company_language',
		'plugin.school.push',
		'plugin.school.vocabulary',
		'plugin.school.vocabulary_language',
		'plugin.school.member',
		'plugin.school.member_language',
		'plugin.school.member_login_method',
		'plugin.school.login_method',
		'plugin.school.member_role',
		'plugin.school.role',
		'plugin.school.administrators_role',
		'plugin.school.permission',
		'plugin.school.roles_permission',
		'plugin.school.push_rule',
		'plugin.school.push_language',
		'plugin.school.school_class',
		'plugin.school.school_image',
		'plugin.school.school_language',
		'plugin.school.school_subject',
		'plugin.school.student_class',
		'plugin.school.teacher_create_lesson'
	);

/**
 * testAdminIndex method
 *
 * @return void
 */
	public function testAdminIndex() {
		$this->markTestIncomplete('testAdminIndex not implemented.');
	}

/**
 * testAdminView method
 *
 * @return void
 */
	public function testAdminView() {
		$this->markTestIncomplete('testAdminView not implemented.');
	}

/**
 * testAdminAdd method
 *
 * @return void
 */
	public function testAdminAdd() {
		$this->markTestIncomplete('testAdminAdd not implemented.');
	}

/**
 * testAdminEdit method
 *
 * @return void
 */
	public function testAdminEdit() {
		$this->markTestIncomplete('testAdminEdit not implemented.');
	}

/**
 * testAdminDelete method
 *
 * @return void
 */
	public function testAdminDelete() {
		$this->markTestIncomplete('testAdminDelete not implemented.');
	}

}
