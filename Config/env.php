<?php
	date_default_timezone_set('Asia/Hong_Kong');

	/**
	 * Domains environments
	 * IMPORTANT: This lines on the top of the file
	 */
	Configure::write('Environment.domains', array(
		'demo' 			=> 'demo.all4learn.com',
		'staging' 		=> 'staging.all4learn.com',
		'production' 	=> 'all4learn.com',
		'development' 	=> '.*',
	));

	// normal this fire from core.php
	Configure::write('Routing.prefixes', array(
		'admin', 'api'
	));

	/**
	 * Development settings
	 */
	Environment::write(array(
 		'debug' => 1,
 		'Security.salt' => 'ISDU898AdjlakJDASSDKANLmHDLZXLKM7983LJKS', // 40 charaters long Security.salt
 		'Security.cipherSeed' => '32984038533582395728988589743', // 29 digits long Security.cipherSeed
		'Config.timezone' => 'Asia/Hong_Kong',
		'secret_key' => 'All4Learn123',
		'company_name' => 'All 4 Learn',
		'client_api' => 'https://zoom-api-test.rabbidas.com/',
		'playback_view_time' => 14, 	// day
		'cdn_base_url' => '/',

		'allow_max_upload_file' => 30,

		'allow_file_upload' => array(
			 '.docx', '.doc', '.pptx', '.ppt', '.xls', '.xlsx', '.pdf', '.mp3', '.mp4', '.jpg', '.jpeg', '.gif', '.png', '.zip', '.rar'
		),

		'all4learn' => array(
			'email' =>'',	// 'ricky.lam@vtl-vtl.com',
		),

		'paydollar' => array(
			'action' => 'https://test.paydollar.com/b2cDemo/eng/payment/payForm.jsp',
			'secure_hash_secret' => 'wGao2Uvb1KQZngrSqjkZldyG9DlZ8PQY',
			'merchant_id'		 => '88123777',
			'currency'			 => 344,
			'payment_type'		 => 'N',
			'success_url' 		 => 'schools/payment/',
			'fail_url' 			 => 'schools/payment/',
			'cancel_url' 		 => 'schools/payment/',
			'lang' 				 => 'C'
		),

		'email' => array(
			'transport' => 'Smtp',
			'host' 		=> 'smtp.gmail.com',	
			'port' 		=> 587,
			'timeout' 	=> '',
			'from' 		=> 'rockman1688@gmail.com',
			'username' 	=> 'rockman1688@gmail.com',
			'password' 	=> 'sshyimlfwzzamdfn',
			'emailFormat' => 'html',
			'charset' => 'utf8',
			'headerCharset' => 'utf8',
			'log' => '',
			'tls'=>true

			// 'context' => [
			// 	'ssl' => [
			// 		'verify_peer' => false,
			// 		'verify_peer_name' => false,
			// 		'allow_self_signed' => true
			// 	]
			//   ]

			// 'tls' => true
			
			//'ssl' => true,
			// 'SMTPSecure' => 'starttls',
			// 'context'=>array('ssl' => array(
			// 	'verify_peer' => false,
			// 	'verify_peer_name' => false,
			// 	'allow_self_signed' => true
			// )), 
		),

		// 'email' => array(
		// 	'transport' => 'Smtp',
		// 	'host' 		=> 'smtp.office365.com',	
		// 	'port' 		=> 587,
		// 	'timeout' 	=> '',
		// 	'from' 		=> array('info@all4learn.com' => 'All4Learn Admin'),
		// 	'username' 	=> 'info@all4learn.com',
		// 	'password' 	=> 'All4Learn*',
		// 	'emailFormat' => 'html',
		// 	'charset' => 'utf8',
		// 	'headerCharset' => 'utf8',
		// 	'log' => '',
		// 	'tls' => true,
		// ),
		
		'role' => array(
			'teacher'			=> 1,
			'student' 			=> 2,
			'school-admin' 		=> 3,
			'parent' 			=> 4,
			'guest' 			=> 5,
			'system-admin' 		=> 6,
			'register' 			=> 100,
		),

		'login_method' => array(
			'facebook' 	=> '@SOCIAL-FACEBOOK-NETWORK@',
			'google'	=> '@SOCIAL-GOOGLE-NETWORK@',
		),

		'locale_format' => array(
			'zho' => "Y年n月d日H:i",
			'chi' => "Y年n月d日H:i",
			'eng' => "d F Y H:i",
		),

		'fb_app' => array(
			'login_method_id' => 900002,
			'client_id' => '1728840177257415',
			'client_secret' => 'c5691df29c8cfc33b9594f6ee23396ad'
		),

		'gg_app' => array(
			'login_method_id' => 900001,
			'client_id' => '582353043070-t8da0egb0o77s203r4sofvj3h4u65q4l.apps.googleusercontent.com',
			'client_secret' => 'hnHl7633UAlyjVYB1PHLzrW4'
		),

		'time' => array(
			'no_repeat' => 10,
			'daily' => 0,
			'weekly' => 1,
		),

 		'Session' => array(
 			'defaults' => 'php',
 			'timeout' => 240, // 4 hours
 			'cookie' => 'all4learn' // Cookie name
		),
		
		'database' => array(
			'host' => '127.0.0.1',	// use localhost => so can cake/bake model
			'port' => 3306,			// use port too
 			'login' => 'root',
 			'password' => '',
			'db' => 'all4learn_v2',
			'prefix' => 'booster_',
			 'encoding' => 'utf8mb4'
		),
		 
		'web' => array(
			'super_role' => 'role-vtl-admin',
		),
		'api' => array(
			'language' => 'zho',
			'available_languages' => array('zho', 'eng', 'chi'),
			'token_expiry' => '+6 month'
		),

 		'site' => array(
			'type' => 'development',
			'default_language' => 'zho',
			
 			'name' => 'Development 2.2', // Site name
 			'description' => '', // Site description in meta tag
 			'keywords' => '', // Site keywords in meta tag
 			'cache_prefix' => 'clean_cms_' // cache prefix
 		),
		
		'poweredby' => array(
			'name' => '',
			'website' => ''
		)
	), 'development');

	/**
	 * staging settings
	 */
	Environment::write(array(
		'debug' => 1,
		'Security.salt' => 'ISDU898AdjlakJDASSDKANLmHDLZXLKM7983LJKS', // 40 charaters long Security.salt
		'Security.cipherSeed' => '32984038533582395728988589743', // 29 digits long Security.cipherSeed
		'Config.timezone' => 'Asia/Hong_Kong',
		'secret_key' => 'All4Learn123',
		'company_name' => 'All 4 Learn',
		'client_api' => 'https://zoom-api-demo.rabbidas.com/',
		'playback_view_time' => 14, 	// day
		'cdn_base_url' => '/',

		'allow_max_upload_file' => 30,

		'allow_file_upload' => array(
			 '.docx', '.doc', '.pptx', '.ppt', '.xls', '.xlsx', '.pdf', '.mp3', '.mp4', '.jpg', '.jpeg', '.gif', '.png', '.zip', '.rar'
		),

		'all4learn' => array(
			'email' => 'ricky.lam@vtl-vtl.com',
		),

		'paydollar' => array(
			'action' => 'https://test.paydollar.com/b2cDemo/eng/payment/payForm.jsp',
			'secure_hash_secret' => 'wGao2Uvb1KQZngrSqjkZldyG9DlZ8PQY',
			'merchant_id'		 => '88123777',
			'currency'			 => 344,
			'payment_type'		 => 'N',
			'success_url' 		 => 'schools/payment/',
			'fail_url' 			 => 'schools/payment/',
			'cancel_url' 		 => 'schools/payment/',
			'lang' 				 => 'C'
		),

		'email' => array(
			'transport' => 'Smtp',
			'host' 		=> 'smtp.office365.com',	
			'port' 		=> 587,
			'timeout' 	=> '',
			'from' 		=> array('info@all4learn.com' => 'All4Learn Admin'),
			'username' 	=> 'info@all4learn.com',
			'password' 	=> 'All4Learn*',
			'emailFormat' => 'html',
			'charset' => 'utf8',
			'headerCharset' => 'utf8',
			'log' => '',
			'tls' => true,
		),

		'role' => array(
			'teacher'			=> 1,
			'student' 			=> 2,
			'school-admin' 		=> 3,
			'parent' 			=> 4,
			'guest' 			=> 5,
			'system-admin' 		=> 6,
			'register' 			=> 0,
		),

		'login_method' => array(
			'facebook' 	=> '@SOCIAL-FACEBOOK-NETWORK@',
			'google'	=> '@SOCIAL-GOOGLE-NETWORK@',
		),

		'locale_format' => array(
			'zho' => "Y年n月d日H:i",
			'chi' => "Y年n月d日H:i",
			'eng' => "d F Y H:i",
		),

		'fb_app' => array(
			'login_method_id' => 900002,
			'client_id' => '1728840177257415',
			'client_secret' => 'c5691df29c8cfc33b9594f6ee23396ad'
		),

		'gg_app' => array(
			'login_method_id' => 900001,
			'client_id' => '582353043070-t8da0egb0o77s203r4sofvj3h4u65q4l.apps.googleusercontent.com',
			'client_secret' => 'hnHl7633UAlyjVYB1PHLzrW4'
		),
	
		'time' => array(
			'no_repeat' => 10,
			'daily' => 0,
			'weekly' => 1,
		),

		'Session' => array(
			'defaults' => 'php',
			'timeout' => 240, // 4 hours
			'cookie' => 'all4learn' // Cookie name
		),
		
	   'database' => array(
		   'host' => 'localhost',	// use localhost => so can cake/bake model
		 	'login' => 'staging_all4learn',
			'password' => 'wM8A10RsaHU6slDm',
			'db' => 'staging_all4learn',
			'prefix' => 'booster_',
			'encoding' => 'utf8mb4'
		),
	   
		'site' => array(
			'type' => 'staging',
			'default_language' => 'zho',
			'name' => 'Staging 2.2', // Site name
			'description' => '', // Site description in meta tag
			'keywords' => '', // Site keywords in meta tag
			'cache_prefix' => 'clean_cms_' // cache prefix
		),

		'api' => array(
			'language' => 'zho',
			'available_languages' => array('zho', 'eng', 'chi'),
			'token_expiry' => '+6 month'
		),
	   
	   'poweredby' => array(
		   'name' => '',
		   'website' => ''
	   )
	), 'staging');


	/**
	 * production settings
	 */
	Environment::write(array(
		'debug' => 0,
		'Security.salt' => 'ISDU898AdjlakJDASSDKANLmHDLZXLKM7983LJKS', // 40 charaters long Security.salt
		'Security.cipherSeed' => '32984038533582395728988589743', // 29 digits long Security.cipherSeed
		'Config.timezone' => 'Asia/Hong_Kong',
		'secret_key' => 'All4Learn123',
		'company_name' => 'All 4 Learn',
		'client_api' => 'https://zoom-api-prod.rabbidas.com/',
		'playback_view_time' => 14, 	// day
		'cdn_base_url' => 'https://static.all4learn.com/',

		'allow_max_upload_file' => 30,

		'allow_file_upload' => array(
			 '.docx', '.doc', '.pptx', '.ppt', '.xls', '.xlsx', '.pdf', '.mp3', '.mp4', '.jpg', '.jpeg', '.gif', '.png', '.zip', '.rar'
		),

		'all4learn' => array(
			'email' => 'ricky.lam@vtl-vtl.com',
		),

		'paydollar' => array(
			'action' => 'https://test.paydollar.com/b2cDemo/eng/payment/payForm.jsp',
			'secure_hash_secret' => 'wGao2Uvb1KQZngrSqjkZldyG9DlZ8PQY',
			'merchant_id'		 => '88123777',
			'currency'			 => 344,
			'payment_type'		 => 'N',
			'success_url' 		 => 'schools/payment/',
			'fail_url' 			 => 'schools/payment/',
			'cancel_url' 		 => 'schools/payment/',
			'lang' 				 => 'C'
		),

		'login_method' => array(
			'facebook' 	=> '@SOCIAL-FACEBOOK-NETWORK@',
			'google'	=> '@SOCIAL-GOOGLE-NETWORK@',
		),

		'email' => array(
			'transport' => 'Smtp',
			'host' 		=> 'smtp.office365.com',	
			'port' 		=> 587,
			'timeout' 	=> '',
			'from' 		=> array('info@all4learn.com' => 'All4Learn Admin'),
			'username' 	=> 'info@all4learn.com',
			'password' 	=> 'All4Learn*',
			'emailFormat' => 'html',
			'charset' => 'utf8',
			'headerCharset' => 'utf8',
			'log' => '',
			'tls' => true,
		),

		'role' => array(
			'teacher'			=> 1,
			'student' 			=> 2,
			'school-admin' 		=> 3,
			'parent' 			=> 4,
			'guest' 			=> 5,
			'system-admin' 		=> 6,
			'register' 			=> 0,
		),

		'locale_format' => array(
			'zho' => "Y年n月d日H:i",
			'chi' => "Y年n月d日H:i",
			'eng' => "d F Y H:i",
		),

		'fb_app' => array(
			'login_method_id' => 900002,
			'client_id' => '615376049407012',
			'client_secret' => '827a4d15d5d12e0480e73a4ad7b14d6d'
		),

		'gg_app' => array(
			'login_method_id' => 900001,
			'client_id' => '1090299652589-3h9nmlp6n8h86p07elcmnaaap55g830t.apps.googleusercontent.com',
			'client_secret' => 'acDEkUmS_2g7v_2GH0CHWua_'
		),

		'time' => array(
			'no_repeat' => 10,
			'daily' => 0,
			'weekly' => 1,
		),


		'Session' => array(
			'defaults' => 'php',
			'timeout' => 240, // 4 hours
			'cookie' => 'all4learn' // Cookie name
		),
		
	   'database' => array(
		   'host' => 'localhost',	// use localhost => so can cake/bake model
		 	'login' => 'all4learn',
			'password' => '0cpf8OEmLaeP6uu5',
			'db' => 'all4learn',
			'prefix' => 'booster_',
			'encoding' => 'utf8mb4'
		),


		'web' => array(
			'super_role' => 'role-vtl-admin',
		),
		
		'api' => array(
			'language' => 'zho',
			'available_languages' => array('zho', 'eng', 'chi'),
			'token_expiry' => '+6 month'
		),
	   
		'site' => array(
			'type' => 'production',
			'default_language' => 'zho',
			'name' => 'Production 2.6', // Site name
			'description' => '', // Site description in meta tag
			'keywords' => '', // Site keywords in meta tag
			'cache_prefix' => 'clean_cms_' // cache prefix
		),
	   
	   'poweredby' => array(
		   'name' => '',
		   'website' => ''
	   )

	   
	), 'production');


	/**
	 * demo settings
	 */
	Environment::write(array(
		'debug' => 1,
		'Security.salt' => 'ISDU898AdjlakJDASSDKANLmHDLZXLKM7983LJKS', // 40 charaters long Security.salt
		'Security.cipherSeed' => '32984038533582395728988589743', // 29 digits long Security.cipherSeed
		'Config.timezone' => 'Asia/Hong_Kong',
		'secret_key' => 'All4Learn123',
		'company_name' => 'All 4 Learn',
		'client_api' => 'https://zoom-api-demo.rabbidas.com/',
		'playback_view_time' => 14, 	// day
		'cdn_base_url' => '/',

		'allow_max_upload_file' => 30,

		'allow_file_upload' => array(
			 '.docx', '.doc', '.pptx', '.ppt', '.xls', '.xlsx', '.pdf', '.mp3', '.mp4', '.jpg', '.jpeg', '.gif', '.png', '.zip', '.rar'
		),

		'all4learn' => array(
			'email' => 'ricky.lam@vtl-vtl.com',
		),
		
		'paydollar' => array(
			'action' => 'https://test.paydollar.com/b2cDemo/eng/payment/payForm.jsp',
			'secure_hash_secret' => 'wGao2Uvb1KQZngrSqjkZldyG9DlZ8PQY',
			'merchant_id'		 => '88123777',
			'currency'			 => 344,
			'payment_type'		 => 'N',
			'success_url' 		 => 'schools/payment/',
			'fail_url' 			 => 'schools/payment/',
			'cancel_url' 		 => 'schools/payment/',
			'lang' 				 => 'C'
		),
		
		'web' => array(
			'super_role' => 'role-vtl-admin',
		),
		
		'api' => array(
			'language' => 'zho',
			'available_languages' => array('zho', 'eng', 'chi'),
			'token_expiry' => '+6 month'
		),

		'email' => array(
			'transport' => 'Smtp',
			'host' 		=> 'smtp.office365.com',	
			'port' 		=> 587,
			'timeout' 	=> '',
			'from' 		=> array('info@all4learn.com' => 'All4Learn Admin'),
			'username' 	=> 'info@all4learn.com',
			'password' 	=> 'All4Learn*',
			'emailFormat' => 'html',
			'charset' => 'utf8',
			'headerCharset' => 'utf8',
			'log' => '',
			'tls' => true,
		),

		'role' => array(
			'teacher'			=> 1,
			'student' 			=> 2,
			'school-admin' 		=> 3,
			'parent' 			=> 4,
			'guest' 			=> 5,
			'system-admin' 		=> 6,
			'register' 			=> 0,
		),

		'locale_format' => array(
			'zho' => "Y年n月d日H:i",
			'chi' => "Y年n月d日H:i",
			'eng' => "d F Y H:i",
		),

		'fb_app' => array(
			'login_method_id' => 900002,
			'client_id' => '615376049407012',
			'client_secret' => '827a4d15d5d12e0480e73a4ad7b14d6d'
		),

		'gg_app' => array(
			'login_method_id' => 900001,
			'client_id' => '1090299652589-3h9nmlp6n8h86p07elcmnaaap55g830t.apps.googleusercontent.com',
			'client_secret' => 'acDEkUmS_2g7v_2GH0CHWua_'
		),

		'login_method' => array(
			'facebook' 	=> '@SOCIAL-FACEBOOK-NETWORK@',
			'google'	=> '@SOCIAL-GOOGLE-NETWORK@',
		),

		'time' => array(
			'no_repeat' => 10,
			'daily' => 0,
			'weekly' => 1,
		),


		'Session' => array(
			'defaults' => 'php',
			'timeout' => 240, // 4 hours
			'cookie' => 'all4learn' // Cookie name
		),
		
	   'database' => array(
			'host' => 'localhost',
		 	'login' => 'demo_all4learn',
			'password' => 'MLzJEoxIfHmhYpJp',
			'db' => 'demo_all4learn',
			'prefix' => 'booster_',
			'encoding' => 'utf8mb4'
			//'unix_socket' => '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock'	// please change this oli
		),

		'site' => array(
			'type' => 'production',
			'default_language' => 'zho',
			'name' => 'Demo 2.2', // Site name
			'description' => '', // Site description in meta tag
			'keywords' => '', // Site keywords in meta tag
			'cache_prefix' => 'clean_cms_' // cache prefix
		),
	   
	   'poweredby' => array(
		   'name' => '',
		   'website' => ''
	   )
	), 'demo');

?>