<?php
	App::uses('Component', 'Controller');
	App::uses('Folder', 'Utility');
	App::uses('File', 'Utility');

	class CommonComponent extends Component {
		
		/**
		 * Components
		 *
		 * @var array
		 */
		public $components = array(
			// Enable ExcelReader in PhpExcel plugin
			'PhpExcel.ExcelReader',

			// Enable PhpExcel in PhpExcel plugin
			'PhpExcel.PhpExcel',
		);


		public function initialize(Controller $controller) {
			parent::initialize($controller);

	        if (!class_exists('PHPExcel')){
	            // load vendor classes if does not load before
	            App::import('Vendor', 'PhpExcel.PHPExcel');
			}
		}

		public function get_minimal_name($name=''){
	        if(!isset($name) || empty($name)) return '';
	        $minimal_name = '';
	        $words = preg_split("/[\s,_-]+/", $name);
	        foreach ($words as $w) {
	        	$matches = preg_split('//u', $w, -1, PREG_SPLIT_NO_EMPTY);
	        	if(isset($matches[0]) && !empty($matches[0])){
	        		$minimal_name .= $matches[0];
	        	}
	        }

	        if (strlen($minimal_name) > 3) {
	            $minimal_name = substr($minimal_name, 0, 3);
	        }
	        
	        return $minimal_name;
	    }

		public function curl_get($url, $body){
			$ch = curl_init();
			$body_string = http_build_query($body);
			if(substr( $url, 0, 4 ) != "http"){
				$url = Router::url('/', true).$url."?".$body_string;
			}else{
				$url = $url."?".$body_string;
			}
			
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_TIMEOUT, 80);
			 
			$resp = curl_exec($ch);
			 
			// if(curl_error($ch)){
			// 	echo 'Request Error:' . curl_error($ch);
			// }
			// else
			// {
			// 	echo $response;
			// }
			 
			curl_close($ch);
			return $resp;
		}

		public function curl_post($url, $body){
			$curl = curl_init();
			$base_api_url = Router::url('/', true);
			$base_url = Router::url('/', true);
			curl_setopt_array($curl, array(
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_URL => $base_api_url.$url,
			    CURLOPT_POST => 1,
			    CURLOPT_SSL_VERIFYPEER => false, //Bỏ kiểm SSL
			    CURLOPT_POSTFIELDS => $body
			));
			$resp = curl_exec($curl);
			if($resp!=false){
				$check_token = json_decode($resp, true);
				if (isset($check_token['status']) &&$check_token['status'] == 600) {
					setcookie("currentuser", "", 1, '/');
					echo "<script>window.location='".$base_url."'</script>";
				}
			}

			curl_close($curl);
			return $resp;
		}



		/**
		 * Check whether the file is able to be uploaded
		 * 
		 * @return 		TRUE or FALSE
		 */
		public function isUploadedFile( $params ) {
			$val = array_shift( $params );

			if ((isset($val['error']) && $val['error'] == 0) || (!empty( $val['tmp_name']) && $val['tmp_name'] != 'none')) {
				return is_uploaded_file($val['tmp_name']);
			}

			return false;
		}

		/**
		 * General function for single table/model excel import
		 * e.g. Category, Unit, Supplier
		 * 
		 */
		public function import_excel( $Model, $data, $upload_folder ){
			$import = array(
				'status' => false, 'message' => '', 'params' => array()
			);

			if( empty($Model) ){
				$import = array(
					'status' => false, 
					'message' => 'Please provide a model for import',
					'params' => array()
				);
			} else if( empty($data) ){
				$import = array(
					'status' => false, 
					'message' => 'No data can be imported',
					'params' => array()
				);
			} else {
				if( !isset($upload_folder) || empty($upload_folder) ){
					$upload_folder = WWW_ROOT . 'uploads' . DS . 'import';
				}

				$folder = new Folder($upload_folder, true, 0777);

				if( $folder ){
					$file = new File( $data['file']['name'] );

					// rename the uploaded file
					$renamed_file = date('Ymd-Hi') . '.' . $file->ext();

					// set the full path of uploaded file name
					$renamed_file_full_path = $upload_folder . DS . $renamed_file;

					if( move_uploaded_file($data['file']['tmp_name'], $renamed_file_full_path) ){
						try {
							// read the uploaded file through ExcelReader Component
							$this->ExcelReader->loadExcelFile( $renamed_file_full_path );
						} catch (Exception $e) {
							$import = array(
								'status' => false, 
								'message' => 'Fail to read the uploaded file. Please check and try again.',
								'params' => array(
									'File name' => $data['file']['name'],
								)
							);

							return $import;
						}

						// if read successfully, get the result array
						$rows_data = $this->ExcelReader->dataArray;

						$rows = array();

						/**
						 * get the db header
						 * 
						 * row 0 - readable text header
						 * row 1 - db field header
						 */
						$header = $rows_data[1];

						foreach ($rows_data as $row => $data) {
							if( $row >= 2 ){ // skip the headers
								$_category = array();
								// re-format the resultant array
								foreach ($data as $d_key => $d_field) {
									$rows[$row][$header[$d_key]] = $d_field;
								}
							}
						}

						if( $Model->saveAll( $rows ) ){
							$number_of_rows = $Model->getSaveMetrics();

							$import = array(
								'status' => true, 
								'message' => 'Import data successfully.',
								'params' => array(
									'Number of affected records' => (int) ($number_of_rows['insert']['count'] + $number_of_rows['update']['count'])
								)
							);
						} else {
							$import = array(
								'status' => false, 
								'message' => 'Fail to import data. Please check and try again.',
								'params' => array(
									'File name' => $data['file']['name'],
								)
							);
						}
					} else {
						$import = array(
							'status' => false, 
							'message' => 'Fail to upload file.',
							'params' => array(
								'File name' => $data['file']['name'],
							)
						);
					}
				} else {
					$import = array(
						'status' => false, 
						'message' => 'Fail to create folder.',
						'params' => array(
							'Folder Path' => $upload_folder,
						)
					);
				}
			}

			return $import;
		}

		/**
		 * General function for single table/model excel export
		 * e.g. Category, Unit, Supplier
		 * 
		 */
		public function export_excel_old( $data, $output_filename, $readable_header, $db_header ){
			$export = array(
				'status' => false, 'message' => '', 'params' => array()
			);
			
			if( empty($data) ){
				$export = array(
					'status' => false, 
					'message' => 'No data can be exported',
					'params' => array()
				);
			} else {
				if( !isset($output_filename) || empty($output_filename) ){
					$output_filename = date('Ymd-Hi') . ".xlsx";
				}

				try{
					// create new empty worksheet and set default font
					$this->PhpExcel->createWorksheet()->setDefaultFont('Arial', 14);

					$readable_field_keys = array_keys( $readable_header );

					$excel_readable_header = $excel_db_header = array();

					foreach ($readable_field_keys as $key => $f_key) {
						$excel_readable_header[ $key ]['label'] = $readable_header[ $f_key ]['label'];

						if( isset($readable_header[ $f_key ]['width']) && !empty($readable_header[ $f_key ]['width']) ){
							$excel_readable_header[ $key ]['width'] = $readable_header[ $f_key ]['width'];
						}

						if( isset($readable_header[ $f_key ]['filter']) && ($readable_header[ $f_key ]['filter'] == true) ){
							$excel_readable_header[ $key ]['filter'] = $readable_header[ $f_key ]['filter'];
						}
					}

					// add readable heading bold text
					$this->PhpExcel->addTableHeader($excel_readable_header, array('bold' => true));

					$db_field_keys = array_keys( $db_header );
					foreach ($db_field_keys as $key => $db_f_key) {
						$excel_db_header[ $key ]['label'] = $db_f_key;
					}

					// add heading for db fields
					$this->PhpExcel->addTableHeader($excel_db_header);

					foreach ($data as $value) {
						$_data = array();

						foreach ($readable_field_keys as $key => $f_key) {
							if( isset($value[$f_key]) ){
								if( $f_key == "status" ){
									$_data[ $key ] = (int) $value[$f_key];
								} else {
									$_data[ $key ] = $value[$f_key];
								}
							}
						}

						$this->PhpExcel->addTableRow( $_data );
					}

					// close table and output
					$this->PhpExcel->addTableFooter()->output( $output_filename );
				} catch ( Exception $e ) {
					$export = array(
						'status' => false, 
						'message' => 'Fail to export the Excel file. Please try again.',
						'params' => array()
					);

					return $export;
				}
			}

			return $export;
		}

		public function export_excel ($data, $output_filename, $readable_header, $file_path = '') {	
			if( empty($data) ){
                return array(
					'status' => false, 
					'message' => 'No data can be exported',
					'params' => array()
				);
            } 
            
            if( !isset($output_filename) || empty($output_filename) ){
                $output_filename = date('Ymd-Hi') . ".xls";
            }
            else
            {
                $output_filename = $output_filename . ".xls"; //".xlsx";	
            }

            try{
                // create new empty worksheet and set default font
                $this->PhpExcel->createWorksheet()->setDefaultFont('Tahoma', 12);

                $readable_field_keys = array_keys( $readable_header );

                $excel_readable_header  = array();

                foreach ($readable_field_keys as $key => $f_key) {
                    $excel_readable_header[ $key ]['label'] = $readable_header[ $f_key ]['label'];

                    if( isset($readable_header[ $f_key ]['width']) && !empty($readable_header[ $f_key ]['width']) ){
                        $excel_readable_header[ $key ]['width'] = $readable_header[ $f_key ]['width'];
                    }

                    if( isset($readable_header[ $f_key ]['filter']) && ($readable_header[ $f_key ]['filter'] == true) ){
                        $excel_readable_header[ $key ]['filter'] = $readable_header[ $f_key ]['filter'];
                    }
                }

                // add readable heading bold text
                //$this->PhpExcel->addTableHeader($excel_readable_header, array('name' => 'Roboto', 'bold' => true));

                $this->PhpExcel->addTableHeader($excel_readable_header, array('name' => 'Tahoma'));

                // $db_field_keys = array_keys( $readable_header );
                // foreach ($readable_header as $key => $db_f_key) {
                // 	$excel_db_header[ $key ]['label'] = $db_f_key['label'];
                // }

                // add heading for db fields
                // $this->PhpExcel->addTableHeader($excel_db_header);

                foreach ($data as $value) {
                    $_data = array();

                    foreach ($readable_field_keys as $key => $f_key) {
                        if( isset($value[$f_key]) ){
                            if( $f_key == "status" ){
                                $_data[$key] = (int) $value[$f_key];
                            } 
                            else  {
                                $_data[$key] = !empty($value[$f_key]) ? $value[$f_key] : ' ';
                            }
                        }
                    }

                    $this->PhpExcel->addTableRow($_data);
                }

                // vilh (2019/04/06) 
                // Format Excel file
                $this->PhpExcel->getDefaultStyle()->getAlignment()->setWrapText(true);
                $sheet = $this->PhpExcel->getActiveSheet();
                
                $fill_style = array(
                                    'fill' => array
                                    (
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'FFCC00')	// yellow	
                                    )
                                );

                $border_style = array(
                                    'borders' => array
                                    (
                                        'allborders' => array
                                        (
                                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                                            'color' => array('rgb' => '000000'),		// BLACK
                                        )
                                    )
                                );

                $column =  $this->getCellID(count($readable_header) - 1);
                $row = count($data) + 1;
                
                // format header
                $sheet->getStyle("A1:" . $column . "1")->applyFromArray($fill_style);
                $sheet->getStyle("A1:" . $column . "1")->getFont()->setBold(false)
                                                    ->setName('Verdana')
                                                    ->setSize(14)
                                                    ->getColor()->setRGB('FF0000');

                // format header + data
                $sheet->getStyle("A1:" . $column . $row)->applyFromArray($border_style);
                $this->PhpExcel->addTableFooter();
                // close table and output
                if($file_path){
                    $this->PhpExcel->save(WWW_ROOT . $file_path);
                    return array( 
                            'status' => true, 
                            'message' => '', 
                            'params' => array() 
                        );
                }else{
                    $this->PhpExcel->output($output_filename);
                    
                    return array( 'status' => true, 'message' => '', 'params' => array() );	
                }
            } catch ( Exception $e ) {
                $export = array(
                    'status' => false, 
                    'message' => 'Fail to export the Excel file. Please try again.',
                    'params' => array()
                );

                return $export;
            }
        }


	


		public function getCellID($num) {
			$arr = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
					'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AK', 'AL', 'AM', 'AN', 'AO'];
			return $arr[$num];
		}
		

		public function force_logout_affected_user($ids) {
            // $myid = $this->Session->id();
			// foreach($ids as $id) {
            //     $objAdministratorsRole = ClassRegistry::init('Administration.AdministratorsRole');
            //     $user_arr = $objAdministratorsRole->get_user_by_role($id);
			// 	foreach($user_arr as $user) {
			// 		$session_cache = $this->Redis->get_cache_global('booster_user'.$user.'_sessionid');
			// 		if(!empty($session_cache)) {						
			// 			session_write_close();

			// 			session_id($session_cache);
			// 			session_start();
			// 			session_destroy();

			// 			session_id($myid);
			// 			session_start();
			// 		}
			// 	}
			// }
		}
		

			/**
		 * public method to upload image(s) in a batch
		 */
		public function upload_images($images, $relative_upload_folder, $image_name_suffix = "") {
			$upload = array(
				'status' => false, 'message' => 'Fail to upload image(s)', 'params' => array()
			);

			if (isset($images) && !empty($images)) {

				$upload_folder = WWW_ROOT;
			
				if( isset($relative_upload_folder) && !empty($relative_upload_folder) ){
					$upload_folder .= $relative_upload_folder;
				} else {
					$upload_folder .= 'uploads' . DS . 'import';
				}

                if(!file_exists($upload_folder)){
                    @mkdir($upload_folder, 0777, true);
                }

				$folder = new Folder($upload_folder, true, 0777);

				if ($folder) {

					$success_images = $fail_images = array();
					foreach ($images as $key => $image) {		// images MUST BE ARRAY here
						$data['file'] = $image;

						if ($temp = $this->isUploadedFile($data)) {

							$_filename = mb_strtolower( $data['file']['name'] );
						
							$file = new File( $_filename );

							list($width, $height, $type, $attr) = getimagesize( $data['file']['tmp_name'] );

							// rename the uploaded file
							$renamed_file = date('Ymd-Hi') . '-' . $image_name_suffix . '-' . uniqid() . '-' . $key . '.' . $file->ext();

							// set the full path of uploaded file name
							$renamed_file_full_path = $upload_folder . DS . $renamed_file;

							$file_type = explode('/', $data['file']['type']);
							

							if( move_uploaded_file($data['file']['tmp_name'], $renamed_file_full_path) ){
								$success_images[] = array(
									'ori_name' => $data['file']['name'],
									're_name' => $renamed_file,
									'path' =>  $relative_upload_folder . DS . $renamed_file,
									'type' => $file_type[0],
									'width' => $width,
									'height' => $height,
									'size' => $data['file']['size']
								);
							} else {
								$fail_images[] = array(
									'ori_name' => $data['file']['name'],
									're_name' => $renamed_file,
									'path' =>  $relative_upload_folder . DS . $renamed_file, 
									'type' => $file_type[0],
									'width' => $width,
									'height' => $height,
									'size' => $data['file']['size']
								);
							}
						}
					}

					$upload = array(
						'status' => true, 
						'message' => 'Upload images successfully. [' . count($success_images) . ' success, ' . count($fail_images) . ' fail]',
						'params' => array(
							'success' => $success_images,
							'fail' => $fail_images,
						)
					);
				} else {
					$upload = array(
						'status' => false, 
						'message' => 'Fail to create folder.',
						'params' => array(
							'Folder Path' => $upload_folder,
						)
					);
				}
			}

			return $upload;
        }
        
		/**
		 * public method to upload file(s) in a batch
		 */
		public function upload_file( $files, $relative_upload_folder, $file_name_suffix = "", $dont_change_file_name = false){
			$upload = array(
				'status' => false, 'message' => 'Fail to upload file(s)', 'params' => array()
			);

			if (isset($files) && !empty($files)) {

				$upload_folder = WWW_ROOT;

				if( isset($relative_upload_folder) && !empty($relative_upload_folder) ){
					$upload_folder .= $relative_upload_folder;
				} else {
					$upload_folder .= 'uploads';
				}

				$folder = new Folder($upload_folder, true, 0777);

				if( $folder ){
					$success_files = $fail_files = array();

					foreach ($files as $key => $image) {
						$data['file'] = $image;

						// $data['file']['name'] = rawurlencode($data['file']['name']);
						// $data['file']['name'] = iconv("UTF-8", "gb2312", $data['file']['name']);

						if( $temp = $this->isUploadedFile( $data ) ){
							$_filename = mb_strtolower( $data['file']['name'] );

							$file = new File( $_filename );
							
							$renamed_file_full_path  = "";
							$renamed_file = "";
							if ($dont_change_file_name == false) {
								// rename the uploaded file
								$renamed_file = date('Ymd') . '-' . $file_name_suffix . '-' . $data['file']['name'] . '-' . time();

								if (count($files) > 1) {
									$renamed_file .= '-' . $key;
								}

								$renamed_file .= '.' . $file->ext();
								$renamed_file_full_path = $upload_folder . DS . $renamed_file;

							} else {
								// no need rename the file
								$renamed_file = $data['file']['name'];
									
							}

							$renamed_file_full_path = $upload_folder . DS . $renamed_file;
						
							$file_type = explode('/', $data['file']['type']);

							if( move_uploaded_file($data['file']['tmp_name'], $renamed_file_full_path) ){
								$success_files[] = array(
									'ext'		=> $file->ext(),
									'ori_name' => $data['file']['name'],
									're_name' => $renamed_file,
									'path' => $relative_upload_folder . DS . $renamed_file,
									'type' => $file_type[0],
									'size' => $data['file']['size']
								);
							} else {
								$fail_files[] = array(
									'ext'		=> $file->ext(),
									'ori_name' => $data['file']['name'],
									're_name' => $renamed_file,
									'path' => $relative_upload_folder . DS . $renamed_file,
									'type' => $file_type[0],
									'size' => $data['file']['size']
								);
							}
						}
					}

					$upload = array(
						'status' => true, 
						'message' => 'Upload files successfully. [' . count($success_files) . ' success, ' . count($fail_files) . ' fail]',
						'params' => array(
							'success' => $success_files,
							'fail' => $fail_files,
						)
					);
				} else {
					$upload = array(
						'status' => false, 
						'message' => 'Fail to create folder.',
						'params' => array(
							'Folder Path' => $upload_folder,
						)
					);
				}
			}

			return $upload;
		}




		public function setup_export_excel($readable_header, $model, $data, $conditions, $limit, $output_filename, $lang){
            $this->PhpExcel->createWorksheet()->setDefaultFont('Tahoma', 12);
            $header = array();
            foreach($readable_header as $item){
                array_push($header, array('label' => $item));
            }

            $this->PhpExcel->addTableHeader($header);

            $objModel = ClassRegistry::init($model);
            $total = $this->set_data_excel($objModel, $data, $conditions, 1, $limit, $lang);

            // Format Excel file
            $this->PhpExcel->getDefaultStyle()->getAlignment()->setWrapText(true);
            $sheet = $this->PhpExcel->getActiveSheet();
            
            $fill_style = array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FFCC00')	// yellow	
                    )
                );

            $border_style = array(
                    'borders' => array (
                        'allborders' => array (
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '000000'), // BLACK
                        )
                    )
                );

            $column = $this->getCellID(count($readable_header) - 1);
            // format header
            $sheet->getStyle("A1:" . $column . "1")->applyFromArray($fill_style);
            $sheet->getStyle("A1:" . $column . "1")->getFont()->setBold(false)
                                                ->setName('Verdana')
                                                ->setSize(14)
                                                ->getColor()->setRGB('FF0000');

            // format header + data
            $sheet->getStyle("A1:" . $column . ($total + 1))->applyFromArray($border_style);
            $this->PhpExcel->addTableFooter();
            // END Format Excel file

            // close table and output
            $type_file = '.xls';
            $this->PhpExcel->output($output_filename . $type_file);

            return $total;
        }

        private function set_data_excel($objModel, $data, $conditions, $page, $limit, $lang){
            $list_item = $objModel->get_data_export($conditions, $page, $limit, $lang);
            foreach ($list_item as $row) {
                $item = $objModel->format_data_export($data, $row);
                
                $this->PhpExcel->addTableRow($item);
            }
            if($limit <= count($list_item)){
                return $this->set_data_excel($objModel, $data, $conditions, ($page+1), $limit, $lang);
            }else{
                return ($limit * ($page - 1)) + count($list_item);
            }
        }



		public function export_excel_v2($readable_header, $data, $output_filename){
            $this->PhpExcel->createWorksheet()->setDefaultFont('Tahoma', 12);
            $header = array();
            foreach($readable_header as $item){
                array_push($header, array('label' => $item));
            }

			$this->PhpExcel->addTableHeader($header);
			
            foreach ($data as $row) {
                $this->PhpExcel->addTableRow($row);
			}
			
            // Format Excel file
            $this->PhpExcel->getDefaultStyle()->getAlignment()->setWrapText(true);
            $sheet = $this->PhpExcel->getActiveSheet();
            
            $fill_style = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFCC00')	// yellow	
				)
			);

            $border_style = array(
				'borders' => array (
					'allborders' => array (
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'), // BLACK
					)
				)
			);

            $column = $this->getCellID(count($readable_header) - 1);
            // format header
            $sheet->getStyle("A1:" . $column . "1")->applyFromArray($fill_style);
            $sheet->getStyle("A1:" . $column . "1")->getFont()->setBold(false)
                                                ->setName('Verdana')
                                                ->setSize(14)
                                                ->getColor()->setRGB('FF0000');

            // format header + data
           	$sheet->getStyle("A1:" . $column . (count($data) + 1))->applyFromArray($border_style);
            $this->PhpExcel->addTableFooter();
            // END Format Excel file

            // close table and output
            $type_file = '.xlsx';
			$this->PhpExcel->output($output_filename . $type_file);
			return true;
        }
		

	}
?>