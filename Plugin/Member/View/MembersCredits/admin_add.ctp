
<div class="row">
    <div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('member', 'add_members_credit'); ?></h3>
				<div class="pull-right"> <h5 class="box-title red"><?php echo __('required'); ?></h5></div>
			</div>
			<div class="box-body table-responsive">
		
				<?php echo $this->Form->create('MembersCredit', array('role' => 'form')); ?>

					<fieldset>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<?php echo $this->Form->input('school_id', array(
										'id'		=> 'school_id',
										'required' => 'required',
										'empty' => __('please_select'),
										'data-live-search' => true,
										'label' => '<font class="red"> * </font> ' . __d('school', 'school'),
										'class' => 'form-control selectpicker')); ?>
								</div><!-- .form-group -->
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<?php echo $this->Form->input('credit_type_id', array(
										'id'		=> 'credit_type_id',
										'empty' => __('please_select'),
										'required' => 'required',
										'label' => '<font class="red"> * </font> ' . __d('credit', 'credit_type'),
										'class' => 'form-control')); ?>
								</div><!-- .form-group -->
							</div>
						
						</div>

						<div class="row">

							<div class="col-md-6">
								<div class="form-group">
									<?php echo $this->Form->input('member_id', array(
										'label' => __d('member', 'member'),
										'id' 	=> 'member_id', 
										'data-live-search' => true,
										'empty' => __('please_select'),
										'class' => 'form-control selectpicker')); ?>
								</div><!-- .form-group -->
							</div>
						
							<div class="col-md-6">
								<div class="form-group">
									<?php echo $this->Form->input('credit', array(
										'required' => 'required',
										'label' => '<font class="red"> * </font> ' . __d('school', 'credit'),
										'class' => 'form-control')); ?>
								</div><!-- .form-group -->
							</div>
						</div>

						<div class="form-group">
							<?php echo $this->Form->input('pay_dollar_ref', array(
								'label' =>  __d('member', 'pay_dollar_ref'),
								'class' => 'form-control')); ?>
						</div><!-- .form-group -->

						
						<div class="form-group">
							<?php echo $this->Form->input('remark', array(
								'label' => __('remark'),
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
	echo $this->Html->script('CakeAdminLTE/pages/admin_members_credit.js?v=' . date('U') , array('inline' => false));
?>

<script type="text/javascript">
	$(document).ready(function(){

		ADMIN_MEMBERS_CREDIT.url_get_member 			= '<?= Router::url(array('plugin' => 'member', 'controller' => 'members', 'action' => 'get_list_member')); ?>';
		ADMIN_MEMBERS_CREDIT.init_page();
	});
</script>