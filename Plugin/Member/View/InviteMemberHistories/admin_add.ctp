
<div class="row">
    <div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('member', 'add_invite_member_history'); ?></h3>
				<div class="pull-right"> <h5 class="box-title red"><?php echo __('required'); ?></h5></div>
			</div>
			<div class="box-body">
		
			<?php echo $this->Form->create('InviteMemberHistory', array('role' => 'form')); ?>
				<fieldset>

					<div class="form-group">
						<?php 
							if ($school_id) {
								echo $this->Form->input('school_id', array(
									'required' => 'required',
									'value' => $school_id,
									'data-live-search' => true,
									'empty' => __('please_select'),
									'label' => "<font class='red'>  * </font>" . __d('school', 'school'),
									'class' => 'form-control selectpicker')); 

							} else {
								echo $this->Form->input('school_id', array(
									'data-live-search' => true,
									'required' => 'required',
									'empty' => __('please_select'),
									'label' => "<font class='red'>  * </font>" . __d('school', 'school'),
									'class' => 'form-control selectpicker')); 
							}
						?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('role_id', array(
							'required' => 'required',
							'label' => "<font class='red'>  * </font>" . __d('administration', 'role'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('email', array(
							'required' => 'required',
							'label' => "<font class='red'>  * </font>" . __d('member', 'email'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<?php echo $this->Form->submit(__('submit'), array('class' => 'btn btn-large btn-primary')); ?>

				</fieldset>

			<?php echo $this->Form->end(); ?>

		</div><!-- /.form -->
			
	</div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->