<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('company','company_languages'); ?></h3>
				
				<div class="box-tools pull-right">
					<?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> '.__d('company','add_company_language'), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
				</div>
			</div>	

			<div class="box-body table-responsive">
				<table id="CompanyLanguages" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id',__('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('company_id',__d('company','company_id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('alias',__('alias')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('name',__d('company','name')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('description',__d('company','description')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('address',__d('company','address')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('about',__d('company','about')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('terms',__d('company','terms')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('privacy',__d('company','privacy')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('hotline',__d('company','hotline')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('service_time',__d('company','service_time')); ?></th>
							<th class="text-center"><?php echo __('operations'); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($companyLanguages as $companyLanguage): ?>
							<tr>
								<td class="text-center"><?php echo h($companyLanguage['CompanyLanguage']['id']); ?>&nbsp;</td>
								<td class="text-center">
									<?php echo $this->Html->link($companyLanguage['Company']['email'], array('plugin' => 'company', 'controller' => 'companies', 'action' => 'view', $companyLanguage['Company']['id'])); ?>
								</td>
								<td class="text-center"><?php echo h($companyLanguage['CompanyLanguage']['alias']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($companyLanguage['CompanyLanguage']['name']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($companyLanguage['CompanyLanguage']['description']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($companyLanguage['CompanyLanguage']['address']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($companyLanguage['CompanyLanguage']['about']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($companyLanguage['CompanyLanguage']['terms']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($companyLanguage['CompanyLanguage']['privacy']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($companyLanguage['CompanyLanguage']['hotline']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($companyLanguage['CompanyLanguage']['service_time']); ?>&nbsp;</td>
								<td class="text-center">
									<?php echo $this->Html->link(__('<i class="fa fa-eercast"></i>'), array('plugin' => 'company', 'controller' => 'company languages', 'action' => 'view', $companyLanguage['CompanyLanguage']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('view'))); ?>
									<?php echo $this->Html->link(__('<i class="fa fa-pencil"></i>'), array('plugin' => 'company', 'controller' => 'company languages', 'action' => 'edit', $companyLanguage['CompanyLanguage']['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('edit'))); ?>
									<?php echo $this->Form->postLink(__('<i class="glyphicon glyphicon-trash"></i>'), array('plugin' => 'company', 'controller' => 'company languages', 'action' => 'delete', $companyLanguage['CompanyLanguage']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('delete')), __('are_you_sure_to_delete', $companyLanguage['CompanyLanguage']['id'])); ?>
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
		// $("#CompanyLanguages").dataTable();
	});
</script>