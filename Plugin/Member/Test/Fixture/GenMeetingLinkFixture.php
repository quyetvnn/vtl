<?php
/**
 * GenMeetingLink Fixture
 */
class GenMeetingLinkFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'gen_meeting_link';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'params' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'type' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => '0: insert, 1: add: 2 update'),
		'enabled' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => '1: enabled, 0: disabled'),
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
			'params' => 'Lorem ipsum dolor sit amet',
			'type' => 1,
			'enabled' => 1,
			'created' => '2020-08-03 18:06:28',
			'updated' => '2020-08-03 18:06:28',
			'created_by' => 1,
			'updated_by' => 1
		),
	);

}
