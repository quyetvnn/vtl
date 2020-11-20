<?php

App::uses('AppController', 'Controller');

class CompanyAppController extends AppController {

	public function   beforeFilter() {
        parent::beforeFilter();
        $this->theme = "CakeAdminLTE";
        $this->layout = "default";
    }

	public function admin_add_new_image(){

		$data = $this->request->data;

		if ($data) {

			$images_model = $data['images_model'];

			// $imageTypes = $this->ImageType->find('list', array(
			// 	'fields' => array( 'ImageType.id','ImageType.slug'),
			// 	'conditions' => array(
			// 		'OR' => array(
			// 			array('ImageType.slug like' => '%'.strtolower('brand').'%'),
			// 			array('ImageType.slug like' => '%'.strtolower('shop').'%')
			// 		)
			// 	),
			// ));
			$imageTypes = $this->ImageType->find_list(array(
				'OR' => array(
					array('ImageType.slug like' => '%'.strtolower('brand').'%'),
					array('ImageType.slug like' => '%'.strtolower('shop').'%')
				)
			));

			$this->set(compact('imageTypes','images_model'));

			$this->render('Pages/add_new_image');

		}else{
			return 'NULL';
		}
		
	}

	// get images by xxx_id
	protected function get_images($ids, $obj = array()){

		if (empty($obj)) {
			return array();
		}else{
			$plugin = $obj['plugin'];
			$model = $obj['model'];
			$relate_id = $obj['relate_id'];
		}

		$data = array();

		$this->Image = ClassRegistry::init("$plugin.$model");

		$imageTypes = $this->ImageType->find('list', array(
			'fields' => array( 'ImageType.id','ImageType.slug'),
		));

		$data = $this->Image->find('all', array(
			'fields' => array(
				'image_type_id',
				'path',
				'width',
				'height',
				'size',
			),
			'conditions' => array(
				$relate_id => $ids
			),
			'recursive' => -1,
		));

		$data = Hash::extract($data, "{n}.$model");

		foreach ($data as  &$img) {
			$img['type'] = $imageTypes[$img['image_type_id']];
		}

		return $data;
	}

}
