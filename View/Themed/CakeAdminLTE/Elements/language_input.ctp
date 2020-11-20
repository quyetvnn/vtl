    <?php 
        // Cat added by Tony
        $arr_title = array(
			'school_title' 	=> __d('contact', 'school_title'),
            'name' 			=> '<font color="red">*</font>' . __('name'),
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

			'first_text' 				=> '<font color="red"> * </font>' . __d('introduce', 'first_text'),	
			'second_text'				=> '<font color="red"> * </font>' . __d('introduce', 'second_text'),
			'third_text'				=> '<font color="red"> * </font>' . __d('introduce', 'third_text'),
			'fourth_text'				=> '<font color="red"> * </font>' . __d('introduce', 'fourth_text'),	
		);
		
		$arr_language_tabs = array();
		foreach($available_language as $lang) {
			$arr_language_tabs[$lang] = __($lang.'_language');
		}
    ?>

	<?php  if ( (isset($languages_list) && !empty($languages_list)) ): ?>

	<?php 	
		if ($languages_edit_data) {
			$languages_edit_data = Hash::combine($languages_edit_data,'{n}.alias','{n}');
		}	
 	?>
		<div class="form-group">
			<div role="tabpanel">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" id="tabs" role="tablist">
					<?php $flag = 1;
					foreach ($languages_list as $key => $language): ?>
						<li role="presentation"  class="<?php if ($flag == 1){ echo ('active'); } ?> ">

							<?php $flag = 0    ?>
						
							<a href="#<?php echo($language['alias']); ?>" aria-controls="tab" role="tab" data-toggle="tab">
								<?= isset($arr_language_tabs[$language['alias']]) ? $arr_language_tabs[$language['alias']] : '' ?>
							</a>
						</li>
					<?php endforeach ?>
				</ul>
			</div>
			<div class="tab-content">
				<?php $flag = true;
					
				foreach ($languages_list as $key => $language): ?>
					<div role="tabpanel" class="tab-pane <?php if ($flag == true) echo ('active'); ?>" id="<?php echo($language['alias']); ?>">

						<?php 
							$flag = false;
						if (isset($languages_edit_data[$language['alias']]))
						{
							foreach ($language_input_fields as $field) 
							{
								$attr = array(
									'class' => 'form-control',
									'style' => 'margin-bottom:15px',
									'div' => 'col-xs-12',
									// 'value' => $languages_edit_data[ $language['alias'] ][ $field ],
									'value' => isset($languages_edit_data[ $language['alias'] ][ $field ]) ? $languages_edit_data[ $language['alias'] ][ $field ] : NULL,
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
									( strpos($field, 'privacy') !== false  ) || 
									( strpos($field, 'course_description') !== false  ) ||
									( strpos($field, 'course_remark') !== false  ) || 
									( strpos($field, 'course_certification') !== false ) ||
									( strpos($field, 'course_term_and_condition') !== false  ) ) 	{
									$attr['class'] = 'form-control ckeditor';
									$attr['type'] = 'textarea';
								}

								if (isset($arr_title[$field])) {
									if ($field == "name" || $field == "content" || $field == "course_title" || 
										$field == "title" || $field == "short_description" ||  $field == "long_description" || // push
										$field == "first_text" ||  $field == "second_text" ||
										$field == "third_text" ||  $field == "fourth_text")
									{
										$attr['required'] = 'true';
									}

									$attr['label'] = $arr_title[$field];
								}
								echo '<div class="row">' . $this->Form->input($languages_model . '.' . $key . '.' . $field, $attr) . '</div>';
							}
							
						}
						else
						{
							foreach ($language_input_fields as $field) 
							{
								$attr = array(
									'class' => 'form-control',
									'style' => 'margin-bottom:20px',
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
									( strpos($field, 'privacy') !== false  ) || 
									( strpos($field, 'course_description') !== false  ) ||
									( strpos($field, 'course_remark') !== false ) || 
									( strpos($field, 'course_certification') !== false ) ||
									( strpos($field, 'course_term_and_condition') !== false ))	{
									$attr['class'] = 'form-control ckeditor';
									$attr['type'] = 'textarea';
								}

								if (isset($arr_title[$field])) {
									if ($field == "name" || $field == "course_title" || 
										$field == "title" || $field == "short_description" ||  $field == "long_description" || // push
										$field == "first_text" ||  $field == "second_text" || 
										$field == "third_text" ||  $field == "fourth_text") {
										$attr['required'] = 'true';
									}

									$attr['label'] = $arr_title[$field];
								}

								echo '<div class="row">' . $this->Form->input($languages_model . '.' . $key . '.' . $field, $attr) . '</div>';
							}
						}
						?>
					</div> <!-- close tabpanel -->
				<?php endforeach ?>
			</div> <!-- close tab-content -->
		</div>
	<?php endif; ?>

	<style type="text/css">
		label.error{
			color: red;
		}
	</style>

	<script type="text/javascript">

		// query.validate.min: fix display hidden required field from language
		$('form').validate(
			{
				ignore:"ui-tabs-hide",
		    	invalidHandler: function(e, validator){
			    if(validator.errorList.length){
			    	bootbox.alert(validator.errorList[0].message);
			    	$(validator.errorList[0].element).focus();
			    	var tab_id = $(validator.errorList[0].element).closest(".tab-pane").attr('id');
			        $('#tabs a[href="#' + tab_id + '"]').tab('show');
			    }
			    }});
	</script>
