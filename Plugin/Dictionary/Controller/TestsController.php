<?php
App::uses('DictionaryAppController', 'Dictionary.Controller');
/**
 * Languages Controller
 *
 * @property Language $Language
 */
class TestsController extends DictionaryAppController {

    private function test_push($aos_token, $ios_token, $title, $body) {
        $devices['ios'] = array(
            'device' => array(
                'member_id' => 1,
                'device_token' => $ios_token, //"37FF42C3C4C571556C8063F3CD45E8346BBEDA4A980A07BFAA77C0F2AAC90AAC",)
            ),
        );
            
        $devices['android'] =  array(
            'device' => array(
                'member_id' => 1,
                'device_token' => $aos_token, //"37FF42C3C4C571556C8063F3CD45E8346BBEDA4A980A07BFAA77C0F2AAC90AAC",)
            ),
        );

        // message for push
        $android_message = array(
            "notification" => array(
                'title' =>  $title,
                'body' =>   $body,
            ),
            // "custom_data" => $custom_data,
        );

        $ios_message = array(
            "notification" => array(
                'title' =>  $title,
                'body' =>   $body,
            ),
        );

        $push_params = array(
            "custom_data" => array(
                'id' =>  11,
                'content' =>  "",
            )
        );
        
        $push_result = $this->Notification->push($devices['ios'], $ios_message, 
                                                $devices['android'], $android_message, $push_params);

        return array(
            'ios_status'             => $push_result['ios_status'],
            'ios_error_messages'     => $push_result['ios_error_messages'],
            'android_status'         => $push_result['android_status'],
            'android_error_messages' => $push_result['android_error_messages'],
            'ios_params'             => $push_result['ios_params'],
            'android_params'         => $push_result['android_params'],
        );
    }

    private function test_push_ios($ios_token, $title, $body) {
        $devices['ios'] = array(
            'device' => array(
                'member_id' => 1,
                'device_token' => $ios_token, //"37FF42C3C4C571556C8063F3CD45E8346BBEDA4A980A07BFAA77C0F2AAC90AAC",)
            ),
        );

        $ios_message = array(
            "notification" => array(
                'title' =>  $title,
                'body' =>   $body,
            ),
        );

        $push_params = array(
            "custom_data" => array(
                'id' =>  11,
                'content' =>  "",
            )
        );
        
        $push_result = $this->Notification->push_ios_device($devices['ios'], $ios_message, $push_params);

        return array(
            'ios_status'            => $push_result['ios_status'],
            'ios_error_messages'    => $push_result['ios_error_messages'],
            'ios_params'            => $push_result['ios_params'],
        );
    }

    private function test_push_aos($aos_token, $title, $body) {
        $devices['aos'] = array(
            'device' => array(
                'member_id' => 1,
                'device_token' => $aos_token, //"37FF42C3C4C571556C8063F3CD45E8346BBEDA4A980A07BFAA77C0F2AAC90AAC",)
            ),
        );

        $ios_message = array(
            "notification" => array(
                'title' =>  $title,
                'body' =>   $body,
            ),
        );

        $push_params = array(
            "custom_data" => array(
                'id' =>  11,
                'content' =>  "",
            )
        );
        
        $push_result = $this->Notification->push_aos_device($devices['aos'], $ios_message, $push_params);

        return array(
            'android_status'             => $push_result['android_status'],
            'android_error_messages'     => $push_result['android_error_messages'],
            'android_params'                => $push_result['android_params'],
        );
    }

    public function api_push_aos() {
     
        $this->Api->init_result();
        $message  = "";
        $feedback = false;
        $arr_params = array();
        if ($this->request->is('post')) {
            $this->disableCache();
            $data = $this->request->data;

            $this->Api->set_language('eng');
            if (!isset($data['token']) && empty($data['token'])) {
                $message = __('missing_parameter') . 'token';
                goto load_data_api;
            }
            
			if (!isset($data['title']) || empty($data['title'])) {
                $message = __('missing_parameter') . 'title';
                goto load_data_api;
            }

            if (!isset($data['message']) || empty($data['message'])) {
                $message = __('missing_parameter') . 'message';
                goto load_data_api;
            }

            $result = $this->test_push_aos($data['token'], $data['title'], $data['message']);

            $feedback = $result['android_status'];
            $message = isset($result['android_error_message']) ? $result['android_error_message'] : '';
            $arr_params_aos =  $result['android_params'];
        }
        
        load_data_api:
        $this->Api->set_result($feedback, $message, $arr_params);
    
        $this->Api->output();
    }

    public function api_push_ios() {
     
        $this->Api->init_result();
        $message  = "";
        $feedback = false;
        $arr_params = array();
        if ($this->request->is('post')) {
            $this->disableCache();
            $data = $this->request->data;

            $this->Api->set_language('eng');
            if (!isset($data['token']) && empty($data['token'])) {
                $message = __('missing_parameter') . 'token';
                goto load_data_api;
            }
            
			if (!isset($data['title']) || empty($data['title'])) {
                $message = __('missing_parameter') . 'title';
                goto load_data_api;
            }

            if (!isset($data['message']) || empty($data['message'])) {
                $message = __('missing_parameter') . 'message';
                goto load_data_api;
            }

            $result = $this->test_push_ios($data['token'], $data['title'], $data['message']);

            $feedback = $result['ios_status'];
            $message = isset($result['ios_error_message']) ? $result['ios_error_message'] : '';
            $arr_params_aos =  $result['ios_params'];
        }
        
        load_data_api:
        $this->Api->set_result($feedback, $message, $arr_params);
    
        $this->Api->output();
    }

