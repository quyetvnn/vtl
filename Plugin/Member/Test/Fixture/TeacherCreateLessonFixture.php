<?php
/**
 * TeacherCreateLesson Fixture
 */
class TeacherCreateLessonFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'school_id' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'class_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'teacher_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'start_time' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'duration' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'meeting' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created_by' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'updated_by' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
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
			'school_id' => 'Lorem ipsum dolor sit amet',
			'class_id' => 1,
			'teacher_id' => 1,
			'start_time' => '2020-04-12 10:21:38',
			'duration' => 1,
			'meeting' => 'Lorem ipsum dolor sit amet',
			'created' => '2020-04-12 10:21:38',
			'created_by' => 1,
			'updated' => '2020-04-12 10:21:38',
			'updated_by' => 1
		),
	);

}
