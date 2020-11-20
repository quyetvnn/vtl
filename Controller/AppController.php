<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');
App::import('Vendor', array('file' => 'autoload'));
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array(
		// Enable DebugKit toolbar (when debug is set to >= 1)
		'DebugKit.Toolbar' => array(
			'panels' => array('ClearCache.ClearCache')
		),

		// Enable JSON or XML view
        'RequestHandler',
        
		// Enable SessionComponent
		'Session',

		// Enable FlashComponent
		'Flash',

		// Enable general functions in CommonComponent
        'Common',
        
		// Enable CookieComponent
		'Cookie',

		// Enable ApiComponent
        'Api',
        
        // Excel component
        'ExcelSpout',   
		
		// Enable PushComponent
		'Notification',

		// Enable LogFileComponent
		'LogFile',

	);

	public $helpers = array( 'Session', 'Flash' );
	public $lang18 = 'zho';
    public $current_user = '';
	// public $theme = "CakeAdminLTE";	// all project use this theme

    /*Google config*/
    public $google_client;
    /*Google config*/

	protected $school_id = false;
    protected $is_admin = false;
    protected $role_school_admin = false;
    
    private $allow_actions = array('index', 'add', 'edit', 'view', 'delete', 'approve', 'import');

	public function beforeFilter(){

		$this->layout  = 'bootstrap';
        //Set the OAuth 2.0 Client ID
        $this->google_client = new Google_Client();
        $this->google_client->setClientId(Environment::read('gg_app.client_id'));

        //Set the OAuth 2.0 Client Secret key
        $this->google_client->setClientSecret(Environment::read('gg_app.client_secret'));

        //Set the OAuth 2.0 Redirect URI
        $this->google_client->setRedirectUri(Router::url('/', true).'gg_login_redirect');
        $this->google_client->addScope('email');
        $this->google_client->addScope('profile');

        
		$permissions = array();
        $login_gg_url = '';
		
 		if($this->request->plugin == "administration" && $this->request->controller == "administrators" &&
                ($this->request->action == "admin_login" || $this->request->action == "admin_logout"
                || $this->request->action == "admin_forgot_password" || $this->request->action == "admin_change_password")){
            return;
        }

		// $this->current_user = $this->Session->read('Member.current'); 

        // set and get language  *****
        $obj_Administrator = ClassRegistry::init('Administration.Administrator');
        $available_language = $obj_Administrator->get_lang_from_db();

		$params = $this->request->params;

		if(isset($this->request->data["set_new_language"]) && $this->request->data["set_new_language"] != "" &&
			in_array($this->request->data["set_new_language"], $available_language)){

			$url_params = array();
			foreach($this->request->query as $key => $value){
				array_push($url_params, $key . '=' . $value);
			}
			
			if (isset($params['prefix']) && ($params['prefix'] == "admin")) {	// admin
				$arr_url = array(
					'plugin' => $params['plugin'],
					'controller' => $params['controller'],
					'action' => $params['action'],
					'admin' => true,
				);
			} else {		// frontend
                if($params['controller']=='pages' && $params['action'] == 'school_page'){
                    $arr_url = array(
                        'plugin' => $params['plugin'],
                        'controller' => $params['controller'],
                        'action' => $params['action'],
                        'admin' => false,
                        'id' => $this->request->params['id']
                    );
                }else{
                    $arr_url = array(
                        'plugin' => $params['plugin'],
                        'controller' => $params['controller'],
                        'action' => $params['action'],
                        'admin' => false,
                    );
                }
				
			}
		
			foreach($params['pass'] as $item){
				array_push($arr_url, $item);
			}

			$current_url = Router::url($arr_url, true) . ($url_params ? '?' . implode('&', $url_params) : '');
			$this->Session->write('Config.language', $this->request->data["set_new_language"]);
			$this->redirect($current_url);
		}

		$this->lang18 = $this->Session->read('Config.language') ? $this->Session->read('Config.language'): 'zho';
		$this->Session->write('Config.language', $this->lang18);
	
		if (!$this->Session->check('Config.language')) {
            $new_lang = Environment::read('web.default_language');
            $this->Session->write('Config.language', $new_lang);
        }
		
		// $this->set(compact('current_user','permissions', 'available_language'));
		$this->set(compact('available_language'));
	
		// ---------- admin here ---------
		if ($this->lang18 && file_exists(APP . 'View' . DS . $this->lang18 . DS . $this->viewPath . DS . $this->view . $this->ext)) {
            $this->viewPath = $this->lang18 . DS . $this->viewPath;
        }

        $school_info = array();
        $current_user = array();
		if (isset($params['prefix']) && ($params['prefix'] == "admin")) {

            // log befor filter
			$url_action = $this->getCurrentFunctionInfo();
            $this->LogFile->writeLogStart($url_action);
            

            $data = ($this->request->is('post') || $this->request->is('put')) ? $this->request->data : ($this->request->is('get') ? $this->request->query : array());

            if($data){
                $this->LogFile->writeLog($this->LogFile->get_request(), $data);
            }
       
            /***** Start Secure on web ******/
			if( !($this->Session->check('Administrator.id') && $this->Session->check('Administrator.current')) ){
                $arr_url = array(
                    'plugin' => $params['plugin'],
                    'controller' => $params['controller'],
                    'action' => $params['action'],
                    'admin' => true,
                );
                if($params['pass']){
                    foreach($params['pass'] as $item){
                        array_push($arr_url, $item);
                    }
                }
                
                $arr_url['?'] = $this->request->query;

                $current_url = Router::url($arr_url, true);

                return $this->redirect( Router::url( array(
                    'plugin' => 'administration',
                    'controller' => 'administrators',
                    'action' => 'login',
                    'admin' => true,
                    '?' => array('last_url' => $current_url)
                ), true));
            }

            $current_user = $this->Session->read('Administrator.current');
            $this->is_admin = isset($current_user['is_admin']) ? $current_user['is_admin'] : false;
            $this->role_school_admin = isset($current_user['role_school_admin']) ? $current_user['role_school_admin'] : false;

            $this->school_id = array();
            if(isset($current_user['school_id']) && $current_user['school_id']){
                $this->school_id = $current_user['school_id'];
            }

            $permissions = $current_user['Permission'];
            unset($current_user['Permission']);

    
            // check permission in action
            $arr_action = explode('_', $params['action']);
            $action = strtolower(end($arr_action));

            if($action == 'index'){
                $action = 'view';
            }  

            if (in_array($action, $this->allow_actions)) {
                $has_permission = array_filter($permissions, function($item) use($params, $action){

                    return strtolower($item['p_plugin']) == strtolower($params['plugin']) && 
                        strtolower($item['p_controller']) == strtolower($params['controller']) && isset($item[$action]);
                });

                if (!$has_permission) {
					$this->theme = "CakeAdminLTE";
					$this->layout = "default";

                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
						echo __('invalid_permission'); 
						exit;

                    } else {
                        throw new NotFoundException(__('invalid_permission'));
                    }
                }
            }

            $this->ObjLog = ClassRegistry::init('Log.Log');
        }else{
            // frontend;
            $params = $this->request->params;
            $param_url = $this->params['url'];
            if(isset($param_url['school_id']) && isset($param_url['school_code']) && 
                isset($param_url['email']) && isset($param_url['role_id'])){
                if(isset($_COOKIE['currentuser'])){
                    setcookie("currentuser", "", 1, '/');
                    echo "<script>location.reload();</script>";
                }
                $email_invited = $param_url['email'];
                
                $api_params = array('language'=>$this->lang18, 'school_id'=>$param_url['school_id']);
                $resp = $this->Common->curl_post('api/school/schools/get_school_by_id.json', $api_params);

                if($resp!=false){
                    $resp = json_decode($resp, true);

                    if(count($resp['params'])>0){
                        $school_info = $resp['params'][0];
                        $school_info['avatar'] = '';
                        $school_info['role_id'] = $param_url['role_id'];
                        $school_info['email_link'] = $param_url['email'];
                        $school_info['school_code_link'] = $param_url['school_code'];
                        foreach ($school_info['image'] as $i) {
                            if($i['image_type_id']==1){
                                $school_info['avatar'] = Router::url('/', true).$i['path'];

                            }
                        }
                        $state = json_encode($param_url);
                        $this->google_client->setState($state);
                    }
                }
                
            }else{
                if (!isset($params['prefix'])) {
                    if(isset($_COOKIE['currentuser'])){
                        $current_user = json_decode(urldecode($_COOKIE['currentuser']), true);
                        $this->current_user = $current_user;
                        if(!isset($current_user['token']) || empty($current_user['token'])){
                            setcookie("currentuser", "", 1, '/');
                            echo "<script>window.location='".Router::url('/', true)."'</script>";
                        }else{
                            if(isset($current_user['login_method_id'])){
                                if($current_user['login_method_id'] == Environment::read('fb_app.login_method_id')){
                                    $req_me_body = array('fields' => 'id,email,name,picture', 'access_token' => $current_user['access_token']);
                                    $resp_me = $this->Common->curl_get('https://graph.facebook.com/v7.0/me/', $req_me_body);
                                    $resp_me = json_decode($resp_me);
                                    if(!isset($resp_me->name) || empty($resp_me->name)){
                                        setcookie("currentuser", "", 1, '/');
                                        echo "<script>window.location='".Router::url('/', true)."'</script>";
                                    }
                                }else if($current_user['login_method_id'] == Environment::read('gg_app.login_method_id')){
                                    $req_me_body = array('access_token' => $current_user['access_token']);
                                    $resp_me = $this->Common->curl_get('https://oauth2.googleapis.com/tokeninfo', $req_me_body);
                                    $resp_me = json_decode($resp_me);
                                    if(!isset($resp_me->expires_in) || empty($resp_me->expires_in) ){
                                        setcookie("currentuser", "", 1, '/');
                                        echo "<script>window.location='".Router::url('/', true)."'</script>";
                                    }
                                }
                            }
                            $current_user = $this->get_profile();
                            $this->current_user = $current_user;
                        }
                    }
                }
            }
            if(!isset($current_user) || empty($current_user)){
                $login_gg_url = $this->google_client->createAuthUrl();
            }
            
            $this->school_info = $school_info;
        }

        $this->set(compact('current_user', 'school_info', 'permissions', 'login_gg_url'));
        
        $is_admin = $this->is_admin;
        $role_school_admin = $this->role_school_admin;

        $this->set(compact('is_admin', 'role_school_admin'));
	}
	


	// get current function name, purpose write log
	protected function getCurrentFunctionInfo() {
        $method = '';
        if($this->request->is('post')){
            $method = 'POST';
        }else if($this->request->is('get')){
            $method = 'GET';
        }else if($this->request->is('put')){
            $method = 'PUT';
        }else if($this->request->is('delete')){
            $method = 'DELETE';
        }
		return $this->request->url . ' [' .  $method . ']';
    }

	public function beforeRender(){
        $params = $this->request->params;

        
		if ( isset($params['prefix']) ) {
            switch($params['prefix']){
                case "admin":
                    if($this->Session->check('Message.flash')){
                        $messages = $this->Session->read('Message.flash');
                        if(isset(reset($messages)['message'])){
                            $this->LogFile->writeLog($this->LogFile->get_response_success(), reset($messages)['message']);
                        }
                    }
                    if($this->Session->check('Message.flash_error')){
                        $messages = $this->Session->read('Message.flash_error');
                        if(isset(reset($messages)['message'])){
                            $this->LogFile->writeLog($this->LogFile->get_response_error(), reset($messages)['message']);
                        }
                    }
                    break;
                case "api": // all post
                 
                    if (isset($this->request->data['password'])) {
                        unset($this->request->data['password']);
                    }
                    $this->LogFile->writeLog($this->LogFile->get_response_success(), $this->request->data);
                    break;
            }
        }

        $url_action = $this->getCurrentFunctionInfo();
        $this->LogFile->writeLogEnd($url_action);
    }

	public function admin_add_new_image() {
		$data = $this->request->data;

		if ($data) {
			$images_model = $data['images_model'];

			$this->set(compact('images_model'));
            $this->render('Pages/add_new_image');   // call add_new_image.ctp
            
		}else{
			return 'NULL';
		}
    }
    
	public function admin_add_new_image_with_type() {
		$data = $this->request->data;

		if ($data) {
			$images_model = $data['images_model'];

            // init imagetype
            $objImageType = ClassRegistry::init('Dictionary.ImageType');
			$imageTypes = $objImageType->find_list(array(
                'ImageType.slug LIKE' => strtolower($data['base_model']) . "%"
            ), $this->lang18);

			$this->set(compact('imageTypes', 'images_model'));
			$this->render('Pages/add_new_image_with_type');      // call pages/add_new_image_with_type.ctp
		}else{
			return 'NULL';
		}
    }

    public function get_profile(){
        if(!isset($this->current_user) || empty($this->current_user)) {
            return array();
        }

        $lang = $this->lang18;
        $req_body = array('token' => $this->current_user['token'], 'language' => $lang);
        $obj_user = array();
        $resp_profile = $this->Common->curl_post('api/member/member_login_methods/get_profile.json', $req_body);
        if($resp_profile!=false){
            $resp_profile = utf8_decode($resp_profile);
            $resp_profile = json_decode($resp_profile, true, 512, JSON_UNESCAPED_UNICODE);
            
            if( isset($resp_profile['status']) && $resp_profile['status']==200){
                $resp_profile = $resp_profile['params'];
                $MemberLoginMethod = $resp_profile['MemberLoginMethod'];

                $obj_user = array(
                    'id'=> $MemberLoginMethod['id'],
                    'member_id'=> $MemberLoginMethod['member_id'],
                    'username'=> $MemberLoginMethod['username'],
                    'name'=> '',
                    'token'=> $MemberLoginMethod['token'],
                    'verified'=> '',
                    'login_method'=> $MemberLoginMethod['school_id'],
                    'community'=> [],
                    'avatar'=> '',
                    'email'=> '',
                    'member_role'=> [],
                    'role_id' => [],
                    'schools' => [],
                    'is_teacher' => false,
                    'is_student' => false,
                    'is_school_admin' => false,
                    'is_self_register' => false,
                );
                $Member = $resp_profile['Member'];
                $obj_user['email']     = $resp_profile['Member']['email'];
                $obj_user['nick_name'] = $MemberLoginMethod['display_name'];
                if(count($Member['MemberImage'])>0){
                    foreach ($Member['MemberImage'] as $item) {
                        if($item['image_type_id']==2){
                            $obj_user['avatar'] =  Router::url('/', true).$item['path'];
                            break;
                        }
                    }
                }
                if(count($Member['MemberLanguage'])>0){
                    $member_lang = $Member['MemberLanguage'][0];
                    $obj_user['name'] = $member_lang['name'];
                    $obj_user['first_name'] = $member_lang['first_name'];
                    $obj_user['last_name'] = $member_lang['last_name'];


                    if(isset($obj_user['name']) && !empty($obj_user['name'])){
                        $obj_user['full_name'] = $obj_user['name'];
                    }else{
                        if($obj_user['last_name']=='' && $obj_user['first_name'] ==''){
                            $obj_user['full_name'] = $MemberLoginMethod['username'];
                        }else{
                            $obj_user['full_name'] = $member_lang['last_name'] . ' '.$member_lang['first_name'];
                        }
                    }
                }
                if($obj_user['avatar']==''){
                    $obj_user['tmp_avatar'] = "https://ui-avatars.com/api/?name=".$obj_user['full_name'];
                }
                if(isset($Member['community']) && $Member['community']!=''){
                    if(count($Member['community'])>0){
                        $obj_user['community'] = $Member['community'];
                        foreach ($obj_user['community'] as $i=>$item) {
                            foreach ($item['image'] as $j=>$img ) {
                                $obj_user['community'][$i]['image'][$j]['path'] = Router::url('/', true).$img['path'];
                            }
                            $obj_user['community'][$i]['minimal_name'] = $this->Common->get_minimal_name($item['name']);
                        }
                    }
                }
                if(isset($Member['MemberRole']) && !empty($Member['MemberRole'])){
                    for($i=0;$i<count($Member['MemberRole']); $i++){
                        $school_id = $Member['MemberRole'][$i]['school_id'];
                        $role_id = $Member['MemberRole'][$i]['role_id'];
                        $school = $Member['MemberRole'][$i]['School'];
                        if( isset($school['status']) && $school['status'] != 1) continue;
                        if(!in_array($role_id, $obj_user['role_id'])) {
                            array_push($obj_user['role_id'], $role_id);
                            $obj_user['member_role'][$role_id] = array();
                        }
                        if(isset($school['SchoolImage'])){
                            foreach ($school['SchoolImage'] as $key => $value) {
                                if($value['image_type_id']==1){
                                    $Member['MemberRole'][$i]['avatar'] = Router::url('/', true).$value['path'];
                                    break;
                                }
                            }
                        }
                        $Member['MemberRole'][$i]['name'] = '';
                        $Member['MemberRole'][$i]['minimal_name'] = '';
                        if(isset($school['SchoolLanguage'])){
                            $Member['MemberRole'][$i]['name'] = $school['SchoolLanguage'][0]['name'];
                            $Member['MemberRole'][$i]['minimal_name'] = $this->Common->get_minimal_name($school['SchoolLanguage'][0]['name']);
                        }
                        array_push($obj_user['member_role'][$role_id], $Member['MemberRole'][$i]);

                        $is_exists = array_filter($obj_user['schools'], function($k) use ($school_id) {
                            return $k == $school_id;
                        }, ARRAY_FILTER_USE_KEY);
                        if(empty($is_exists) && $role_id!=Environment::read('role.register')){
                            $obj_user['schools'][$school_id] = $Member['MemberRole'][$i];
                        }
                    }
                }
                if(in_array(Environment::read("role.student"), $obj_user['role_id'])){
                    $obj_user['is_student'] = true;
                }
                if(in_array(Environment::read("role.teacher"), $obj_user['role_id'])){
                    $obj_user['is_teacher'] = true;
                }
                if(in_array(Environment::read("role.school-admin"), $obj_user['role_id'])){
                    $obj_user['is_school_admin'] = true;
                }
                if(in_array(Environment::read("role.register"), $obj_user['role_id'])){
                    $obj_user['is_self_register'] = true;
                }
            }
        }
        // setcookie('currentuser', json_encode($keep_obj), strtotime( '+30 days' ), Router::url('/', true));
        return $obj_user;
    }

    public function convert_second_to_format_time($second) {
		$time = array();
        $day = floor($second / (60 * 60 * 24));
        $minute = $hour = array();

		if ($day == 0) {
            $hour = floor($second / (60 * 60));
            
            if ($hour == 0) {
                $minute = floor($second / (60));
                $time = $minute . __d('course', "minutes");
                
            } else {
                $time = $hour . __d('course', "hours");
            }
		
		
		} else {
			$time = $day . __d('course', "days");
        }
        
		return array(
            'day'       => $day,
            'hour'      => $hour,
            'minute'    => $minute,
            'time'      => $time,
        );
    }
    
	public function get_end_time($day, $duration_hour_id, $duration_minute_id) {
	
		$duration_hour = $duration_hour_id;
		$duration_minute = $this->get_duration_minute($duration_minute_id);
		$hour = '+' . $duration_hour . ' hour';
		$minute = '+' . $duration_minute . ' minute';
		$end_time = date('Y-m-d H:i:s', strtotime($day . $hour . $minute));
		return $end_time;
    }
    
	public function get_duration_minute($key) {
		$durationMinutes = $this->TeacherCreateLesson->duration_minutes;
		return $durationMinutes[$key];
    }
    
    
}
