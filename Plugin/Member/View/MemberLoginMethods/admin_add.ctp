
<div class="row">
    <div class="col-xs-6 col-xs-offset-3">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('member', 'admin_add_member_login_method'); ?></h3>
				<div class="pull-right"> <h5 class="box-title red"><?php echo __('required'); ?></h5></div>
			</div>
			<div class="box-body table-responsive">
		
			<?php echo $this->Form->create('MemberLoginMethod', array('role' => 'form')); ?>

				<fieldset>
					<div class="form-group">
						<?php echo $this->Form->input('member_id', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('username', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					
					<div class="form-group">
						<?php echo $this->Form->input('password', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('token', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('enabled', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('school_id', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('created_by', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('updated_by', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<?php echo $this->Form->submit('Submit', array('class' => 'btn btn-large btn-primary')); ?>

				</fieldset>

						<?php echo $this->Form->end(); ?>

		</div><!-- /.form -->
			
	</div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->