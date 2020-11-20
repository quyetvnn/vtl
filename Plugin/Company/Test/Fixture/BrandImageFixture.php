<?php
/**
 * BrandImage Fixture
 */
class BrandImageFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'brand_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'image_type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'path' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 191, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'),
		'width' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'height' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'size' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
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
			'image_type_id' => 1,
			'path' => 'Lorem ipsum dolor sit amet',
			'width' => 1,
			'height' => 1,
			'size' => 1,
			'updated' => '2017-09-01 11:33:27',
			'updated_by' => 1,
			'created' => '2017-09-01 11:33:27',
			'created_by' => 1
		),
	);

}
