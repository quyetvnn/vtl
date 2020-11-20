<?php
/**
 * PushHistory Fixture
 */
class PushHistoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'push_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'push_rule_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'total_push_devices' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'This table stored all number of devices get pushed'),
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
			'push_id' => 1,
			'push_rule_id' => 1,
			'total_push_devices' => 1,
			'created' => '2019-12-09 18:08:31',
			'created_by' => 1,
			'updated' => '2019-12-09 18:08:31',
			'updated_by' => 1
		),
	);

}
