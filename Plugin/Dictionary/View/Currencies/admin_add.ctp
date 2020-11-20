<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('dictionary','add_currency'); ?></h3>
			</div>

			<div class="box-body table-responsive">
				<?php echo $this->Form->create('Currency', array('role' => 'form')); ?>
					<fieldset>
						<div class="form-group">
							<?php echo $this->Form->input('slug', array('class' => 'form-control','label'=>__d('dictionary','slug'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('rate_to_usd', array('class' => 'form-control','label'=>__d('dictionary','rate_to_usd'))); ?>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('enabled', array('class' => 'form-control','label'=>__('enabled'))); ?>
						</div>

						<div class="form-group">
							<?php //echo $this->Form->input('Shop');?>
						</div>
						
						<?php echo $this->element('language_input', array(
								'languages_model' => $languages_model,
								'languages_list' => $languages_list,
								'language_input_fields' => $language_input_fields,
								'languages_edit_data' => isset($this->request->data[$languages_model]) ? $this->request->data[$languages_model] : false,
						)); ?>

						<div class="pull-right">
							<?php echo $this->Form->submit(__('submit'), array('class' => 'btn btn-large btn-primary')); ?>
						</div>
					</fieldset>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>