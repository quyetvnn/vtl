
<div class="row">
    <div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('member', 'create_member'); ?></h3>
				<div class="pull-right"> <h5 class="box-title red"><?php echo __('required'); ?></h5></div>
			</div>

			<div class="box-body table-responsive">
			
			<?php echo $this->Form->create('Member', array('role' => 'form', 'type' => 'file')); ?>
				<fieldset>
					<div class="form-group">
						<?php echo $this->Form->input('username', array(
							'required' => 'required',
							'label' => '<font class="red"> * </font>' . __d('member', 'username'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<div class="form-group">
						<?php echo $this->Form->input('password', array(
							'required' => 'required',
							'autocomplete' => 'new-password',
							'label' => '<font class="red"> * </font>' . __d('administration', 'password'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<div class="form-group">
						<?php echo $this->Form->input('email', array(
							'required' => 'required',
							'label' => '<font class="red"> * </font>' . __d('member', 'email'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<div class="form-group">
						<?php echo $this->Form->input('phone_number', array(
							'required' => 'required',
							'label' => '<font class="red"> * </font>' . __d('member', 'phone_number'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<div class="form-group">
						<?php echo $this->Form->input('role_id', array(
							'required' => 'required',
							'empty' => __('please_select'),
							'label' => '<font class="red"> * </font>' . __d('administration', 'role'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<div class="form-group">
						<?php echo $this->Form->input('school_id', array(
							'required' => 'required',
							'label' => '<font class="red"> * </font>' . __d('school', 'school'),
							'empty' => __('please_select'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<?php echo $this->element('language_input_temp', array(
							'languages_model' => $languages_model,
							'languages_list' => $languages_list,
							'language_input_fields' => $language_input_fields,
							'languages_edit_data' => isset($this->request->data[$languages_model]) ? $this->request->data[$languages_model] : false,
						)); 
					?>

					<?php 
						echo $this->element('images_upload_with_type',array(
							'add_new_images_url' => $add_new_images_url,
							'images_model' => $images_model,
							'base_model' => $model,
						));
					?>


					<?php echo $this->Form->submit(__('submit'), array('class' => 'btn btn-large btn-primary')); ?>

				</fieldset>

			<?php echo $this->Form->end(); ?>

		</div><!-- /.form -->
			
	</div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->