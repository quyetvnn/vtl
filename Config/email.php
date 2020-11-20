<?php
/**
 * This is email configuration file.
 *
 * Use it to configure email transports of Cake.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 2.0.0
 */

/**
 * Email configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * transport => The name of a supported transport; valid options are as follows:
 *		Mail		- Send using PHP mail function
 *		Smtp		- Send using SMTP
 *		Debug		- Do not send the email, just return the result
 *
 * You can add custom transports (or override existing transports) by adding the
 * appropriate file to app/Network/Email. Transports should be named 'YourTransport.php',
 * where 'Your' is the name of the transport.
 *
 * from =>
 * The origin email. See CakeEmail::from() about the valid values
 */
class EmailConfig {
	public $gmail;
    
	public function __construct (){
		$this->gmail = array(
            'transport' => Environment::read('email.transport'),
			'host' => Environment::read('email.host'),
			'port' => Environment::read('email.port'),
			// 'timeout' => Environment::read('email.timeout'),
            'from' => Environment::read('email.from'),
			'username' => Environment::read('email.username'),
			'password' => Environment::read('email.password'),
			'emailFormat' => Environment::read('email.emailFormat'),
			'charset' => Environment::read('email.charset'),
			'tls'  => Environment::read('email.tls'),
			'ssl'  => Environment::read('email.ssl'),
			// 'headerCharset' => Environment::read('email.headerCharset'),
			// 'log' => Environment::read('email.log'),
		);
	}
}
