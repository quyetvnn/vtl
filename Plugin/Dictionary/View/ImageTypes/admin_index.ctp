<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>

<div class="row">
	<div class="col-xs-12">
	<?php
		/**
		 * Filter panel
		 */
		echo $this->element('Dictionary.imagetypes_filter', array());
	?>
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('dictionary','image_types'); ?></h3>
				
				<div class="box-tools pull-right">
                    <?php 
                    if(isset($permissions['ImageType']['add']) && ($permissions['ImageType']['add'] == true)){ 
                        echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> '.__d('dictionary','add_image_type'), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); 
                    } 
                    ?>
				</div>
			</div>	

			<div class="box-body table-responsive">
				<table id="ImageTypes" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id',__d('dictionary','id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('slug',__d('dictionary','slug')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('name',__d('dictionary','name')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('enabled',__('enabled')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('updated',__('updated')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('created',__('created')); ?></th>
							<th class="text-center"><?php echo __('operation'); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($imageTypes as $imageType): ?>  <!-- imageTypes -->
							<tr>
								<td class="text-center"><?php echo h($imageType['ImageType']['id']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($imageType['ImageType']['slug']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($imageType['ImageTypeLanguage'][0]['name']); ?>&nbsp;</td>
								<td class="text-center">
								<?php echo $this->element('view_check_ico',array('_check'=>$imageType['ImageType']['enabled'])); ?>&nbsp;
								</td>
								<td class="text-center"><?php echo h($imageType['ImageType']['updated']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($imageType['ImageType']['created']); ?>&nbsp;</td>
								<td class="text-center">
									<?php echo $this->Html->link(__('<i class="fa fa-eercast"></i>'), array('plugin' => 'dictionary', 'controller' => 'image_types', 'action' => 'view', $imageType['ImageType']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('view'))); ?>
                                    <?php if(isset($permissions['ImageType']['edit']) && ($permissions['ImageType']['edit'] == true)){ ?>
                                        <?php echo $this->Html->link(__('<i class="fa fa-pencil"></i>'), array('plugin' => 'dictionary', 'controller' => 'image_types', 'action' => 'edit', $imageType['ImageType']['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('edit'))); ?>
                                    <?php } ?>
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
	$(document).ready(function(){
        COMMON.init_visible_column_table();
    });
</script>