
<div class="row">
    <div class="col-xs-12 col-md-6 col-xs-offset-3">
		<div class="box box-primary">
			<div class="box-header">
			<h3 class="box-title"><?php echo __d('school', 'edit_school_subject'); ?></h3>
			</div>
			<div class="box-body table-responsive">
		
			<?php echo $this->Form->create('SchoolSubject', array('role' => 'form')); ?>

				<fieldset>

					<div class="form-group">
						<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php 
						
						if ($school_id) {
							echo $this->Form->input('school_id', array(
								'disabled' => 'disabled',
								'class' => 'form-control',
								'required' => 'required',
								'value' => $school_id,
								'label' => "<font class='red'> * </font>" . __d('school', 'school'),
							)); 

						} else {
							echo $this->Form->input('school_id', array(
								'class' => 'form-control',
								'label' => "<font class='red'> * </font>" . __d('school', 'school'),
								'required' => 'required',
							)); 
						}
						
						?>
					</div><!-- .form-group -->
				
					<div class="form-group">
						<?php echo $this->Form->input('enabled', array(
							'label' => __('enabled'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->
					
					<?php echo $this->element('language_input_temp', array(
						'languages_model' => $languages_model,
						'languages_list' => $languages_list,
						'language_input_fields' => $language_input_fields,
						'languages_edit_data' => isset($this->request->data[$languages_model]) ? $this->request->data[$languages_model] : false,
					)); ?>
					

					<?php echo $this->Form->submit(__('submit'), array('class' => 'btn btn-large btn-primary')); ?>


				</fieldset>

			

			<?php echo $this->Form->end(); ?>

		</div><!-- /.form -->
			
	</div><!-- /#page-content .col-sm-9 -->
		</div><!-- /#page-content .col-sm-9 -->
</div><!-- /#page-container .row-fluid -->