<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * MembersCredit Model
 *
 * @property Member $Member
 * @property CreditType $CreditType
 * @property School $School
 */
class MembersCredit extends MemberAppModel {

	// Override belongto parent appmodel
	public function __construct($id = false, $table = null, $ds = null) {
		$parent = get_parent_class($this);
		$this->_mergeVars(array('belongsTo'), $parent);	// override belongto parent appmodel
	
		parent::__construct($id, $table, $ds);
	}

	public $actsAs = array('Containable');
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
		'CreditType' => array(
			'className' => 'Credit.CreditType',
			'foreignKey' => 'credit_type_id',
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

	public function get_list($school_id, $date, $language) {

		return $this->find('all', array(
			'conditions' => array(
				'MembersCredit.school_id' 		=> $school_id,
				'YEAR(MembersCredit.created)' 	=> date('Y', strtotime($date)),
				'MONTH(MembersCredit.created)' 	=> date('m', strtotime($date)),
				'DAY(MembersCredit.created)' 	=> date('d', strtotime($date)),
			),
			'fields' => array(
				'MembersCredit.*',
			),
			'contain' => array(
				'School' => array(
					'SchoolLanguage'  => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $language
						),
						'fields' => array(
							'SchoolLanguage.name',
						),
					),
				),
				'CreditType' => array(
					'fields' => array(
						'CreditType.is_add_point',
						'CreditType.id',
					),
					'CreditTypeLanguage' => array(
						'fields' => array(
							'CreditTypeLanguage.name',
						),
					),
				),
			),
		));	
	}

	public function get_latest_transaction_record($school_id, $limit) {
		return $this->find('all', array(
			'conditions' => array(
				'MembersCredit.school_id' => $school_id,
			),
			'order' => array(
				'MembersCredit.id DESC',
			),
			'limit' => $limit,
		));
	}

	// export
	public function get_data_export($conditions, $page, $limit, $lang){
		//$fields = array('Company.id', 'Company.allow_public', 'Company.enabled', 'Company.created', 'Company.updated');
		$fields = array('MembersCredit.id',  'MembersCredit.credit_type_id', 'MembersCredit.pay_dollar_ref', 'MembersCredit.credit', 'MembersCredit.remark', 'MembersCredit.created');
        $all_settings = array(
            'contain' => array(
				'School' => array(
					'SchoolLanguage'  => array(
						'conditions' => array(
							'SchoolLanguage.alias' => $lang
						),
						'fields' => array(
							'SchoolLanguage.name',
						),
					),
				),
				'CreditType' => array(
					'fields' => array(
						'CreditType.is_add_point',
						'CreditType.id',
					),
					'CreditTypeLanguage' => array(
						'fields' => array(
							'CreditTypeLanguage.name',
						),
					),
				),
				'CreatedBy',
				'UpdatedBy',
            ),
            'fields' => $fields,
            'recursive' => -1,
            'conditions' => $conditions,
            'group' => $fields,
            'limit' => $limit,
            'page' => $page
        );

        $data = $this->find('all', $all_settings);
        return  $data;
    }

    public function format_data_export($data, $row, $no = 0){

        return array(
			$no,
			reset($row['CreditType']["CreditTypeLanguage"])['name'] . "/" . $row['CreditType']["CreditTypeLanguage"][1]['name'],
			isset($row['MembersCredit']["pay_dollar_ref"]) ? $row['MembersCredit']["pay_dollar_ref"] : '',
			isset($row['MembersCredit']["credit"]) ? ($row['CreditType']["is_add_point"] > 0 ? $row['MembersCredit']["credit"] : -$row['MembersCredit']["credit"]) : '',
			isset($row['MembersCredit']["remark"]) ? $row['MembersCredit']["remark"] : '',
			isset($row['MembersCredit']["created"]) ? $row['MembersCredit']["created"] : '',
        );
    }
}
