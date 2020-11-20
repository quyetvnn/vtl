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
class TestsController extends AppController {

	// public $components = array(');

	public $components = array(

		'Paginator',
		
		'Email',

		// Enable ExcelReader in PhpExcel plugin
		'PhpExcel.ExcelReader',

		// Enable PhpExcel in PhpExcel plugin
		'PhpExcel.PhpExcel',
	);

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	public function pagination() {

		$obj_Member = ClassRegistry::init('Log.LogApi');
		$result = $obj_Member->find('all', array(
			'recursive' => 2,
			'limit' => 3, 
			'offset' => 3,	// get from the row offset 
		));

		pr ($result);
		exit;
	}

	public function index(){
		$this->layout = "bootstrap";
		$is_space_username = ctype_space("ss 0001");
		$is_space_username = ctype_space("ss0001");

		if ( preg_match('/\s/', "ss  0001")) {	/// // exist space in username
			pr ('yesss');

		} else {
			pr ('noooo');
		}

		pr ($is_space_username);
		exit;

	}

	// done
	public function send_mail() {
	

		$this->layout = "bootstrap";
		// $template = "contact_us";
		// $data = array(
		// 	'name' => 'anhlaai',
		// 	'phone' => '0906440368',
		// 	'email' => 'huuvi168@gmail.com',
		// 	'message' => 'HOW ARE YOU',
		// );
		$template = "test";
		$data_Email = array(
			'username' => 'abc',
			'code' => '6737',
		);

		$send_to = 'quyet.vo@vtl-vtl.com';
		// $result_email = $this->Email->send("info@all4learn.com", __d('fact', 'subject_contact_us'), $template, $data);
		$result_email = $this->Email->send($send_to, __d('member', 'subject_confirm'), $template, $data_Email);

		$this->set(compact('result_email'));

		if($result_email['status']){
			$flag = true;
			$message = __('retrieve_data_successfully') . $send_to;
		}else{
			$message = $result_email['message'];
		}


	}

	public function import_excel() {

		$this->layout = "bootstrap";

		$renamed_file_full_path = WWW_ROOT . 'uploads' . DS . 'import' . DS . 'abc.xlsx';
		$this->ExcelReader->loadExcelFile( $renamed_file_full_path );

		// if read successfully, get the result array
		$data = $this->ExcelReader->dataArray;

		$this->set(compact('data'));
	}
}
