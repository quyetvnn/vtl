<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>

<?= $this->element('School.SchoolClass_filter', array(
	'data_search' => $data_search
)); ?>


<div class="row">
    <div class="col-xs-12">

    <div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo __d('school', 'school_classes'); ?></h3>
			<div class="box-tools pull-right">
                <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-plus"></i>')  . __('add'), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
            </div>
		</div>	
			<div class="box-body table-responsive">
                <table id="SchoolClasses" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id', 		__('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('school_id', 	__d('school', 'school')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('name',		__('name'));  ?></th>
							<!-- <th class="text-center"><?php //echo $this->Paginator->sort('level',		__d('school', 'level'));  ?></th>
							<th class="text-center"><?php // echo $this->Paginator->sort('created',		__('created'));  ?></th>
							<th class="text-center"><?php //echo $this->Paginator->sort('created_by',		__('created_by'));  ?></th> -->
							<th class="text-center"><?php echo __('operation'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($schoolClasses as $schoolClass): ?>
							<tr>
							
								<td class="text-center"><?php echo h($schoolClass['SchoolClass']['id']); ?>&nbsp;</td>
								<td class="text-center">
									<?php 
									
										if (isset($schoolClass['School']['SchoolLanguage'])) {
											echo $this->Html->link(
												reset($schoolClass['School']['SchoolLanguage'])['name'] . " (" . $schoolClass['School']['school_code'] . ")", array('plugin' => 'school', 'controller' => 'schools', 'action' => 'view', $schoolClass['School']['id'])); 
										}
									?>
								</td>

								<td class="text-center"><?php echo h($schoolClass['SchoolClass']['name']); ?>&nbsp;</td>
								<!-- <td class="text-center">
									<?= $this->element('view_check_ico',array('_check'=>$schoolClass['SchoolClass']['enabled'])) ?>
								</td>
								 -->
								<!-- <td class="text-center"><?php //echo h($schoolClass['SchoolClass']['level']); ?>&nbsp;</td>
								<td class="text-center"><?php //echo h($schoolClass['SchoolClass']['created']); ?>&nbsp;</td>
								<td class="text-center"><?php //echo h($schoolClass['CreatedBy']['email']); ?>&nbsp;</td> -->
								<td class="text-center">
									<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('action' => 'view', $schoolClass['SchoolClass']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('view'))); ?>
									<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>'), array('action' => 'edit', $schoolClass['SchoolClass']['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('edit'))); ?>
									<?php echo $this->Form->postLink(__('<i class="glyphicon glyphicon-trash"></i>'), array('action' => 'delete', $schoolClass['SchoolClass']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('delete')), __('Are you sure you want to delete # %s?', $schoolClass['SchoolClass']['id'])); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->
			
			
		</div><!-- /.index -->
	
	</div><!-- /#page-content .col-sm-9 -->
	<?php echo $this->element('Paginator'); ?>	</div><!-- /#page-content .col-sm-9 -->
</div><!-- /#page-container .row-fluid -->

<?php
	// echo $this->Html->script('jquery.min');
	// echo $this->Html->script('plugins/datatables/jquery.dataTables');
	// echo $this->Html->script('plugins/datatables/dataTables.bootstrap');
?>
<script type="text/javascript">
    // $(function() {
    //     $("#SchoolClasses").dataTable();
    // });
</script>