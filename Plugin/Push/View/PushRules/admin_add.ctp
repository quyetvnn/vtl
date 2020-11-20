<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('push', 'add_push_rule'); ?></h3>
			</div>

			<div class="box-body">
				<?php echo $this->Form->create('PushRule', array('role' => 'form')); ?>
					<fieldset>
						<div class="form-group">
							<?php
								echo $this->Form->input('push_id', array(
                                    'class' => 'form-control',
                                    'label' => '<font style="color:red">*</font>' . __('push'),
                                    'empty' => __("please_select"),
                                    'required' => 'required',
								));
							?>
						</div><!-- .form-group -->
						<div class="form-group">
							<?php
								echo $this->Form->input('push_type_id', array(
                                    'id' => 'push_type_id',
									'class' => 'form-control',
									'empty' => __("please_select"),
									'label' => '<font style="color:red">*</font>' . __d('push', 'push_type'),
                                    'required' => 'required',
								));
							?>
                        </div><!-- .form-group -->
                        <div class="period_date">
                            <div class="row">
                                <div class="col-xs-6">
                                    <?php 
                                        echo $this->element('datetime_picker',array(
                                            'field_name' => 'period_start', 
                                            'label' => __d('push','period_start'), 
                                            'id' => 'period_start',
                                            'required' => 'required',
                                        ));
                                    ?>
                                </div>	
                                <div class="col-xs-6">
                                    <?php 
                                        echo $this->element('datetime_picker',array(
                                            'field_name' => 'period_end', 
                                            'label' => __d('push','period_end'), 
                                            'id' => 'period_end',
                                            'required' => 'required',
                                        ));
                                    ?>
                                </div>
                            </div>	
                        </div> 
                        <!-- specific_datetime -->
                        <div class="push_type_rules specific_date">
                            <?php 
                                echo $this->element('date_picker',array(
                                    'field_name' => __('execute_date'),
                                    'id' => 'execute_date',
                                    'label' => __('specific_date'), 
                                    'required' => 'required',
                                ));
                            ?>
                        </div>
                        
                        <!-- exutetime / daily -->
                        <div class="push_type_rules execute-time">
                            <div class="form-group">
                                <label for="execute_time"><?php echo '<font style="color:red">*</font>' . __('execute_time') ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon" ><i class="fa fa-calendar"></i></span>
                                    <?php 
                                        echo $this->Form->input('execute_time', array(
                                            'class' => 'form-control timepicker ',
                                            'label' => false,
                                            'type' => 'text',
                                            'id' => 'execute_time',
                                            'required' => 'required',
                                        ));
                                    ?>
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
						<div class="form-group dv-status">
							<?php echo $this->Form->input('enabled', array(
								'class' => 'form-control',
								'checked' => 'checked',
								'label'=>__('enabled'))); ?>
                        </div><!-- .form-group -->
                        
						<div class="pull-right">
							<?php echo $this->Form->submit(__('submit'), array('class' => 'btn btn-large btn-primary')); ?>
						</div>
					</fieldset>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>

<?php echo $this->Html->script('CakeAdminLTE/pages/admin_push_rule', array('inline' => false)); ?>

<script>
    $(document).ready(function () {
        ADMIN_PUSH_RULE.init_page();
	});
</script>