<?php
/**
 * AppShell file
 *
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 2.0
 */

App::uses('Shell', 'Console');
App::uses('ComponentCollection', 'Controller'); // add this row for fix bug when console/cake bake mode ... --plugin Member


/**
 * Application Shell
 *
 * Add your application-wide methods in the class below, your shells
 * will inherit them.
 *
 * @package       app.Console.Command
 */
class AppShell extends Shell {
    
    protected $arr_langs = array('eng', 'zho', 'chi');
    protected $arr_enviroments = array('development', 'production', 'demo', 'staging');
    protected $lang = 'zho';
    protected $log_module;
    public $uses = array();
    
    public function startup() {
        $collection = new ComponentCollection();
       //  $this->Session = $collection->load('Session');
        
    }

    public function set_enviroment_language(){
        // temporarily using the "development" DB config
        Environment::set('development'); // developmet/production
        
        if (isset($this->args[0]) && !empty($this->args[0])) {
            if(!in_array($this->args[0], $this->arr_enviroments)){
				$this->out("Parameter enviroment must be development, production or staging.");
                return false;
            }

            Environment::set($this->args[0]);
        }

        if (isset($this->args[1]) && !empty($this->args[1])) {
            $this->lang = $this->args[1];
            if(!in_array($this->args[1], $this->arr_langs)){
				$this->out("Parameter language must be zho, chi or eng.");
                return false;
            }
        }
        
       // $this->Session->write('Config.language', $this->lang);
        return true;
    }
}
