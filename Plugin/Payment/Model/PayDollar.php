<?php
App::uses('PaymentAppModel', 'Payment.Model');

/**
 * PayDollar Model
 *
 * @property Member $Member
 * @property School $School
 */
class PayDollar extends PaymentAppModel {

	public $actsAs = array('Containable');

	public $log_module = 'PayDollar';

	public $status = array(
		0 => 'Succeed',
		1 => 'Failed',
		2 => 'Processing',
	);
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		
		'Ref' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'PayRef' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'successcode' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'Amt' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'Cur' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Member' => array(
			'className' => 'Member.Member',
			'foreignKey' => 'member_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'School' => array(
			'className' => 'School.School',
			'foreignKey' => 'school_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	public function get_payment_dollar_info($ref) {

		return $this->find('first', array(
			'conditions' => array(
				'PayDollar.Ref' => 	$ref,
			),
			'fields' => array(
				'PayDollar.*',
			),
		));
	}

	public function payment_data_feed($data) {
	
		CakeLog::write($this->log_module, "Start\r\n");
		CakeLog::write($this->log_module, "Data: " . json_encode($data) . "\r\n");
		$status = "";

		if (isset($data['Ref']) ) {
			$result = $this->get_payment_dollar_info($data['Ref']);
			$secure_hash_secret = Environment::read('paydollar.secure_hash_secret');	// "wGao2Uvb1KQZngrSqjkZldyG9DlZ8PQY";//offered by paydollar
		
			if ($result) {
				$data['id'] = $result['PayDollar']['id'];
				$secureHashs = explode(',', $data['secureHash']);

				App::import(
					'Vendor',
					'Payment.SHAPaydollarSecure',
					array('file' => 'PaydollarSecure' . DS . 'SHAPaydollarSecure.php')
				);

				while(list($key, $value) = each($secureHashs)) {
				
					$paydollarSecure 	= new SHAPaydollarSecure(); 
					$verifyResult = $paydollarSecure->verifyPaymentDatafeed($data['src'], $data['prc'], $data['successcode'], 
									$data['Ref'], $data['PayRef'], $data['Cur'], $data['Amt'], $data['payerAuth'],
									$secure_hash_secret, $value);	
								
				
					// update status
					if ($verifyResult) {

						if ($this->save($data)) {
							CakeLog::write($this->log_module, "Update status succeed: " . json_encode($data));

							// get credit type
							$obj_CreditType = ClassRegistry::init('Credit.CreditType');
							$obj_CreditTypeLanguage = ClassRegistry::init('Credit.CreditTypeLanguage');

							$credit_type_id = $obj_CreditType->get_id_by_slug('credit-add-payment-gate');
							$result_CreditTypeLanguage = $obj_CreditTypeLanguage->get_obj($credit_type_id, 'zho');

							$obj_MembersCredit = ClassRegistry::init('Member.MembersCredit');

							// find administrator id;
							$administrator_id = array();
							$obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');
							$list_username = $obj_MemberLoginMethod->get_list_username_by_member_id($result['PayDollar']['member_id']);
							if ($list_username) {	// array usernames

								$obj_Administrator = ClassRegistry::init('Administration.Administrator');
								$administrator_id = $obj_Administrator->get_id_by_username($list_username);	
							}
							
							// save members credit
							$data_MembersCredit = array(
								'member_id' 		=> $result['PayDollar']['member_id'],
								'credit_type_id' 	=> $credit_type_id,
								'pay_dollar_ref' 	=> $data['Ref'],
								'credit' 			=> $data['Amt'],
								'remark' 			=> $result_CreditTypeLanguage ? $result_CreditTypeLanguage['CreditTypeLanguage']['name'] : array(),
								'school_id'			=> $result['PayDollar']['school_id'],
								'create_by'			=> $administrator_id,
								'update_by'			=> $administrator_id,
							);

							CakeLog::write($this->log_module, json_encode($data_MembersCredit));

							if (!$obj_MembersCredit->save($data_MembersCredit)) {
								$status = 999;
								CakeLog::write($this->log_module, "Save Members Credit failed");
							}

							// save credit to school

							if ($data['successcode'] == array_search('Succeed', $this->status)) {
								$obj_School = ClassRegistry::init('School.School');
								$result_School = $obj_School->get_school_by_id($result['PayDollar']['school_id']);
	
								$new_credit = $result_School['School']['credit'] + $data['Amt'];
								
								$obj_School->is_from_frontend = true;
								$obj_School->id = $result_School['School']['id'];
								$obj_School->saveField('credit', 	$new_credit);	// update field
								$obj_School->saveField('update_by', $administrator_id);	// update field
							}
							
							$status = 200;
							
						} else {
							CakeLog::write($this->log_module, "Update status failed: " . json_encode($data));
							$status = 999;
	
						}
						$this->clear();

					} else {
						CakeLog::write($this->log_module, "Wrong verified value");
						$status = 998;
					}
				}
			} else {
				CakeLog::write($this->log_module, "Record note correct!");
				$status = 997;
			}
		}
		
		CakeLog::write($this->log_module, "End\r\n");
		return $status;
	}


	public function get_payment_receipt_info($member_id, $Ref, $langauge) {
		return $this->find('first', array(
			'conditions' => array(
				'PayDollar.member_id' 	=> $member_id,
				'PayDollar.Ref' 		=> $Ref, 
			),
			'fields' => array(
				'PayDollar.*'
			),
			'contain' => array(
				'School' => array(
					'SchoolLanguage' => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $langauge,
						),
						'fields' => array(
							'SchoolLanguage.name',
						),
					),
				),
			),
		));
	}
	
}
