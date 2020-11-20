<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('dictionary','add_language'); ?></h3>
			</div>

			<div class="box-body table-responsive">
				<?php echo $this->Form->create('Language', array('role' => 'form')); ?>
					<fieldset>
						<div class="form-group">
							<?php echo $this->Form->input('alias', array('class' => 'form-control','label'=>__d('dictionary','alias'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('is_default', array('class' => 'form-control','label'=>__('is_default'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('enabled', array('class' => 'form-control','label'=>__('enabled'))); ?>
						</div>

						<?php echo $this->Form->submit(__('submit'), array('class' => 'btn btn-large btn-primary')); ?>
					</fieldset>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>