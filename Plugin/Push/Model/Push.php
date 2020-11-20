<?php
App::uses('PushAppModel', 'Push.Model');
/**
 * Push Model
 *
 * @property Company $Company
 * @property Section $Section
 * @property PushMethod $PushMethod
 * @property Tier $Tier
 * @property Gender $Gender
 * @property Age $Age
 * @property District $District
 * @property DobMonth $DobMonth
 * @property PushRule $PushRule
 * @property Member $Member
 */
class Push extends PushAppModel {
	
	public $actsAs = array('Containable');

	public function __construct($id = false, $table = null, $ds = null) {
		$parent = get_parent_class($this);
		$this->_mergeVars(array('belongsTo'), $parent);	
		parent::__construct($id, $table, $ds);
	}

	public $push_method = array(
		1 => 'Push to all',
		2 => 'Push to all (student)',
		3 => 'Push to all (teacher)',
		10 => 'Push to someone (student)',
		11 => 'Push to someone (teacher)',
		20 => 'Push to criteria',
	);

	public $push_type = array(
		1 => 'Instant',
		2 => 'Specific datetime',
		3 => 'Daily',	// weekday, month, ...
	);

	public $push_group = array(
		1 => 'System Maintennace',
		2 => 'Promotion',
		3 => 'Course Information',	
		4 => 'Payment Information',
		5 => 'System Annoument',
	);

