<?php
/**
 * TeacherClass Fixture
 */
class TeacherClassFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'teacher_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'class_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'school_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'teacher_id' => 1,
			'class_id' => 1,
			'school_id' => 1
		),
	);

}
