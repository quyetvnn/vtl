<?php
/**
 * PushRule Fixture
 */
class PushRuleFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'push_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'push_type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'period_start' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'period_end' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'execute_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'execute_time' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 191, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'),
		'weekday' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'month' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'day' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'enabled' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'updated_by' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created_by' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB')
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
			'push_type_id' => 1,
			'period_start' => '2017-09-01 11:56:31',
			'period_end' => '2017-09-01 11:56:31',
			'execute_date' => '2017-09-01 11:56:31',
			'execute_time' => 'Lorem ipsum dolor sit amet',
			'weekday' => 1,
			'month' => 1,
			'day' => 1,
			'enabled' => 1,
			'updated' => '2017-09-01 11:56:31',
			'updated_by' => 1,
			'created' => '2017-09-01 11:56:31',
			'created_by' => 1
		),
	);

}
