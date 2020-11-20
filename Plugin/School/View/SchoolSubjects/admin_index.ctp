<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>

<?= $this->element('School.SchoolSubject_filter', array(
	'data_search' => $data_search
)); ?>

<div class="row">
    <div class="col-xs-12">

    <div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo __d('school', 'school_subjects'); ?></h3>
			<div class="box-tools pull-right">
                <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-plus"></i>' . __('add')), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
            </div>
		</div>	
			<div class="box-body table-responsive">
                <table id="SchoolSubjects" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id', 		__('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('school_id',	__d('school', 'school')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('name',		__d('member', 'subject')); ?></th>
							<!-- <th class="text-center"><?php echo $this->Paginator->sort('created',	__('created')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('created_by',	__('created_by')); ?></th> -->
							<th class="text-center"><?php echo __('operation'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($schoolSubjects as $schoolSubject): ?>
						<tr>
							<td class="text-center"><?php echo h($schoolSubject['SchoolSubject']['id']); ?>&nbsp;</td>
							<td class="text-center">
								<?php 
									echo $this->Html->link(reset($schoolSubject['School']['SchoolLanguage'])['name'] . " (" . $schoolSubject['School']['school_code'] . ")", array('controller' => 'schools', 'action' => 'view', $schoolSubject['School']['id'])); ?>
							</td>
							<td class="text-center">
								<?php 
									if (isset($schoolSubject['SchoolSubjectLanguage'])) {
										echo h($schoolSubject['SchoolSubjectLanguage']['name']); 
									}
								?>
								&nbsp;
							</td>
						
							<!-- <td class="text-center">
								<?php //echo h($schoolSubject['SchoolSubject']['created']); ?>&nbsp;
							</td> -->
							<td class="text-center">
								<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('action' => 'view', $schoolSubject['SchoolSubject']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('view'))); ?>
								<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>'), array('action' => 'edit', $schoolSubject['SchoolSubject']['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('edit'))); ?>
								<?php echo $this->Form->postLink(__('<i class="glyphicon glyphicon-trash"></i>'), array('action' => 'delete', $schoolSubject['SchoolSubject']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('delete')), __('Are you sure you want to delete # %s?', $schoolSubject['SchoolSubject']['id'])); ?>
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
    $(function() {
       // $("#SchoolSubjects").dataTable();
    });
</script>