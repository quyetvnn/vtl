<!-- 
	vilh (2019-03-14) 
	- add radio button all
	- add new variables for check button when submit search

-->

<div class="row filter-panel">
	<div class="col-md-12">
		<?php 
			echo $this->Form->create('Dictionary.filter', array(
				'url' => array('plugin' => 'dictionary', 
						'controller' => 'image_types', 
						'action' => 'index', 
						'admin' => true, 
						'prefix' => 'admin'),
				'class' => 'form_filter',
                'type' => 'get',
			));
		?>

		<div class="action-buttons-wrapper border-bottom">
			<div class="row">
				<!-- imageTypePrefix --> 
				<div class="col-md-4">
					<?php echo $this->element('multi_select', array(
						'field_name' => 'ImageType.type_prefix_id', //typPrefixes
						'live_search' => true,
						'title' => '',
						'multiple' => true,
						'class' => 'form-control',
						'selecteds' => isset($selected) ? $selected : NULL,
					)); ?>
				</div>
				
				<div class="col-md-3">

					<div class="btn-group btn-group-sm" data-toggle="buttons" >
						<label class="btn btn-default">
							<input type="radio" name="data[filter][enabled]" value="" autocomplete="off" 
									<?php  
									if ( !isset($this->request->query["data"]['filter']["enabled"]) || $this->request->query['data']["filter"]["enabled"] === "") 
										echo 'checked="checked"';
									?>>
							<?php echo __('all'); ?>
						</label>

						<label class="btn btn-default">
							<input type="radio" name="data[filter][enabled]" value="1" autocomplete="off" 
									<?php  
									if (isset($this->request->query["data"]["filter"]["enabled"]) && $this->request->query["data"]["filter"]["enabled"]  === "1") 
										echo 'checked="checked"';
									?>>
							<?php echo __('enabled'); ?>
						</label>

						<label class="btn btn-default">
							<input type="radio" name="data[filter][enabled]" value="0" autocomplete="off" 
								<?php  
									if (isset($this->request->query["data"]["filter"]["enabled"]) && $this->request->query["data"]["filter"]["enabled"] === "0") 
										echo 'checked="checked"';
									?>>
							
							<?php echo __d('coupon','disabled'); ?>
						</label>
					</div>

				</div>
				
			</div>


			<div class="row ">
				<div class="col-md-12">
                    <div class="pull-right vtl-buttons">
                        <?php
                            echo $this->Form->submit(__('submit'), array(
                                'class' => 'btn btn-primary btn-sm filter-button',
                            ));
                        ?>

                        <?php
                            echo $this->Html->link(__('reset'), array(
                                'plugin' => 'dictionary', 'controller' => 'image_types', 'action' => 'index',
                                'admin' => true, 'prefix' => 'admin'
                            ), array(
                                'class' => 'btn btn-danger btn-sm filter-button',
                            ));
                        ?>
                        <div class="action-buttons-wrapper border-top">
                            <?php
                                echo $this->Form->input(__('export'), array(
                                    'div' => false,
                                    'label' => false,
                                    'type' => 'submit',
                                    'name' => 'button_export_csv',
                                    'class' => 'btn btn-success btn-sm filter-button btn-filter-export',
                                ));
                            ?>

                            <span class="spinner" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Sending...</span>
                        </div>
                        
                        <div class="action-buttons-wrapper border-top">
                            <?php
                                echo $this->Form->input(__('export_excel'), array(
                                    'div' => false,
                                    'label' => false,
                                    'type' => 'submit',
                                    'name' => 'button_export_excel',
                                    'class' => 'btn btn-warning btn-sm filter-button',
                                ));
                            ?>
                            <span class="spinner" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Sending...</span>
                        </div>
                    </div>
                </div>
			</div>
		</div>

		<?php echo $this->Form->end(); ?>
	</div>
</div>
