<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('member', 'push_histories'); ?></h3>
			</div>	

			<div class="box-body table-responsive">
				<table id="PushHistories" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id'); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('push_id'); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('push_rule_id'); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('total_push_devices'); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('created'); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('updated'); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($pushHistories as $pushHistory): ?>
							<tr>
								<td class="text-center"><?php echo h($pushHistory['PushHistory']['id']); ?>&nbsp;</td>
								<td class="text-center">
									<?php echo $this->Html->link($pushHistory['PushHistory']['push_id'], array('plugin' => 'push', 'controller' => 'pushes', 'action' => 'view', $pushHistory['PushHistory']['push_id'])); ?>
								</td>
								<td class="text-center">
									<?php echo $this->Html->link($pushHistory['PushHistory']['push_rule_id'], array('plugin' => 'push', 'controller' => 'push_rules', 'action' => 'view', $pushHistory['PushHistory']['push_rule_id'])); ?>
								</td>
								<td class="text-center"><?php echo h($pushHistory['PushHistory']['total_push_devices']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($pushHistory['PushHistory']['created']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($pushHistory['PushHistory']['updated']); ?>&nbsp;</td>
							
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
<script type="text/javascript">
	$(function() {
		// $("#PushHistories").dataTable();
	});
</script>