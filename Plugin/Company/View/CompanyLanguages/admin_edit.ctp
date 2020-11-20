<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('company','edit_company_language'); ?></h3>
			</div>

			<div class="box-body table-responsive">
				<?php echo $this->Form->create('CompanyLanguage', array('role' => 'form')); ?>
					<fieldset>
						<div class="form-group">
							<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
						</div>

						<div class="form-group">
							<?php
								echo $this->Form->input('company_id', array(
									'class' => 'form-control',
									'empty' => __("please_select")
								));
							?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('alias', array('class' => 'form-control','label'=>__('alias'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('name', array('class' => 'form-control','label'=>__d('company','name')));?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('description', array('class' => 'form-control','label'=>__d('company','description'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('address', array('class' => 'form-control','label'=>__d('company','address'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('about', array('class' => 'form-control','label'=>__d('company','about'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('terms', array('class' => 'form-control','label'=>__d('company','terms'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('privacy', array('class' => 'form-control','label'=>__d('company','privacy'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('hotline', array('class' => 'form-control','label'=>__d('company','hotline'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('service_time', array('class' => 'form-control','label'=>__d('company','service_time'))); ?>
						</div>

						<?php echo $this->Form->submit(__('submit'), array('class' => 'btn btn-large btn-primary')); ?>
					</fieldset>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>