<?php
App::uses('VocabularyLanguage', 'Dictionary.Model');

/**
 * VocabularyLanguage Test Case
 */
class VocabularyLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dictionary.vocabulary_language',
		'plugin.dictionary.vocabulary'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->VocabularyLanguage = ClassRegistry::init('Dictionary.VocabularyLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->VocabularyLanguage);

		parent::tearDown();
	}

}
