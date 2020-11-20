
<div class="row">
    <div class="col-xs-12 col-md-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('member', 'edit_member_login_method'); ?></h3>
			</div>
			<div class="box-body table-responsive">
		
			<?php echo $this->Form->create('MemberLoginMethod', array('role' => 'form')); ?>

				<fieldset>
					<div class="form-group">
						<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('member_id', array(
							'label' => __d('member', 'member'),
							'disabled' => 'disabled',
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('username', array(
							
							'readonly' => 'readonly',
							'label' => __d('member', 'username'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->
					
					<div class="form-group">
						<?php echo $this->Form->input('password', array(
							'label' => '<font class="red">*</font>'.__d('administration', 'password'),
							'autocomplete' => 'new-password',
							'value' => '',
							'required' => 'required',
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->
				
					<div class="form-group">
						<?php echo $this->Form->input('school_id', array(
							'label' => __d('school', 'school'),
							'disabled' => 'disabled',
							'empty' => __('please_select'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->
					

					<?php echo $this->Form->submit('Submit', array('class' => 'btn btn-large btn-primary')); ?>

				</fieldset>

			<?php echo $this->Form->end(); ?>

		</div><!-- /.form -->
			
	</div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->