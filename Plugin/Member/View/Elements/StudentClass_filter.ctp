<!-- Modal filter -->
<div class="row filter-panel">
	<div class="col-md-12">
		<?php echo $this->Form->create('Member.filter', 
			array(
				'url' => array(
					'plugin' => 'member', 
					'controller' => 'student_classes', 
					'action' => 'index', 
					'admin' => true, 
					'prefix' => 'admin'
				),
				'class' => 'form_filter',
				'type' =>'get',
				'autocomplete' => 'off'
			));
		?>
		<div class="action-buttons-wrapper border-bottom">
			<div class="row">
				<!-- slug -->
				<div class="col-md-4 col-xs-4">
					<div class="form-group">
                        <?php
                        
                            if ($school_id) {
                                $data_search["school_id"] = $school_id;
                                echo $this->Form->input('school_id', array(
                                    'id' => 'school_id',
                                    'class' => 'form-control selectpicker',
                                    'data-live-search' => true,
                                    'label' => __d('school','school'),
                                    'selected' => isset($data_search["school_id"]) && $data_search["school_id"] ? array($data_search["school_id"]) : array(),
                                ));

                            } else {
                                echo $this->Form->input('school_id', array(
                                    'id' => 'school_id',
                                    'class' => 'form-control selectpicker',
                                    'data-live-search' => true,
                                    'empty' => __("please_select"),
                                    'label' => __d('school','school'),
                                    'selected' => isset($data_search["school_id"]) && $data_search["school_id"] ? array($data_search["school_id"]) : array(),
                                ));
                            }
						
						?>
					</div>
                </div>

                <div class="col-md-4 col-xs-4">
					<div class="form-group">
						<?php
							echo $this->Form->input('school_class_id', array(
                                'id' => 'school_class_id',
								'class' => 'form-control selectpicker',
								'data-live-search' => true,
								'empty' => __("please_select"),
								'label' => __d('member','class'),
								'selected' => isset($data_search["school_class_id"]) && $data_search["school_class_id"] ? array($data_search["school_class_id"]) : array(),
							));
						?>
					</div>
				</div>


                <div class="col-md-4 col-xs-4">
                    <?php
                        echo $this->Form->input('student_id', array(
                            'class' => 'form-control selectpicker',
                            'id' => 'student_id',
                            'data-live-search' => true,
                            'empty' => __("please_select"),
                            'label' => __d('member','student'),
                            'value' => isset($data_search["student_id"]) && $data_search["student_id"] ? array($data_search["student_id"]) : array(),
						));
                    ?>
				</div>

               
			</div> <!-- end row -->

			
			<div class="row">
				<!-- course_type  -->
			

				<!-- <div class="col-md-6 col-xs-6">
					<div><label><?php echo __('status'); ?></label></div>
					<div class="btn-group btn-group-sm" data-toggle="buttons" >
						<label class="btn btn-default">
							<input type="radio" name="is_status" value="" autocomplete="off" 
								<?php echo !isset($data_search['is_status']) || $data_search['is_status'] === "" ? 'checked="checked"' : ''; ?>>
							<?php echo __('all'); ?>
						</label>
						<label class="btn btn-default">
							<input type="radio" name="is_status" value="1" autocomplete="off" 
								<?php echo isset($data_search['is_status']) && $data_search['is_status']  === "1" ? 'checked="checked"' : '';?> >
							<?php echo __('approve'); ?>
						</label>
						<label class="btn btn-default">
							<input type="radio" name="is_status" value="0" autocomplete="off" 
								<?php echo isset($data_search['is_status']) && $data_search['is_status'] === "0" ? 'checked="checked"' : ''; ?> >
							<?php echo __('reject'); ?>
						</label>
						<label class="btn btn-default">
							<input type="radio" name="is_status" value="2" autocomplete="off" 
								<?php echo isset($data_search['is_status']) && $data_search['is_status'] === "2" ? 'checked="checked"' : ''; ?> >
							<?php echo __d('course', 'just_submit'); ?>
						</label>
					</div>
				</div> -->
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="pull-right vtl-buttons">
						<div>
							<input type="submit" name="data[filter][search]" value="<?php echo __('search')?>" class="btn btn-primary" />
						</div>
						<?php
							echo $this->Html->link(__('reset'), array(
								'plugin' => 'member', 'controller' => 'student_classes', 'action' => 'index',
								'admin' => true, 'prefix' => 'admin'
							), array(
								'class' => 'btn btn-danger filter-button'
							));
						?>
						<div class="action-buttons-wrapper border-top">
							<?php
								// echo $this->Form->input(__('export'), array(
								// 	'div' => false,
								// 	'label' => false,
								// 	'type' => 'submit',
								// 	'name' => 'button_export',
								// 	'class' => 'btn btn-success btn-sm filter-button btn-filter-export'
								// ));
							?>
						</div>
					</div>
				</div>
			</div> <!-- export -->
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
       
	});
</script>