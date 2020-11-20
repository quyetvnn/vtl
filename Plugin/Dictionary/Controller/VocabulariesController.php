<?php
App::uses('DictionaryAppController', 'Dictionary.Controller');
/**
 * Vocabularies Controller
 *
 * @property Vocabulary $Vocabulary
 * @property PaginatorComponent $Paginator
 */
class VocabulariesController extends DictionaryAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
    public function beforeFilter(){
		parent::beforeFilter();

		$this->set('title_for_layout', __('dictionary') . ' > ' . __d('dictionary','vocabularies'));
	}
    /**
     * admin_index method
     *
     * @return void
     */
	public function admin_index() {
		// vilh - save prefix of the brand
		$this->Vocabulary->recursive = 0;

		$vocabulary = $this->Vocabulary->find('list', array(
			'fields' => 'id, slug',
		));

		// get prefix and apply to search form
		$typePrefixes = $this->Vocabulary->getPrefix($vocabulary);

		$prefixFromPost = isset($this->request->query['type_prefix_id']) ? 
						$this->request->query['type_prefix_id'] :
						array();	
		
		$conditions = array();
        $selecteds = [];
        $placeholder = "";

		if ($prefixFromPost)  {
			// search box
			$arrPrefix = [];

			foreach ($typePrefixes as $key => $val)	// 0-brand, 3-shop, 6-menu
			{
				foreach ($prefixFromPost as $value)	// 0, 3, 6
				{
					if ($value == $key) {
						array_push ($arrPrefix, array('Vocabulary.slug like' => $val . '%'));	// brand, shop, menu
						// value on seletion box
						$placeholder = $placeholder . $val . ", ";
						// id on selection box
						array_push($selecteds, $key); 
					}
				}
			}
			
			$conditions = array(
				'OR' => $arrPrefix,
			);
		}

		if(isset($this->request->query['enable']) && $this->request->query['enable'] != ""){
			$conditions["Vocabulary.enabled"] = $this->request->query['enable'];
		}

		if(isset($this->request->query['parent_id']) && $this->request->query['parent_id'] != ""){
			 
			if  ($this->request->query['parent_id'] == 1)
				$conditions["Vocabulary.parent_id >"] = 0;	

			elseif  ($this->request->query['parent_id'] == 0)
				$conditions["Vocabulary.parent_id"] = null;				// array("Vocabulary.parent_id IS NULL");	
		}

		$contain = array(
			'VocabularyLanguage' => array(
				'fields' => array(
					'VocabularyLanguage.name',
				),
				'conditions' => array(
					'VocabularyLanguage.alias' => $this->lang18
				),
			),
		);

		$this->Paginator->settings = array(
			'conditions' => isset($conditions) ? $conditions : '',
			'contain' => $contain,
            'order' => array('Vocabulary.created' => 'DESC')
		);

		$vocabularies = $this->paginate();
	
		for ($i = 0; $i < count($vocabularies); $i++)
		{
			$parent_id = $vocabularies[$i]['Vocabulary']['parent_id'];

			if (isset($parent_id) && !empty($parent_id))
			{
				$vocabularies[$i]['ParentVocabulary']['name'] = isset($vocabularies[$parent_id]['Vocabulary']['slug']) ?  $vocabularies[$parent_id]['Vocabulary']['slug'] : '';
				$vocabularies[$i]['ParentVocabulary']['id'] = $parent_id;
			}
			else
			{
				$vocabularies[$i]['ParentVocabulary']['name'] = "";
				$vocabularies[$i]['ParentVocabulary']['id'] = "";
			}
		}

		$this->set(compact('vocabularies', 'typePrefixes', 'placeholder', 'selecteds'));

		// vilh
		// export data
		$data = $this->request->query;	//['export'];
		if( isset($data['button']['export']) && !empty($data['button']['export']) ){
			$sent = $this->requestAction(array(
				'plugin' => 'dictionary',
				'controller' => 'vocabularies',
				'action' => 'export',
				'admin' => true,
				'prefix' => 'admin',
				'ext' => 'json'
			), array(
				'conditions' => $conditions,
				'contain' => array_merge($contain, array(
					'CreatedBy',
					'UpdatedBy'
				)),
				'type' => 'csv',
				'language' => "",	//$language,
			));
		}

		if( isset($data['button']['export_excel']) && !empty($data['button']['export_excel']) ) {
	
			$sent = $this->requestAction(array(
				'plugin' => 'dictionary',
				'controller' => 'vocabularies',
				'action' => 'export',
				'admin' => true,
				'prefix' => 'admin',
				'ext' => 'json'
			), array(
				'conditions' => $conditions,
				'contain' => array_merge($contain, array(
					'CreatedBy',
					'UpdatedBy'
				)),
				'type' => 'xls',
				'language' => "",	//$language,
			));
		}

		// $column_cache = json_encode($this->Redis->get_cache('booster_column', '_vocabularies'));
		// $this->set(compact('column_cache'));
	}

    public function admin_export() {
        $this->disableCache();
        if( $this->request->is('get') ) {
			$conditions = $this->request->conditions;
            $contain = $this->request->contain;
			
			// for export data use
			$data  = $this->Vocabulary->find('all', array(
				'recursive' => 0,
				'conditions' => isset($conditions) ? $conditions : "",
				'contain' => isset($contain) ? $contain : "",
                'order' => array('Vocabulary.created' => 'DESC')
			));

			for ($i = 0; $i < count($data); $i++)
			{
				$parent_id = $data[$i]['Vocabulary']['parent_id'];

				if (isset($parent_id) && !empty($parent_id))
				{
					$data[$i]['ParentVocabulary']['name'] = $data[$parent_id]['Vocabulary']['slug'];
					$data[$i]['ParentVocabulary']['id'] = $parent_id;
				}
				else
				{
					$data[$i]['ParentVocabulary']['name'] = "";
					$data[$i]['ParentVocabulary']['id'] = "";
				}
			}
			
            if ($data) 
            {
				$cvs_data = array();

				foreach ($data as $row) {
					$row["Vocabulary"]["enabled"] = $row['Vocabulary']['enabled'] == 1 ? 'Y' : 'N';

					$temp = array(
						!empty($row['Vocabulary']["id"]) ? $row['Vocabulary']["id"] : ' ',
						!empty($row['Vocabulary']["slug"]) ? $row['Vocabulary']["slug"] : ' ',
						isset($row['VocabularyLanguage']) && reset($row['VocabularyLanguage']) ? reset($row['VocabularyLanguage'])["name"] : '',
						!empty($row['Vocabulary']["enabled"]) ? $row['Vocabulary']["enabled"] : ' ',
						!empty($row['ParentVocabulary']["name"]) ? $row['ParentVocabulary']["name"] : ' ',
						!empty($row['Vocabulary']["created"]) ? $row['Vocabulary']["created"] : ' ',
						!empty($row['CreatedBy']["email"]) ? $row['CreatedBy']["email"] : ' ',
						!empty($row['Vocabulary']["updated"]) ? $row['Vocabulary']["updated"] : ' ',
						!empty($row['UpdatedBy']["email"]) ? $row['UpdatedBy']["email"] : ' ',
					);

					array_push($cvs_data, $temp);
				}

				try{
					// coupons_20180503
					$file_name = 'vocabulary_'.date('Ymd');

					// export xls
					if ($this->request->type == "xls") {
						$excel_readable_header = array(
							array('label' =>__('id')),
							array('label' =>__('slug')),
							array('label' =>__('name')),
							array('label' => __('enabled')),
							array('label' => __('parent_name')),
							array('label' =>__('created')),
							array('label' =>__('created_by')),
							array('label' =>__('updated')),
							array('label' =>__('updated_by')),
						);

						$this->Common->export_excel(
							$cvs_data,
							$file_name,
							$excel_readable_header
						);
					} else {
						$header = array(
								__('id'),
								__('slug'),
								__('name'),
								__('enabled'),
								__('parent_name'),
								__('created'),
								__('created_by'),
								__('updated'),
								__('updated_by'),
						);

						$this->Common->export_csv(
							$cvs_data,
							$header,
							$file_name
						);
					}
					exit;
				} catch ( Exception $e ) {
                    $this->LogFile->writeLog($this->LogFile->get_system_error(), $e->getMessage());
					$results = array(
						'status' => false, 
						'message' => __('export_csv_fail'),
						'params' => array()
					);
				}
        
            }else{
                $results['message'] = __('no_record');
            }
        }

        $this->set(array(
            'results' => $results,
            '_serialize' => array('results')
        ));
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
	public function admin_view($id = null) {
		if (!$this->Vocabulary->exists($id)) {
			throw new NotFoundException(__('invalid_data'));
		}

		$options = array(
            'conditions' => array('Vocabulary.' . $this->Vocabulary->primaryKey => $id),
            'contain' => array(
                'ParentVocabulary',
                'VocabularyLanguage',
                'CreatedBy',
                'UpdatedBy'
            )
        );
		$vocabulary = $this->Vocabulary->find('first', $options);
        //languages fields
        $language_input_fields = array(
            'name',
            'description',
        );
        
        $languages = isset($vocabulary['VocabularyLanguage']) ? $vocabulary['VocabularyLanguage'] : array();

        $this->set(compact('vocabulary', 'language_input_fields','languages'));
	}

	public function is_check($val){
		if ( isset($val) && !empty($val) ){
			$status = true;
		} else {
			$status = false;
		}

		return $status;
    }
    
    /**
     * admin_add method
     * @return void
     */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Vocabulary->create();
			
			$vocabulary = $this->request->data["Vocabulary"];
	
			// get prefix
			// $parentVocabularies = $this->Vocabulary->ParentVocabulary->find('list', array(
			// 	'fields' => array('id', 'slug')
			// ));
			// get prefix of vocabularies
			// $prefix = $this->Vocabulary->getPrefix($parentVocabularies);

			if ( $this->is_check($vocabulary["prefix"])  && $this->is_check($vocabulary["content"]) ) {
				$vocabulary["slug"] =  $vocabulary["prefix"] . $vocabulary["content"];
			}
	
			if ($this->Vocabulary->saveAll($this->request->data)) {
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
		
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		}

		// -- vilh: 
		// -- get method when click to vocalbulary module
		$parentVocabularies = $this->Vocabulary->ParentVocabulary->find('list', array(
			'fields' => array('id', 'slug')
		));

		// get prefix of vocabularies
		$prefix = json_encode($this->Vocabulary->getPrefix($parentVocabularies));

		$this->set(compact('parentVocabularies', 'prefix'));

		//Vocabulary languages fields
		$language_input_fields = array(
			'id',
			'vocabulary_id',
			'alias',
			'name',
			// 'description',
			// 'zip_code',
		);

        $objLanguage = ClassRegistry::init('Dictionary.Language');
		$languages_list = $objLanguage->get_languages();

		$languages_model = 'VocabularyLanguage';

		$this->set(compact('language_input_fields','languages_list','languages_model'));
	}

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
	public function admin_edit($id = null) {
        $this->Vocabulary->id = $id;
		
		if (!$this->Vocabulary->exists($id)) {
			throw new NotFoundException(__('invalid_data'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Vocabulary->saveAll($this->request->data)) {
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			
			}
		} else {
			$options = array(
                'conditions' => array('Vocabulary.' . $this->Vocabulary->primaryKey => $id),
                'contain' => array(
                    'VocabularyLanguage'
                )
            );
			$this->request->data = $this->Vocabulary->find('first', $options);

		}
        //Vocabulary languages fields
        $language_input_fields = array(
            'id',
            'vocabulary_id',
            'alias',
            'name',
            //'description',
           // 'zip_code',
        );

        $objLanguage = ClassRegistry::init('Dictionary.Language');
        $languages_list = $objLanguage->get_languages();

        $languages_model = 'VocabularyLanguage';

        $this->set(compact('language_input_fields','languages_list','languages_model'));
		$parentVocabularies = $this->Vocabulary->ParentVocabulary->find('list', array(
			'fields' => array('id', 'slug')
		));
		$this->set(compact('parentVocabularies'));

	}

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}

		$this->Vocabulary->id = $id;
		if (!$this->Vocabulary->exists()) {
			throw new NotFoundException(__('invalid_data'));
		}
		
		if ($this->Vocabulary->delete()) {
			$this->Session->setFlash(__('data_is_deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		
		$this->Session->setFlash(__('data_is_not_deleted'), 'flash/error');
	
		$this->redirect(array('action' => 'index'));
	}

	public function admin_district_data_select() {
		$this->Api->init_result();
		
		if( $this->request->is('post') ) {
			$data = $this->request->data;
			$message = "";
			$status = false;
			$result_data = array();
			
			$this->disableCache();

			if (!isset($data['id'])) {
                $message = __('missing_parameter') .  'id';
                
			} else {
				$conditions = array(
					'Vocabulary.parent_id' => $data['id']
				);

				$result_data = $this->Vocabulary->get_full_district_region_list($this->lang18, false, $conditions);
				$status = true;
				
				
            }   
			$this->Api->set_result($status, $message, $result_data);
		}
		$this->Api->output();
	}


    public function api_get_list() {
	   $this->Api->init_result();

        if( $this->request->is('post') ) {
			$data = $this->request->data;

			$message = "";
            $flag = 999;
			$result_data = array();
			
            $this->disableCache();
            if (isset($data['language']) && !empty($data['language'])) {
                $this->Api->set_language( $data['language'] );
            }
            $language = $this->Api->get_language();

            if (!isset($data['device_token']) || empty($data['device_token'])) {
				$message = __('missing_parameter') .  'device_token';
				
			} else if(!isset($data['slug_type']) || empty($data['slug_type'])) {
				$message = __('missing_parameter') .  'slug_type';

            } else {
			
                $slug_type = $data['slug_type'];
                $result_data = $this->Vocabulary->get_list($language['language'], $slug_type);
				$flag = 200;
				$message = __('retrieve_data_successfully');
            }
            
			$this->Api->set_result($flag, $message, $result_data);
        }
		$this->Api->output();
    }

    // public function admin_get_section_object(){
    //     $list = array();
    //     if( $this->request->is('post') ) {
    //         $data = $this->request->data;
    //         if (isset($data['company_id']) && !empty($data['company_id']) && 
    //                 isset($data['section_id']) && !empty($data['section_id'])) {
    //             $list = $this->Vocabulary->available_section_object($data['section_id'], $data['company_id'], $this->lang18);
    //         }
    //     }
    //     $this->set('list', $list);
    // }
}
