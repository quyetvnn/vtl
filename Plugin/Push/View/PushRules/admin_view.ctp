<div class="row">
    <div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __d('push', 'push_rule'); ?></h3>
				<div class="box-tools pull-right">
					<?php // echo $this->Html->link('<i class="fa fa-pencil"></i> ' . __('edit'), array('action' => 'edit', $pushRule['PushRule']['id']), array('class' => 'btn btn-primary', 'escape' => false)); ?>
				</div>
			</div>
			
			<div class="box-body table-responsive">
                <table id="PushRules" class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td><strong><?php echo __('id'); ?></strong></td>
							<td>
								<?php echo h($pushRule['PushRule']['id']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('push'); ?></strong></td>
							<td>
								<?php echo $this->Html->link($pushRule['Push']['id'], /*$pushRule['Push']['name_zho'],*/ array('controller' => 'pushes', 'action' => 'view', $pushRule['Push']['id']), array('class' => '')); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('push', 'push_type'); ?></strong></td>
							<td>
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
						</tr>
						<tr>
							<td><strong><?php echo __d('push', 'period_start'); ?></strong></td>
							<td>
								<?php echo h($pushRule['PushRule']['period_start']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('push', 'period_end'); ?></strong></td>
							<td>
								<?php echo h($pushRule['PushRule']['period_end']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('push', 'execute_date'); ?></strong></td>
							<td>
								<?php echo h($pushRule['PushRule']['execute_date']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('execute_time'); ?></strong></td>
							<td>
								<?php echo h($pushRule['PushRule']['execute_time']); ?>
							</td>
						</tr>
						
						<tr>
							<td><strong><?php echo __('enabled'); ?></strong></td>
							<td>
								<?php echo $this->element('view_check_ico', array('_check' => $pushRule['PushRule']['enabled'])); ?>
							</td>
						</tr>

						<tr>
							<td><strong><?php echo __('status'); ?></strong></td>
							<td>
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
						</tr>
						<tr>
							<td><strong><?php echo __('updated'); ?></strong></td>
							<td>
								<?php echo h($pushRule['PushRule']['updated']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('updated_by'); ?></strong></td>
							<td>
								<?php echo h($pushRule['UpdatedBy']['email']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('created'); ?></strong></td>
							<td>
								<?php echo h($pushRule['PushRule']['created']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('created_by'); ?></strong></td>
							<td>
								<?php echo h($pushRule['CreatedBy']['email']); ?>
							</td>
						</tr>
					</tbody>
				</table><!-- /.table table-striped table-bordered -->
			</div><!-- /.table-responsive -->
		</div><!-- /.view -->
	</div><!-- /#page-content .span9 -->
</div><!-- /#page-container .row-fluid -->

