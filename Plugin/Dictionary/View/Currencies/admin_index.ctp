<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('dictionary','currency'); ?></h3>
				
				<div class="box-tools pull-right">
                    <?php
                        if(isset($permissions['Currency']['add']) && ($permissions['Currency']['add'] == true)){
                            echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> '.__d('dictionary','add_currency'), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); 
                        }
                    ?>
				</div>
			</div>	

			<div class="box-body table-responsive">
				<table id="Currencies" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id',__d('dictionary','id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('slug',__d('dictionary','slug')); ?></th>
							<th class="text-center"><?php echo __d('dictionary','name'); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('rate_to_usd',__d('dictionary','rate_to_usd')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('enabled',__('enabled')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('updated',__('updated')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('created',__('created')); ?></th>
							<th class="text-center"><?php echo __('operation'); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($currencies as $currency): ?>
							<tr>
								<td class="text-center"><?php echo h($currency['Currency']['id']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($currency['Currency']['slug']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($currency['CurrencyLanguage'][0]['name']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($currency['Currency']['rate_to_usd'] + 0); ?>&nbsp;</td>
								<td class="text-center">
									<?php echo $this->element('view_check_ico',array('_check'=>$currency['Currency']['enabled'])) ?>
								</td>
								<td class="text-center"><?php echo h($currency['Currency']['updated']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($currency['Currency']['created']); ?>&nbsp;</td>
								<td class="text-center">
									<?php echo $this->Html->link(__('<i class="fa fa-eercast"></i>'), array('plugin' => 'dictionary', 'controller' => 'currencies', 'action' => 'view', $currency['Currency']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('view'))); ?>
                                    <?php if(isset($permissions['Currency']['edit']) && ($permissions['Currency']['edit'] == true)){ ?>
                                        <?php echo $this->Html->link(__('<i class="fa fa-pencil"></i>'), array('plugin' => 'dictionary', 'controller' => 'currencies', 'action' => 'edit', $currency['Currency']['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('edit'))); ?>
                                    <?php } ?>
                                    <?php if(isset($permissions['Currency']['delete']) && ($permissions['Currency']['delete'] == true)){ ?>
                                        <?php echo $this->Form->postLink(__('<i class="glyphicon glyphicon-trash"></i>'), array('plugin' => 'dictionary', 'controller' => 'currencies', 'action' => 'delete', $currency['Currency']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('delete')), __('are_you_sure_to_delete', $currency['Currency']['id'])); ?>
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

<script type="text/javascript">
	$(document).ready(function(){
		COMMON.module_name = '_currencies';
		COMMON.url_update_cache = '<?= Router::url(array('prefix' => 'admin', 'plugin' => '', 'controller' => 'redis', 'action' => 'update_column_cache'), true) ?>';
		COMMON.column_cache = <?= $column_cache; ?>;
        COMMON.init_visible_column_table();
    });
</script>