<?php
/**
 * ShopsCoupon Fixture
 */
class ShopsCouponFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'coupon_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'brand_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'shop_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
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
			'coupon_id' => 1,
			'brand_id' => 1,
			'shop_id' => 1
		),
	);

}
