<?= $this->Html->css('datatables/dataTables.bootstrap'); ?>

<div class="row">
	<div class="col-xs-12">
		<?php
			echo $this->element('Dictionary.vocabulary_filter', array(
			));
		?>
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?= __('vocabularies'); ?></h3>
				
				<div class="box-tools pull-right">
					<?php if(isset($permissions['Vocabulary']['add']) && ($permissions['Vocabulary']['add'] == true)){ 
                        echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> '.__d('dictionary', 'add_vocabulary'), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); 
                    } ?>
				</div>
			</div>	

			<div class="box-body table-responsive">
				<table id="Vocabularies" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?= $this->Paginator->sort('id',__d('dictionary','id')); ?></th>
							<th class="text-center"><?= $this->Paginator->sort('parent_id',__d('dictionary','parent_id')); ?></th>
							<th class="text-center"><?= $this->Paginator->sort('slug',__d('dictionary','slug')); ?></th>
							<th class="text-center"><?= $this->Paginator->sort('name',__d('dictionary','name')); ?></th>
							<th class="text-center"><?= $this->Paginator->sort('enabled',__('enabled')); ?></th>
							<th class="text-center"><?= $this->Paginator->sort('updated',__('updated')); ?></th>
							<th class="text-center"><?= $this->Paginator->sort('created',__('created')); ?></th>
							<th class="text-center"><?= __('operation'); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($vocabularies as $vocabulary): ?>
							<tr>
								<td class="text-center"><?= h($vocabulary['Vocabulary']['id']); ?></td>
								<td class="text-center">
									<?= $this->Html->link($vocabulary['ParentVocabulary']['name'], array('plugin' => 'dictionary', 'controller' => 'vocabularies', 'action' => 'view', $vocabulary['Vocabulary']['id'])); ?>
								</td>
								<td class="text-center"><?= h($vocabulary['Vocabulary']['slug']); ?></td>
								<td class="text-center"><?= reset($vocabulary['VocabularyLanguage']) ? h(reset($vocabulary['VocabularyLanguage'])['name']) : ''; ?></td>
								<td class="text-center"> <?= $this->element('view_check_ico',array('_check'=>$vocabulary['Vocabulary']['enabled'])) ?> </td>
								<td class="text-center"><?= h($vocabulary['Vocabulary']['updated']); ?></td>
								<td class="text-center"><?= h($vocabulary['Vocabulary']['created']); ?></td>
								<td class="text-center">
									<?= $this->Html->link(__('<i class="fa fa-eercast"></i>'), array('plugin' => 'dictionary', 'controller' => 'vocabularies', 'action' => 'view', $vocabulary['Vocabulary']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('view'))); ?>
									<?php if(isset($permissions['Vocabulary']['edit']) && ($permissions['Vocabulary']['edit'] == true)){ ?>
                                        <?= $this->Html->link(__('<i class="fa fa-pencil"></i>'), array('plugin' => 'dictionary', 'controller' => 'vocabularies', 'action' => 'edit', $vocabulary['Vocabulary']['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('edit'))); ?>
                                    <?php } ?>
                                    <?php if(isset($permissions['Vocabulary']['delete']) && ($permissions['Vocabulary']['delete'] == true)){ ?>
                                        <?= $this->Form->postLink(__('<i class="glyphicon glyphicon-trash"></i>'), array('plugin' => 'dictionary', 'controller' => 'vocabularies', 'action' => 'delete', $vocabulary['Vocabulary']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('delete')), __('are_you_sure_to_delete', $vocabulary['Vocabulary']['id'])); ?>
                                    <?php } ?>
                                </td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->
		</div><!-- /.index -->
		
		<?= $this->element('Paginator'); ?>	</div><!-- /#page-content .col-sm-9 -->
</div><!-- /#page-container .row-fluid -->

<?php
	echo $this->Html->script('plugins/datatables/jquery.dataTables');
	echo $this->Html->script('plugins/datatables/dataTables.bootstrap');
?>

<script type="text/javascript">
	$(document).ready(function(){
		COMMON.module_name = '_vocabularies';
		COMMON.url_update_cache = '<?= Router::url(array('prefix' => 'admin', 'plugin' => '', 'controller' => 'redis', 'action' => 'update_column_cache'), true) ?>';
		COMMON.column_cache = <?= $column_cache; ?>;
        COMMON.init_visible_column_table();
    });
</script>