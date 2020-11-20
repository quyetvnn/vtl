<?php
/**
 * StudentClass Fixture
 */
class StudentClassFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'student_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'student'),
		'school_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'class_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'class_no' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'no of this student in class'),
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
			'student_id' => 1,
			'school_id' => 1,
			'class_id' => 1,
			'class_no' => 1,
			'created' => '2020-04-12 10:21:18',
			'updated' => '2020-04-12 10:21:18',
			'created_by' => 1,
			'updated_by' => 1
		),
	);

}
