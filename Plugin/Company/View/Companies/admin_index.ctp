<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('company','companies'); ?></h3>
				
				<div class="box-tools pull-right">
					<?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> '.__d('company','add_company'), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
				</div>
			</div>	

			<div class="box-body table-responsive">
				<table id="Companies" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id',__('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('contact_person',__d('company','contact_person')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('contact_email',__d('company','contact_email')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('contact_phone',__d('company','contact_phone')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('contact_job_title',__d('company','contact_job_title')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('enabled',__('enabled')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('updated',__('updated')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('created',__('created')); ?></th>
							<th class="text-center"><?php echo __('operation'); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($companies as $company): ?>
							<tr>
								<td class="text-center"><?php echo h($company['Company']['id']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($company['Company']['contact_person']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($company['Company']['contact_email']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($company['Company']['contact_phone']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($company['Company']['contact_job_title']); ?>&nbsp;</td>
								<td class="text-center">
									<?php echo $this->element('view_check_ico',array('_check'=>$company['Company']['enabled'])) ?>
								</td>
								<td class="text-center"><?php echo h($company['Company']['updated']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($company['Company']['created']); ?>&nbsp;</td>
								<td class="text-center">
									<?php echo $this->Html->link(__('<i class="fa fa-eercast"></i>'), array('plugin' => 'company', 'controller' => 'companies', 'action' => 'view', $company['Company']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => 'View')); ?>
									<?php echo $this->Html->link(__('<i class="fa fa-pencil"></i>'), array('plugin' => 'company', 'controller' => 'companies', 'action' => 'edit', $company['Company']['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => 'Edit')); ?>
									<?php echo $this->Form->postLink(__('<i class="glyphicon glyphicon-trash"></i>'), array('plugin' => 'company', 'controller' => 'companies', 'action' => 'delete', $company['Company']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => 'Delete'), __('are_you_sure_to_delete', $company['Company']['id'])); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php echo $this->element('Paginator'); ?>
	</div>
</div>

<?php
	echo $this->Html->script('plugins/datatables/jquery.dataTables');
	echo $this->Html->script('plugins/datatables/dataTables.bootstrap');
?>
<script type="text/javascript">
	$(function() {
		// $("#Companies").dataTable();
	});
</script>