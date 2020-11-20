<?php
/**
 * TeacherLessonsParticipant Fixture
 */
class TeacherLessonsParticipantFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'lesson_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'group_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'teacher_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'student_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'enabled' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created_by' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
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
			'lesson_id' => 1,
			'group_id' => 1,
			'teacher_id' => 1,
			'student_id' => 1,
			'enabled' => 1,
			'created' => '2020-07-31 11:21:18',
			'updated' => '2020-07-31 11:21:18',
			'created_by' => 1,
			'updated_by' => 1
		),
	);

}
