<?php
App::uses('SchoolAppModel', 'School.Model');
/**
 * School Model
 *
 * @property SchoolClass $SchoolClass
 * @property SchoolImage $SchoolImage
 * @property SchoolLanguage $SchoolLanguage
 * @property SchoolSubject $SchoolSubject
 * @property StudentClass $StudentClass
 * @property TeacherCreateLesson $TeacherCreateLesson
 */
class School extends SchoolAppModel {


	public $actsAs = array('Containable');

	public $status = array(
		// 1 => 'Approved', 	// default
		// 0 => 'Rejected',	
		// 2 => 'Submit'

		1 => 'Normal', 	// Similar to the "Enable" we used as normal. By default, after the School Admin fills the create school form, the School profile will be created and automatically approved. At this moment, the status should be "Normal"
		0 => 'Blocked',	// Blocked --> Similar to "Disable" as A4L Admin can disable / terminate the access of the School. This action is done by A4L Admin.
		2 => 'Closed'	// this is a new flow that should be raised by the School Admin. If the School will not be operated anymore, the School Admin is abled to claim to shut down the School. [Skip to do this flow first, because it's a new requirement from client. But you an set the "status" ready in CMS]
	);

	// Override belongto parent appmodel
	public function __construct($id = false, $table = null, $ds = null) {
		$parent = get_parent_class($this);
		$this->_mergeVars(array('belongsTo'), $parent);	// override belongto parent appmodel
	
		parent::__construct($id, $table, $ds);
	}
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'enabled' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

