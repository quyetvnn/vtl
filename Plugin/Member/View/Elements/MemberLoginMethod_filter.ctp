<!-- Modal filter -->
<div class="row filter-panel">
	<div class="col-md-12">
		<?php echo $this->Form->create('Member.filter', 
			array(
				'url' => array(
					'plugin' => 'member', 
					'controller' => 'member_login_methods', 
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
							echo $this->Form->input('member_id', array(
                                'id' => 'member_id',
								'class' => 'form-control selectpicker',
								'data-live-search' => true,
								'empty' => __("please_select"),
								'label' => __d('member','member'),
								'selected' => isset($data_search["member_id"]) && $data_search["member_id"] ? array($data_search["member_id"]) : array(),
							));
						?>
					</div>
				</div>

                <div class="col-md-4 col-xs-4">
					<div class="form-group">
						<?php
							echo $this->Form->input('username', array(
                                'id' => 'username',
								'class' => 'form-control selectpicker',
								'data-live-search' => true,
								'empty' => __("please_select"),
								'label' => __d('member','username'),
								'value' => isset($data_search["username"]) && $data_search["username"] ? $data_search["username"] : array(),
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
							<input type="radio" name="is_status" value="1" autocomplete="off" 
								<?php echo isset($data_search['is_status']) && $data_search['is_status']  === "1" ? 'checked="checked"' : '';?> >
							<?php echo __('enabled'); ?>
						</label>
						<label class="btn btn-default">
							<input type="radio" name="is_status" value="0" autocomplete="off" 
								<?php echo isset($data_search['is_status']) && $data_search['is_status'] === "0" ? 'checked="checked"' : ''; ?> >
							<?php echo __('disabled'); ?>
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
								'plugin' => 'member', 'controller' => 'member_login_methods', 'action' => 'index',
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