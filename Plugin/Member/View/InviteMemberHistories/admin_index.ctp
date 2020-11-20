<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>

<?= $this->element('Member.InviteMemberHistory_filter', array(
	'data_search' => $data_search
)); ?>

<div class="row">
    <div class="col-xs-12">

    <div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo __d('member', 'invite_member_histories'); ?></h3>
			<div class="box-tools pull-right">
                <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-plus"></i>') . __('add'), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
            </div>
		</div>	
			<div class="box-body table-responsive">
                <table id="InviteMemberHistories" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id', 		__('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('school_id', 	__d('school', 'school')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('role_id', 	__d('administration', 'role')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('email', 		__d('member', 'email')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('verified', 	__d('member', 'verified')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('created',	__('created')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('updated',	__('updated')); ?></th>
						
						</tr>
					</thead>
					<tbody>
					<?php foreach ($inviteMemberHistories as $inviteMemberHistory): ?>
						<tr>
							<td class="text-center"><?php echo h($inviteMemberHistory['InviteMemberHistory']['id']); ?>&nbsp;</td>
							<td class="text-center">
								<?php 
									if (isset($inviteMemberHistory['School']['SchoolLanguage'])) {
										echo $this->Html->link(
											reset($inviteMemberHistory['School']['SchoolLanguage'])['name'] .  " (" . $inviteMemberHistory['School']['school_code'] . ")"
											
											, array('plugin' => 'school', 'controller' => 'schools', 'action' => 'view', $inviteMemberHistory['InviteMemberHistory']['school_id']));
									}
								?>
							</td>
							<td class="text-center">
								<?php 
									if (isset($inviteMemberHistory['Role']['RoleLanguage'])) {
										echo (reset($inviteMemberHistory['Role']['RoleLanguage'])['name']);
									}
								?>&nbsp;
								
							</td>
							</td>
							<td class="text-center"><?php echo h($inviteMemberHistory['InviteMemberHistory']['email']); ?>&nbsp;</td>
							
							<td class="text-center">
								<?= $this->element('view_check_ico',array('_check'=>$inviteMemberHistory['InviteMemberHistory']['verified'])) ?>
							</td>

							<td class="text-center"><?php echo h($inviteMemberHistory['InviteMemberHistory']['created']); ?>&nbsp;</td>
							<td class="text-center"><?php echo h($inviteMemberHistory['InviteMemberHistory']['updated']); ?>&nbsp;</td>
							<!-- <td class="text-center">
								<?php // echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('action' => 'view', $inviteMemberHistory['InviteMemberHistory']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('view'))); ?>
								<?php // echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>'), array('action' => 'edit', $inviteMemberHistory['InviteMemberHistory']['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('edit'))); ?>
								<?php // echo $this->Form->postLink(__('<i class="glyphicon glyphicon-trash"></i>'), array('action' => 'delete', $inviteMemberHistory['InviteMemberHistory']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('delete')), __('Are you sure you want to delete # %s?', $inviteMemberHistory['InviteMemberHistory']['id'])); ?>
							</td> -->
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->
			
			
		</div><!-- /.index -->
	
	</div><!-- /#page-content .col-sm-9 -->
	<?php  echo $this->element('Paginator'); ?>	</div><!-- /#page-content .col-sm-9 -->
</div><!-- /#page-container .row-fluid -->

<?php
	// echo $this->Html->script('jquery.min');
	echo $this->Html->script('plugins/datatables/jquery.dataTables');
	echo $this->Html->script('plugins/datatables/dataTables.bootstrap');
?>
<script type="text/javascript">
    // $(function() {
    //     $("#InviteMemberHistories").dataTable();
    // });
</script>