<!-- Modal filter -->
<div class="row filter-panel">
	<div class="col-md-12">
		<?php echo $this->Form->create('School.filter', 
			array(
				'url' => array(
					'plugin' => 'school', 
					'controller' => 'school_classes', 
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
              
                <div class="col-md-4 col-xs-4">
					<div class="form-group">
						<?php
							echo $this->Form->input('school_id', array(
                                'id'    => 'school_id',
								'class' => 'form-control',
								'empty' => __("please_select"),
								'label' => __d('school','school'),
								'selected' => isset($data_search["school_id"]) && $data_search["school_id"] ? $data_search["school_id"] : array(),
							));
						?>
					</div>
                </div>
                <div class="col-md-4 col-xs-4">
					<div class="form-group">
						<?php
							echo $this->Form->input('name', array(
                                'id'    => 'name',
								'class' => 'form-control',
								'empty' => __("please_select"),
								'label' => __('name'),
								'value' => isset($data_search["name"]) && $data_search["name"] ? $data_search["name"] : array(),
							));
						?>
					</div>
                </div>
                <div class="col-md-4 col-xs-4">
					<div class="form-group">
						<?php
							echo $this->Form->input('level', array(
                                'id'    => 'name',
								'class' => 'form-control',
								'empty' => __("please_select"),
								'label' => __d('school', 'level'),
								'value' => isset($data_search["level"]) && $data_search["level"] ? $data_search["level"] : array(),
							));
						?>
					</div>
				</div>
			</div> 

			<div class="row">
				<div class="col-md-12">
					<div class="pull-right vtl-buttons">
						<div>
							<input type="submit" name="data[filter][search]" value="<?php echo __('search')?>" class="btn btn-primary" />
						</div>
						<?php
							echo $this->Html->link(__('reset'), array(
								'plugin' => 'school', 'controller' => 'school_classes', 'action' => 'index',
								'admin' => true, 'prefix' => 'admin'
							), array(
								'class' => 'btn btn-danger filter-button'
							));
						?>
					</div>
				</div>
			</div> 
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
       
	});
</script>