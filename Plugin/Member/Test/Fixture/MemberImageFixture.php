<?php
/**
 * MemberImage Fixture
 */
class MemberImageFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'member_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'image_type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'path' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'width' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'height' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'size' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
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
			'member_id' => 1,
			'image_type_id' => 1,
			'path' => 'Lorem ipsum dolor sit amet',
			'width' => 1,
			'height' => 1,
			'size' => 1
		),
	);

}
