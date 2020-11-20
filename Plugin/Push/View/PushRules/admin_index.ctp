<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('push', 'push_rule'); ?></h3>
				
				<div class="box-tools pull-right">
                    <?php
                    if(isset($permissions['PushRule']['add']) && ($permissions['PushRule']['add'] == true)){ 
                        echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i>' . __('add'), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false));
                    } 
                    ?>
				</div>
			</div>	

			<div class="box-body table-responsive">
				<table id="PushRules" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id', __('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('push_id', __('push')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('push_type_id', __d('push', 'push_type')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('period_start', __d('push', 'period_start')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('period_end', __d('push', 'period_end')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('execute_date', __d('push', 'execute_date')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('execute_time', __('execute_time')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('status', __('status')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('enabled', __('enabled')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('updated', __('updated')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('created', __('created')); ?></th>
							<th class="text-center"><?php echo __('operation'); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($pushRules as $pushRule): ?>
							<tr>
								<td class="text-center"><?php echo h($pushRule['PushRule']['id']); ?>&nbsp;</td>
								<td class="text-center">
									<?php 
									 echo $this->Html->link($pushRule['Push']['id'], array('plugin' => 'push', 'controller' => 'pushes', 'action' => 'view', $pushRule['Push']['id'])); ?>
								</td>
								<td class="text-center">
									<?php 
										switch ($pushRule['PushRule']['push_type']) {
											case array_search('Instant', $push_type): ?>
												<label class='label label-success'> <?= __d('push', 'instant') ?> </label> 

											<?php break;
											case array_search('Specific datetime', $push_type): ?>
												<label class='label label-warning'> <?= __d('push', 'specific_datetime') ?> </label> 

											<?php break;
											case array_search('Daily', $push_type): ?>
												<label class='label label-primary'> <?= __d('push', 'daily') ?> </label> 
											
											<?php break;
										}
									?>
								</td>
								<td class="text-center"><?php echo h($pushRule['PushRule']['period_start']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($pushRule['PushRule']['period_end']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($pushRule['PushRule']['execute_date']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($pushRule['PushRule']['execute_time']); ?>&nbsp;</td>
								<td class="text-center">
									<?php 
										switch ($pushRule['PushRule']['status']) {
											case array_search('Complete', $status): ?>
												<label class='label label-success'> <?= __d('push', 'complete') ?> </label> 

											<?php break;
											case array_search('Pending', $status): ?>
												<label class='label label-danger'> <?= __d('push', 'pending') ?> </label> 

											<?php break;
											case array_search('Pushing', $status): ?>
												<label class='label label-warning'> <?= __d('push', 'pushing') ?> </label> 
											
											<?php break;
										}
									?>
								</td>
								<td class="text-center">
									<?php echo $this->element('view_check_ico', array('_check' => $pushRule['PushRule']['enabled'])); ?>
								</td>
								<td class="text-center"><?php echo h($pushRule['PushRule']['updated']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($pushRule['PushRule']['created']); ?>&nbsp;</td>
								<td class="text-center">
									<?php 
										echo $this->Html->link(__('<i class="fa fa-eercast"></i>'), array('plugin' => 'push', 'controller' => 'push_rules', 'action' => 'view', $pushRule['PushRule']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('view'))); 

                                    if ($pushRule['PushRule']['enabled'] && isset($permissions['PushRule']['edit']) && ($permissions['PushRule']['edit'] == true)) { ?>
										<?php echo $this->Form->postLink(__('<i class="fa fa-ban"></i>'), array('plugin' => 'push', 'controller' => 'push_rules', 'action' => 'disable', $pushRule['PushRule']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('disabled')), sprintf(__('are_you_sure_to_disable'), $pushRule['PushRule']['id'])); ?>
										
                                    <?php } ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->
		</div><!-- /.index -->
		<?php echo $this->element('Paginator'); ?>	</div><!-- /#page-content .col-sm-9 -->
</div><!-- /#page-container .row-fluid -->

<?php
	echo $this->Html->script('plugins/datatables/jquery.dataTables');
	echo $this->Html->script('plugins/datatables/dataTables.bootstrap');
?>

