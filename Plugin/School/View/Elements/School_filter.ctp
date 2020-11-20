<!-- Modal filter -->
<div class="row filter-panel">
	<div class="col-md-12">
		<?php echo $this->Form->create('School.filter', 
			array(
				'url' => array(
					'plugin' => 'school', 
					'controller' => 'schools', 
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
							echo $this->Form->input('school_code', array(
                                'id'    => 'school_code',
								'class' => 'form-control',
								'empty' => __("please_select"),
								'label' => __d('school','school_code'),
								'value' => isset($data_search["school_code"]) && $data_search["school_code"] ? $data_search["school_code"] : array(),
							));
						?>
					</div>
				</div>
                <div class="col-md-4 col-xs-4">
					<div class="form-group">
						<?php
							echo $this->Form->input('email', array(
                                'id' => 'role_id',
								'class' => 'form-control',
								'data-live-search' => true,
								'empty' => __("please_select"),
								'label' => __d('member','email'),
								'value' => isset($data_search["email"]) && $data_search["email"] ? $data_search["email"] : array(),
							));
						?>
					</div>
				</div>

                <div class="col-md-4 col-xs-4">
					<div><label><?php echo __('status'); ?></label></div>
					<div class="btn-group btn-group-sm" data-toggle="buttons" >
						<label class="btn btn-default">
							<input type="radio" name="is_status" value="" autocomplete="off" 
								<?php echo !isset($data_search['is_status']) || $data_search['is_status'] === "" ? 'checked="checked"' : ''; ?>>
								<?php echo __('all'); ?>
						</label>
						<label class="btn btn-default">
							<input type="radio" name="is_status" value="2" autocomplete="off" 
								<?php echo isset($data_search['is_status']) && $data_search['is_status']  === "2" ? 'checked="checked"' : '';?> >
								<?php echo __d('school', 'closed'); ?>
						</label>
						<label class="btn btn-default">
							<input type="radio" name="is_status" value="1" autocomplete="off" 
								<?php echo isset($data_search['is_status']) && $data_search['is_status']  === "1" ? 'checked="checked"' : '';?> >
								<?php echo __d('school', 'normal'); ?>
						</label>
						<label class="btn btn-default">
							<input type="radio" name="is_status" value="0" autocomplete="off" 
								<?php echo isset($data_search['is_status']) && $data_search['is_status'] === "0" ? 'checked="checked"' : ''; ?> >
								<?php echo __d('school', 'blocked'); ?>
						</label>
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
								'plugin' => 'school', 'controller' => 'schools', 'action' => 'index',
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