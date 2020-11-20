
<div class="row">
	<div class="col-xs-12 col-md-6 col-xs-offset-3">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('school', 'add_school_class'); ?></h3>
			</div>
			<div class="box-body table-responsive">
		
			<?php echo $this->Form->create('SchoolClass', array('role' => 'form')); ?>
				<fieldset>
					<div class="form-group">
						<?php
						
							echo $this->Form->input('school_id', array(
								'class' => 'form-control',
								'label' => "<font class='red'> * </font>" . __d('school', 'school'),
								'required' => 'required',
							)); 
							
						?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('name', array(
							'required' => 'required',
							'label' => "<font class='red'> * </font>" . __('name'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<div class="form-group">
						<?php echo $this->Form->input('level', array(
							'label' => __d('school', 'level'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<?php echo $this->Form->submit(__('submit'), array('class' => 'btn btn-large btn-primary')); ?>

				</fieldset>

			<?php echo $this->Form->end(); ?>

		</div><!-- /.form -->
			
	</div><!-- /#page-content .col-sm-9 -->
</div><!-- /#page-container .row-fluid -->