<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 */

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	
	// Router::connect('/*', array('controller' => 'pages', 'action' => 'maintain_page'));

 	Router::connect('/', 		array('controller' => 'pages', 'action' => 'landing'));
	Router::connect('/landing', array('controller' => 'pages', 'action' => 'landing'));
	Router::connect('/term_n_conditions', array('controller' => 'pages', 'action' => 'term_n_conditions'));
	Router::connect('/privacy_policy', array('controller' => 'pages', 'action' => 'privacy_policy'));
	Router::connect('/school_registration_approved', array('controller' => 'pages', 'action' => 'landing'));
	// Router::connect('/', array('controller' => 'pages', 'action' => 'maintain_page'));
	Router::connect('/school_page/:id', array('controller' => 'pages', 'action' => 'school_page'));

	Router::connect('/student_portals/assignments', array('controller' => 'student_portals', 'action' => 'assignments'));
	
	Router::connect('/student_portals/assignment/submit/:id', 
		array(
			'controller' => 'student_portals', 'action' => 'assignment_submit'), 
		array(
			'pass' => array('id', 'resubmit')
		)
	);

	Router::connect('/teacher_portals/assignments', array('controller' => 'teacher_portals', 'action' => 'assignments'));
	Router::connect('/teacher_portals/assignment/create', array('controller' => 'teacher_portals', 'action' => 'assignment_create'));
	Router::connect('/teacher_portals/assignment/edit/:id', 
		array(
			'controller' => 'teacher_portals', 'action' => 'assignment_edit'), 
		array(
			'pass' => array('id')
		)
	);

	Router::connect('/login', array('plugin' => 'member', 'controller' => 'member_login_methods', 'action' => 'login'));
	Router::connect('/logout', array('plugin' => 'member', 'controller' => 'member_login_methods', 'action' => 'logout'));
	Router::connect('/forgot_password', array('plugin' => '', 'controller' => 'pages', 'action' => 'forgot_password'));

	/*Social login processing*/
	Router::connect('/fb_login_redirect', array('controller' => 'pages', 'action' => 'fb_login_redirect'));
	Router::connect('/gg_login_redirect', array('controller' => 'pages', 'action' => 'gg_login_redirect'));
	

	Router::connect('/admin', array('plugin' => 'administration', 'controller' => 'administrators', 'action' => 'login', 'admin' => true));
	
	
	// Router::connect('/:api/payment/pay_dollar_logs/payment_data_feed.php', array(
	// 	'plugin' => 'payment', 
	// 	'controller' => 'pay_dollar_logs', 
	// 	'action' => 'payment_data_feed',
	// 	'ext' => 'json',
	// 	'api'  => true,
	// ));

	Router::connect('/payment/paydollar/datafeed', array(
		'plugin' => 'payment', 'controller' => 'pay_dollar_logs', 
		'action' => 'paydollar_datafeed'
	));


	// Router::connect('/student_classes', array('plugin' => 'member', 'controller' => 'student_classes', 'action' => 'index'));
	
	// Router::connect('/admin_teacher_create_lesson', 
	// 	array('plugin' => 'member', 
	// 		'controller' => 'teacher_create_lessons', 
	// 		'action' => 'index',
	// 		'admin' => true	// call admin_index
	// 	)
	// );

	// pass param to id
	// Router::connect(
	// 	'/blog/:id-:slug', // E.g. /blog/3-CakePHP_Rocks
	// 	array('controller' => 'blog', 'action' => 'view'),
	// 	array(
	// 		// order matters since this will simply map ":id" to
	// 		// $articleId in your action
	// 		'pass' => array('id', 'slug'),
	// 		'id' => '[0-9]+'
	// 	)
	// );

	
	// ember/teacher_create_lessons/edit/1
	
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	// Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));


	/**
	 * Enable the routing for JSON / XML 
	 */
	Router::parseExtensions('json', 'xml');
	

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

 /* Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
