
<div class="row">
    <div class="col-xs-12">
		
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __('Import Student History'); ?></h3>
				<div class="box-tools pull-right">
	                <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>' . __('edit')), array('action' => 'edit', $importStudentHistory['ImportStudentHistory']['id']), array('class' => 'btn btn-primary', 'escape' => false)); ?>
	            </div>
			</div>
			
			<div class="box-body table-responsive">
                <table id="ImportStudentHistories" class="table table-bordered table-striped">
					<tbody>
						<tr>		<td><strong><?php echo __('Id'); ?></strong></td>
		<td>
			<?php echo h($importStudentHistory['ImportStudentHistory']['id']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('School'); ?></strong></td>
		<td>
			<?php echo $this->Html->link($importStudentHistory['School']['id'], array('controller' => 'schools', 'action' => 'view', $importStudentHistory['School']['id']), array('class' => '')); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Content'); ?></strong></td>
		<td>
			<?php echo h($importStudentHistory['ImportStudentHistory']['content']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Path'); ?></strong></td>
		<td>
			<?php echo h($importStudentHistory['ImportStudentHistory']['path']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
		<td>
			<?php echo h($importStudentHistory['ImportStudentHistory']['created']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Updated'); ?></strong></td>
		<td>
			<?php echo h($importStudentHistory['ImportStudentHistory']['updated']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Created By'); ?></strong></td>
		<td>
			<?php echo h($importStudentHistory['ImportStudentHistory']['created_by']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Updated By'); ?></strong></td>
		<td>
			<?php echo h($importStudentHistory['ImportStudentHistory']['updated_by']); ?>
			&nbsp;
		</td>
</tr>					</tbody>
				</table><!-- /.table table-striped table-bordered -->
			</div><!-- /.table-responsive -->
			
		</div><!-- /.view -->

			
	</div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->

