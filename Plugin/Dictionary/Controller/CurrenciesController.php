<?php
App::uses('DictionaryAppController', 'Dictionary.Controller');
/**
 * Currencies Controller
 *
 * @property Currency $Currency
 * @property PaginatorComponent $Paginator
 */
class CurrenciesController extends DictionaryAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function beforeFilter(){
		parent::beforeFilter();

		$this->set('title_for_layout', __('dictionary') . ' > ' . __d('dictionary','currencies'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Currency->recursive = 0;

		$contain = array(
			'CurrencyLanguage' => array(
				'fields' => array(
					'CurrencyLanguage.name',
				),
				'conditions' => array(
					'CurrencyLanguage.alias' => $this->lang18
				),
			),
		);
	
		$this->Paginator->settings = array(
            'contain' => $contain,
            'order' => array('Currency.created' => 'DESC')
		);

		$this->set('currencies', $this->paginate());

		$column_cache = json_encode($this->Redis->get_cache('booster_column', '_currencies'));
		$this->set(compact('column_cache'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Currency->exists($id)) {
			throw new NotFoundException(__('invalid_data'));
		}
        $options = array(
            'conditions' => array('Currency.' . $this->Currency->primaryKey => $id),
            'contain' => array(
                'CurrencyLanguage',
                'CreatedBy',
                'UpdatedBy'
            )
        );
        $currency = $this->Currency->find('first', $options);
        //languages fields
        $language_input_fields = array(
            'name',
            'description',
        );

        $languages = isset($currency['CurrencyLanguage']) ? $currency['CurrencyLanguage'] : array();

        $this->set(compact('currency', 'language_input_fields','languages'));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Currency->create();
			
		
			if ($this->Currency->saveAll($this->request->data)) {
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		}

		//Currency languages fields
		$language_input_fields = array(
			'currency_id',
			'alias',
			'name',
			'description',
		);

        $objLanguage = ClassRegistry::init('Dictionary.Language');
		$languages_list = $objLanguage->get_languages();

		$languages_model = 'CurrencyLanguage';

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
        $this->Currency->id = $id;
		if (!$this->Currency->exists($id)) {
			throw new NotFoundException(__('invalid_data'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->Currency->saveAll($this->request->data)) {
				$this->Session->setFlash(__('data_is_saved'), 'flash/success');
				
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
			}
		} else {
			$options = array(
                'conditions' => array('Currency.' . $this->Currency->primaryKey => $id),
                'contain' => array(
                    'CurrencyLanguage',
                    'CreatedBy',
                    'UpdatedBy'
                )
            );
			$this->request->data = $this->Currency->find('first', $options);
		}
        //Currency languages fields
        $language_input_fields = array(
            'id',
            'currency_id',
            'alias',
            'name',
            'description',
        );

        $objLanguage = ClassRegistry::init('Dictionary.Language');
        $languages_list = $objLanguage->get_languages();

        $languages_model = 'CurrencyLanguage';

        $this->set(compact('language_input_fields','languages_list','languages_model'));
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
		$this->Currency->id = $id;
		if (!$this->Currency->exists()) {
			throw new NotFoundException(__('invalid_data'));
        }
        
        $objShopsCurrency = ClassRegistry::init('Company.ShopsCurrency');
        $shop_currencies = $objShopsCurrency->find('count', array(
            'conditions' => array(
                'ShopsCurrency.currency_id' => $id, 
            ),
        ));

        if($shop_currencies){
            $this->Session->setFlash(__('data_not_delete_was_used'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }

        $objCouponDetail = ClassRegistry::init('Coupon.CouponDetail');
        $coupons = $objCouponDetail->find('count', array(
            'conditions' => array(
                'CouponDetail.currency_id' => $id, 
            ),
        ));

        if($coupons){
            $this->Session->setFlash(__('data_not_delete_was_used'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }

		if ($this->Currency->delete()) {
            $this->Session->setFlash(__('data_is_deleted'), 'flash/success');
            
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('data_is_not_deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
}
