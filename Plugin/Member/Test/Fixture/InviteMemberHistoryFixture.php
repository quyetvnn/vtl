<?php
/**
 * InviteMemberHistory Fixture
 */
class InviteMemberHistoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'school_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'email' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'verified' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'role_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created_by' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'updated_by' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
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
			'school_id' => 1,
			'email' => 1,
			'verified' => 1,
			'role_id' => 1,
			'created' => '2020-05-08 14:20:42',
			'updated' => '2020-05-08 14:20:42',
			'created_by' => 1,
			'updated_by' => 1
		),
	);

}
