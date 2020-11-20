<?php
/**
 * ShopsCurrency Fixture
 */
class ShopsCurrencyFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'brand_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'shop_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'currency_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
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
			'brand_id' => 1,
			'shop_id' => 1,
			'currency_id' => 1,
			'enabled' => 1,
			'updated' => '2017-09-01 11:33:30',
			'updated_by' => 1,
			'created' => '2017-09-01 11:33:30',
			'created_by' => 1
		),
	);

}
