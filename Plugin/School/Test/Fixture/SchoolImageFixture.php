<?php
/**
 * SchoolImage Fixture
 */
class SchoolImageFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'path' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'width' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'heigth' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
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
			'path' => 1,
			'width' => 1,
			'heigth' => 1
		),
	);

}
