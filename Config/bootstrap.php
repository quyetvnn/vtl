<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 */

/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 */


/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter . By default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 * 		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

CakeLog::config('client_api', array(
	'engine' => 'File',
	'types' => array('client_api'),			// type of log, important, not this row will not show
	'path' => LOGS . 'client_api' . DS,	
	'file' => 'client_api_' . date("Y_m_d"),					// write into member log file 'path' => LOGS . 'cms' . DS,
	'size' => '100MB',									// max = 100 MB
	'rotate' => '20',									// keep current 20 files, the old 20 files will be deleted
	'mask' => 0777
));

// log cms
CakeLog::config('cms', array(
	'engine' => 'File',
	'types' => array('***START***', '*** END ***', '----Request---------', '----Response Success', '----Response Error--', '____System Error____'),			
	'path' => LOGS . 'cms' . DS,	
	'file' => 'cms_' . date("Y_m_d"),					// write into member log file 'path' => LOGS . 'cms' . DS,
	'size' => '100MB',									// max = 100 MB
	'rotate' => '20',									// keep current 20 files, the old 20 files will be deleted
	'mask' => 0777
));

// log crontask
CakeLog::config('api', array(
	'engine' => 'File',
	'types' => array('API'),			
	'path' => LOGS . 'api' . DS,	
	'file' => 'api_' . date("Y_m_d"),					// write into member log file 'path' => LOGS . 'cms' . DS,
	'size' => '100MB',									// max = 100 MB
	'rotate' => '20',									// keep current 20 files, the old 20 files will be deleted
	'mask' => 0777
));


// log crontask
CakeLog::config('PayDollar', array(
	'engine' => 'File',
	'types' => array('PayDollar'),			
	'path' => LOGS . 'pay_dollar_log' . DS,	
	'file' => 'api_' . date("Y_m_d"),					// write into member log file 'path' => LOGS . 'cms' . DS,
	'size' => '100MB',									// max = 100 MB
	'rotate' => '20',									// keep current 20 files, the old 20 files will be deleted
	'mask' => 0777
));

// log crontask
CakeLog::config('AddChiLanguage', array(
	'engine' => 'File',
	'types' => array('AddChiLanguage'),			
	'path' => LOGS . 'add_chi_language' . DS,	
	'file' => 'api_' . date("Y_m_d"),					// write into member log file 'path' => LOGS . 'cms' . DS,
	'size' => '100MB',									// max = 100 MB
	'rotate' => '20',									// keep current 20 files, the old 20 files will be deleted
	'mask' => 0777
));

CakeLog::config('ReportMembersCredits', array(
	'engine' => 'File',
	'types' => array('ReportMembersCredits'),			
	'path' => LOGS . 'report_members_credits' . DS,	
	'file' => 'api_' . date("Y_m_d"),					// write into member log file 'path' => LOGS . 'cms' . DS,
	'size' => '100MB',									// max = 100 MB
	'rotate' => '20',									// keep current 20 files, the old 20 files will be deleted
	'mask' => 0777
));

CakeLog::config('CallPartnerGenMeetingLink', array(
	'engine' => 'File',
	'types' => array('CallPartnerGenMeetingLink'),			
	'path' => LOGS . 'call_partner_gen_meeting_link' . DS,	
	'file' => 'call_partner_gen_meeting_link_' . date("Y_m_d"),					// write into member log file 'path' => LOGS . 'cms' . DS,
	'size' => '100MB',									// max = 100 MB
	'rotate' => '20',									// keep current 20 files, the old 20 files will be deleted
	'mask' => 0777
));

CakeLog::config('Migratev3', array(
	'engine' => 'File',
	'types' => array('Migratev3'),			
	'path' => LOGS . 'migrate_v3' . DS,	
	'file' => 'migrate_v3_' . date("Y_m_d"),					// write into member log file 'path' => LOGS . 'cms' . DS,
	'size' => '100MB',									// max = 100 MB
	'rotate' => '20',									// keep current 20 files, the old 20 files will be deleted
	'mask' => 0777
));

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); // Loads a single plugin named DebugKit
 */

/**
 * [3rd party] Load the DebugKit plugin
 * 
 * @link https://github.com/cakephp/debug_kit/tree/2.2
 */
CakePlugin::load('DebugKit');

/**
 * [3rd party] Load the ClearCache plugin
 * 
 * @link https://github.com/ceeram/clear_cache
 */
CakePlugin::load('ClearCache');

/**
 * [3rd party] Load the Cakephp Environment plugin
 * 
 * @link https://github.com/quest/cakephp-environment
 */

CakePlugin::load('Environment', array('bootstrap' => true));

CakePlugin::load('PhpExcel', array('bootstrap' => false, 'routes' => false));

CakePlugin::load('Dictionary', array('bootstrap' => false, 'routes' => true));

CakePlugin::load('Administration', array('bootstrap' => false, 'routes' => false));

CakePlugin::load('Company', array('bootstrap' => false, 'routes' => false));

CakePlugin::load('Log', array('bootstrap' => false, 'routes' => false));

CakePlugin::load('Push', array('bootstrap' => false, 'routes' => false));

CakePlugin::load('School', array('bootstrap' => false, 'routes' => false));

CakePlugin::load('Member', array('bootstrap' => false, 'routes' => false));	// routes = false => get boostrap theme / true: get default theme

CakePlugin::load('Payment', array('bootstrap' => false, 'routes' => false));

CakePlugin::load('Credit', array('bootstrap' => false, 'routes' => false));
