<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

	public $is_from_frontend = false;

	public $belongsTo = array(
		'CreatedBy' => array(
			'className' => 'Administration.Administrator',
			'foreignKey' => 'created_by',
			'conditions' => '',
			'fields' => array('email','name'),
			'order' => ''
		),
		'UpdatedBy' => array(
			'className' => 'Administration.Administrator',
			'foreignKey' => 'updated_by',
			'conditions' => '',
			'fields' => array('email','name'),
			'order' => ''
        ),
	);
	
    public $recursive = -1;
	public $saved_ids = array(
		'insert' => array(
			'count' => 0, 'id' => array()
		),
		'update' => array(
			'count' => 0, 'id' => array()
		)
	);

	/**
	 * beforeSave Callback for all Models
	 */
	function beforeSave( $options = array() ){

		if (isset($options['created_by'])) {
			$this->data[$this->alias]['created_by'] = $options['created_by'];
			return;
		}
		if (isset($options['updated_by'])) {
			$this->data[$this->alias]['updated_by'] = $options['updated_by'];
			return;
		}

		if ($this->hasField('updated') ){
			$this->data[$this->alias]['updated'] = date("Y-m-d H:i:s");
		}

		if ($this->hasField('updated_by')) {
			if (!$this->is_from_frontend) {// admin
				$this->data[$this->alias]['updated_by'] = CakeSession::read('Administrator.id');
			
			}
		}

		// only save the 'created' time stamp when there is NO id given
		if (!isset($this->data[$this->alias]['id']) || empty($this->data[$this->alias]['id'])) {
			if( $this->hasField('created') ){
				$this->data[$this->alias]['created'] = date("Y-m-d H:i:s");
			}
			if ($this->hasField('created_by')) {
				if (!$this->is_from_frontend) {// admin
					$this->data[$this->alias]['created_by'] = CakeSession::read('Administrator.id');
				} 
			}
		}

		$this->is_from_frontend = false;
	}

	/**
	 * afterSave Callback for all Models
	 * 
	 * count the number of records that have been inserted / updated
	 * and return the affected IDs accordingly
	 */
	function afterSave( $created, $options = array() ){
		if( $created ){
			$this->saved_ids['insert']['count']++;
			$this->saved_ids['insert']['id'][] = $this->getID();
		} else {
			$this->saved_ids['update']['count']++;
			$this->saved_ids['update']['id'][] = $this->getID();
		}

		return $this->saved_ids;
	}

	/**
	 * provide a public function to retrieve the metrics
	 */
	public function getSaveMetrics(){
		return $this->saved_ids;
	}
	
	public function generateToken( $length = "16" ){
		return substr(str_shuffle("123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}

	public function remove_uploaded_image( $images_model, $images_plugin = '',$image_ids = array()){
		$params = array();

		$result = array( 
			'status' => false, 
			'params' => $params
		);

		$removed = array();

		$conditions = array(
			'id' => $image_ids
		);

		$this->images_model = ClassRegistry::init("$images_plugin.$images_model");

		$images = $this->images_model->find('all', array(
			'fields' => array(
				$images_model.'.id', $images_model.'.path'
			),
			'conditions' => $conditions,
			'recursive' => -1
		));

		if( $images ){
			$params['removed'] = array();

			foreach ($images as $key => $image) {
				if( $this->images_model->delete($image[$images_model]['id']) ){
					$file = new File( $image[$images_model]['path'] );

					$file->delete();

					$removed[] = $image[$images_model]['id'];

					$params['removed'][] = $image[$images_model];
				}
			}
		}

		if( !empty($removed) ){
			$result = array(
				'status' => true,
				'params' => $params
			);
		}

		return $result;
	}
	
	public function convert_time_to_days($date) {
		$current_date = date("Y-m-d H:i:s"); 
		$time = array();
		$day = floor((strtotime($current_date) - strtotime($date)) / (60 * 60 * 24));

		if ($day == 0) {
			$hour = floor((strtotime($current_date) - strtotime($date)) / (60 * 60));

			if ($hour == 0) {
				$minute = floor((strtotime($current_date) - strtotime($date)) / (60));
				$time = $minute . __d('course', "minutes ago");

			} else {
				$time = $hour . __d('course', "hours ago");
			}
		
		} else {
			$time = $day . __d('course', "days ago");
		}
		
		return $time;
	}

	public function convert_second_to_days($second) {
		$time = array();
		$day = floor($second / (60 * 60 * 24));

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
		
		return $time;
	}
	
	public function hash( $string ){
		App::uses('Security', 'Utility');

		return Security::hash($string, 'sha1', true);
	}

	public function generateToken_advance( $length = "16" ){
		$length = $length < 16 ? 16 : $length;
		$unicode = uniqid(rand(), false);	// false: don't have dot signal
		return  strtoupper($unicode).substr(str_shuffle("123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length - mb_strlen($unicode));
	}





	public function create_meeting($lesson_id, $duration, $start_time, $lesson_title) {
		$curl = curl_init();

		$fields = array(
			"lessonId" 	=>  $lesson_id,
			"duration" 	=>  $duration,		// minutes
			"startTime" =>  $start_time,
			"topic" 	=>  $lesson_title,
		);
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => Environment::read('client_api') . "api/a4l/meetings", 	// "https://zoom-api-test.rabbidas.com/api/a4l/meetings",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($fields),
			CURLOPT_HTTPHEADER => array(
				"Accept: application/json",
				"Content-Type: application/json"
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	public function update_meeting($lesson_id, $duration, $start_time, $lesson_title) {
		$curl = curl_init();

		$fields = array(
			"duration" 	=>  $duration,		// minutes
			"startTime" =>  $start_time,
			"topic" 	=>  $lesson_title,
		);
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => Environment::read('client_api') . "api/a4l/meetings/"  . $lesson_id,
			// CURLOPT_URL =>    "https://zoom-api-test.rabbidas.com/api/a4l/meetings/" . $lesson_id,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "PUT",
			CURLOPT_POSTFIELDS => json_encode($fields),
			CURLOPT_HTTPHEADER => array(
				"Accept: application/json",
				"Content-Type: application/json",
				"Content-Type: text/plain"
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		return $response;
	}


	public function delete_meeting($class_lesson_id) {

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => Environment::read('client_api') . "api/a4l/meetings/"  . $class_lesson_id,
			//CURLOPT_URL => "https://zoom-api-test.rabbidas.com/api/a4l/meetings/" . $class_lesson_id,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "DELETE",
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
	}



	public function format_date_time($language) {
		return date(Environment::read('locale_format.' . $language));
	}

	// 1h-3h => 2h-8h
	public function check_time_overlap($start_time1, $end_time1, $start_time2, $end_time2) {

		//return (strtotime($start_time1) <=  strtotime($end_time2) && strtotime($start_time2) <= strtotime($end_time1) ? true : false);
		return (($start_time1) <=  ($end_time2) && ($start_time2) <= ($end_time1) ? true : false);
	}

	
	public function get_lang_from_db(){
		$objlang = ClassRegistry::init('Dictionary.Language');
		
		$options = array(
			'fields' => array('Language.alias'),
			'conditions' => array(
				'Language.enabled' => 1 
			),
			'recursive' => -1
		);
		
		$available_language = array_values($objlang->find('list', $options));
		return $available_language;
	}

}
