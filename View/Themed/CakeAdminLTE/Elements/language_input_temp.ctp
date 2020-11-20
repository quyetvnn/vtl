    <?php 
        // Cat added by Tony
        $arr_title = array(
			'school_title' 	=> __d('contact', 'school_title'),
			'name' 			=> '<font color="red">*</font>' . __('name'),

			'zho_name' 			=> '<font color="red">*</font>' . __('zho_language_name'),
			'eng_name' 			=> '<font color="red">*</font>' . __('eng_language_name'),
			'chi_name' 			=> '<font color="red">*</font>' . __('chi_language_name'),

			'zho_about_us' 			=> '<font color="red">*</font>' . __('zho_language_about_us'),
			'eng_about_us' 			=> '<font color="red">*</font>' . __('eng_language_about_us'),
			'chi_about_us' 			=> '<font color="red">*</font>' . __('chi_language_about_us'),

			'zho_first_name' 			=> __('zho_first_name'),
			'eng_first_name' 			=> __('eng_first_name'),
			'chi_first_name' 			=> __('chi_first_name'),

			'zho_last_name' 			=> __('zho_last_name'),
			'eng_last_name' 			=> __('eng_last_name'),
			'chi_last_name' 			=> __('chi_last_name'),

			'description' 	=> __('description'),
			'about_us' 		=> __d('school', 'about_us'),	

			'first_name' 	=> __d('member', 'first_name'),
			'last_name' 	=> __d('member', 'last_name'),
		
			'content' 		=> __('content'),
            'terms' => __('terms'),
            'privacy' => __('privacy'),
            'address' => __('address'),
            'opening' => __('opening'),
			'remarks' => __('remark'),

			'phone' 					=> __d('member', 'phone'),	// add new by vilh
			'course_title' 				=> '<font color="red"> * </font>' . __d('course', 'course_title'),	
			'course_description' 		=> __d('course', 'course_description'),	
			'course_remark' 			=> __d('course', 'course_remark'),	
			'course_certification'		=> __d('course', 'course_certification'),	
			'course_term_and_condition'	=> __d('course', 'course_term_and_condition'),	

			'title' 					=> '<font color="red"> * </font>' . __d('push', 'title'),	
			'short_description' 		=> '<font color="red"> * </font>' . __d('push', 'short_description'),
			'long_description' 			=> '<font color="red"> * </font>' . __d('push', 'long_description'),
	
		);
		
    ?>

	<?php  if ( (isset($languages_list) && !empty($languages_list)) ): ?>

	<?php 	
		if ($languages_edit_data) {
			$languages_edit_data = Hash::combine($languages_edit_data,'{n}.alias','{n}');
		}	
 	?>
		<div class="form-group">
		
			<div>

				<?php 
					$attr = array();

					foreach ($languages_list as $key => $language) {

						foreach ($language_input_fields as $field)  	{
							$attr = array(
								'class' => 'form-control',
								'style' => 'margin-bottom:15px',
								'div' => 'col-xs-12',
								'value' => isset($languages_edit_data[ $language['alias'] ][ $field ]) ? $languages_edit_data[ $language['alias'] ][ $field ] : NULL,
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
								( strpos($field, 'privacy') !== false  ) || 
								( strpos($field, 'course_description') !== false  ) ||
								( strpos($field, 'course_remark') !== false  ) || 
								( strpos($field, 'course_certification') !== false ) ||
								( strpos($field, 'course_term_and_condition') !== false  ) ) 	{
								$attr['class'] = 'form-control ckeditor';
								$attr['type'] = 'textarea';
							}

							if (isset($arr_title[$field])) {
								if ($field == "name" || $field == "content" ||
									$field == "title" || $field == "short_description" ||  $field == "long_description" ) {
									$attr['required'] = 'true';
								}

								$n = $language['alias'] . "_" . $field;
								$attr['label'] = $arr_title[$n];
							}

							echo '<div class="row">' . $this->Form->input($languages_model . '.' . $key . '.' . $field, $attr) . '</div>';
								
						}
					}	
				?>
			</div> 
		</div>
	<?php endif; ?>

	<style type="text/css">
		label.error{
			color: red;
		}
	</style>
