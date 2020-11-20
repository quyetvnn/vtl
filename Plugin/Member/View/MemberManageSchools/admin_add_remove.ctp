
<div class="row">
    <div class="col-xs-12 col-md-6">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('member', 'add_member_manage_school'); ?></h3>
			</div>
			<div class="box-body table-responsive">
		
			<?php echo $this->Form->create('MemberManageSchool', array('autocomplete' => "off", 'role' => 'form')); ?>

				<fieldset>

					<div class="form-group">
						<?php echo $this->Form->input('school_id', array(
							'label' => "<font class='red'> * </font>" . __d('school', 'school'),
							'data-live-search' => true,
							'required' => 'required',
							'multiple' => 'multiple',
							'class' => 'form-control selectpicker'
						)); ?>
					</div><!-- .form-group -->
					<div class="form-group">
						<?php echo $this->Form->input('member_id', array(
							'required' => 'required',
							'label' => "<font class='red'> * </font>" . __d('member', 'teacher'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<div class="form-group">
						<?php echo $this->Form->input('username', array(
							'id'	=> 'username',
							'required' => 'required',
							'label' => "<font class='red'> * </font>" . __d('member', 'username'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<div class="form-group">
						<?php echo $this->Form->input('password', array(
							'id'	=> 'password',
							'autocomplete' => "new-password", // remove auto fill username, password
							'minlength'	=> 8,
							'required' => 'required',
							'label' => "<font class='red'> * </font>" . __d('administration', 'password'),
							'class' => 'form-control')); ?>
					</div><!-- .form-group -->

					<?php echo $this->Form->submit(__('submit'), array('class' => 'btn btn-large btn-primary')); ?>

				</fieldset>

			<?php echo $this->Form->end(); ?>

		</div><!-- /.form -->
			
	</div><!-- /#page-content .col-sm-9 -->
		</div><!-- /#page-content .col-sm-9 -->
</div><!-- /#page-container .row-fluid -->

<script type="text/javascript">
  	$(document).ready(function() {
    });
</script>