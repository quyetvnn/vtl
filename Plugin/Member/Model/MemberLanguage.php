<?php
App::uses('MemberAppModel', 'Member.Model');
/**
 * MemberLanguage Model
 *
 * @property Member $Member
 */
class MemberLanguage extends MemberAppModel {

	public $actsAs = array('Containable');
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
		)
	);

	public function get_name($ids, $language) {
		return $this->find('all', array(
			'conditions' => array(
				'MemberLanguage.alias' => $language,
				'MemberLanguage.member_id' => $ids,
			),
			'fields' => array(
				'MemberLanguage.id',
				'MemberLanguage.name',
				'MemberLanguage.first_name',
				'MemberLanguage.last_name',
			),
		));
	}

	public function generate_all_member_language($name, $member_id, $first_name = array(), $last_name = array()) {

		$available_language = $this->get_lang_from_db();

		$data_MemberLanguage = array();
		foreach ($available_language as $value) {
			$data_MemberLanguage[] = array(
				'name' 			=> $name,
				'member_id' 	=> $member_id,
				'first_name'	=> $first_name,
				'last_name' 	=> $last_name,
				'alias' 		=> $value
			);
		}

		return $data_MemberLanguage;
	}

	public function get_info_by_language($member_id, $language) {
		return $this->find('first', array(
			'conditions' => array(
				'MemberLanguage.alias' 		=> $language,
				'MemberLanguage.member_id' 	=> $member_id,
			),
			'fields' => array(
				'MemberLanguage.*',
			),
		));
	}

	public function get_items_by_member_id($member_id) {
		return $this->find('all', array(
			'conditions' => array(
				'MemberLanguage.member_id' 	=> $member_id,
			),
			'fields' => array(
				'MemberLanguage.*',
			),
		));
	}
}
