<?php
    App::uses('DictionaryAppController', 'Dictionary.Controller');
    App::uses('ClearCacheAppController', 'ClearCache.Controller');
    App::uses('ClearCacheController', 'ClearCache.Controller');
    App::uses('ClearCache', 'ClearCache.Lib');
    include('../Vendor/poparser/poparser.php');
    /**
     * Languages Controller
     *
     * @property Language $Language
     * @property PaginatorComponent $Paginator
     */
    class LanguagesController extends DictionaryAppController {
        public $locale_setting;

        public $table_list = array(
        
            array(
                "parent_name" => "company_details", 
                "name" => "company_languages", 
                "field_id" => "company_detail_id",
                "field_parent_id" => "company_id",
                "field_status" => "status",
                "class" => "Company.CompanyLanguage",
                "is_having_detail" => true,
            ),
         
            // array(
            //     "parent_name" => "currencies", 
            //     "name" => "currency_languages", 
            //     "field_id" => "currency_id",
            //     "field_parent_id" => "id",
            //     "field_status" => "enabled",
            //     "class" => "Dictionary.CurrencyLanguage",
            //     "is_having_detail" => false,
            // ),
            array(
                "parent_name" => "device_types", 
                "name" => "device_type_languages", 
                "field_id" => "device_type_id",
                "field_parent_id" => "id",
                "field_status" => "enabled",
                "class" => "Member.DeviceTypeLanguage",
                "is_having_detail" => false,
            ),
          
            array(
                "parent_name" => "image_types", 
                "name" => "image_type_languages", 
                "field_id" => "image_type_id",
                "field_parent_id" => "id",
                "field_status" => "enabled",
                "class" => "Dictionary.ImageTypeLanguage",
                "is_having_detail" => false,
            ),
         
            // array(
            //     "parent_name" => "payment_method_details", 
            //     "name" => "payment_method_languages", 
            //     "field_id" => "payment_method_detail_id",
            //     "field_parent_id" => "payment_method_id",
            //     "field_status" => "status",
            //     "action" => "edit",
            //     "class" => "PaymentMethod.PaymentMethodLanguage",
            //     "is_having_detail" => true,
            // ),
           
            array(
                "parent_name" => "push_methods", 
                "name" => "push_method_languages", 
                "field_id" => "push_method_id",
                "field_parent_id" => "id",
                "field_status" => "enabled",
                "class" => "Push.PushMethodLanguage",
                "is_having_detail" => false,
            ),
            array(
                "parent_name" => "push_types", 
                "name" => "push_type_languages", 
                "field_id" => "push_type_id",
                "field_parent_id" => "id",
                "field_status" => "enabled",
                "class" => "Push.PushTypeLanguage",
                "is_having_detail" => false,
            ),

            // array(
            //     "parent_name" => "verification_types", 
            //     "name" => "verification_type_languages", 
            //     "field_id" => "verification_type_id",
            //     "field_parent_id" => "id",
            //     "field_status" => "enabled",
            //     "class" => "Member.VerificationTypeLanguage",
            //     "is_having_detail" => false,
            // ),
            array(
                "parent_name" => "vocabularies", 
                "name" => "vocabulary_languages", 
                "field_id" => "vocabulary_id",
                "field_parent_id" => "id",
                "field_status" => "enabled",
                "class" => "Dictionary.VocabularyLanguage",
                "is_having_detail" => false,
            ),
        );
    /**
     * Components
     *
     * @var array
     */
        public $components = array('Paginator');
        
        public function __construct ($request = null, $response = null){
            parent::__construct($request, $response);
            $path = Environment::read('web.source_code_path');

            $this->locale_setting = array(
                array(
                    "name" => "common", 
                    "path_eng" => APP ."Locale/eng/LC_MESSAGES/default.po", 
                    "path" => APP ."Locale/%s/LC_MESSAGES/default.po",
                    "source_path" => $path ."Locale/%s/LC_MESSAGES/default.po",
                ),
                array(
                    "name" => "administration", 
                    "path_eng" => APP ."Plugin/Administration/Locale/eng/LC_MESSAGES/administration.po", 
                    "path" => APP ."Plugin/Administration/Locale/%s/LC_MESSAGES/administration.po",
                    "source_path" => $path ."Plugin/Administration/Locale/%s/LC_MESSAGES/administration.po",
                ),
                array(
                    "name" => "company", 
                    "path_eng" => APP ."Plugin/Company/Locale/eng/LC_MESSAGES/company.po", 
                    "path" => APP ."Plugin/Company/Locale/%s/LC_MESSAGES/company.po", 
                    "source_path" => $path ."Plugin/Company/Locale/%s/LC_MESSAGES/company.po", 
                ),
                array(
                    "name" => "coupon", 
                    "path_eng" => APP ."Plugin/Coupon/Locale/eng/LC_MESSAGES/coupon.po", 
                    "path" => APP."Plugin/Coupon/Locale/%s/LC_MESSAGES/coupon.po", 
                    "source_path" => $path ."Plugin/Coupon/Locale/%s/LC_MESSAGES/coupon.po", 
                ),
                array(
                    "name" => "dashboard", 
                    "path_eng" => APP ."Plugin/Dashboard/Locale/eng/LC_MESSAGES/dashboard.po", 
                    "path" => APP."Plugin/Dashboard/Locale/%s/LC_MESSAGES/dashboard.po", 
                    "source_path" => $path ."Plugin/Dashboard/Locale/%s/LC_MESSAGES/dashboard.po", 
                ),
                array(
                    "name" => "dictionary", 
                    "path_eng" => APP ."Plugin/Dictionary/Locale/eng/LC_MESSAGES/dictionary.po", 
                    "path" => APP ."Plugin/Dictionary/Locale/%s/LC_MESSAGES/dictionary.po", 
                    "source_path" => $path ."Plugin/Dictionary/Locale/%s/LC_MESSAGES/dictionary.po", 
                ),
                array(
                    "name" => "fact", 
                    "path_eng" => APP ."Plugin/Fact/Locale/eng/LC_MESSAGES/fact.po", 
                    "path" => APP ."Plugin/Fact/Locale/%s/LC_MESSAGES/fact.po", 
                    "source_path" => $path ."Plugin/Fact/Locale/%s/LC_MESSAGES/fact.po", 
                ),
                array(
                    "name" => "log", 
                    "path_eng" => APP ."Plugin/Log/Locale/eng/LC_MESSAGES/log.po", 
                    "path" => APP ."Plugin/Log/Locale/%s/LC_MESSAGES/log.po", 
                    "source_path" => $path ."Plugin/Log/Locale/%s/LC_MESSAGES/log.po", 
                ),
                array(
                    "name" => "member", 
                    "path_eng" => APP ."Plugin/Member/Locale/eng/LC_MESSAGES/member.po", 
                    "path" => APP ."Plugin/Member/Locale/%s/LC_MESSAGES/member.po", 
                    "source_path" =>  $path ."Plugin/Member/Locale/%s/LC_MESSAGES/member.po", 
                ),
                array(
                    "name" => "menu", 
                    "path_eng" => APP ."Plugin/Menu/Locale/eng/LC_MESSAGES/menu.po", 
                    "path" => APP ."Plugin/Menu/Locale/%s/LC_MESSAGES/menu.po", 
                    "source_path" => $path ."Plugin/Menu/Locale/%s/LC_MESSAGES/menu.po", 
                ),
                array(
                    "name" => "payment_method", 
                    "path_eng" => APP ."Plugin/PaymentMethod/Locale/eng/LC_MESSAGES/payment_method.po", 
                    "path" => APP ."Plugin/PaymentMethod/Locale/%s/LC_MESSAGES/payment_method.po", 
                    "source_path" => $path ."Plugin/PaymentMethod/Locale/%s/LC_MESSAGES/payment_method.po", 
                ),
                array(
                    "name" => "point", 
                    "path_eng" => APP ."Plugin/Point/Locale/eng/LC_MESSAGES/point.po", 
                    "path" => APP ."Plugin/Point/Locale/%s/LC_MESSAGES/point.po", 
                    "source_path" => $path ."Plugin/Point/Locale/%s/LC_MESSAGES/point.po", 
                ),
                array(
                    "name" => "promotion", 
                    "path_eng" => APP ."Plugin/Promotion/Locale/eng/LC_MESSAGES/promotion.po", 
                    "path" => APP ."Plugin/Promotion/Locale/%s/LC_MESSAGES/promotion.po", 
                    "source_path" => $path ."Plugin/Promotion/Locale/%s/LC_MESSAGES/promotion.po", 
                ),
                array(
                    "name" => "push", 
                    "path_eng" => APP ."Plugin/Push/Locale/eng/LC_MESSAGES/push.po", 
                    "path" => APP ."Plugin/Push/Locale/%s/LC_MESSAGES/push.po", 
                    "source_path" => $path ."Plugin/Push/Locale/%s/LC_MESSAGES/push.po", 
                ),
                array(
                    "name" => "service", 
                    "path_eng" => APP ."Plugin/Service/Locale/eng/LC_MESSAGES/service.po", 
                    "path" => APP ."Plugin/Service/Locale/%s/LC_MESSAGES/service.po", 
                    "source_path" => $path ."Plugin/Service/Locale/%s/LC_MESSAGES/service.po", 
                ),
                array(
                    "name" => "terminology", 
                    "path_eng" => APP ."Plugin/Terminology/Locale/eng/LC_MESSAGES/terminology.po", 
                    "path" => APP ."Plugin/Terminology/Locale/%s/LC_MESSAGES/terminology.po", 
                    "source_path" => $path ."Plugin/Terminology/Locale/%s/LC_MESSAGES/terminology.po", 
                ),
                array(
                    "name" => "version", 
                    "path_eng" => APP ."Plugin/Version/Locale/eng/LC_MESSAGES/version.po", 
                    "path" => APP ."Plugin/Version/Locale/%s/LC_MESSAGES/version.po", 
                    "source_path" => $path ."Plugin/Version/Locale/%s/LC_MESSAGES/version.po", 
                ),
            );
        
        }

        public function beforeFilter(){
            parent::beforeFilter();

            $this->set('title_for_layout', __('dictionary') . ' > ' . __d('dictionary','languages'));
        }
    /**
     * admin_index method
     *
     * @return void
     */
        public function admin_index() {
            $this->Language->recursive = 0;
            $this->Paginator->settings = array(
                'order' => array('Language.created' => 'DESC')
            );
            $this->set('languages', $this->paginate());
        }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
        public function admin_view($id = null) {
            if (!$this->Language->exists($id)) {
                throw new NotFoundException(__('invaid_data'));
            }
            $options = array(
                'conditions' => array('Language.' . $this->Language->primaryKey => $id),
                'contain' => array(
                    'CreatedBy',
                    'UpdatedBy'
                )
            );
            $this->set('language', $this->Language->find('first', $options));
        }

    /**
     * admin_add method
     *
     * @return void
     */
        public function admin_add() {
            if ($this->request->is('post')) {
                $this->Language->create();

                if ($this->Language->save($this->request->data)) {
                    //$tmp_lang = $this->Common->get_lang_from_db();
                    $tmp_lang = $this->Language->get_lang_from_db();
                    $this->Session->setFlash(__('data_is_saved'), 'flash/success');

                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
                }
            }
        }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
        public function admin_edit($id = null) {
            $this->Language->id = $id;
            if (!$this->Language->exists($id)) {
                throw new NotFoundException(__('invalid_data'));
            }
            if ($this->request->is('post') || $this->request->is('put')) {
                if ($this->Language->save($this->request->data)) {
                   // $tmp_lang = $this->Common->get_lang_from_db();

                    $tmp_lang = $this->Language->get_lang_from_db();
                    $this->Session->setFlash(__('data_is_saved'), 'flash/success');

                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('data_is_not_saved'), 'flash/error');
                }
            } else {
                $options = array('conditions' => array('Language.' . $this->Language->primaryKey => $id));
                $this->request->data = $this->Language->find('first', $options);
            }
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
            $this->Language->id = $id;
            if (!$this->Language->exists()) {
                throw new NotFoundException(__('invalid_data'));
            }
            if ($this->Language->delete()) {
                // $tmp_lang = $this->Common->get_lang_from_db();
                $tmp_lang = $this->Language->get_lang_from_db();
                $this->Session->setFlash(__('data_is_deleted'), 'flash/success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('data_is_not_deleted'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }


    public function insert_new_lang($id, $name, $lang_name, $objModel, $arr_setting) {
        $field_name = $arr_setting['field_id'];
        $field_parent_id = $arr_setting['field_parent_id'];
        $class_name = $arr_setting['class'];
        $table_parent = $arr_setting['parent_name'];
        $field_status = $arr_setting['field_status'];
        $is_having_detail = $arr_setting['is_having_detail'];

        $keyname = explode(".", $class_name);
        $modal_name = $keyname[1];

        $data_update = array();

        $insert_id = $id;
        if ($is_having_detail) {
            $options = array(
                'fields' => array($modal_name.'.*', 'b.id as parent_id'),
                'conditions' => array(
                    'b.'.$field_parent_id => $id,
                    'b.'.$field_status => 1,
                ),
                'joins' => array(
                    array(
                        'alias' => 'b',
                        'table' => Environment::read('table_prefix') . $table_parent,
                        'type' => 'RIGHT',
                        'conditions' => array(
                            'AND' => array('b.id = '.$field_name, "alias = '".$lang_name."'"),
                        ),
                    ),
                ),
                'recursive' => -1,
            );			 

            $sql_result = $objModel->find('first', $options);

            if (!isset($sql_result[$modal_name])) {
                $strmsg = 'id => '.$id.' is not found';
                throw new NotFoundException($strmsg);
            }
            $data_update = $sql_result[$modal_name];
            $insert_id = $sql_result['b']['parent_id'];

            if (!($data_update['id'] > 0)) {
                $objModel->create();
                $data_update[$field_name] = $insert_id;
                $data_update['alias'] = $lang_name;
            }
        } else {
            $options = array(
                'conditions' => array(
                    $field_name => $id,
                    'alias' => $lang_name
                ),
                'recursive' => -1
            );
            $old_data = $objModel->find('first', $options);
            if (count($old_data) <= 0) {
                $objModel->create();
                $data_update[$field_name] = $insert_id;
                $data_update['alias'] = $lang_name;
            } else if (!$is_having_detail) {
                $data_update = $old_data[$modal_name];
            }
        }

        $data_update['name'] = $name;

        if (!($objModel->save($data_update))) {
            $err = $objModel->invalidFields();
            $err_key = array_keys($err);
            $strmsg = "'".$err_key[0] . "' - " . $err[$err_key[0]][0];
            throw new NotFoundException($strmsg);
        }

        return $data_update;
    }

    /**
     * admin_import method
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
    // public function admin_validate($id = null) {
    //     $this->Language->id = $id;
    //     if (!$this->Language->exists()) {
    //         throw new NotFoundException(__('invalid_data'));
    //     }

    //     $lang_default = $this->Language->findByIsDefault(1);

    //     if ($id == $lang_default['Language']['id']) {
    //         throw new NotFoundException('Unable to validate default language');
    //     }

    //     $data = $this->request->data;

    //     $languages_data = $this->Language->find('first',array(
    //         'fields' => array(
    //             'Language.id',
    //             'Language.alias',
    //             'Language.is_default',
    //         ),
    //         'conditions' => array( 'Language.id' => $id, ),
    //         'recursive' => -1
    //     ));

    //     $lang_name = $languages_data['Language']['alias'];

    //     $short_msg = array();
    //     $short_msg[] = "====================  LOCALE FILE  ====================";	
    //     $is_err = false;
    //     foreach($this->locale_setting as $locale) {
    //         $tmpdata = array();
    //         $path_def = $locale['path_eng'];
    //         $path = $locale['path'];
    //         $path = sprintf($path, $lang_name);

    //         $poparser_def = new PoParser();
    //         $entries_def = $poparser_def->read($path_def);
    //         unset($entries_def['']);

    //         $name = $locale['name'];

    //         $file_exists = false;
    //         if (file_exists($path)) {
    //             $poparser = new PoParser();
    //             $entries = $poparser->read($path);
    //             unset($entries['']);
    //             $file_exists = true;
    //         } else {
    //             //file is not found, add error log
    //             $is_err = true;
    //             $short_msg[] = "[<b>".$name."</b>] : File locales is not found";	
    //             goto end_of_loop;		
    //         }

    //         $msgid_deff_arr = array_keys($entries_def);
    //         foreach($msgid_deff_arr as $msgid) {
    //             if(!isset($entries[$msgid])){
    //                 $is_err = true;
    //                 $short_msg[] = "[<b>".$name."</b>] - unable to find msgid : '<b>".$msgid."</b>'";	
    //             } else if (strlen(trim($entries[$msgid]['msgstr'][0])) <= 0) {
    //                 $is_err = true;
    //                 $short_msg[] = "[<b>".$name."</b>] - translation string for msgid : '<b>".$msgid."</b>' is empty.";	
    //             }
    //         }
            
    //         /*
    //         foreach($entries_def as $entries_def) {
    //             //search for each entries def in entries
    //             //and vice versa

    //         }
    //         */
    //         end_of_loop:
    //     }
        
    //     if (!$is_err) {
    //         $short_msg[] = "No error found.";	
    //     }

    //     $short_msg[] = "";	
    //     $short_msg[] = "";	
    //     $short_msg[] = "====================  DATABASE  ====================";	
    //     $is_err = false;
    //     foreach($this->table_list as $table) {
    //         $tmpdata = array();
    //         $table_parent_name = 'booster_'.$table['parent_name'];
    //         $table_name = 'booster_'.$table['name'];
    //         $field_id = $table['field_id'];
    //         $field_parent_id = $table['field_parent_id'];
    //         $field_status = $table['field_status'];
            
    //         $sqlstr =  "select a.".$field_parent_id." as id, b.name as name_def, IFNULL(c.name, '') as name
    //         from ".$table_parent_name." a inner join ".$table_name." b on (b.".$field_id." = a.id and b.alias = 'eng')
    //             left join ".$table_name." c on (c.".$field_id." = a.id and c.alias = '".$lang_name."')
    //         where a.".$field_status." = 1 and (c.id is null or c.name = '')";
            
    //         $entries = $this->Language->query($sqlstr);
            
    //         foreach($entries as $entries) {
    //             $is_err = true;
    //             $short_msg[] = "[<b>".$table_name."</b>] - translation string for : '<b>".$entries['b']['name_def']."</b>' is empty.";
    //         }
    //     }

    //     if (!$is_err) {
    //         $short_msg[] = "No error found.";	
    //     }

    //     $this->set(compact('short_msg'));
    // }

    /**
     * admin_import method
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
    // public function admin_import($id = null) {
    //     $this->Language->id = $id;
    //     if (!$this->Language->exists()) {
    //         throw new NotFoundException(__('invalid_data'));
    //     }

    //     $short_msg = array();
    //     $class_hidden = "hidden";
    //     if ($this->request->is('post')) {
    //         $data = $this->request->data;

    //         $languages_data = $this->Language->find('first',array(
    //             'fields' => array(
    //                 'Language.id',
    //                 'Language.alias',
    //                 'Language.is_default',
    //             ),
    //             'conditions' => array( 'Language.id' => $id, ),
    //             'recursive' => -1
    //         ));
        
    //         $lang_name = $languages_data['Language']['alias'];

    //         $objresult = $this->Common->upload_and_read_excel($data['Language'], '');

    //         if (!isset($objresult['status']) || !$objresult['status']) {
    //             throw new NotFoundException(__('invalid_data'));
    //         }

    //         $msg = array();
    //         $excel_data = $objresult['data'];
    //         foreach ($excel_data as $sheet_name => $sheet_data) {
    //             $valid = true;
    //             $type = null;
                
    //             $key_index = $this->Common->get_key_from_2dim_array($sheet_name, 'name', $this->locale_setting); 
    //             if($key_index >= 0) {
    //                 $type = 'locale';

    //                 //get path
    //                 $path = $this->locale_setting[$key_index]['path'];
    //                 $path = sprintf($path, $lang_name);

    //                 $filename = basename($path);
    //                 $dir = str_replace('/' . $filename, '', $path);					

    //                 if (!file_exists($dir)) {
    //                     $oldmask = umask(0);
    //                     mkdir($dir, 0777, true);
    //                     umask($oldmask);
    //                 }

    //                 //open the path for rewrite
    //                 $fp = fopen($path,"w");

    //                 if(!isset($fp) || !$fp) {
    //                     $valid = false;
    //                     $msg[] = array(
    //                         'name' => $sheet_name,
    //                         'status' => $valid,
    //                         'type' => $type,
    //                         'msg' => 'unable to create file'
    //                     );

    //                     $short_msg[] = "'".$sheet_name."' : Unable to open/access the file/folder, please check permission";

    //                     goto load_data;
    //                 }

    //             } else {
    //                 $key_index = $this->Common->get_key_from_2dim_array($sheet_name, 'name', $this->table_list); 
    //                 if ($key_index >= 0) {
    //                     $type = 'database';
    //                     //get the table name and check if the table name is exists
    //                 } else {
    //                     $valid = false;
    //                     $msg[] = array(
    //                         'name' => $sheet_name,
    //                         'status' => $valid,
    //                         'type' => $type,
    //                         'msg' => 'unrecognized sheet name'
    //                     );

    //                     $short_msg[] = "'".$sheet_name."' : unrecognized sheet name";

    //                     goto load_data;
    //                 }
    //             }

    //             if ($valid) {
    //                 if($type == 'locale') {
    //                     //write the array back to original file
    //                     $index = 0;
    //                     foreach ($sheet_data as $data) {
    //                         if ($index == 0) { 
    //                             fwrite( $fp, "msgid \"\"\n" );
    //                             fwrite( $fp, "msgstr \"\"\n" );
    //                             fwrite( $fp, "\"Project-Id-Version: \\n\"\n" );
    //                             fwrite( $fp, "\"POT-Creation-Date: \\n\"\n" );
    //                             fwrite( $fp, "\"PO-Revision-Date: \\n\"\n" );
    //                             fwrite( $fp, "\"Last-Translator: \\n\"\n" );
    //                             fwrite( $fp, "\"Language-Team: \\n\"\n" );
    //                             fwrite( $fp, "\"MIME-Version: 1.0\\n\"\n" );
    //                             fwrite( $fp, "\"Content-Type: text/plain; charset=UTF-8\\n\"\n" );
    //                             fwrite( $fp, "\"Content-Transfer-Encoding: 8bit\\n\"\n" );
    //                             fwrite( $fp, "\"Language: zh_HK\\n\"\n" );
    //                             fwrite( $fp, "\"Plural-Forms: nplurals=1; plural=0;\\n\"\n" );
    //                         } else {
    //                             fwrite( $fp, "msgid \"".$data[0]."\"\n" );
    //                             $msgstr = trim($data[2]);
    //                             fwrite( $fp, "msgstr \"".$msgstr."\"\n" );
                                
    //                         }
    //                         fwrite( $fp, "\n" );
    //                         $index++;
    //                     }
    //                     fclose($fp);

    //                     //build the mo file
    //                     //$dest_file_name = $dir.'/'.str_replace('.po', '.mo', $filename);
    //                     //$cmd = Environment::read('web.gettext_path')."msgfmt ".$path." -o ".$dest_file_name;

    //                     $source_path = $this->locale_setting[$key_index]['source_path'];
    //                     $source_path = sprintf($source_path, $lang_name);

    //                     $dest_file_name = str_replace('.po', '.mo', $source_path);
    //                     $cmd = Environment::read('web.gettext_path')."msgfmt ".$source_path." -o ".$dest_file_name;
                        
                        


    //                     $output = '';
    //                     $return = 5;					
    //                     exec($cmd, $output, $return);

    //                     if ($return > 0) {
    //                         //unable to generate mo file
    //                         $msg[] = array(
    //                             'name' => $sheet_name,
    //                             'status' => false,
    //                             'type' => $type,
    //                             'msg' => 'Unable to generate mo file'
    //                         );						
    //                         $short_msg[] = "'".$sheet_name."' : Unable to to generate mo file";

    //                     } else {
    //                         $msg[] = array(
    //                             'name' => $sheet_name,
    //                             'status' => $valid,
    //                             'type' => $type,
    //                             'msg' => 'completed successfully'
    //                         );
    //                     }

    //                     //Cache::clear(false);
    //                     //clearCache();
    //                     //(new ClearCacheController())->engines();
    //                 } else if($type == 'database') {
    //                     //start trans
    //                     //read per record and then update the original record from database
    //                     //if single record is failed, then we should have log for these records
    //                     //commit
    //                     //or rollback
                        
    //                     $index = 0;
    //                     $log = array();
    //                     //$table_name = $this->table_list[$key_index]['name'];
    //                     //$field_name = $this->table_list[$key_index]['field_id'];
    //                     $class_name = $this->table_list[$key_index]['class'];
    //                     $arr_setting = $this->table_list[$key_index];
    //                     $objModel = ClassRegistry::init($class_name);
                        
    //                     foreach ($sheet_data as $data) {

    //                         if ($index > 0) {
    //                             $update_status = true;
    //                             $msgstr = "updated successfully";
    //                             $result = null;
                                
    //                             $db = $this->Language->getDataSource();
    //                             $db->begin();
    //                             try{							
    //                                 $result = $this->insert_new_lang($data[0], $data[2], $lang_name, $objModel, $arr_setting);
    //                                 $db->commit();
    //                             } catch(Exception $e){
    //                                 $db->rollback();
    //                                 $update_status = false;
    //                                 $msgstr = "failed, err : " . $e->getMessage();

    //                                 $short_msg[] = "'".$sheet_name."' - '".$data[1]."' : failed to save to db, err : ".$e->getMessage();
    //                             }

    //                             $log[] = array(
    //                                 'id_detail' => $data[0],
    //                                 'name_eng' => $data[1],
    //                                 'status' => $update_status,
    //                                 'data' => $result,
    //                                 'msg' => $msgstr,
    //                             );

    //                         }
    //                         $index++;
    //                     }



    //                     $msg[] = array(
    //                         'name' => $sheet_name,
    //                         'status' => $valid,
    //                         'type' => $type,
    //                         'msg' => $log
    //                     );


    //                 }
    //             }

    //         }

    //         if (count($short_msg) <= 0) {
    //             $this->Session->setFlash(__('data_is_saved'), 'flash/success');
    //             $this->redirect(array('action' => 'index'));
    //         } else {
    //             $this->Session->setFlash('invalid data while importing translation', 'flash/error');
    //             $class_hidden = "";
    //         }
    //     }

    //     $this->set(compact('short_msg', 'class_hidden'));
    // }

    public function admin_export($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        
        $this->Language->id = $id;
        if (!$this->Language->exists()) {
            throw new NotFoundException(__('invalid_data'));
        }
        
        $languages_data = $this->Language->find('first',array(
            'fields' => array(
                'Language.id',
                'Language.alias',
                'Language.is_default',
            ),
            'conditions' => array( 'Language.id' => $id, ),
            'recursive' => -1
        ));

        $lang_name = $languages_data['Language']['alias'];

        $csv_data = array();
        $locale_data = array();
        $header_locale_data = array();
        
        foreach($this->locale_setting as $locale) {
            $tmpdata = array();
            $path_eng = $locale['path_eng'];
            $path = $locale['path'];
            $path = sprintf($path, $lang_name);

            $poparser_eng = new PoParser();
            $entries_eng = $poparser_eng->read($path_eng);
            unset($entries_eng['']);

            $file_exists = false;
            if (file_exists($path)) {
                $poparser = new PoParser();
                $entries = $poparser->read($path);
                unset($entries['']);
                $file_exists = true;
            }

            foreach($entries_eng as $entries_eng) {
                $row = array();
                $row[] = $entries_eng['msgid'][0];
                $row[] = $entries_eng['msgstr'][0];
                $row[] = (isset($entries[$entries_eng['msgid'][0]]['msgstr'][0]) && $file_exists) ? 
                    $entries[$entries_eng['msgid'][0]]['msgstr'][0] : 
                    "";
                $tmpdata[] = $row;
            }

            $locale_data[$locale['name']] = $tmpdata;
            $header_locale_data[$locale['name']] = array(
                array('label' => 'msgid'),
                array('label' => 'msgstr_eng'),
                array('label' => 'msgstr'),
            );
        }

        foreach($this->table_list as $table) {
            $tmpdata = array();
            $table_parent_name = 'booster_'.$table['parent_name'];
            $table_name = 'booster_'.$table['name'];
            $field_id = $table['field_id'];
            $field_parent_id = $table['field_parent_id'];
            $field_status = $table['field_status'];

            /*
            $sqlstr =  "select b.".$field_id." as id, b.name as name_eng, IFNULL(c.name, '') as name
                        from ".$table_parent_name." a inner join ".$table_name." b on (b.".$field_id." = a.id and b.alias = 'eng')
                            left join ".$table_name." c on (c.".$field_id." = a.id and c.alias = '".$lang_name."')
                        where a.".$field_status." = 1";
            */
            
            $sqlstr =  "select a.".$field_parent_id." as id, b.name as name_eng, IFNULL(c.name, '') as name
            from ".$table_parent_name." a inner join ".$table_name." b on (b.".$field_id." = a.id and b.alias = 'eng')
                left join ".$table_name." c on (c.".$field_id." = a.id and c.alias = '".$lang_name."')
            where a.".$field_status." = 1";
            
            $entries = $this->Language->query($sqlstr);
            
            foreach($entries as $entries) {
                $row = array();
                $row[] = $entries['a']['id'];
                $row[] = $entries['b']['name_eng'];
                $row[] = $entries[0]['name'];
                $tmpdata[] = $row;
            }

            $locale_data[$table['name']] = $tmpdata;
            $header_locale_data[$table['name']] = array(
                array('label' => 'id'),
                array('label' => 'name_eng'),
                array('label' => 'name'),
            );
        }

        $csv_data["language_export_".$lang_name] = $locale_data;

        try{
            // export xls
            $excel_readable_header["language_export_".$lang_name] = $header_locale_data;

            $this->Common->export_multiple_excel(
                $csv_data,
                $excel_readable_header
            );
            
            exit;

        } catch ( Exception $e ) {
            $this->Session->setFlash($e->getMessage(), 'flash/error');
        }
    }

	// -----------------------------------------
	// API AREA
	// -----------------------------------------

	public function api_get_language() {
		$this->Api->init_result();

		if ($this->request->is('post')) {
            $this->disableCache();
            $status = 999;
            $message = "";
            $params = (object)array();
			$data = $this->request->data;
			
			if (isset($data['language']) && !empty($data['language'])) {
				$this->Api->set_language($data['language']);
            }
			
			if (!isset($data['device_token']) || empty($data['device_token'])) {
				$message = __('missing_parameter') .  'device_token';
				
			} else {
    
                $params = $this->Language->get_languages();
				$message = __('retrieve_data_successfully');
				$status = 200;
			}

			load_data_api:
            $this->Api->set_result($status, $message, $params);	// param = token when login
        }
        
		$this->Api->output();
	}

}
