<?php
	/**
	 * Notification list
	 */
	Router::connect('/:api/push/notification', array(
		'plugin' => 'push', 'controller' => 'pushes',
		'action' => 'notification', 'api' => true,
	));

	Router::connect('/:api/notification/push', array(
		'plugin' => 'push', 'controller' => 'pushes',
		'action' => 'external_push', 'api' => true,
	));
?>