<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>

<?= $this->element('Member.MemberLoginMethod_filter', array(
	'data_search' => $data_search
)); ?>


<div class="row">
    <div class="col-xs-12">

    <div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo __d('member', 'member_login_method'); ?></h3>
			<div class="box-tools pull-right">
                <?php // echo $this->Html->link(__('<i class="glyphicon glyphicon-plus"></i>') . __('add'), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
            </div>
		</div>	
			<div class="box-body table-responsive">
                <table id="MemberLoginMethods" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id', 		__('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('member_id', 	__d('member', 'member') . __('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('username',	__d('member', 'username')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('email',		__d('member', 'email')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('login_method_id',	__d('member', 'login_method')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('enabled',	__('enabled')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('created',	__('created')); ?></th>
							<th class="text-center"><?php echo __('operation') ?></th>
						
						</tr>
					</thead>
					<tbody>
					<?php foreach ($memberLoginMethods as $memberLoginMethod): ?>
						<tr>
							<td class="text-center"><?php echo h($memberLoginMethod['MemberLoginMethod']['id']); ?>&nbsp;</td>
							<td class="text-center">
								<?php 
									echo h($memberLoginMethod['MemberLoginMethod']['member_id']); 
								?>&nbsp;
							</td>
					
							<td class="text-center">
								<?php 
									echo h($memberLoginMethod['MemberLoginMethod']['username']); 
								?>&nbsp;
							</td>
						
							<td class="text-center">
								<?php 
									if (isset($memberLoginMethod['Member']['email'])) {
										echo h($memberLoginMethod['Member']['email']); 
									} 

								?>
							</td>
							<td class="text-center">
								<?php 
									if ($memberLoginMethod['MemberLoginMethod']['school_id'] &&
										$memberLoginMethod['MemberLoginMethod']['school_id'] != 0 &&
										$memberLoginMethod['MemberLoginMethod']['school_id'] != 900001 && 
										$memberLoginMethod['MemberLoginMethod']['school_id'] != 900002
										) {

										if (isset($memberLoginMethod['School']['SchoolLanguage']) && !empty($memberLoginMethod['School']['SchoolLanguage'])) {
											echo $this->Html->link(
												reset($memberLoginMethod['School']['SchoolLanguage'])['name'], array('plugin' => 'school', 'controller' => 'schools', 'action' => 'view', $memberLoginMethod['School']['id'])); 
										
										}
									
									} 
								?>
							</td>

							<td class="text-center">
								<?= $this->element('view_check_ico',array('_check'=>$memberLoginMethod['MemberLoginMethod']['enabled'])) ?>
							</td>

							<td class="text-center"><?php echo h($memberLoginMethod['MemberLoginMethod']['created']); ?>&nbsp;</td>
							
							<td class="text-center">
								<?php 
								
								echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>'), array('action' => 'edit', $memberLoginMethod['MemberLoginMethod']['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('edit_password')));  ?>
								&nbsp;
								<?php if ($memberLoginMethod['MemberLoginMethod']['enabled'] == true) {
									echo $this->Html->link(__('<i class="fa fa-ban"></i>'), array('action' => 'change_account_status', $memberLoginMethod['MemberLoginMethod']['username'], $memberLoginMethod['MemberLoginMethod']['id'], $memberLoginMethod['MemberLoginMethod']['member_id'], $memberLoginMethod['MemberLoginMethod']['enabled']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__d('member', 'disable_account'))); 
								
								} else {
									echo $this->Html->link(__('<i class="fa fa-eye"></i>'), array('action' => 'change_account_status', $memberLoginMethod['MemberLoginMethod']['username'], $memberLoginMethod['MemberLoginMethod']['id'], $memberLoginMethod['MemberLoginMethod']['member_id'], $memberLoginMethod['MemberLoginMethod']['enabled']), array('class' => 'btn btn-success btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__d('member', 'enabled_account'))); 
					
								}
								?>
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
	// echo $this->Html->script('jquery-ui.min');
	// echo $this->Html->script('plugins/datatables/jquery.dataTables');
	// echo $this->Html->script('plugins/datatables/dataTables.bootstrap');
?>
<script type="text/javascript">
    $(function() {
        //$("#MemberLoginMethods").dataTable();
    });
</script>