<?php
	/**
	 * Brand list
	 */
	Router::connect('/:api/brand/list', array(
		'plugin' => 'company', 'controller' => 'brands', 
		'action' => 'list', 'api' => true,
	));


	/**
	 * Shop list
	 */
	Router::connect('/:api/shop/list', array(
		'plugin' => 'company', 'controller' => 'shops', 
		'action' => 'list', 'api' => true,
	));

	/**
	 * Shop detail
	 */
	Router::connect('/:api/shop/detail', array(
		'plugin' => 'company', 'controller' => 'shops', 
		'action' => 'detail', 'api' => true,
	));

	/**
	 * Shop Listing Name ( CMS Use )
	 */
	Router::connect('/:api/shop/list/name', array(
		'plugin' => 'company', 'controller' => 'shops', 
		'action' => 'list_name', 'api' => true,
	));
?>