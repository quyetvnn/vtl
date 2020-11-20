<?php
/**
 * Push Fixture
 */
class PushFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'company_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'section_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'object' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 191, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'),
		'link' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 191, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'),
		'message' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'),
		'push_method_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'tier_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'gender_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'age_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'district_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'dob_month' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'join_from' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'join_to' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'spending_from' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'spending_to' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
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
			'company_id' => 1,
			'section_id' => 1,
			'object' => 'Lorem ipsum dolor sit amet',
			'link' => 'Lorem ipsum dolor sit amet',
			'message' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'push_method_id' => 1,
			'tier_id' => 1,
			'gender_id' => 1,
			'age_id' => 1,
			'district_id' => 1,
			'dob_month' => 1,
			'join_from' => '2017-09-01 11:56:29',
			'join_to' => '2017-09-01 11:56:29',
			'spending_from' => 1,
			'spending_to' => 1,
			'enabled' => 1,
			'updated' => '2017-09-01 11:56:29',
			'updated_by' => 1,
			'created' => '2017-09-01 11:56:29',
			'created_by' => 1
		),
	);

}
