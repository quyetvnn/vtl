<?php
/**
 * CreditType Fixture
 */
class CreditTypeFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 191, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'),
		'is_add_point' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => '= 1 => add point ;  = 0 => deduct point'),
		'enabled' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
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
			'slug' => 'Lorem ipsum dolor sit amet',
			'is_add_point' => 1,
			'enabled' => 1,
			'updated' => '2020-06-08 11:46:44',
			'updated_by' => 1,
			'created' => '2020-06-08 11:46:44',
			'created_by' => 1
		),
	);

}