    /**
     * Validation rules
     *
     * @var array
     */
	public $validate = array(
		'message' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
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
		
		'District' => array(
			'className' => 'Dictionary.Vocabulary',
			'foreignKey' => 'district_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),

		'Student' => array(
			'className' => 'Member.Member',
			'foreignKey' => 'student_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),

	);

    /**
     * hasMany associations
     *
     * @var array
     */
	public $hasMany = array(
		'PushRule' => array(
			'className' => 'Push.PushRule',
			'foreignKey' => 'push_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'PushLanguage' => array(
			'className' => 'Push.PushLanguage',
			'foreignKey' => 'push_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

	/**
	 * fung edit 2018年03月08日17:39:56
	 * get devices
	 */
 	public function get_devices($member_ids){
		$objDevice = ClassRegistry::init('Member.Device');

		$member_devices = $objDevice->find('all',array(
			'fields' => array('Device.member_id','Device.device_type','Device.device_token'),
			'conditions' => array(
				'Device.enabled' => true,
				'Device.member_id' => $member_ids
			),
		));
		
		// $android_data = array();
		// $ios_data = array();
		$device_token = array();
        foreach ($member_devices as $device) {

			if (isset($device['Device']['device_token']) && !empty($device['Device']['device_token'])
				&& isset($device['Device']['member_id']) && !empty($device['Device']['member_id'])) {
					
				$device_token[] = array(
					'member_id' 	=> $device['Device']['member_id'],
					'device_token' 	=> $device['Device']['device_token'],
				);
			}
        }

        return array(
            'status' 		=> empty($device_token) ? false : true,
			'data'  		=> $device_token, 
        );
 	}

 	/**
 	 * fung edit 2018年05月18日12:24:55
 	 * get devices 改2
 	 */
 	public function get_device_by_member_ids($member_ids){
 		$this->Member = ClassRegistry::init('Member.Member');
		$this->Device = ClassRegistry::init('Member.Device');

		$devices_aos = array();
		$devices_ios = array();

 		$devices = array(
			'device-aos' => $devices_aos,
			'device-ios' => $devices_ios
 		);

 		$members_pushes = array();

		$member_devices = $this->Device->find('all',array(
			'fields' => array('Device.member_id','Device.device_type_id','Device.device_token'),
			'conditions' => array(
				'Device.enabled' => true,
				'Device.member_id' => $member_ids
			),
			'recursive' => -1
		));

		$devices_type = $this->Device->DeviceType->find('list',array(
			'fields' => array('DeviceType.id','DeviceType.slug'),
			'conditions' => array(
				'DeviceType.enabled' => true,
			),
			'recursive' => -1
		));

		if (( isset($member_ids)     && !empty($member_ids) ) &&
			( isset($member_devices) && !empty($member_devices) ) &&
			( isset($devices_type)   && !empty($devices_type) ) 
		) {
			foreach ($member_devices as $device) {

				array_push($members_pushes, $device['Device']['member_id']); 

				if ( $devices_type[$device['Device']['device_type_id']] == 'ios' ) {
					array_push($devices_ios, $device['Device']['token']); 

				}elseif ( $devices_type[$device['Device']['device_type_id']] == 'aos' ) {
					array_push($devices_aos, $device['Device']['token']); 

				}
			}
			$devices['device-ios'] = array_filter($devices_ios);	// remove null
			$devices['device-aos'] = array_filter($devices_aos);
			$members_pushes = array_unique($members_pushes);

			return array(
				'status' => true,
				'devices' => $devices,
				'members_pushes' => $members_pushes
			);
			
		}else{
			return array(
				'status' => false,
 				'messages' => array(
 					'member_ids' => $member_ids,
 					'member_devices' => $member_devices,
 					'devices_type' => $devices_type
 				)
			);
		}
	}
	
	public function get_push_info_by_id($id) {
		return $this->find('first', array(
			'fields' => array(
				'*',
			),
			'conditions' => array( 
				'Push.id' =>  $id
			),
			'recursive' => -1,
		));
	}

	public function add_push_record($push_group, $member_ids, $message, $push_method, $push_type, $type, 
                                    $period_start = "",
                                    $period_end = "",
									$execute_time = "",
									$class_lession_id = "",
									$course_class_id = "",
									$course_id = "",
									$student_id = "",
									$is_accept_message = 0,
									$student_course_payment_transaction_id = "") {
        // get data for push record
        $push_data = array(
			'push_method'       => $push_method,
			'push_group'		=> $push_group,
			'remark'            => json_encode($member_ids),
			'student_course_payment_transaction_id' => $student_course_payment_transaction_id,
			'course_id'   		=> $course_id,
			'course_class_id'   => $course_class_id,
			'class_lession_id'  => $class_lession_id,
			'student_id'   		=> $student_id,
			'is_accept_message' => $is_accept_message,
            'enabled'           => true,
            'type'              => $type,        // 1: student, 2: member, 10: all
            'created_by'        => 0,
        );

        if (!$push_model = $this->save($push_data)) {
            return array(
                'status' => false,
                'message' => 'Create Push records failed: ' . json_encode($this->invalidFields())
            );
		}
	
		$this->clear();

        // save push language
        $language = array();
        foreach ($message as $val) {
            $language[] = array(
                'push_id'           	=> $push_model['Push']['id'],
                'title'             	=> $val['title'],
                'short_description'     => $val['short_description'],
                'long_description'      => $val['long_description'],
                'alias'             	=> $val['alias'],
            );
		}

        if (!$this->PushLanguage->saveAll($language)) {
            return array(
                'status' => false,
                'message' => 'Create Push Language failed: ' . json_encode($language),
            );
        }

        // push rule
        $push_rule = array(
            'push_id'   => $push_model['Push']['id'],
            'push_type' => $push_type,
            'period_start'  => isset($period_start) ? $period_start : NULL,
            'period_end'    => isset($period_end) 	? $period_end : NULL,
            'execute_time'  => isset($execute_time) ? $execute_time : NULL,
            'enabled'   => true,
            'created_by' => 0,
		);
	
        if (!$this->PushRule->save($push_rule)) {
            return array(
                'status' => false,
                'message' => 'Create Push Rule for expiry date failed: ' . json_encode($this->Push->PushRule->invalidFields())
            );
		}
		
		$this->PushRule->clear();
        return array(
            'status' => true,
            'message' => '',
        );
	}
	
	public function get_push_group() {
		return array(
			1 => __d('push', 'system_maintennace'), 
			2 => __d('push', 'promotion'), 
			3 => __d('push', 'course_information'), 
			4 => __d('push', 'payment_information'), 
			5 => __d('push', 'system_annoument'), 
		);
	}
}