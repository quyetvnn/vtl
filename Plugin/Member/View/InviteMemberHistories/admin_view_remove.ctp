
<div class="row">
    <div class="col-xs-12">
		
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __('Invite Member History'); ?></h3>
				<div class="box-tools pull-right">
	                <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>' . __('edit')), array('action' => 'edit', $inviteMemberHistory['InviteMemberHistory']['id']), array('class' => 'btn btn-primary', 'escape' => false)); ?>
	            </div>
			</div>
			
			<div class="box-body table-responsive">
                <table id="InviteMemberHistories" class="table table-bordered table-striped">
					<tbody>
						<tr>		<td><strong><?php echo __('Id'); ?></strong></td>
		<td>
			<?php echo h($inviteMemberHistory['InviteMemberHistory']['id']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('School'); ?></strong></td>
		<td>
			<?php echo $this->Html->link($inviteMemberHistory['School']['id'], array('controller' => 'schools', 'action' => 'view', $inviteMemberHistory['School']['id']), array('class' => '')); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Email'); ?></strong></td>
		<td>
			<?php echo h($inviteMemberHistory['InviteMemberHistory']['email']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Verified'); ?></strong></td>
		<td>
			<?php echo h($inviteMemberHistory['InviteMemberHistory']['verified']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Role'); ?></strong></td>
		<td>
			<?php echo $this->Html->link($inviteMemberHistory['Role']['name'], array('controller' => 'roles', 'action' => 'view', $inviteMemberHistory['Role']['id']), array('class' => '')); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
		<td>
			<?php echo h($inviteMemberHistory['InviteMemberHistory']['created']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Updated'); ?></strong></td>
		<td>
			<?php echo h($inviteMemberHistory['InviteMemberHistory']['updated']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Created By'); ?></strong></td>
		<td>
			<?php echo h($inviteMemberHistory['InviteMemberHistory']['created_by']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Updated By'); ?></strong></td>
		<td>
			<?php echo h($inviteMemberHistory['InviteMemberHistory']['updated_by']); ?>
			&nbsp;
		</td>
</tr>					</tbody>
				</table><!-- /.table table-striped table-bordered -->
			</div><!-- /.table-responsive -->
			
		</div><!-- /.view -->

			
	</div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->

