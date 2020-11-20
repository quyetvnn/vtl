<?php

App::uses('AppModel', 'Model');

class DictionaryAppModel extends AppModel {
	// vilh (2019/03/20)
	// get prefix of vocabulary
	public function getPrefix($parentVocabularies)
	{
		$prefix = [];
		foreach ($parentVocabularies as $v)
		{
			$start = strrpos($v, '-') +1 ;
			$end = strlen($v);
			$pre = substr($v, 0 , $start);
			array_push($prefix, $pre );
		}

		// remove duplicate elements
		return array_unique($prefix);
	}
}
