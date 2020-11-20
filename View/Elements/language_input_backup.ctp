<?php 
// languages_model
// languages_list
// language_input_fields
// languages_edit_data
	
	//Cat added by Tony
	$arr_title = array(
		'name' => '<font color="red">*</font>名稱',
		'description' => '短描述',
		'content' => '內容',
		'terms' => '條款及細則',
		'privacy' => '私隱政策',
		'address' => '地址',
		'opening' => '營業時間',
		'remarks' => '備註'
	);
	//Cat added by Tony

	if ( (isset($languages_list) && !empty($languages_list)) ):

	
	if ($languages_edit_data) {
		$languages_edit_data = Hash::combine($languages_edit_data,'{n}.alias','{n}');
		
	}	
 ?>


<!-- language_input_field=  array(
				'id',
				'vocabulary_id',
				'alias',
				'name',
				'description',
				'zip_code',)
-->

<?php foreach ($languages_list as $key => $language): ?>
	<hr>
	<div class="form-group ">
		<!-- <div class="well well-sm"> -->
			<div class="row ">
				<div class="col-xs-12">
					<h4><?php
						switch ($language['alias']) {
							case 'zho':
								echo '中文(繁)';
								break;
							case 'chi':
								echo '中文(簡)';
								break;
							case 'eng':
								echo '英文';
								break;
							default:
								break;
						}
					?></h4>
				</div>
				<?php 




					if (isset($languages_edit_data[$language['alias']])) {

						foreach ($language_input_fields as $field) {
							$attr = array(
								'class' => 'form-control',
								'style' => 'margin-bottom:15px',
								'div' => 'col-xs-12',
								'value' => $languages_edit_data[ $language['alias'] ][ $field ],
							);

							if ( strpos($field, 'id') !== false ) {
								$attr['type'] = 'hidden';

							}

							if ( strpos($field, 'alias') !== false ) {
								$attr['type'] = 'hidden';
							}

							if ( 
								( strpos($field, 'about') !== false  ) ||
								( strpos($field, 'terms') !== false  ) ||
								( strpos($field, 'content') !== false  ) ||
								( strpos($field, 'privacy') !== false  )
								) {
								$attr['class'] = 'form-control ckeditor';
								$attr['type'] = 'textarea';
							}

							if (isset($arr_title[$field])) {
								$attr['label'] = $arr_title[$field];
							}

							echo $this->Form->input($languages_model . '.' . $key . '.' . $field, $attr);
						}
						
					}else{

						foreach ($language_input_fields as $field) {
							$attr = array(
								'class' => 'form-control',
								'style' => 'margin-bottom:15px',
								'div' => 'col-xs-12',
							);

							if ( strpos($field, 'id') !== false ) {
								$attr['type'] = 'hidden';
							}

							if ( strpos($field, 'alias') !== false ) {
								$attr['type'] = 'hidden';
								$attr['value'] = $language['alias'];
							}

							if ( 
								( strpos($field, 'about') !== false  ) ||
								( strpos($field, 'terms') !== false  ) ||
								( strpos($field, 'content') !== false  ) ||
								( strpos($field, 'privacy') !== false  )
								) {
								$attr['class'] = 'form-control ckeditor';
								$attr['type'] = 'textarea';
							}

							if (isset($arr_title[$field])) {
								$attr['label'] = $arr_title[$field];
							}

							echo $this->Form->input($languages_model . '.' . $key . '.' . $field, $attr);
						}
						
					}
				
					
					

				?>
			</div>
		<!-- </div> -->
	</div><!-- .form-group -->	
<?php endforeach ?>


<?php endif; ?>