    public $belongsTo = array(
		'Member' => array(
			'className' => 'Member.Member',
			'foreignKey' => 'member_id',
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
		'MemberManageSchool' => array(
			'className' => 'Member.MemberManageSchool',
			'foreignKey' => 'school_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SchoolClass' => array(
			'className' => 'School.SchoolClass',
			'foreignKey' => 'school_id',
			'dependent' => false,
			'conditions' =>  array(
				'SchoolClass.enabled' => true,
			),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SchoolImage' => array(
			'className' => 'School.SchoolImage',
			'foreignKey' => 'school_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SchoolLanguage' => array(
			'className' => 'School.SchoolLanguage',
			'foreignKey' => 'school_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SchoolSubject' => array(
			'className' => 'School.SchoolSubject',
			'foreignKey' => 'school_id',
			'dependent' => false,
			'conditions' => array(
				'SchoolSubject.enabled' => true,
			),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SchoolBusinessRegistration' => array(
			'className' => 'School.SchoolBusinessRegistration',
			'foreignKey' => 'school_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'StudentClass' => array(
			'className' => 'Member.StudentClass',
			'foreignKey' => 'school_id',
			'dependent' => false,
			'conditions' => array(
				'StudentClass.enabled' => true,
			),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'TeacherCreateLesson' => array(
			'className' => 'Member.TeacherCreateLesson',
			'foreignKey' => 'school_id',
			'dependent' => false,
			'conditions' => array(
				'TeacherCreateLesson.enabled' => true,
			),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function get_school_list($where = array(), $language = 'eng'){

		$data = array();

		$fields = array(
			'School.id',
		);
		$conditions = array(
			'School.status' => 1,
			'School.enabled' => true,
		);
		if (!empty($where)) {
			$conditions = array_merge($conditions,$where);
		}
		$contain = array(
			'SchoolLanguage' => array(
				'fields' => array(
					'SchoolLanguage.name',
				),
				'conditions' => array(
					'SchoolLanguage.alias' => $language
				),
			),
		);

		$data = $this->find('all',array(
			'fields' => $fields,
			'conditions' => $conditions,
			'contain' => $contain,
		));

		if ($data) {
			$data = Hash::combine($data, '{n}.School.id', '{n}.SchoolLanguage.0.name');
		}else{
			$data = array();
		}

		return $data;
	}

	public function get_list_school_by_id($school_ids, $language) {
		$temp = $this->find('all', array(
			'fields' => array(
				'School.*',
			),
			'conditions' => array(
				'School.id' => $school_ids,
				'School.status' => array_search('Normal', $this->status),
			),
			'contain' => array(
				'SchoolLanguage' => array(
					'conditions' => array(
						'SchoolLanguage.alias' => $language,	
					),
				),
				'SchoolImage',
			),
			'order' => array(
				'School.id DESC',
			),
		));

		$result = array();
		foreach ($temp as $val) {
			$result[] = array(
				'id' 			=> $val['School']['id'],
				'email'			=> $val['School']['email'],
				'school_code'			=> $val['School']['school_code'],
				'credit_charge'			=> $val['School']['credit_charge'],
				'credit'				=> $val['School']['credit'],
				'phone_number'			=> $val['School']['phone_number'],
				'address'				=> $val['School']['address'],
				'name' 			=> reset($val['SchoolLanguage'])['name'],
				'description' 	=> reset($val['SchoolLanguage'])['description'],
				'about_us' 		=> reset($val['SchoolLanguage'])['about_us'],
				'image' 		=> $val['SchoolImage'],
			);
		}
		return $result;
	}

	public function get_list_school_by_code($school_codes, $language) {
		$temp = $this->find('all', array(
			'fields' => array(
				'School.*',
			),
			'conditions' => array(
				'School.school_code' => $school_codes,
				'School.status' => array_search('Normal', $this->status),
			),
			'contain' => array(
				'SchoolLanguage' => array(
					'conditions' => array(
						'SchoolLanguage.alias' => $language,	
					),
				),
				'SchoolImage',
			),
			'order' => array(
				'School.id DESC',
			),
		));

		$result = array();
		foreach ($temp as $val) {
			$result[] = array(
				'id' 			=> $val['School']['id'],
				'email'			=> $val['School']['email'],
				'school_code'			=> $val['School']['school_code'],
				'credit_charge'			=> $val['School']['credit_charge'],
				'credit'				=> $val['School']['credit'],
				'phone_number'				=> $val['School']['phone_number'],
				'address'				=> $val['School']['address'],
				'name' 			=> reset($val['SchoolLanguage'])['name'],
				'description' 	=> reset($val['SchoolLanguage'])['description'],
				'about_us' 		=> reset($val['SchoolLanguage'])['about_us'],
				'image' 		=> $val['SchoolImage'],
			);
		}
		return $result;
	}

	public function is_school_available($school_id){
		$temp = $this->find('first', array(
			'fields' => array(
				'School.status',
			),
			'conditions' => array(
				'School.id' => $school_id,
				'School.status' => array_search('Normal', $this->status),
			)
		));
		if(isset($temp) && !empty($temp)) return true;
		return false;
	}

	public function is_school_code_available($school_code){
		$temp = $this->find('first', array(
			'fields' => array(
				'School.status',
			),
			'conditions' => array(
				'School.school_code' => $school_code,
				'School.status' => array_search('Normal', $this->status),
			)
		));
		if(isset($temp) && !empty($temp)) return true;
		return false;
	}

	public function get_list_class($school_ids, $language) {
		$temp = $this->find('all', array(
			'fields' => array(
				'School.id',
			),
			'conditions' => array(
				'School.id' => $school_ids,
				'School.enabled' => true,
			),
			'contain' => array(
				'SchoolLanguage' => array(
					'conditions' => array(
						'SchoolLanguage.alias' => $language,	
					),
				),
				'SchoolImage',
			),
		));

		$result = array();
		foreach ($temp as $val) {
			$result[] = array(
				'id' 			=> $val['School']['id'],
				'name' 			=> reset($val['SchoolLanguage'])['name'],
				'description' 	=> reset($val['SchoolLanguage'])['description'],
				'image' 		=> $val['SchoolImage'],
			);
		}
		return $result;
	}

	public function get_list_school($school_id = array(), $language) {

		$conditions  = array();
		if ($school_id) {
			$conditions = array(
				'School.id' => $school_id,
			);
		} 

		$result =  $this->find('all', array(
			'fields' => array(
				'School.id',
				'SchoolLanguage.name',
				'School.school_code',
			),
			'conditions' => array_merge($conditions, array(
				'School.enabled' => true,
				'School.status' => array_search('Normal', $this->status),
			)),
			
			'joins' => array(
                array(
                    'table' => Environment::read('table_prefix') . 'school_languages', 
                    'alias' => 'SchoolLanguage',
                    'type' => 'INNER',
                    'conditions'=> array(
						'SchoolLanguage.school_id = School.id',
						'SchoolLanguage.alias' => $language,
                    )
                ),
            ),
		));

		$temp = array();
		foreach ($result as $val) {
			$temp[] = array(
				$val['School']['id'] => $val['SchoolLanguage']['name'] . " (" . $val['School']['school_code'] . ")",
			);
		}

		$temp2 = array();
		array_walk_recursive($temp, function($val, $key) use(&$temp2) {
			$temp2[$key] = $val;
		});

		return $temp2;

	}

	public function get_full_list($language) {
		return $this->find('list', array(
			'fields' => array(
				'School.id',
				'School.school_code',
				'SchoolLanguage.name',
			),
			'conditions' => array(
				'School.enabled' => true,
			),
			'joins' => array(
                array(
                    'table' => Environment::read('table_prefix') . 'school_languages', 
                    'alias' => 'SchoolLanguage',
                    'type' => 'INNER',
                    'conditions'=> array(
						'SchoolLanguage.school_id = School.id',
						'SchoolLanguage.alias' => $language,
                    )
                ),
            ),
		));
	}

	public function get_school_by_id($school_id) {
		return  $this->find('first', array(
			'fields' => array(
				'School.*',
			),
			'conditions' => array(
				'School.id' => $school_id,
			),
		));
	}


	public function get_school_name_by_id($school_id, $language) {
		$result = $this->find('first', array(
			'fields' => array(
				'School.id',
				'SchoolLanguage.name',
			),
			'conditions' => array(
				'School.id' => $school_id,
			),
			'joins' => array(
                array(
                    'table' => Environment::read('table_prefix') . 'school_languages', 
                    'alias' => 'SchoolLanguage',
                    'type' => 'INNER',
                    'conditions'=> array(
						'SchoolLanguage.school_id = School.id',
						'SchoolLanguage.alias' => $language,
                    )
                ),
            ),
		));

		return $result['SchoolLanguage']['name'];
	}


	public function get_obj($id = array()) {

		if ($id == array()) {
			return $this->find('all', array(
				'fields' => array(
					'School.*'
				),
			));
		}

		return $this->find('first', array(
			'conditions' => array(
				'id' => $id,
			),
			'fields' => array(
				'School.*'
			),
		));
	}

	public function get_full_obj($language) {

		return $this->find('all', array(
			'fields' => array(
				'School.*',
			),
			'contain' => array(
				'SchoolLanguage' => array(
					'fields' => array(
						'SchoolLanguage.name',
					),
					'conditions' => array(
						'SchoolLanguage.alias' => $language,
					),
				),
			),
		));
	}

	public function get_obj_by_school_code($school_code) {
		return $this->find('first', array(
			'fields' => array(
				'School.*',
			),
			'conditions' => array(
				'School.school_code' => $school_code,
				'School.status' => array_search('Normal', $this->status),
			),
		));
	}
}
