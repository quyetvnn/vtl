<?php
/**
 * Custom Component for push notification
 * 
 * @author vi.lh@vtl-vtl.com
 */
	// App::uses('Component', 'Controller');

	class PushCommonComponent extends Component {
	
		// notify sound
		public $aps_sound = "default";

		// notify badge
		public $aps_badge = "1";

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

         public function push($device_data, $message, $push_params) {
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

				// device_data
				// Array
				// (
				// 	[0] => arrayfSiW2K4tzpY:APA91bGxwkrBAI2FR3Dt5iAMwfhxLeCdSz62HCzF_4xRT4dcWw61bQxUjV7T0JK4hSKYTP2wG--A_pWGAfXlxH9vO68rR_h0crChNnGR0vnDUkgpe2KzGNsZgICEuYX0xCs5KilX3RhJ
				// 	[1] => fSiW2K4tzpY:APA91bGxwkrBAI2FR3Dt5iAMwfhxLeCdSz62HCzF_4xRT4dcWw61bQxUjV7T0JK4hSKYTP2wG--A_pWGAfXlxH9vO68rR_h0crChNnGR0vnDUkgpe2KzGNsZgICEuYX0xCs5KilX3RhJ
				// )

                $fields = array(
					// 'to' => $device_data[0]['device_token'],
					'registration_ids' => $device_data,	// $device_data[0]['device_token'],
					'notification' 	=> array(
						'body'		=> $message['notification']['body'],
						'title'		=> $message['notification']['title'],
					),
					'priority' => 'high',
					'data' => isset($push_params['custom_data']) ? $push_params['custom_data'] : '',

      			);
				
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

                $result = curl_exec($ch);

				// {"multicast_id":9114866147884203417,"success":1,"failure":3,"canonical_ids":0,
				//	"results":[{"message_id":"0:1576208394681875%cb43adbbcb43adbb"},{"error":"InvalidRegistration"},
				//				{"error":"NotRegistered"},{"error":"NotRegistered"}]}
			
				$temp = json_decode($result, true);
				if ($temp['failure'] == 0) {		// dont have fail case
					$succeed_case = $device_data;
					$failed_case = array();

				} else {		// exist fail case
					$index = 0;
					foreach ($temp['results'] as $value) {
						
						if (isset($value['error'])) {
						 	$failed_case[] = $device_data[$index];
						
						} else {
							$succeed_case[] = $device_data[$index];
						}

						$index = $index + 1;
					}
				}

				$pushed = array(
                    'status' => true,
					'params' => array(
						'result'		=> $result,
						'succeed' 		=> $succeed_case,
						'failed' 		=> $failed_case,
					),
                );
			} catch (Exception $e) {
              	$pushed = array(
                    'status' => false,
					'params' => array(),
                    'error_messages' => $e->getMessage(),
                );

			} finally {
				curl_close($ch);	 // Close the connection to the server
			}
	
			return $pushed;
		}

		public function set_sound($sound) {
			$this->aps_sound = $sound;
		}

		public function set_badge($badge) {
			$this->aps_badge = $badge;
		}
    }
    