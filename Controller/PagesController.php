<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {
	public $components = array(
		
        'Common'
	);
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	// public $current_user = '';

/**
 * Displays a view
 *
 * @return void
 * @throws ForbiddenException When a directory traversal attempt.
 * @throws NotFoundException When the view file could not be found
 *   or MissingViewException in debug mode.
 */
	public function display() {


		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		if (in_array('..', $path, true) || in_array('.', $path, true)) {
			throw new ForbiddenException();
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));

		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}

		// $path = func_get_args();

		// $count = count($path);
		// if (!$count) {
		// 	return $this->redirect('/');
		// }
		// if (in_array('..', $path, true) || in_array('.', $path, true)) {
		// 	throw new ForbiddenException();
		// }
		// $page = $subpage = $title_for_layout = null;

		// if (!empty($path[0])) {
		// 	$page = $path[0];
		// }
		// if (!empty($path[1])) {
		// 	$subpage = $path[1];
		// }
		// if (!empty($path[$count - 1])) {
		// 	$title_for_layout = Inflector::humanize($path[$count - 1]);
		// }
		// $this->set(compact('page', 'subpage', 'title_for_layout'));

		// try {
		// 	$this->render(implode('/', $path));
		// } catch (MissingViewException $e) {
		// 	if (Configure::read('debug')) {
		// 		throw $e;
		// 	}
		// 	throw new NotFoundException();
		// }
	}

	public function maintenance(){
		$this->layout = "maintenance";
	}

	public function student_portal(){
		$this->layout = "bootstrap";
	}

	public function index(){
		$this->layout = "bootstrap";
	}

	public function support(){
		$this->layout = "bootstrap";
	}

	public function profile(){
		$this->layout = "bootstrap";
		$current_user = $this->current_user;
		if (!isset($current_user) || empty($current_user)) {
			$this->redirect('/');
		}
	}
	public function profile_update(){
		$this->layout = "bootstrap";
		$current_user = $this->current_user;
		if (!isset($current_user) || empty($current_user)) {
			$this->redirect('/');
		}
	}

	public function login(){
		$this->layout = "bootstrap";
		$current_user = $this->current_user;
		if (isset($current_user) && !empty($current_user)) {
			$this->redirect('/');
		}
	}

	public function social_login($param_login_social, $access_token){
		$resp_login = $this->Common->curl_post('api/member/member_login_methods/login_social_method.json', $param_login_social);
    	$resp_login = json_decode($resp_login, true, 512, JSON_UNESCAPED_UNICODE);
    	if(isset($resp_login['status']) && $resp_login['status'] && $resp_login['status']==200){
    		$this->current_user = array('token'=>$resp_login['params']['token']);
    		// $this->current_user['token'] = $resp_login['params']['token'];
    		$current_user = $this->get_profile();
    		$keep_obj = array('token' => $current_user['token'], 'access_token' => $access_token, 'login_method_id' => $current_user['login_method']);
    		setcookie('currentuser', json_encode($keep_obj), strtotime(' + 30 days '), '/');
    		if ($current_user['is_teacher']) {
				$this->redirect(Router::url( array(
	                    'plugin' => '',
	                    'controller' => 'teacher_portals',
	                    'action' => 'index',
	                    'admin' => false
	                ), true));
			}else if($current_user['is_student']){
				$this->redirect(Router::url( array(
	                    'plugin' => '',
	                    'controller' => 'student_portals',
	                    'action' => 'index',
	                    'admin' => false
	                ), true));
			}else{
				$this->redirect('/');
			}
    	}else{
    		$this->Session->setFlash($resp_login['message'], 'flash/error');
    		$this->redirect('/');
    	}
	}

	public function gg_login_redirect(){
		$this->layout = "bootstrap";
		$this->view = "landing";
		$query = $this->request->query;
		if(isset($_GET["code"])){
			$token = $this->google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
			if(!isset($token['error'])){
				$this->google_client->setAccessToken($token['access_token']);
				$google_service = new Google_Service_Oauth2($this->google_client);
				$data = $google_service->userinfo->get();
				$param_login_social = array(
            		'language' => $this->lang18,
            		'social_token' => $token['access_token'],
            		'social_type' => 2
            	);
				if(!empty($data['name'])){
					$param_login_social['social_uuid'] = $data['id'];
					$param_login_social['name'] = $data['name'];
					$param_login_social['avatar_link'] = $data['picture'];
					$param_login_social['email'] = isset($data['email'])?$data['email']:'';
					if(isset($query['state']) && !empty($query['state'])){
	            		$invitation = json_decode($query['state'], true);
	            		if(isset($invitation['email']) && isset($invitation['role_id']) && isset($invitation['school_code']) && isset($invitation['school_id'])){
				            $param_login_social['username_link'] = $invitation['email'];
				            $param_login_social['school_id_link'] = $invitation['school_id'];
				            $param_login_social['role_id_link'] = $invitation['role_id'];
		            	}
	            	}
	            	$this->social_login($param_login_social, $token['access_token']);
				}else{
					$this->redirect('/');
				}
			}else{
				$this->redirect('/');
			}
		}		
	}

	public function fb_login_redirect(){
		$this->layout = "bootstrap";
		$this->view = "landing";
		$query = $this->request->query;
		if(isset($query['code'])){
			$req_body = array('client_id' => Environment::read('fb_app.client_id'), 'redirect_uri' => Router::url('/', true).'fb_login_redirect', 'client_secret'=> Environment::read('fb_app.client_secret'), 'code'=>$query['code']);
			$resp = $this->Common->curl_get('https://graph.facebook.com/v7.0/oauth/access_token', $req_body);
            $resp = json_decode($resp);
            if(isset($resp->error)){
            	$this->redirect('/');
            }else if(isset($resp->access_token)){
            	$access_token = $resp->access_token;
            	$req_me_body = array('fields' => 'id,email,name,picture', 'access_token' => $access_token);
				$resp_me = $this->Common->curl_get('https://graph.facebook.com/v7.0/me/', $req_me_body);
	            $resp_me = json_decode($resp_me);

	            if(isset($resp_me->name)){
	            	$userID = $resp_me->id;
	            	$param_login_social = array(
	            		'language' => $this->lang18,
	            		'social_uuid' => $userID, 
	            		'social_token' => $access_token,
	            		'social_type' => 1,
	            		'name' => $resp_me->name,
	            		'avatar_link' => $resp_me->picture->data->url,
	            		'email'=> isset($resp_me->email)?$resp_me->email:''
	            	);
	            	$state = $query['state'];
	            	if($state!='fb_redirect_infomation'){
	            		$invitation = json_decode($state, true);
	            	}

	            	if(isset($invitation['email']) && isset($invitation['role_id']) && isset($invitation['school_code']) && isset($invitation['school_id'])){
			            $param_login_social['username_link'] = $invitation['email'];
			            $param_login_social['school_id_link'] = $invitation['school_id'];
			            $param_login_social['role_id_link'] = $invitation['role_id'];
	            	}
	            	$this->social_login($param_login_social, $access_token);
	            }
            }
			
		}
		// pr($this->request);
	}

	public function register(){
		$this->layout = "bootstrap";
		$current_user = $this->current_user;
		if (isset($current_user) && !empty($current_user)) {
			$this->redirect('/');
		}
	}

	public function forgot_password(){
		$this->layout = "bootstrap";
		$this->view = "landing";

		if ($this->request->is('post')) {
			// pr($this->request);
        	$data = $this->request->data;
        	$query = $this->request->query;
        	$obj_Member = ClassRegistry::init('Member.Member');
        	$password =  $obj_Member->set_password($data['reset_forget_password']);
        	$key = $query['key'];
        	$req_body = array('language' => $this->lang18, 'key' => $key, 'password' => $password);

	        $resp = $this->Common->curl_post('api/member/member_login_methods/use_link_reset_password.json', $req_body);
	        
	        if($resp!=false){
	            $resp = json_decode($resp, true, 512, JSON_UNESCAPED_UNICODE);
	            if( isset($resp['status'])){
	            	$message = $resp['message'];
	            	if($resp['status']==200){
		        		$this->Session->setFlash($message, 'flash/reset_password_success_modal');
	            	}else{
	            		$this->Session->setFlash($message, 'flash/error');
	            	}
	            	$this->redirect('/');
	            	
	            }
	        }
        }
	}

	public function landing(){
		$this->layout = "bootstrap";
		$current_user = $this->current_user;
		$param_url = $this->params['url'];
		$request = $this->request;
		$school_approved_id = false;
		$is_school_approved = false;

		if($request->url == 'school_registration_approved'){
			$is_school_approved = true;
			$school_approved_id = $param_url['school'];
			goto endfunc;
		}
        if(isset($param_url['school_id']) && isset($param_url['school_code']) && 
            isset($param_url['email']) && isset($param_url['role_id'])){

        }else{
        	if (isset($current_user) && !empty($current_user)) {
				if ($current_user['is_teacher']) {
					$this->redirect(Router::url( array(
		                    'plugin' => '',
		                    'controller' => 'teacher_portals',
		                    'action' => 'index',
		                    'admin' => false
		                ), true));
				}else if($current_user['is_student']){
					$this->redirect(Router::url( array(
		                    'plugin' => '',
		                    'controller' => 'student_portals',
		                    'action' => 'index',
		                    'admin' => false
		                ), true));
				}
			}
        }
        
        endfunc:
		$this->set(compact('current_user', 'is_school_approved', 'school_approved_id'));

		


		// $services = array(
		// 	'tour' => 'Study Tour',
		// 	'aboard' => 'Study Aboard',
		// 	'competition' => 'Competition'
		// );

		// $this->set(compact('services'));
	}

	public function school_page(){
		$this->layout = "bootstrap";
		$layout_class = 'school-page';
		$params = $this->request->params;
		$current_user = $this->current_user;

        if (!$current_user) {
			$this->Session->setFlash(__d('member', 'please_login_first'), 'flash/error');
			$this->redirect('/');
		}

		if (!$current_user['is_teacher'] && !$current_user['is_student']) {
			$this->Session->setFlash(__d('member', 'please_login_first'), 'flash/error');
			$this->redirect('/');
		}

		$id = $this->request->params['id'];
		$school_detail = array();
		$params = array(
			'language' => $this->lang18,
			'school_id' => $id
		);

		$resp = $this->Common->curl_post('api/school/schools/get_school_by_id.json', $params);
        if($resp!=false){
            $resp = json_decode($resp, true);

            if(count($resp['params'])>0){
                $school_detail = $resp['params'][0];
     //            $school_detail['phone_prefix'] = '';
     //            if(isset($school_detail['phone_number']) && !empty($school_detail['phone_number'])){
     //            	$is_86 = preg_match("#^86(.*)$#i", $school_detail['phone_number']);
					// if($is_86 != 0){
					//     $school_detail['phone_prefix'] = '86';
					// }else{
					// 	$is_852 = preg_match("#^852(.*)$#i", $school_detail['phone_number']);
					//     if($is_852 != 0){
					// 	    $school_detail['phone_prefix'] = '852';
					// 	}else{

					// 	}
					// }
					// if(!empty($school_detail['phone_prefix'])){
					// 	$school_detail['phone_number'] = substr($school_detail['phone_number'], strlen($school_detail['phone_prefix']));
					// }
     //            }

                $school_detail['logo'] = '';
                $school_detail['banner'] = '';
                
                $school_detail['minimal_name'] = $this->Common->get_minimal_name($school_detail['name']);
                foreach ($school_detail['image'] as $i) {
                    if($i['image_type_id']==1){
                        $school_detail['logo'] = Router::url('/', true).$i['path'];
                    }
                    else if($i['image_type_id']==3){
                    	$school_detail['banner'] = Router::url('/', true).$i['path'];
                    }
                }
            }
        }

        if(count($school_detail)==0){
        	$this->Session->setFlash(__d('member', 'page_not_found'), 'flash/error');
			$this->redirect('/');
        }

        $this->set(compact('school_detail', 'current_user', 'layout_class'));
	}

	public function term_n_conditions(){
		$this->layout = "bootstrap";
	}

	public function privacy_policy(){
		$this->layout = "bootstrap";
	}

	public function maintain_page(){
		$this->layout = "default";
	}

}
