
<div class="row">
    <div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('school', 'add_school'); ?></h3>
			</div>
		
			<div class="box-body table-responsive">
		
			<?php echo $this->Form->create('School', array('role' => 'form', 'type' => 'file')); ?>

				<fieldset>
					<div class="form-group">
						<?php echo $this->Form->input('school_code', array(
							'label' => '<font class="red"> * </font>' . __d('school', 'school_code'),
							'required' => 'required',
							'class' => 'form-control')); 
						?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('email', array(
							'label' => '<font class="red"> * </font>' . __d('member', 'email'),
							'required' => 'required',
							'class' => 'form-control')); 
						?>
					</div><!-- .form-group -->

					<div class="form-group">
						<?php echo $this->Form->input('credit_charge', array(
							'label' => '<font class="red"> * </font>' . __d('school', 'credit_charge'),
							'required' => 'required',
							'value' => 0,
							'class' => 'form-control')); 
						?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('credit', array(
							'label' => '<font class="red"> * </font>'.  __d('school', 'credit'),
							'required' => 'required',
							'class' => 'form-control')); 
						?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('phone_number', array(
							'label' => '<font class="red"> * </font>'.  __d('member', 'phone_number'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('address', array(
							'label' => '<font class="red"> * </font>' . __d('school', 'address'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->




					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
						
								<?php 	
									echo $this->Form->input('status_id', 
										array('class' 	=> 'form-control', 
										'required' 		=> 'required',
										'id'			=> 'status_id',
										'selected' 		=> isset($this->request->data['School']['status']) ? $this->request->data['School']['status'] : '',
										'label' 		=> "<font class='text-red'> * </font>" . __('status')));
									
								?>
							</div><!-- .form-group -->
						</div><!-- .col -->

						<div class="col-md-6">
							<div class="form-group">
								<ul>
									<br/>
									<li> <label class="label label-warning"> Submit </label> &nbsp; <?= __('submit'); ?> </li>
									<li> <label class="label label-success"> Approved </label> &nbsp; <?= __('approved'); ?> </li>
									<li> <label class="label label-danger"> Rejected </label> &nbsp; <?= __('rejected'); ?> </li>
								</ul>
							</div><!-- .form-group -->
						</div><!-- .col -->
					</div><!-- .row -->


					<?php echo $this->element('language_input', array(
						'languages_model' => $languages_model,
						'languages_list' => $languages_list,
						'language_input_fields' => $language_input_fields,
						'languages_edit_data' => isset($this->request->data[$languages_model]) ? $this->request->data[$languages_model] : false,
					)); ?>


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