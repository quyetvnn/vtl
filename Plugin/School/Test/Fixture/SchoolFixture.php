<?php
/**
 * School Fixture
 */
class SchoolFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'school_code' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'credit_charge' => array('type' => 'integer', 'null' => true, 'default' => '1', 'unsigned' => false, 'comment' => 'fee each student watch live'),
		'credit' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'phone' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'enabled' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'address' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
			'school_code' => 'Lorem ipsum dolor sit amet',
			'credit_charge' => 1,
			'credit' => 1,
			'phone' => 'Lorem ipsum dolor sit amet',
			'enabled' => 1,
			'address' => 'Lorem ipsum dolor sit amet',
			'created' => '2020-04-30 18:58:27',
			'updated' => '2020-04-30 18:58:27',
			'created_by' => 1,
			'updated_by' => 1
		),
	);

}
