<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('dictionary','add_vocabulary'); ?></h3>
			</div>

			<div class="box-body table-responsive">
				<?php echo $this->Form->create('Vocabulary', array('role' => 'form')); ?>
					<fieldset>
						<div class="form-group">
							<?php
								echo $this->Form->input('parent_id', array(
                                    'class' => 'form-control',
                                    'label' => __d('dictionary', 'parent_id'),
									'empty' => __("please_select"),
									'options' => $parentVocabularies,
								));
							?>
						</div>
								
						<div class="form-group">
							<?php
								echo $this->Form->input('prefix', array(
									'class' => 'form-control member-autocomplete',
                                    'label' => __('prefix'),
									'id' => 'ddl_prefix'
								));
							?>
						</div>

						<div class="form-group dv-slug-content">
							<?php echo $this->Form->input('content', array(
								'id' => 'txt_content',
                                'class' => 'form-control',
                                'label'=> __('content'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('slug', array(
								'id' => 'txt_slug',
								'readonly' => true,
                                'class' => 'form-control',
                                'label'=> __d('dictionary','slug') )); ?>
						</div>
						
						<!-- <div class="form-group">
							<input  id="txtSlug" disabled class="form-control" /> 
						</div> -->
						
						<div class="form-group">
							<?php echo $this->Form->input('enabled', array('class' => 'form-control','label'=>__('enabled'))); ?>
						</div>

						<?php echo $this->element('language_input', array(
								'languages_model' => $languages_model,
								'languages_list' => $languages_list,
								'language_input_fields' => $language_input_fields,
								'languages_edit_data' => isset($this->request->data[$languages_model]) ? $this->request->data[$languages_model] : false,
						)); ?>

						<div class="pull-right" >
							<?php echo $this->Form->submit(__('submit'), array(
                                'class' => 'btn btn-large btn-primary',
                                'id' => 'btn-submit-data'
							)); ?>
						</div>
						
					</fieldset>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>

<script>
    $(document).ready(function(){
        COMMON.init_validate_form_tabs($("#btn-submit-data"));
		
		var prefix = <?= $prefix ?>;
	
		$('.member-autocomplete').autocomplete({
            delay: 500,
            source: function(request, response) {
				var starting_key = $('#ddl_prefix').val();
				response($.map(prefix, function(item, key) {
					if (item.indexOf(starting_key) == 0) {
						return {
							label: item,
							value: item
						}
					}
                }));				
			}
        });


        check_ddl_prefix();

        $('#ddl_prefix').on('change', function(){
            check_ddl_prefix();
        })

        $('#txt_content').on('keyup', function(){
            generate_slug();
        });
    });
    function check_ddl_prefix(){
        if($('#ddl_prefix').val() == ''){
            $('.dv-slug-content').hide();
            $('#txt_content').val('');
            $('#txt_slug').val('').removeAttr('readonly');
        }else{
            $('.dv-slug-content').show();
            $('#txt_content').val('');
            $('#txt_slug').val('').attr('readonly', 'readonly');
            generate_slug();
        }
    }
	// auto gen text on content
	function generate_slug(){
        var prefix_val = $("#ddl_prefix").val();
   	    var selectText = $("#ddl_prefix").find('option[value="' + prefix_val + '"]').text();

		$("#txt_slug").val(prefix_val + $("#txt_content").val()) ;
	}

</script>