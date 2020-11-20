<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __('push', 'add_push'); ?></h3>
			</div>

			<div class="box-body">
                <?php echo $this->Form->create('Push', array('role' => 'form', 'id' => 'push-form')); ?>
             		<fieldset>
						
						<!-- push rule -->
						<div class="well">
                            <div class="row">
                                <div class="col-md-3 col-xs-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->input('push_group_id', array(
                                                'id'    => 'push_group_id',
                                                'class' => 'form-control',
                                               // 'empty' => __("please_select"),
                                                'label' => "<font style='color:red'> * </font>"  . __d('push', 'push_group'),
                                                'required' => 'required',
                                            ));

                                        ?>
                                    </div><!-- .form-group -->
                                </div><!-- .col -->
                            </div><!-- .col -->

                            <div class="row">
                                <div class="col-md-3 col-xs-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->input('PushRule.0.push_type', array(
                                                'id' => 'push_type',
                                                'class' => 'form-control',
                                                'label' => '<font style="color: red">*</font>' . __d('push', 'push_type'),
                                                'required' => 'required',
                                            ));
                                        ?>
                                    </div><!-- .form-group -->
                                </div>
                                <!-- start period_day -->
                                <div class="col-xs-offset-2 col-xs-10 specific_datetime">
                                    <div class="period_date">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <?php 
                                                    echo $this->element('datetime_picker',array(
                                                        'field_name' => 'PushRule.0.period_start', 
                                                        'label' => __d('push','period_start'), 
                                                        'id' => 'period_start',
                                                    ));
                                                ?>
                                            </div>	
                                            <div class="col-xs-6">
                                                <?php 
                                                    echo $this->element('datetime_picker',array(
                                                        'field_name' => 'PushRule.0.period_end', 
                                                        'label' => __d('push','period_end'), 
                                                        'id' => 'period_end',
                                                    ));
                                                ?>
                                            </div>
                                        </div>	
                                    </div> 
                                    <!-- end period_day -->

                                    <!-- specific_datetime -->
                                    <div class="push_type_rules specific_date">
                                        <?php 
                                            echo $this->element('date_picker',array(
                                                'field_name' => 'PushRule.0.execute_date', 
                                                'label' => __('specific_date'), 
                                                'id' => 'execute_date',
                                            ));
                                        ?>
                                    </div>

                                    <!-- exetetime / daily -->
                                    <div class="push_type_rules execute-time">
                                        <div class="form-group">
                                            <label for="execute_time"><?php echo __('execute_time') ?></label>
                                            <div class="input-group">
                                                <span class="input-group-addon" ><i class="fa fa-calendar"></i></span>
                                                <?php 
                                                    echo $this->Form->input('PushRule.0.execute_time', array(
                                                        'class' => 'form-control timepicker ',
                                                        'label' => false,
                                                        'type' => 'text',
                                                        'id' => 'execute_time'
                                                    ));
                                                ?>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
						<!-- Push Method -->
						<div class="well">
							<div class="row">
								<div class="col-xs-3">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->input('push_method', array(
                                                'id' => 'push_method',
                                                'class' => 'form-control',
                                                'label' => '<font style="color: red">*</font>' . __d('push', 'push_method'),
                                                'required' => 'required',
                                            ));
                                        ?>
                                    </div><!-- .form-group -->
								</div>
								<div class="col-xs-10 col-xs-offset-2 push-to-someone">
									<div class="form-group">
                                        <?php    
                                            echo $this->Form->input('phone', array(
                                                'id' => 'phone',
                                                'class' => 'form-control',
                                                'label' => __d('member', 'phone'),
                                                'required' => 'required',
                                                'placeholder' => '0906440368, 0937128938, ...',
                                            ));
                                        ?>
                                    </div><!-- .form-group -->
                                    <div class="form-group list-member-name">
                                    </div>
                                </div>

                                <div class="col-xs-10 col-xs-offset-2 push-by-criteria">
									<div class="row">
                                        <div class="col-md-12"><h4><?=  __('district') ?></h4></div>
										<div data-toggle="buttons" style="padding: 0px 0 20px;">
                                            <?php foreach ($districts as $key => $value): ?>
												<div class="col-md-3 col-sm-4 col-xs-6">
                                                    <input type="checkbox" name = "districts[]" value="<?= $key; ?>"> 
                                                    <?php echo $value; ?>
												</div>
											<?php endforeach ?>				
										</div>
                                    </div> <!-- end row -->
                                    
                                    <div class="row">
                                        <div class="col-md-12"><h4><?=  __d('course', 'course_category') ?></h4></div>
										<div data-toggle="buttons" style="padding: 0px 0 20px;">
											<?php foreach ($courseCategories as $key => $value): ?>
												<div class="col-md-3 col-sm-4 col-xs-6">
                                                    <input type="checkbox" name="course_categories[]" value="<?= $key; ?>"> 
                                                    <?php echo $value; ?>
												</div>
											<?php endforeach ?>				
										</div>
                                    </div> <!-- end row -->
								
								</div> <!-- end col-xs-10 col-xs-offset-2 push-by-criteria -->
							</div> <!-- end row -->
						</div> <!-- end well -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->input('course_class_id', array(
                                            'class' => 'form-control',
                                            'empty' => __("Please select"),
                                            'id'	=> 'course_class_id',
                                            'label'	=> __d('course', 'course_class'),
                                        ));
                                    ?>
                                </div><!-- .form-group -->
                            </div>
                        </div>
					
                        <div class="form-group">
							<?php echo $this->Form->input('enabled', array('checked' => true, 'class' => 'form-control', 'label' => __('enabled'))); ?>
                        </div>

                        <?php echo $this->element('language_input', array(
                            'languages_model'       => $languages_model,
                            'languages_list'        => $languages_list,
                            'language_input_fields' => $language_input_fields,
                            'languages_edit_data'   => isset($this->request->data[$languages_model]) ? $this->request->data[$languages_model] : false,
                        )); ?>

                        <div class="pull-right">
							<?php echo $this->Form->submit(__('submit'), array(
                                'id' => 'confirmSubmission',
                                'class' => 'btn btn-large btn-primary')); ?>
						</div>

					</fieldset>
				<?php echo $this->Form->end(); ?>
            </div>
      

		</div>
	</div>
</div>

<?php  echo $this->Html->script('CakeAdminLTE/pages/admin_push', array('inline' => false)); ?>

<script type="text/javascript">
	$(document).ready(function() {
        // ADMIN_PUSH.url_get_members = '<?php echo Router::url(array('plugin'=>'member', 'controller'=> 'members', 'action'=>'get_data_select'), true); ?>';
        ADMIN_PUSH.message_confirm_push_all = '<?php echo __d('push','confirm_to_push_to_all');?>';
        ADMIN_PUSH.message_must_choose_member = '<?php echo __d('push','must_choose_member');?>';
		ADMIN_PUSH.init_page();
	});
</script>