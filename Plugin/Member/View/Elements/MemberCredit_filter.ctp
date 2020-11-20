<!-- Modal filter -->
<div class="row filter-panel">
	<div class="col-md-12">
		<?php echo $this->Form->create('Member.filter', 
			array(
				'url' => array(
					'plugin' => 'member', 
					'controller' => 'members_credits', 
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
                <div class="col-md-3 col-xs-3">
					<div class="form-group">
						<?php
							echo $this->Form->input('school_id', array(
                                'id' => 'school_id',
								'class' => 'form-control selectpicker',
								'data-live-search' => true,
								'empty' => __("please_select"),
								'label' => __d('school','school'),
								'selected' => isset($data_search["school_id"]) && $data_search["school_id"] ? array($data_search["school_id"]) : array(),
							));
						?>
					</div>
                </div>
                
                <div class="col-md-3 col-xs-3">
					<div class="form-group">
						<?php
							echo $this->Form->input('credit_type_id', array(
                                'id' => 'role_id',
								'class' => 'form-control selectpicker',
								'data-live-search' => true,
								'empty' => __("please_select"),
								'label' => __d('credit','credit_type'),
								'value' => isset($data_search["credit_type_id"]) && $data_search["credit_type_id"] ? $data_search["credit_type_id"] : array(),
							));
						?>
                    </div>
                </div>  

                <div class="col-md-3 col-xs-3">
					<div class="form-group">
						<?php
							echo $this->Form->input('pay_dollar_ref', array(
                                'id' => 'role_id',
								'class' => 'form-control selectpicker',
								'data-live-search' => true,
								'empty' => __("please_select"),
								'label' => __d('member','pay_dollar_ref'),
								'value' => isset($data_search["pay_dollar_ref"]) && $data_search["pay_dollar_ref"] ? $data_search["pay_dollar_ref"] : array(),
							));
						?>
					</div>
                </div>

                <div class="col-md-3 col-xs-3">
					<div class="form-group">
						<?php
							echo $this->Form->input('remark', array(
                                'id' => 'remark',
								'class' => 'form-control',
								'label' => __('remark'),
								'value' => isset($data_search["remark"]) && $data_search["remark"] ? $data_search["remark"] : array(),
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
								'plugin' => 'member', 'controller' => 'members_credits', 'action' => 'index',
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