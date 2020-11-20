<?php
	/**
	 * Promotion list
	 */
	Router::connect('/:api/vocabulary/list', array(
		'plugin' => 'dictionary', 'controller' => 'vocabularies',
		'action' => 'list', 'api' => true,
	));

	Router::connect('/:api/test/send_push', array(
		'plugin' => 'dictionary', 'controller' => 'tests', 
		'action' => 'send_push', 'api' => true,
	));

	Router::connect('/:api/test/push_ios', array(
		'plugin' => 'dictionary', 'controller' => 'tests', 
		'action' => 'push_ios', 'api' => true,
	));

	Router::connect('/:api/test/push_aos', array(
		'plugin' => 'dictionary', 'controller' => 'tests', 
		'action' => 'push_aos', 'api' => true,
	));

?>