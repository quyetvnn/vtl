
<div class="row">
    <div class="col-xs-12">
		
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __('Member'); ?></h3>
				<div class="box-tools pull-right">
	                <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>' . __('edit')), array('action' => 'edit', $member['Member']['id']), array('class' => 'btn btn-primary', 'escape' => false)); ?>
	            </div>
			</div>
			
			<div class="box-body table-responsive">
                <table id="Members" class="table table-bordered table-striped">
					<tbody>
						<tr>		<td><strong><?php echo __('Id'); ?></strong></td>
		<td>
			<?php echo h($member['Member']['id']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Username'); ?></strong></td>
		<td>
			<?php echo h($member['Member']['username']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Password'); ?></strong></td>
		<td>
			<?php echo h($member['Member']['password']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Register Code'); ?></strong></td>
		<td>
			<?php echo h($member['Member']['register_code']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Verified'); ?></strong></td>
		<td>
			<?php echo h($member['Member']['verified']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Email'); ?></strong></td>
		<td>
			<?php echo h($member['Member']['email']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Phone Number'); ?></strong></td>
		<td>
			<?php echo h($member['Member']['phone_number']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Join Day'); ?></strong></td>
		<td>
			<?php echo h($member['Member']['join_day']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Invitation Code'); ?></strong></td>
		<td>
			<?php echo h($member['Member']['invitation_code']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
		<td>
			<?php echo h($member['Member']['created']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Created By'); ?></strong></td>
		<td>
			<?php echo $this->Html->link($member['CreatedBy']['name'], array('controller' => 'administrators', 'action' => 'view', $member['CreatedBy']['id']), array('class' => '')); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Updated'); ?></strong></td>
		<td>
			<?php echo h($member['Member']['updated']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Updated By'); ?></strong></td>
		<td>
			<?php echo $this->Html->link($member['UpdatedBy']['name'], array('controller' => 'administrators', 'action' => 'view', $member['UpdatedBy']['id']), array('class' => '')); ?>
			&nbsp;
		</td>
</tr>					</tbody>
				</table><!-- /.table table-striped table-bordered -->
			</div><!-- /.table-responsive -->
			
		</div><!-- /.view -->

					
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title"><?php echo __('Related Member Languages'); ?></h3>
					<div class="box-tools pull-right">
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> '.__('New Member Language'), array('controller' => 'member_languages', 'action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); ?>					</div><!-- /.actions -->
				</div>
				<?php if (!empty($member['MemberLanguage'])): ?>
					
					<div class="box-body table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
											<th class="text-center"><?php echo __('Id'); ?></th>
		<th class="text-center"><?php echo __('Member Id'); ?></th>
		<th class="text-center"><?php echo __('Alias'); ?></th>
		<th class="text-center"><?php echo __('Name'); ?></th>
		<th class="text-center"><?php echo __('First Name'); ?></th>
		<th class="text-center"><?php echo __('Last Name'); ?></th>
									<th class="text-center"><?php echo __('Actions'); ?></th>
								</tr>
							</thead>
							<tbody>
									<?php
										$i = 0;
										foreach ($member['MemberLanguage'] as $memberLanguage): ?>
		<tr>
			<td class="text-center"><?php echo $memberLanguage['id']; ?></td>
			<td class="text-center"><?php echo $memberLanguage['member_id']; ?></td>
			<td class="text-center"><?php echo $memberLanguage['alias']; ?></td>
			<td class="text-center"><?php echo $memberLanguage['name']; ?></td>
			<td class="text-center"><?php echo $memberLanguage['first_name']; ?></td>
			<td class="text-center"><?php echo $memberLanguage['last_name']; ?></td>
			<td class="text-center">
				<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('controller' => 'member_languages', 'action' => 'view', $memberLanguage['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('view'))); ?>
				<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>'), array('controller' => 'member_languages', 'action' => 'edit', $memberLanguage['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('edit'))); ?>
				<?php echo $this->Form->postLink(__('<i class="glyphicon glyphicon-trash"></i>'), array('controller' => 'member_languages', 'action' => 'delete', $memberLanguage['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('delete')), __('Are you sure you want to delete # %s?', $memberLanguage['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
							</tbody>
						</table><!-- /.table table-striped table-bordered -->
					</div><!-- /.table-responsive -->
					
				<?php endif; ?>

				
				
			</div><!-- /.related -->

					
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title"><?php echo __('Related Member Login Methods'); ?></h3>
					<div class="box-tools pull-right">
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> '.__('New Member Login Method'), array('controller' => 'member_login_methods', 'action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); ?>					</div><!-- /.actions -->
				</div>
				<?php if (!empty($member['MemberLoginMethod'])): ?>
					
					<div class="box-body table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
											<th class="text-center"><?php echo __('Id'); ?></th>
		<th class="text-center"><?php echo __('Member Id'); ?></th>
		<th class="text-center"><?php echo __('Username'); ?></th>
		<th class="text-center"><?php echo __('Password'); ?></th>
		<th class="text-center"><?php echo __('Token'); ?></th>
		<th class="text-center"><?php echo __('Enabled'); ?></th>
		<th class="text-center"><?php echo __('Login Method Id'); ?></th>
		<th class="text-center"><?php echo __('Created'); ?></th>
		<th class="text-center"><?php echo __('Updated'); ?></th>
		<th class="text-center"><?php echo __('Created By'); ?></th>
		<th class="text-center"><?php echo __('Updated By'); ?></th>
									<th class="text-center"><?php echo __('Actions'); ?></th>
								</tr>
							</thead>
							<tbody>
									<?php
										$i = 0;
										foreach ($member['MemberLoginMethod'] as $memberLoginMethod): ?>
		<tr>
			<td class="text-center"><?php echo $memberLoginMethod['id']; ?></td>
			<td class="text-center"><?php echo $memberLoginMethod['member_id']; ?></td>
			<td class="text-center"><?php echo $memberLoginMethod['username']; ?></td>
			<td class="text-center"><?php echo $memberLoginMethod['password']; ?></td>
			<td class="text-center"><?php echo $memberLoginMethod['token']; ?></td>
			<td class="text-center"><?php echo $memberLoginMethod['enabled']; ?></td>
			<td class="text-center"><?php echo $memberLoginMethod['login_method_id']; ?></td>
			<td class="text-center"><?php echo $memberLoginMethod['created']; ?></td>
			<td class="text-center"><?php echo $memberLoginMethod['updated']; ?></td>
			<td class="text-center"><?php echo $memberLoginMethod['created_by']; ?></td>
			<td class="text-center"><?php echo $memberLoginMethod['updated_by']; ?></td>
			<td class="text-center">
				<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('controller' => 'member_login_methods', 'action' => 'view', $memberLoginMethod['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('view'))); ?>
				<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>'), array('controller' => 'member_login_methods', 'action' => 'edit', $memberLoginMethod['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('edit'))); ?>
				<?php echo $this->Form->postLink(__('<i class="glyphicon glyphicon-trash"></i>'), array('controller' => 'member_login_methods', 'action' => 'delete', $memberLoginMethod['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('delete')), __('Are you sure you want to delete # %s?', $memberLoginMethod['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
							</tbody>
						</table><!-- /.table table-striped table-bordered -->
					</div><!-- /.table-responsive -->
					
				<?php endif; ?>

				
				
			</div><!-- /.related -->

					
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title"><?php echo __('Related Member Roles'); ?></h3>
					<div class="box-tools pull-right">
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> '.__('New Member Role'), array('controller' => 'member_roles', 'action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); ?>					</div><!-- /.actions -->
				</div>
				<?php if (!empty($member['MemberRole'])): ?>
					
					<div class="box-body table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
											<th class="text-center"><?php echo __('Id'); ?></th>
		<th class="text-center"><?php echo __('Member Id'); ?></th>
		<th class="text-center"><?php echo __('Role Id'); ?></th>
		<th class="text-center"><?php echo __('Enabled'); ?></th>
		<th class="text-center"><?php echo __('Created'); ?></th>
		<th class="text-center"><?php echo __('Updated'); ?></th>
		<th class="text-center"><?php echo __('Created By'); ?></th>
		<th class="text-center"><?php echo __('Updated By'); ?></th>
									<th class="text-center"><?php echo __('Actions'); ?></th>
								</tr>
							</thead>
							<tbody>
									<?php
										$i = 0;
										foreach ($member['MemberRole'] as $memberRole): ?>
		<tr>
			<td class="text-center"><?php echo $memberRole['id']; ?></td>
			<td class="text-center"><?php echo $memberRole['member_id']; ?></td>
			<td class="text-center"><?php echo $memberRole['role_id']; ?></td>
			<td class="text-center"><?php echo $memberRole['enabled']; ?></td>
			<td class="text-center"><?php echo $memberRole['created']; ?></td>
			<td class="text-center"><?php echo $memberRole['updated']; ?></td>
			<td class="text-center"><?php echo $memberRole['created_by']; ?></td>
			<td class="text-center"><?php echo $memberRole['updated_by']; ?></td>
			<td class="text-center">
				<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('controller' => 'member_roles', 'action' => 'view', $memberRole['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('view'))); ?>
				<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>'), array('controller' => 'member_roles', 'action' => 'edit', $memberRole['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('edit'))); ?>
				<?php echo $this->Form->postLink(__('<i class="glyphicon glyphicon-trash"></i>'), array('controller' => 'member_roles', 'action' => 'delete', $memberRole['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('delete')), __('Are you sure you want to delete # %s?', $memberRole['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
							</tbody>
						</table><!-- /.table table-striped table-bordered -->
					</div><!-- /.table-responsive -->
					
				<?php endif; ?>

				
				
			</div><!-- /.related -->

			
	</div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->

