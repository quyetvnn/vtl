<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>
<div class="row">
    <div class="col-xs-12">

    <div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo __d('member', 'member_manage_school'); ?></h3>
			<div class="box-tools pull-right">
                <?php /// echo $this->Html->link(__('<i class="glyphicon glyphicon-plus"></i>') . __('add'), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
            </div>
		</div>	
			<div class="box-body table-responsive">
                <table id="MemberManageSchools" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id',			__('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('school_id', 	__d('school', 'school')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('member_id',	__d('member', 'teacher')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('administrator_id', 	__d('administration', 'administrator')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('created',			__('created')); ?></th>
							<th class="text-center"><?php echo __('operation'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($memberManageSchools as $memberManageSchool): ?>
						<tr>
							<td class="text-center"><?php echo h($memberManageSchool['MemberManageSchool']['id']); ?>&nbsp;</td>
							<td class="text-center">
								<?php 
								
									if (isset($memberManageSchool['School']['SchoolLanguage'])) {
										echo $this->Html->link(reset($memberManageSchool['School']['SchoolLanguage'])['name'], array('plugin' => 'school', 'controller' => 'schools', 'action' => 'view', $memberManageSchool['School']['id'])); 
									}
								?>
							</td>
							<td class="text-center">
								<?php 
									if (isset($memberManageSchool['Member'])) {
										echo h($memberManageSchool['Member']['username']);
									}
								?>
							</td>
							<td class="text-center">
								<?php
									if (isset($memberManageSchool['Administration'])) {
										echo h($memberManageSchool['Administration']['name']);
										// echo $this->Html->link($memberManageSchool['Administration']['name'], array('plugin' => 'administration', 'controller' => 'administators', 'action' => 'view', $memberManageSchool['Member']['id'])); 
									}
								?>
							</td>
							<td class="text-center"><?php echo h($memberManageSchool['MemberManageSchool']['created']); ?>&nbsp;</td>
							<td class="text-center">
								<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('action' => 'view', $memberManageSchool['MemberManageSchool']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('view'))); ?>
								<!-- <?php //echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>'), array('action' => 'edit', $memberManageSchool['MemberManageSchool']['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('edit'))); ?> -->
								<?php echo $this->Form->postLink(__('<i class="glyphicon glyphicon-trash"></i>'), array('action' => 'delete', $memberManageSchool['MemberManageSchool']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('delete')), __('Are you sure you want to delete # %s?', $memberManageSchool['MemberManageSchool']['id'])); ?>
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

?>
<script type="text/javascript">
    $(function() {
      //  $("#MemberManageSchools").dataTable();
    });
</script>