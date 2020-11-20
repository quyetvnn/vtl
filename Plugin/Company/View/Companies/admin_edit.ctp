<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('company','edit_company'); ?></h3>
			</div>

			<div class="box-body table-responsive">
				<?php echo $this->Form->create('Company', array('role' => 'form')); ?>
					<fieldset>

						<?php echo $this->element('language_input', array(
								'languages_model' => $languages_model,
								'languages_list' => $languages_list,
								'language_input_fields' => $language_input_fields,
								'languages_edit_data' => isset($this->request->data[$languages_model]) ? $this->request->data[$languages_model] : false,
						)); ?>
						
						<div class="form-group">
							<?php echo $this->Form->input('id', array('class' => 'form-control','label'=>__('id'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('email', array('class' => 'form-control','label'=>__('email'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('facebook', array('class' => 'form-control','label'=>__d('company','facebook'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('instagram', array('class' => 'form-control','label'=>__d('company','instagram'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('twitter', array('class' => 'form-control','label'=>__d('company','twitter'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('website', array('class' => 'form-control','label'=>__d('company','website'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('wechat', array('class' => 'form-control','label'=>__d('company','wechat'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('weibo', array('class' => 'form-control','label'=>__d('company','weibo'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('whatsapp', array('class' => 'form-control','label'=>__d('company','whatsapp'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('youtube', array('class' => 'form-control','label'=>__d('company','youtube'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('remark', array('class' => 'form-control ckeditor','label'=>__d('company','remark'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('contact_person', array('class' => 'form-control','label'=>__d('company','contact_person'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('contact_email', array('class' => 'form-control','label'=>__d('company','contact_email'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('contact_phone', array('class' => 'form-control','label'=>__d('company','contact_phone'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('contact_job_title', array('class' => 'form-control','label'=>__d('company','contact_job_title'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('enabled', array('class' => 'form-control','label'=>__('enabled'))); ?>
						</div>

						<div class="pull-right">
							<?php echo $this->Form->submit(__('submit'), array('class' => 'btn btn-large btn-primary')); ?>
						</div>
					</fieldset>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>