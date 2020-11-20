
<div class="row">
    <div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('school', 'edit_student_class'); ?></h3>
				<div class="pull-right"> <h5 class="box-title red"><?php echo __('required'); ?></h5></div>
			</div>

			<div class="box-body">
			<?php echo $this->Form->create('StudentClass', array('role' => 'form')); ?>

				<fieldset>
					<div class="form-group">
						<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
					</div><!-- .form-group -->
					<?php if ($school_id) { ?>
						<div class="form-group">
							<?php echo $this->Form->input('school_id', array(
								'label' => '<font class="red"> * </font>' . __d('school', 'school'),
								'required' => 'required',
								'id'	=> 'school_id',
								'empty' => __('please_select'),
								'class' => 'form-control')); ?>
						</div><!-- .form-group -->
					<?php } else {  ?>

						<div class="form-group">
							<?php echo $this->Form->input('school_id', array(
								'label' => '<font class="red"> * </font>' . __d('school', 'school'),
								'required' => 'required',
								'id'	=> 'school_id',
								'empty' => __('please_select'),
								'class' => 'form-control')); ?>
						</div><!-- .form-group -->
					<?php }   ?>


					<div class="form-group">
						<?php echo $this->Form->input('school_class_id', array(
							'label' => '<font class="red"> * </font>' . __d('member', 'class'),
							'required' => 'required',
							'id'	=> 'school_class_id',
							'data-live-search' => true, 
							'empty' => __('please_select'),
							'class' => 'form-control student-class-selectpicker')); ?>
					</div><!-- .form-group -->

					<div class="form-group">
                       	
						<?php 
							echo $this->Form->input('student_id', array(
								'label' => '<font class="red"> * </font>' . __d('member', 'student'),
								'required' => 'required',
								'empty' => __('please_select'),
								'data-live-search' => true, 
								'id'	=> 'student_id',
								'class' => 'form-control student-class-selectpicker')); 
						?>
					</div><!-- .form-group -->
				
					<div class="form-group">
						<?php echo $this->Form->input('enabled', array(
							'checked' => true,
							'class' => 'form-control')); ?>

					</div><!-- .form-group -->
				

					<?php echo $this->Form->submit(__('submit'), array('class' => 'btn btn-large btn-primary')); ?>

				</fieldset>

			<?php echo $this->Form->end(); ?>

		</div><!-- /.form -->
			
	</div><!-- /#page-content .col-sm-9 -->
		</div><!-- /#page-content .col-sm-9 -->
</div><!-- /#page-container .row-fluid -->

<?php
	echo $this->Html->script('CakeAdminLTE/pages/admin_student_class.js?v=' . date('U') , array('inline' => false));
?>

<script type="text/javascript">
	$(document).ready(function(){
		ADMIN_STUDENT_CLASS.school_class_id = '<?= isset($school_class_id_selected) ? $school_class_id_selected : ""; ?>'

		ADMIN_STUDENT_CLASS.url_get_school_class 	= '<?= Router::url(array('plugin' => 'member', 'controller' => 'student_classes', 'action' => 'get_school_class')); ?>';
		ADMIN_STUDENT_CLASS.url_get_member 			= '<?= Router::url(array('plugin' => 'member', 'controller' => 'members', 'action' => 'get_list_student')); ?>';
		ADMIN_STUDENT_CLASS.noneSelectedText  		= '<?= __('please_select'); ?>';
		ADMIN_STUDENT_CLASS.init_page();
	
	});
</script>