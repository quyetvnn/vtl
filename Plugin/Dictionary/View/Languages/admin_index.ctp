<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('dictionary','languages'); ?></h3>
				
				<div class="box-tools pull-right">
					<?php if(isset($permissions['Language']['add']) && ($permissions['Language']['add'] == true)){  
                        echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> '.__d('dictionary','add_language'), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); 
                    } ?>
				</div>
			</div>	

			<div class="box-body table-responsive">
				<table id="Languages" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id',__d('dictionary','id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('alias',__d('dictionary','alias')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('is_default',__('is_default')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('enabled',__('enabled')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('updated',__('updated')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('created',__('created')); ?></th>
							<th class="text-center"><?php echo __('operation'); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($languages as $language): ?>
							<tr>
								<td class="text-center"><?php echo h($language['Language']['id']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($language['Language']['alias']); ?>&nbsp;</td>
								<td class="text-center">
									<?php echo $this->element('view_check_ico',array('_check'=>$language['Language']['is_default'])) ?>
								</td>
								<td class="text-center">
									<?php echo $this->element('view_check_ico',array('_check'=>$language['Language']['enabled'])) ?>
								</td>
								<td class="text-center"><?php echo h($language['Language']['updated']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($language['Language']['created']); ?>&nbsp;</td>
								<td class="text-center">
									<?php echo $this->Html->link(__('<i class="fa fa-eercast"></i>'), array('plugin' => 'dictionary', 'controller' => 'languages', 'action' => 'view', $language['Language']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('view'))); ?>
									<?php if(isset($permissions['Language']['edit']) && ($permissions['Language']['edit'] == true)){ ?>
                                        <?php echo $this->Html->link(__('<i class="fa fa-pencil"></i>'), array('plugin' => 'dictionary', 'controller' => 'languages', 'action' => 'edit', $language['Language']['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('edit'))); ?>
                                    <?php } ?>
                                    <?php if(isset($permissions['Language']['delete']) && ($permissions['Language']['delete'] == true)){ ?>
                                        <?php echo $this->Form->postLink(__('<i class="glyphicon glyphicon-trash"></i>'), array('plugin' => 'dictionary', 'controller' => 'languages', 'action' => 'delete', $language['Language']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('delete')), __('are_you_sure_to_delete', $language['Language']['id'])); ?>
									<?php } ?>
									<?php echo $this->Form->postLink(__('<i class="glyphicon glyphicon-export"></i>'), array('plugin' => 'dictionary', 'controller' => 'languages', 'action' => 'export', $language['Language']['id']), array('class' => 'btn btn-success btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('export')), ""); ?>
									<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-import"></i>'), array('plugin' => 'dictionary', 'controller' => 'languages', 'action' => 'import', $language['Language']['id']), array('class' => 'btn btn-success btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('import')), ""); ?>
									<?php echo $this->Form->postLink(__('<i class="glyphicon glyphicon-question-sign"></i>'), array('plugin' => 'dictionary', 'controller' => 'languages', 'action' => 'validate', $language['Language']['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('validation')), ""); ?>
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
        COMMON.init_visible_column_table();
    });
</script>