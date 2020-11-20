<?php
App::uses('LogAppController', 'Log.Controller');
/**
 * Logs Controller
 *
 * @property Log $Log
 * @property PaginatorComponent $Paginator
 */
class LogsController extends LogAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
    // public $helpers = array('Html','Form','Csv','Cache');


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
        $data_search = $this->request->query;
        $conditions = array();

        if($this->company_id){
            $conditions['Log.company_id'] = $this->company_id;
        }

        if(isset($data_search['start_period']) && $data_search['start_period'] != "" ){
            $conditions['Log.created >= '] = $data_search['start_period'];
        }

        if(isset($data_search['end_period']) && $data_search['end_period'] != "" ){
            $conditions['Log.created <= '] = $data_search['end_period'];
        }

        if(isset($data_search['user_id']) && $data_search['user_id'] != "" ){
            $conditions['Log.created_by'] = $data_search['user_id'];
        }
        
        if(isset($data_search['plugin']) && $data_search['plugin'] != "" ){
            $conditions['Log.plugin'] = $data_search['plugin'];
        }

        if(isset($data_search['controller']) && $data_search['controller'] != "" ){
            $conditions['Log.controller'] = $data_search['controller'];
        }

        if(isset($data_search['action']) && $data_search['action'] != "" ){
            $conditions['Log.action'] = $data_search['action'];
        }
        
        if( isset($data_search['button_export_csv']) && !empty($data_search['button_export_csv']) ){
            if(isset($data_search['choose_id']) && $data_search['choose_id']){
                $conditions = array('Log.id' => $data_search['choose_id']);
            }

			$sent = $this->requestAction(array(
				'plugin' => 'log',
				'controller' => 'logs',
				'action' => 'export',
				'admin' => true,
				'prefix' => 'admin',
				'ext' => 'json'
			), array(
                'conditions' => $conditions,
				'type' => 'csv',
				'language' => $this->lang18,
			));
        }
        

        if( isset($data_search['button_export_excel']) && !empty($data_search['button_export_excel']) ){
            if(isset($data_search['choose_id']) && $data_search['choose_id']){
                $conditions = array('Log.id' => $data_search['choose_id']);
            }

			$sent = $this->requestAction(array(
				'plugin' => 'log',
				'controller' => 'logs',
				'action' => 'export',
				'admin' => true,
				'prefix' => 'admin',
				'ext' => 'json'
			), array(
                'conditions' => $conditions,
				'type' => 'xls',
				'language' => $this->lang18,
			));
        }
  
        $this->Paginator->settings = array(
            'conditions' => $conditions,
           // 'contain' => array( 'CreatedBy' ),
            'order' => array( 'Log.id' => 'desc' ),
		);


        $logs = $this->paginate();

        // format get list company name
        $company_ids = Hash::extract($logs, '{n}.Log.company_id');
        $list_index_companies = array();
        if($company_ids){
            $list_index_companies = $this->Log->Company->get_company_list(array('Company.id IN' => $company_ids), $this->lang18);
        }

        $admin_ids = $this->Log->get_distinct_field('created_by');
        $users = $this->Log->CreatedBy->find_list(array('id' => $admin_ids));
        $plugins = $this->Log->get_distinct_field('plugin');
        $controllers = $this->Log->get_distinct_field('controller');
        $actions = $this->Log->get_distinct_field('action');
        
        $color_actions = array(
            'admin_add' => 'label-success',
            'admin_edit' => 'label-warning',
            'admin_delete' => 'label-danger',
        );


    
       //  $column_cache = json_encode($this->Redis->get_cache('booster_column', '_logs'));
        $this->set(compact('logs', 'data_search', 'users', 'color_actions', 'list_index_companies', 'plugins', 'controllers', 'actions', 'column_cache'));
	}

    public function admin_export() {
        $this->disableCache();

        if( $this->request->is('get') ) {
            $limit = 1000; // limit record get one time
            // format get list company name
            $list_index_companies = $this->Log->Company->get_company_list(array(), $this->lang18);
            // format get list company name
            $list_index_brands = $this->Log->Brand->get_brand_list(array(), $this->lang18);

            $header = array(
                __('id'),
                __('company_id'),
                __d('administration','brand'),
                __('plugin'),
                __('controller'),
                __('action'),
                __('statement'),
                __('error'),
                __d('log', 'old_record'),
                __('remark'),
                __d('log','remote_ip'),
                __d('log','agent'),
                __('version'),
                __d('log','platform'),
                __d('log','browser'),
                __('enabled'),
                __('archived'),
                __('created'),
                __('created_by'),
            );

            try{
                $file_name = 'log_' . date('Ymdhis');
                $data_binding = array(
                    'list_index_companies' => $list_index_companies,
                    'list_index_brands' => $list_index_brands
                );

                // export xls
                if ($this->request->type == "xls") {
                    $this->Common->setup_export_excel($header, 'Log.Log', $data_binding, $this->request->conditions, $limit, $file_name, $this->lang18);
                } else {
                    $this->Common->setup_export_csv($header, 'Log.Log', $data_binding, $this->request->conditions, $limit, $file_name, $this->lang18);
                }
                exit;
            } catch ( Exception $e ) {
                $this->LogFile->writeLog($this->LogFile->get_system_error(), $e->getMessage());
                $this->Session->setFlash(__('export_csv_fail') . ": " . $e->getMessage(), 'flash/error');
            }
        }
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
	public function admin_view($id = null) {
		if (!$this->Log->exists($id)) {
			throw new NotFoundException(__('invalid_data'));
        }
        
        $contain = array(
            'CreatedBy',
            'LogSuccess',
            'LogError'
        );

        $options = array(
            'conditions' => array('Log.' . $this->Log->primaryKey => $id),
            'contain' => $contain
        );

        $log = $this->Log->find('first', $options);
        // get company and brand
        $list_index_companies = array();
        if($log['Log']['company_id']){
            $list_index_companies = $this->Log->Company->get_company_list(array('Company.id' => $log['Log']['company_id']), $this->lang18);
        }
        // format get list company name
        $list_index_brands = array();
        if($log['Log']['brand_id']){
            $list_index_brands = $this->Log->Brand->get_brand_list(array('Brand.id' => $log['Log']['brand_id']), $this->lang18);
        }
        
        $success_data = array();
        $error_data = array();
        $new_data = array();
        $old_data = array();
        if($log['LogSuccess']) {
            foreach($log['LogSuccess'] as $item){
                $success_data[] = json_decode($item['content']);
            }
            unset($log['LogSuccess']);
        }

        if($log['LogError']) {
            foreach($log['LogError'] as $item){
                $error_data[] = json_decode($item['content']);
            }
            unset($log['LogError']['content']);
        }

        if($log['Log']['new_data']) {
            $new_data = json_decode($log['Log']['new_data']);
            unset($log['Log']['new_data']);
        }

        if($log['Log']['old_data']) {
            $old_data = json_decode($log['Log']['old_data']);
            unset($log['Log']['old_data']);
        }

		$this->set(compact('log', 'success_data', 'error_data', 'new_data', 'old_data', 'list_index_companies', 'list_index_brands'));
	}
}
