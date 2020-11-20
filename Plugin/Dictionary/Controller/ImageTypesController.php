<?php
App::uses('DictionaryAppController', 'Dictionary.Controller');
/**
 * ImageTypes Controller
 *
 * @property ImageType $ImageType
 * @property PaginatorComponent $Paginator
 */
class ImageTypesController extends DictionaryAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

    public function beforeFilter(){
		parent::beforeFilter();
		$this->set('title_for_layout', __('dictionary') . ' > ' . __d('dictionary','image_types'));
    }
    
	public function admin_export() {
        $this->disableCache();

		if( $this->request->is('get') ) {
            $limit = 200;
            $header = array(
                __('id'),
                __('slug'),
                __('name'),
                __('enabled'),
                __('created'),
                __('created_by'),
                __('updated'),
                __('updated_by'),
            );
            
            try{
                $file_name = 'image_type_' . date('Ymdhis');
                $data_binding = array();

                // export xls
                if ($this->request->type == "xls") {
                    $this->Common->setup_export_excel($header, 'Dictionary.ImageType', $data_binding, $this->request->conditions, $limit, $file_name, $this->lang18);
                } else {
                    $this->Common->setup_export_csv($header, 'Dictionary.ImageType', $data_binding, $this->request->conditions, $limit, $file_name, $this->lang18);
                }
                exit;
            } catch ( Exception $e ) {
                $this->LogFile->writeLog($this->LogFile->get_system_error(), $e->getMessage());
                $this->Session->setFlash(__('export_csv_fail') . ": " . $e->getMessage(), 'flash/error');
            }
        }
	}

    /**
     * admin_index method
     * vilh - 2019/03/14
     * - add prefix to search fields
     * @return void
     */
	public function admin_index() {

		// vilh - save prefix of the brand
		$this->ImageType->recursive = 0;

		$imageType = $this->ImageType->find('list', array(
			'fields' => 'id, slug',
		));

		// get prefix and apply to search form
        $typePrefixes = $this->ImageType->getPrefix($imageType);

		$data_search = $this->request->query;

		$prefixFromPost = isset($data_search['type_prefix_id']) ? $data_search['type_prefix_id'] : array();

		$conditions = array();
		$selected = [];

		// prefix
		if($prefixFromPost) {
			// search box
			// vilh - get prefix
			$arrPrefix = [];
			foreach ($typePrefixes as $key => $val)	{ // 0-brand, 3-shop, 6-menu 
				foreach ($prefixFromPost as $value)	{ // 0, 3, 6 
					if ($value == $key) {
						array_push ($arrPrefix, array('slug like' => $val . '%'));	// brand, shop, menu
						array_push($selected, $key); 
					}
				}
			}
			
			$conditions = array(
				'OR' => $arrPrefix,
			);
		}

		// enabled
		if(isset($data_search['data']['filter']) && $data_search['data']['filter']['enabled'] != ""){
			$conditions["ImageType.enabled"] = $data_search['data']['filter']['enabled'];
		}

		// language
		$contain = array(
			'ImageTypeLanguage' => array(
				'fields' => array(
					'ImageTypeLanguage.name',
				),
				'conditions' => array(
					'ImageTypeLanguage.alias' => $this->lang18
				),
			),
        );

		// vilh
		// export function
		$data = $this->request->query;
		if( isset($data['button_export_csv']) && !empty($data['button_export_csv']) ){
			$this->requestAction(array(
				'plugin' => 'dictionary',
				'controller' => 'image_types',
				'action' => 'export',
				'admin' => true,
				'prefix' => 'admin',
				'ext' => 'json'
			), array(
				'conditions' => $conditions,
				'type' => 'csv',
				'language' => "",	//$language,
			));
		}

		if( isset($data['button_export_excel']) && !empty($data['button_export_excel']) ){
		    $this->requestAction(array(
				'plugin' => 'dictionary',
				'controller' => 'image_types',
				'action' => 'export',
				'admin' => true,
				'prefix' => 'admin',
				'ext' => 'json'
			), array(
				'conditions' => $conditions,
				'type' => 'xls',
				'language' => "",	//$language,
			));
		}

		$this->Paginator->settings = array(
			'conditions' => isset($conditions) ? $conditions : '',
			'contain' => $contain,
            'order' => array('ImageType.created' => 'DESC')
		);

		$imageTypes = $this->paginate();

		// $imageTypes = $this->paginate('ImageType', isset($conditions) ? $conditions : '');
		$this->set(compact('imageTypes', 'typePrefixes',  'selected'));
	}

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
	public function admin_view($id = null) {
		if (!$this->ImageType->exists($id)) {
			throw new NotFoundException(__('invalid_data'));
		}
		$options = array(
            'conditions' => array('ImageType.' . $this->ImageType->primaryKey => $id),
            'contain' => array(
                'ImageTypeLanguage',
                'CreatedBy',
                'UpdatedBy'
            )
        );
        $imageType = $this->ImageType->find('first', $options);
        //languages fields
        $language_input_fields = array(
            'name',
            'description',
        );

        $languages = isset($imageType['ImageTypeLanguage']) ? $imageType['ImageTypeLanguage'] : array();

        $this->set(compact('imageType', 'language_input_fields','languages'));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->ImageType->create();

			if ($this->ImageType->saveAll($this->request->data)) {
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		}
		//Currency languages fields
		$language_input_fields = array(
			'id',
			'image_type_id',
			'alias',
			'name',
			'description',
		);

        $objLanguage = ClassRegistry::init('Dictionary.Language');
		$languages_list = $objLanguage->get_languages();

		$languages_model = 'ImageTypeLanguage';

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
        $this->ImageType->id = $id;
		if (!$this->ImageType->exists($id)) {
			throw new NotFoundException(__('invalid_data'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			
			if ($this->ImageType->saveAll($this->request->data)) {
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		} else {
			$options = array(
                'conditions' => array('ImageType.' . $this->ImageType->primaryKey => $id),
                'contain' => array(
                    'ImageTypeLanguage',
                )
            );
			$this->request->data = $this->ImageType->find('first', $options);
		}

        //Currency languages fields
        $language_input_fields = array(
            'id',
            'image_type_id',
            'alias',
            'name',
            'description',
        );

        $objLanguage = ClassRegistry::init('Dictionary.Language');
        $languages_list = $objLanguage->get_languages();

        $languages_model = 'ImageTypeLanguage';

        $this->set(compact('language_input_fields','languages_list','languages_model'));
	}

    // Thong comment
    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
	// public function admin_delete($id = null) {
	// 	if (!$this->request->is('post')) {
	// 		throw new MethodNotAllowedException();
	// 	}
	// 	$this->ImageType->id = $id;
	// 	if (!$this->ImageType->exists()) {
	// 		throw new NotFoundException(__('invalid_data'));
	// 	}
	// 	if ($this->ImageType->delete()) {
	// 		$this->Session->setFlash(__('data_is_deleted'), 'flash/success');
	// 		$this->redirect(array('action' => 'index'));
	// 	}
	// 	$this->Session->setFlash(__('data_is_not_deleted'), 'flash/error');
	// 	$this->redirect(array('action' => 'index'));
	// }



	public function api_get_list_image_type_with_course_slug() {
		$this->Api->init_result();
		if( $this->request->is('post')) {
			$this->disableCache();
			$feedback = 999;
			$message = "";
	
			$data = $this->request->data;
			$result = (object)array();

			if (!isset($data['language']) || empty($data['language'])) {
				$message = __('missing_parameter') .  'language';

			} elseif (!isset($data['device_token']) || empty($data['device_token'])) {
				$message = __('missing_parameter') .  'device_token';
				
			} else {

				$this->Api->set_language($data['language']);
				
				$result = $this->ImageType->get_list_image_type_with_course_slug($data);
				
               
              	$feedback 	= 200;
				$message 	= __('retrieve_data_successfully');
			
			}
			load_api:
			$this->Api->set_result($feedback, $message, $result);
		}
		$this->Api->output();
	}
}
