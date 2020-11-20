<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>
<div class="row">
    <div class="col-xs-12">

    <div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo __d('member', 'import_histories'); ?></h3>
		
		</div>	
			<div class="box-body table-responsive">
                <table id="ImportStudentHistories" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id', 	__('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('school_id',	__d('school', 'school')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('role_id',	__d('administration', 'role')); ?></th>
							
							<th class="text-center"><?php echo $this->Paginator->sort('path',		__('path')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('message',	__d('member', 'message')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('created',	__('created')); ?></th>
												
						</tr>
					</thead>
					<tbody>
					<?php foreach ($importStudentHistories as $importHistory): ?>
					<tr>
						<td class="text-center"><?php echo h($importHistory['ImportHistory']['id']); ?>&nbsp;</td>


						<td class="text-center">
							<?php 
							
								if (isset($importHistory['School']['SchoolLanguage'])) {
									echo $this->Html->link(
										reset($importHistory['School']['SchoolLanguage'])['name']  . " (" . $importHistory['School']['school_code'] . ")", 
											array('plugin' => 'school', 'controller' => 'school', 'controller' => 'schools', 'action' => 'view', $importHistory['ImportHistory']['school_id'])); 
								}
							?>
						</td>

						<td class="text-center">
							<?php 
								if (isset($importHistory['Role']['RoleLanguage'])) {
									echo reset($importHistory['Role']['RoleLanguage'])['name'];
								}
							?>
						
						</td>
						<td><?php echo h($importHistory['ImportHistory']['path']); ?>&nbsp;</td>
						<td><?php echo html_entity_decode($importHistory['ImportHistory']['message']) ?></td>
						<td class="text-center"><?php echo h($importHistory['ImportHistory']['created']); ?>&nbsp;</td>
						
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
	// echo $this->Html->script('jquery-ui.min');
	// echo $this->Html->script('plugins/datatables/jquery.dataTables');
	// echo $this->Html->script('plugins/datatables/dataTables.bootstrap');
?>
<script type="text/javascript">
    // $(function() {
    //     $("#ImportStudentHistories").dataTable();
    // });
</script>