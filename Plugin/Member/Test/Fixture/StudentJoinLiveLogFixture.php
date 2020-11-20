<?php
/**
 * StudentJoinLiveLog Fixture
 */
class StudentJoinLiveLogFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'student_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'teacher_create_lesson_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'school_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'join_day' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created_by' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'updated_by' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'student_id' => 1,
			'teacher_create_lesson_id' => 1,
			'school_id' => 1,
			'join_day' => '2020-06-08 19:18:43',
			'created' => '2020-06-08 19:18:43',
			'created_by' => 1,
			'updated' => '2020-06-08 19:18:43',
			'updated_by' => 1
		),
	);

}
