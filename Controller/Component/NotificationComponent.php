<?php
/**
 * Custom Component for PUSH notification
 * 
 * @author vi.lh@vtl-vtl.com
 */
	App::uses('Component', 'Controller');

	class NotificationComponent extends Component {
		/**
		 * Components
		 *
		 * @var array
		 */
		public $components = array(
			'PushCommon',
		);

/**
 * Component callbacks
 */
		/**
		 * Is called before the controller’s beforeFilter method.
		 * 
		 */
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
        
        public function push($data, $message, $push_params = array()) {


            $status = false;
            $error_messages = array();
            $params = array();

            if (empty($message)) {
                goto result;
            }

            if (count($data) > 0) {
                // start push android, ios device
            // form the push message and push to device(s)
                $aos_pushed = $this->PushCommon->push($data, $message, $push_params);
            
                if (isset($aos_pushed['status']) && ($aos_pushed['status'] == true)) {
                    $status = true;

                } else {
                    $status = false;
                    $error_messages = $aos_pushed['error_messages'];
                }

                $params = $aos_pushed['params'];
                // end push android, ios device
            }
           
            result:
			return array(
                'status'                => $status,
                'error_messages'        => $error_messages,
                'params'                => $params,
            );
		}

		public function push_2kind_ok($android_data, $ios_data, $message, $push_params = array()) {

            if (empty($message)) {
                return array(
                    'status' => false,
                );
            }

            $ios_status = false;
            $ios_error_messages = array();
            $ios_params = array();

            $android_status = false;
            $android_error_messages = array();
            $android_params = array();
            
            if (count($android_data) > 0) {
                // start push android device
                // form the push message and push to device(s)
                $aos_pushed = $this->PushCommon->push($android_data, $message, $push_params);
            
                if (isset($aos_pushed['status']) && ($aos_pushed['status'] == true)) {
                    $android_status = true;

                } else {
                    $android_status = false;
                    $android_error_messages = $aos_pushed['error_messages'];
                }

                $android_params = $aos_pushed['params'];
                // end push android device
            }
           
            if (count($ios_data) > 0) {
                // start push apple device
                // form the push message and push to device(s)
                $ios_pushed = $this->PushCommon->push($ios_data, $message, $push_params);

                if (isset($ios_pushed['status']) && ($ios_pushed['status'] == true)) {
                    $ios_status = true;

                } else {
                    $ios_status = false;
                    $ios_error_messages = $ios_pushed['error_messages'];
                }
                
                $ios_params = $ios_pushed['params'];
                // end push apple device
            }

			return array(
                'android_status'        => $android_status,
                'android_error_messages' => $android_error_messages,
                'android_params'        => $android_params,
                'ios_status'            => $ios_status,
                'ios_error_messages'    => $ios_error_messages,
                'ios_params'            => $ios_params,
                
            );
		}

		// public function push_ios_device($ios_data, $ios_message, $push_params = array() ){
        //     if (empty($ios_message)) {
        //         return array(
        //             'status' => false,
        //         );
        //     }

        //     $ios_status = false;
        //     $ios_error_messages = array();
        //     $ios_params = array();

        //     // start push apple device
        //     // Calling ApplePushComponent, set the PEM, passphrase and server
        //     $this->ApplePush->set_credential(Environment::read('push.aos.sandbox'));

        //     // form the push message and push to device(s)
        //     $ios_pushed = $this->ApplePush->push($ios_data, $ios_message, $push_params);

        //     if (isset($ios_pushed['status']) && ($ios_pushed['status'] == true)) {
        //         $ios_status = true;
        //     } else {
        //         $ios_status = false;
        //         $ios_error_messages = $ios_pushed['error_messages'];
		// 	}
			
		// 	return array(
        //         'ios_status' 			=> $ios_status,
        //         'ios_error_messages' 	=> $ios_error_messages,
        //         'ios_params' 			=> $ios_params
        //     );
		// }

		// public function push_aos_device($android_data, $android_message, $push_params = array() ) {

        //     if (empty($android_message)) {
        //         return array(
        //             'status' => false,
        //         );
        //     }

        //     $android_status = false;
        //     $android_error_messages = array();
        //     $android_params = array();
            
       
        //     // start push android device
        //     // set the FCM server key accordingly
        //     $this->AndroidPush->set_credential(Environment::read('push.aos.sandbox'));

        //     // form the push message and push to device(s)
        //     $aos_pushed = $this->AndroidPush->push($android_data, $android_message, $push_params);

        //     if( isset($aos_pushed['status']) && ($aos_pushed['status'] == true) ){
        //         $android_status = true;
        //     } else {
        //         $android_status = false;
        //         $android_error_messages = $aos_pushed['error_messages'];
        //     }
        //     $android_params = $aos_pushed['params'];
        //     // end push android device

		// 	return array(
        //         'android_status' 			=> $android_status,
        //         'android_error_messages' 	=> $android_error_messages,
        //         'android_params' 			=> $android_params
        //     );
		// }

		// check invalid token
		public function feedback(){
			$feedback = array(
				'android' => array(),
				'ios' => array(),
			);

			//android

			// ios
			$this->ApplePush->set_credential( Environment::read('push.ios.pem_file'), Environment::read('push.ios.pem_password'), Environment::read('push.sandbox') );

			$feedback['ios'] = $this->ApplePush->feedback();

			return $feedback;
		}

	}
