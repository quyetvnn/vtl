<?php
App::uses('Vocabulary', 'Dictionary.Model');

/**
 * Vocabulary Test Case
 */
class VocabularyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.dictionary.vocabulary',
		'plugin.dictionary.vocabulary_language'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Vocabulary = ClassRegistry::init('Dictionary.Vocabulary');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Vocabulary);

		parent::tearDown();
	}

}
