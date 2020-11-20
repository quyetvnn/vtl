<?php
/**
 * Custom Component for Apple APNS push notification
 * 
 * @author vi.lh@vtl-vtl.com
 */
	App::uses('Component', 'Controller');

	class ApplePushComponent extends Component {
		protected $push_server;

		// Apple .pem file name
		public $pem_file;

		// Apple .pem file name
		public $pem_password;

		// notify sound
		public $aps_sound = "default";

		// notify badge
		public $aps_badge = "1";

		//apple feedback url
		public $apple_feedback_url = "";

		public function initialize(Controller $controller) {
			parent::initialize($controller);
		}

		/**
		 * Is called after the controller’s beforeFilter method 
		 * but before the controller executes the current action handler.
		 * 
		 */
		public function startup(Controller $controller) {
			parent::startup($controller);

		}

		/**
		 * Is called after the controller executes the requested action’s logic,
		 * but before the controller’s renders views and layout.
		 * 
		 */
		public function beforeRender(Controller $controller) {
			parent::beforeRender($controller);

		}

		/**
		 * Is called before output is sent to the browser.
		 * 
		 */
		public function shutdown(Controller $controller) {
			parent::shutdown($controller);

		}

		/**
		 * Is called before output is sent to the browser.
		 * 
		 */
		public function beforeRedirect(Controller $controller, $url = "", $status = null, $exit = true) {
			parent::beforeRedirect($controller, $url, $status, $exit);

		}

		public function set_credential($sandbox = true) {
        
			if ($sandbox === true) {
                $this->server_key 				= Environment::read('push.server_key');
                $this->sender_id	 			= Environment::read('push.sender_id');
				$this->server_feedback_url 		= Environment::read('push.server_feedback_url');
			}
		}

		/**
		 * public method to push message to all device(s)
		 */
		public function push($aos_data, $message, $push_params) {
			$ch = curl_init();

			// Set POST variables
			$this->set_credential(true);
			$url = $this->server_feedback_url;
 
			$headers = array(
				'Connection: keep-alive',
				'Authorization: key=' . $this->server_key,
				'Content-Type: application/json'
			);

			$fields  = array();
	
			$failed_case = array();
			$succeed_case = array();
			try {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

				foreach ($aos_data as $aos) {
					$fields = array(
						'to' => $aos['device_token'],
						'notification' 	=> array(
							'body'		=> $message['notification']['body'],
							'title'		=> $message['notification']['title'],
						),
						'data' => isset($push_params['custom_data']) ? $push_params['custom_data'] : '',
					);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

					$result = curl_exec($ch);

					if ($result === FALSE) {
						array_push($failed_case, $aos);
					}
					else {
						array_push($succeed_case, $aos);
					}
				}
				
				
                
				$pushed = array(
                    'status' => true,
                    'params' => array(
                        'failed' 		=> $failed_case,
                        'pushed_tokens' => $succeed_case,
					)
                );
			} catch (Exception $e) {
                $message = $e->getMessage();
				$pushed = array(
                    'status' => false,
                    'error_messages' => array(
                        'err' => $message,
                        'errstr' => $message,
                    ),
                    'params' => array()
                );
			} finally {
				// Close connection
				curl_close($ch);	 // Close the connection to the server
			}
	
			return $pushed;
		}

		/**
		 * Set the PEM, passphrase and server
		 */
		// public function set_credential_apns($sandbox = true ){
        //     $this->pem_password = Environment::read('push.ios.pem_password');

		// 	if( $sandbox === true ){
        //         $this->pem_file = Environment::read('push.ios.pem_file_sanbox');
        //         $this->push_server = Environment::read('push.ios.server_sandbox');
		// 		$this->apple_feedback_url = Environment::read('push.ios.server_feedback_sandbox');
		// 	} else {
        //         $this->pem_file = Environment::read('push.ios.pem_file');
        //         $this->push_server = Environment::read('push.ios.server_production');
		// 		$this->apple_feedback_url = Environment::read('push.ios.server_feedback_production');
        //     }
		// }

		public function set_sound( $sound ){
			$this->aps_sound = $sound;
		}

		public function set_badge( $badge ){
			$this->aps_badge = $badge;
		}

		/**
		 * public method to push message to device(s)
		 */
		// public function push_apns($ios_data, $message, $push_params) {
		// 	$pushed = array(
		// 		'status' => false, 
		// 		'params' => array()
		// 	);

        //     $ctx = stream_context_create();
        //     stream_context_set_option($ctx, 'ssl', 'local_cert', WWW_ROOT . $this->pem_file);
        //     stream_context_set_option($ctx, 'ssl', 'passphrase', $this->pem_password);

        //     $fp = stream_socket_client( $this->push_server, $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

        //     if( !$fp ) { 
        //         return array(
        //             'status' => false,
        //             'error_messages' => array(
        //                 'err' => $err,
        //                 'errstr' => $errstr,
        //             ),
        //             'params' => array()
        //         );
        //     }

        //     $aps_struct = array(
        //         'aps' => array(
        //             'alert' => $message,
        //             'badge' => $this->aps_badge,
        //             'sound' => $this->aps_sound,
        //             'params' => $push_params
        //         ),
        //     );

        //     $payload = json_encode( $aps_struct );

        //     $pushed_tokens = array();
        //     $failed_tokens = array();
        //     // push to a bundle of devices when the socket is opened
        //     foreach ($ios_data as $ios) {
        //         // Build the binary notification
        //         $expire = time() + 3600;
        //         $id = time();
        //         $binary = pack('CNNnH*n', 1, $id, $expire, 32, $ios['device_token'], strlen($payload)).$payload;
                    
        //         // Send it to the server
        //         if( fwrite($fp, $binary) ){
        //             array_push($pushed_tokens, $ios);
        //         }else{
        //             array_push($failed_tokens, $ios);
        //         }
        //     }

        //     // Close the connection to the server
        //     if( fclose($fp) ){
        //         $pushed = array(
        //             'status' => true,
        //             'params' => array(
        //                 'failed' => $failed_tokens,
        //                 'pushed_tokens' => $pushed_tokens,
        //             )
        //         );
        //     }

		// 	return $pushed;
		// }

		public function feedback(){
			set_time_limit(0);

			$cert_file = $this->pem_file;
			$cert_pw = $this->pem_password;

			//connect to the APNS feedback servers
		    //make sure you're using the right dev/production server & cert combo!
		    $stream_context = stream_context_create();
		    stream_context_set_option($stream_context, 'ssl', 'local_cert', $cert_file);
		    stream_context_set_option($stream_context, 'ssl', 'passphrase', $cert_pw);
		    
		    $apns = stream_socket_client('ssl://feedback.sandbox.push.apple.com:2196', $errcode, $errstr, 60, STREAM_CLIENT_CONNECT, $stream_context); 

		    if (!$apns) {
		        echo "ERROR $errcode: $errstr\n";
		        return;
		    }

		    $feedback_tokens = array();
		    //and read the data on the connection:
		    while(!feof($apns)) {
		        $data = fread($apns, 38);
		        if(strlen($data)) {
		            $feedback_tokens[] = unpack("N1timestamp/n1length/H*devtoken", $data);
		        }
		    }
		    fclose($apns);

		    return $feedback_tokens;
		}
	}