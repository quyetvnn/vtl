<?php
App::uses('PushAppModel', 'Push.Model');
/**
 * PushRule Model
 *
 * @property Push $Push
 * @property PushType $PushType
 */
class PushRule extends PushAppModel {

	public $actsAs = array('Containable');

	public function __construct($id = false, $table = null, $ds = null) {
		$parent = get_parent_class($this);
		$this->_mergeVars(array('belongsTo'), $parent);	
		parent::__construct($id, $table, $ds);
	}
	

	public $status = array(
		0 => 'Pending',			// use update fields for check is running cronjob this day or not (with push_type=daily)
		1 => 'Complete',
		2 => 'Pushing',	// weekday, month, ...
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Push' => array(
			'className' => 'Push.Push',
			'foreignKey' => 'push_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	public function is_pushing() {
		$result = $this->find('list', array(
			'conditions' => array(
				'status'		=> array_search('Pushing', $this->status),
			),
			'recursive' => -1,
		));

		if ($result) {
			return true;

		} else {
			return false;
		}
	}

	// status = Pending, Completed, Pushing
	// type = instant, specific_datetime, daily, weekly, monthly, yearl
	
	public function get_pending_instant_record() {

		return $this->find('first', array(
			'fields' => array(
				'PushRule.*',
			),
			'conditions' => array(
				'status'		=> array_search('Pending', $this->status),
				'push_type'		=> array_search('Instant', $this->Push->push_type)
			),
			'recursive' => -1,
			'order' => array(
				'PushRule.created' => 'ASC'		// do first when insert first
			),
		));
	}

	public function get_pending_record() {

		$current_date  = date("Y/m/d H:i:s");    // 2019/08/02 22:30:29
		$current_time  = date("h:i:s");    // 12:55:50
		// $current_week  = date('w');        // 5 (Friday)
		// $current_month = date('m');        // 08
		// $current_day   = date('d');        // 02

		return $this->find('first', array(
			'fields' => array(
				'PushRule.id', 'PushRule.push_id', 'PushRule.push_type',
			),
			'conditions' => array(
				'PushRule.status' => array_search('Pending', $this->status),
				'PushRule.period_start <=' 	=> $current_date,
				'PushRule.period_end >=' 	=> $current_date,
				'DATE(PushRule.updated) <>' => $current_date,
				'PushRule.execute_time <=' 	=> $current_time,	// execute_time < current_time
				
				// 'AND' => array(
				// 	array(
				// 		'OR'=> array(
				// 			'PushRule.weekday' =>  $current_week,
				// 			'PushRule.weekday' =>  null,
				// 		)
				// 	),
				// 	array(
				// 		'OR'=> array(
				// 			'PushRule.month' =>  $current_month,
				// 			'PushRule.month' =>  null,
				// 		)
				// 	),
				// 	array(
				// 		'OR'=> array(
				// 			'PushRule.day' =>  $current_day,
				// 			'PushRule.day' =>  null,
				// 		)
				// 	),

				// ),
			),
			'order' => array(
				'PushRule.created' => 'ASC'
			),
		));
	}
	
	public function get_special_date_record() {
		$current_date  = date("Y/m/d H:i:s");    // 2019/08/02

		return $this->find('first', array(
			'fields' => array(
				'PushRule.id', 'PushRule.push_id', 'PushRule.execute_date, PushRule.push_type',
			),
			'conditions' => array(
				'PushRule.status' => array_search('Pending', $this->status),
				'PushRule.execute_date <=' 	=> $current_date,
			),
			'order' => array(
				'PushRule.created' => 'ASC'
			),

		));
	}

	public function update_status($id, $status) {
		$result = $this->find('first', array(
			'conditions' => array(
				'PushRule.id' => $id
			),
			'recursive' => -1,
		));

		$result['PushRush']['status'] = $status;
		$result['PushRush']['id'] = $id;
		$result['PushRush']['updated_by'] = 0;
		$result['PushRush']['updated'] = date("Y/m/d"); 	// current

		if ($this->save($result['PushRush'])) {
			return true;
			
		} else {
			return false;
		}
	}
}
