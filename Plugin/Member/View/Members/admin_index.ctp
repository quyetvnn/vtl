<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>

<?= $this->element('Member.Member_filter', array(
	'data_search' => $data_search
)); ?>


<div class="row">
    <div class="col-xs-12">

    <div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo __d('member', 'members'); ?></h3>
			<div class="box-tools pull-right">
                <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-plus"></i>') . __('add'), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
            </div>
		</div>	
			<div class="box-body table-responsive">
                <table id="Members" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id',				__('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('username', 		__d('member', 'username')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('facebook_id',	__d('member', 'facebook')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('google_id',		__d('member', 'google')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('school_name',	__d('school', 'school')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('role',			__d('administration', 'role')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('register_code',	__d('member', 'register_code')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('verified',  		__d('member', 'verified')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('email',			__d('member', 'email')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('phone_number',	__d('member', 'phone_number')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('join_day',		__d('member', 'join_day')); ?></th>
							<!-- <th class="text-center"><?php //echo $this->Paginator->sort('invitation_code', __d('member', 'invitation_code')); ?></th> -->
							<th class="text-center"><?php echo $this->Paginator->sort('created',		__('created')); ?></th>
							<!-- <th class="text-center"><?php echo __('operation'); ?></th> -->
						</tr>
					</thead>
					<tbody>
					<?php foreach ($members as $member):  ?>
						<tr>
							<td class="text-center"><?php echo h($member['Member']['id']); ?>&nbsp;</td>
							<td class="text-center">
								<?= isset($member['MemberLoginMethodT']['username']) ?   $member['MemberLoginMethodT']['username'] : ''; ?>&nbsp;
							</td>
							<td class="text-center"><?php echo h($member['Member']['facebook_id']); ?>&nbsp;</td>
							<td class="text-center"><?php echo h($member['Member']['google_id']); ?>&nbsp;</td>
							<td>
								
								<ul>
									<?php 
										foreach ($schools as $k => $v) {
											if ($k == $member['MemberLoginMethodT']['school_id']) { ?>
												<li> <?php echo $v ?> </li>
											<?php }
										} 
									?>
									&nbsp;
								</ul>
							</td>

							<td> 
								<ul  style='text-align: left;'>
								<?php
									$same = array();
									$display_role = array();
									if (isset($member['MemberRole'])) {
										foreach ($member['MemberRole'] as $role) {

											if (isset($role['Role']['id']) && !in_array($role['Role']['id'], $same)) { ?>
												<li> 
													<?php 
														if (isset($role['Role']['RoleLanguage'])) {
															echo (reset($role['Role']['RoleLanguage'])['name']); 
														
														} 
													?>
												</li>
												<?php $same[] = $role['Role']['id'];
											}
										
										}
									}

									echo implode(", ", $display_role);
									
								?>&nbsp;
								</ul>
							
							</td>


							<td class="text-center"><?php echo h($member['Member']['register_code']); ?>&nbsp;</td>
							
							<td class="text-center">
								<?= $this->element('view_check_ico',array('_check'=>$member['Member']['verified'])) ?>
							</td>

							<td class="text-center"><?php echo h($member['Member']['email']); ?>&nbsp;</td>
							<td class="text-center"><?php echo h($member['Member']['phone_number']); ?>&nbsp;</td>
							<td class="text-center"><?php echo h($member['Member']['join_day']); ?>&nbsp;</td>
							<!-- <td class="text-center"><?php //echo h($member['Member']['invitation_code']); ?>&nbsp;</td> -->
							
							<td class="text-center"><?php echo h($member['Member']['created']); ?>&nbsp;</td>
							
							
							<!-- <td class="text-center">
								<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('action' => 'view', $member['Member']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('view'))); ?>
								<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>'), array('action' => 'edit', $member['Member']['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('edit'))); ?>
								<?php echo $this->Form->postLink(__('<i class="glyphicon glyphicon-trash"></i>'), array('action' => 'delete', $member['Member']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('delete')), __('Are you sure you want to delete # %s?', $member['Member']['id'])); ?>
							</td> -->
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
    //     $("#Members").dataTable();
    // });
</script>