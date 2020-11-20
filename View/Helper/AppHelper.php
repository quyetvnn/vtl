<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Helper', 'View');
App::uses('CommonComponent', 'Controller/Component');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper {
	public function get_minimal_name($name=''){
        if(!isset($name) || empty($name)) return '';
        $collection = new ComponentCollection();
        $common = new CommonComponent($collection);
        return $common->get_minimal_name($name);
    }
}
