<?php
/**
 * TeacherLessonsSchedulesHistory Fixture
 */
class TeacherLessonsSchedulesHistoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'lesson_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'teacher_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'student_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'start_time' => array('type' => 'time', 'null' => true, 'default' => null),
		'end_time' => array('type' => 'time', 'null' => true, 'default' => null),
		'duration_hour' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'duration_minute' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'attend' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'paid' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'attend_start' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'attend_end' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'enabled' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created_by' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'updated_by' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB', 'comment' => 'This table will store all schedule of each student, teacher, we cannot store group because the group will change anytime')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'lesson_id' => 1,
			'teacher_id' => 1,
			'student_id' => 1,
			'date' => '2020-07-31 11:22:01',
			'start_time' => '11:22:01',
			'end_time' => '11:22:01',
			'duration_hour' => 1,
			'duration_minute' => 1,
			'attend' => 1,
			'paid' => 1,
			'attend_start' => '2020-07-31 11:22:01',
			'attend_end' => '2020-07-31 11:22:01',
			'enabled' => 1,
			'created' => '2020-07-31 11:22:01',
			'updated' => '2020-07-31 11:22:01',
			'created_by' => 1,
			'updated_by' => 1
		),
	);

}
