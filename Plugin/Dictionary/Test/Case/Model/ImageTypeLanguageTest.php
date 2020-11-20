<?php
App::uses('ImageTypeLanguage', 'Dictionary.Model');

/**
 * ImageTypeLanguage Test Case
 */
class ImageTypeLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dictionary.image_type_language',
		'plugin.dictionary.image_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ImageTypeLanguage = ClassRegistry::init('Dictionary.ImageTypeLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ImageTypeLanguage);

		parent::tearDown();
	}

}