    public function api_send_push() {
     
        $this->Api->init_result();
        $message  = "";
        $feedback = false;
        $arr_params = array();
        if ($this->request->is('post')) {
            $this->disableCache();
            $data = $this->request->data;

            $this->Api->set_language('eng');
          
			if (!isset($data['title']) || empty($data['title'])) {
                $message = __('missing_parameter') . 'title';
                goto load_data_api;
            }

            if (!isset($data['message']) || empty($data['message'])) {
                $message = __('missing_parameter') . 'message';
                goto load_data_api;
            }

            $arr_params_aos = array();
            $arr_params_ios = array();

            if (isset($data['aos_token']) && !empty($data['aos_token'])) {
                $result = $this->test_push_aos($data['aos_token'], $data['title'], $data['message']);

                $feedback = $result['android_status'];
                $message = isset($result['android_error_message']) ? $result['android_error_message'] : '';
                $arr_params_aos =  $result['android_params'];

            }

            if (isset($data['ios_token']) && !empty($data['ios_token'])) {
                $result = $this->test_push_ios($data['ios_token'], $data['title'], $data['message']);

                $feedback = $result['ios_status'];
                $message = isset($result['ios_error_messages']) ? $result['ios_error_messages'] : '';
                $arr_params_ios =  $result['ios_params'];
            }

            $res = array(
                $arr_params_aos,
                $arr_params_ios 
            );
            
            $arr_params =  $res;
        }
        
        load_data_api:
        $this->Api->set_result($feedback, $message, $arr_params);
    
        $this->Api->output();
    }

    public function api_get_code_email(){
        $this->Api->init_result();
        if ($this->request->is('post')) {
            $this->disableCache();
            $data = $this->request->data;
            
            $feedback = false;
            $message = "";
            $arr_params = array();

            if( isset($data['language']) && !empty($data['language']) ){
                $this->Api->set_language( $data['language'] );
            }
            
			if( !isset($data['email']) || empty($data['email']) ){
                $message = __('missing_parameter') .  ' email';
            } else if( !isset($data['method']) || empty($data['method']) ){
                $message = __('missing_parameter') .  ' method';
            } else if( !isset($data['action']) || empty($data['action']) ){
                $message = __('missing_parameter') .  ' action';
            } else {
                // check member is valid 
                $objMember = ClassRegistry::init('Member.Member');
                $member_data = $objMember->find('first', array(
                    'conditions' => array(
                        'Member.email' => $data['email'],
                        'Member.company_id' => Environment::read('company.id'),
                    )
                ));

                if(!$member_data){
                    $message = __d('member', 'invalid_member');
                    goto load_data_api;
                }

                $member = $member_data['Member'];

                $objVerificationType = ClassRegistry::init('Member.VerificationType');
                $method_id = $objVerificationType->field('id', array(
                    'VerificationType.slug like' => '%' . $data['method'] . '%' 
                ));

                if(!$method_id){
                    $message = "[" . __d('member', 'verification_method') . "]" . __('invalid_data');
                    goto load_data_api;
                }

                $action_id = $objVerificationType->field('id', array(
                    'VerificationType.slug like' => '%' . $data['action'] . '%' 
                ));

                if(!$action_id){
                    $message = "[" . __d('member', 'verification_action') . "]" . __('invalid_data');
                    goto load_data_api;
                }


                // member verification
                $objMemberVerification = ClassRegistry::init('Member.MemberVerification');
                $result_verify = $objMemberVerification->find('first', array(
                    'conditions' => array(
                        'MemberVerification.enabled' => true,
                        'MemberVerification.member_id' => $member['id'],
                        'MemberVerification.verification_method_id' => $method_id,
                        'MemberVerification.verification_action_id' => $action_id,
                    )
                ));

                if(!$result_verify){
                    $message = "[" . __d('member', 'member_verification') . "]" . __('invalid_data');
                    goto load_data_api;
                }

                $feedback = true;
                $message = __('retrieve_data_successfully');
                $arr_params = $result_verify['MemberVerification'];
            }
            
            load_data_api:
            $this->Api->set_result($feedback, $message, $arr_params);
        }

		$this->Api->output();
    }

    public function api_get_shop_by_id(){
        $this->Api->init_result();
        if ($this->request->is('post')) {
            $this->disableCache();
            $data = $this->request->data;
            
            $feedback = false;
            $message = "";
            $arr_params = array();

            if( isset($data['language']) && !empty($data['language']) ){
                $this->Api->set_language( $data['language'] );
            }
            
			if( !isset($data['shop_id']) || empty($data['shop_id']) ){
                $message = __('missing_parameter') .  ' shop_id';
            } else {
                // check member is valid 
                $objShop = ClassRegistry::init('Company.Shop');
                $shop_data = $objShop->find('first', array(
                    'conditions' => array(
                        'Shop.id' => $data['shop_id'],
                    ),
                    'contain' => array(
                        'ShopDetail' => array(
                            'conditions' => array('status' => array_search('Approved', $objShop->status))
                        )
                    )
                ));

                if(!$shop_data){
                    $message = "[" . __('shop') . "]" . __('invalid_data');
                    goto load_data_api;
                }

                $feedback = true;
                $message = __('retrieve_data_successfully');
                $shop = reset($shop_data['ShopDetail']);
                $shop['shop_detail_id'] = $shop['id'];
                unset($shop['id']);
                unset($shop['shop_id']);
                $arr_params = array_merge($shop, $shop_data['Shop']);
            }
            
            load_data_api:
            $this->Api->set_result($feedback, $message, $arr_params);
        }

		$this->Api->output();
    }
}
