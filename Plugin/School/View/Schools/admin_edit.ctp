
<div class="row">
    <div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('school', 'edit_school'); ?></h3>
			</div>

			<div class="box-body table-responsive">
		
			<?php echo $this->Form->create('School', array('role' => 'form', 'type' => 'file')); ?>

				<fieldset>
				<div class="form-group">
						<?php 
						if ($school_id) {
							echo $this->Form->input('school_code', array(
								'label' =>  '<font class="red"> * </font>' . __d('school', 'school_code'),
								'required' 		=> 'required',
								'readonly' 		=> 'readonly',
								'class' => 'form-control')); 

						} else {
							echo $this->Form->input('school_code', array(
								'label' =>  '<font class="red"> * </font>' . __d('school', 'school_code'),
								'required' 		=> 'required',
								'class' => 'form-control')); 
							
						}
						
						?>
						
					</div><!-- .form-group -->

					<?php 	if (!$school_id) { ?>

						<div class="form-group">
							<?php 	

						
								echo $this->Form->input('member_id', 
									array('class' 	=> 'form-control', 
									'disabled' 		=> 'disabled',
									'id'			=> 'member_id',
									'empty'			=> __('please_select'),
									'value' 		=> isset($this->request->data['School']['member_id']) ? $this->request->data['School']['member_id'] : array(),
									'label' 		=> __d('member', 'member')
									)
								);
							?>

							<div class="form-group">
								<?php

									echo $this->Form->input('credit_charge', array(
										'label' => '<font class="red"> * </font>' . __d('school', 'credit_charge'),
										'required' => 'required',
										'class' => 'form-control')); 
								?>
							</div><!-- .form-group -->
							<div class="form-group">
								<?php 
								
									echo $this->Form->input('credit', array(
										'label' =>  __d('school', 'credit'),
										'readonly' => 'readonly',
										'class' => 'form-control')); 

								?>
							</div><!-- .form-group -->
						</div><!-- .form-group -->

					<?php } ?>

				

					
					<div class="form-group">
						<?php echo $this->Form->input('email', array(
							'label' => '<font class="red"> * </font>' . __d('member', 'email'),
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

					<!-- download file here --> 
					
					<?php if (count($schoolBusinessRegistrations) > 0) {
					
						echo __d('school', 'school_business_registration') ?>
						<div class="panel panel-success">
							<div class="panel-body">
								<?php
									foreach ($schoolBusinessRegistrations as $v) { ?>
										<a href="<?= Router::url('/', true) . $v['SchoolBusinessRegistration']['path']; ?>" 
											download="<?= $v['SchoolBusinessRegistration']['name']; ?>"
											target="_blank">
											<i class="fa fa-download"></i>
											<?= $v['SchoolBusinessRegistration']['name'] ?>
										</a>
										<br/>
								<?php } ?>
							</div>
						</div>
					<?php } ?>

					<?php echo $this->element('language_input_temp', array(
						'languages_model' => $languages_model,
						'languages_list' => $languages_list,
						'language_input_fields' => $language_input_fields,
						'languages_edit_data' => isset($this->request->data[$languages_model]) ? $this->request->data[$languages_model] : false,
					)); ?>

					<h4 class='red'> <?= __d('school', 'duplicate_logo_banner'); ?>  </h4>
					<?php 
						echo $this->element('images_upload_with_type',array(
							'add_new_images_url' => $add_new_images_url,
							'images_model' => $images_model,
							'base_model' => $model,
							'imageTypes' => $imageTypes,
							'limit'		=> 2,
						));
					?>




					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
						
								<?php 	

										// echo $this->Form->input('status_id', 
										// 	array('class' 	=> 'form-control', 
										// 	'required' 		=> 'required',
										// 	'id'			=> 'status_id',
										// 	'disabled'		=> 'disabled',
										// 	'selected' 		=> isset($this->request->data['School']['status']) ? $this->request->data['School']['status'] : '',
										// 	'label' 		=> "<font class='text-red'> * </font>" . __('status')));
									?>
								

										<div><label><?php echo __('status'); ?></label></div>
										<div class="btn-group btn-group-sm" data-toggle="buttons" >
											
											<label class="btn btn-default">
												<input type="radio" name="status_id" value="2" autocomplete="off" 
													<?php echo isset($this->request->data['School']['status']) && $this->request->data['School']['status']  === "2" ? 'checked="checked"' : '';?> >
													<?php echo __d('school', 'closed'); ?>
											</label>
											<label class="btn btn-default">
												<input type="radio" name="status_id" value="1" autocomplete="off" 
													<?php echo isset($this->request->data['School']['status']) && $this->request->data['School']['status']  === "1" ? 'checked="checked"' : '';?> >
													<?php echo __d('school', 'normal'); ?>
											</label>
											<label class="btn btn-default">
												<input type="radio" name="status_id" value="0" autocomplete="off" 
													<?php echo isset($this->request->data['School']['status']) && $this->request->data['School']['status'] === "0" ? 'checked="checked"' : ''; ?> >
													<?php echo __d('school', 'blocked'); ?>
											</label>
										</div>
											<!-- 
										echo $this->Form->input('status_id', 
											array('class' 	=> 'form-control', 
											'required' 		=> 'required',
											'id'			=> 'status_id',
											'selected' 		=> isset($this->request->data['School']['status']) ? $this->request->data['School']['status'] : '',
											'label' 		=> "<font class='text-red'> * </font>" . __('status'))); -->
									
									
									
							</div><!-- .form-group -->
						</div><!-- .col -->
						
					</div><!-- .row -->

					<?php 
						echo $this->Form->submit(__('submit'), array('class' => 'btn btn-large btn-primary')); 
					?>

				</fieldset>

			<?php echo $this->Form->end(); ?>

		</div><!-- /.form -->
			
	</div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->