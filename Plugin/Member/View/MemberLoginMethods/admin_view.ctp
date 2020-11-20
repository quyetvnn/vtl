
<div class="row">
    <div class="col-xs-12">
		
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __('Member Login Method'); ?></h3>
				<div class="box-tools pull-right">
	                <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>' . __('edit')), array('action' => 'edit', $memberLoginMethod['MemberLoginMethod']['id']), array('class' => 'btn btn-primary', 'escape' => false)); ?>
	            </div>
			</div>
			
			<div class="box-body table-responsive">
                <table id="MemberLoginMethods" class="table table-bordered table-striped">
					<tbody>
						<tr>		<td><strong><?php echo __('Id'); ?></strong></td>
		<td>
			<?php echo h($memberLoginMethod['MemberLoginMethod']['id']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Member'); ?></strong></td>
		<td>
			<?php echo $this->Html->link($memberLoginMethod['Member']['id'], array('controller' => 'members', 'action' => 'view', $memberLoginMethod['Member']['id']), array('class' => '')); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Username'); ?></strong></td>
		<td>
			<?php echo h($memberLoginMethod['MemberLoginMethod']['username']); ?>
			&nbsp;
		</td>
</tr>

<tr>		<td><strong><?php echo __('Password'); ?></strong></td>
		<td>
			<?php echo h($memberLoginMethod['MemberLoginMethod']['password']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Token'); ?></strong></td>
		<td>
			<?php echo h($memberLoginMethod['MemberLoginMethod']['token']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Enabled'); ?></strong></td>
		<td>
			<?php echo h($memberLoginMethod['MemberLoginMethod']['enabled']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Login Method'); ?></strong></td>
		<td>
			<?php echo $this->Html->link($memberLoginMethod['LoginMethod']['name'], array('controller' => 'login_methods', 'action' => 'view', $memberLoginMethod['LoginMethod']['id']), array('class' => '')); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
		<td>
			<?php echo h($memberLoginMethod['MemberLoginMethod']['created']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Updated'); ?></strong></td>
		<td>
			<?php echo h($memberLoginMethod['MemberLoginMethod']['updated']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Created By'); ?></strong></td>
		<td>
			<?php echo h($memberLoginMethod['MemberLoginMethod']['created_by']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Updated By'); ?></strong></td>
		<td>
			<?php echo h($memberLoginMethod['MemberLoginMethod']['updated_by']); ?>
			&nbsp;
		</td>
</tr>					</tbody>
				</table><!-- /.table table-striped table-bordered -->
			</div><!-- /.table-responsive -->
			
		</div><!-- /.view -->

			
	</div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->

