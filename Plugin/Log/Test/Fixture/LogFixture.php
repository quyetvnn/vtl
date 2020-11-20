<?php
/**
 * Log Fixture
 */
class LogFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'company_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'statement' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
	// 'archived' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'remark' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 191, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'remote_ip' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 191, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'agent' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 191, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'enabled' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'update_by' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created_by' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'company_id' => 1,
			'user_id' => 1,
			'type_id' => 1,
			'statement' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'archived' => 1,
			'remark' => 'Lorem ipsum dolor sit amet',
			'remote_ip' => 'Lorem ipsum dolor sit amet',
			'agent' => 'Lorem ipsum dolor sit amet',
			'enabled' => 1,
			'updated' => '2017-09-14 17:47:11',
			'update_by' => 1,
			'created' => '2017-09-14 17:47:11',
			'created_by' => 1
		),
	);

}
