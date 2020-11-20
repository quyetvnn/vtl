<?php
/**
 * MembersGroup Fixture
 */
class MembersGroupFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'member_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'school_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'role_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'group_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'enabled' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created_by' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'updated_by' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
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
			'member_id' => 1,
			'school_id' => 1,
			'role_id' => 1,
			'group_id' => 1,
			'enabled' => 1,
			'created' => '2020-07-31 11:28:40',
			'updated' => '2020-07-31 11:28:40',
			'created_by' => 1,
			'updated_by' => 1
		),
	);

}
