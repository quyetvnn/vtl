<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>

<?= $this->element('Member.StudentClass_filter', array(
	'data_search' => $data_search
)); ?>

<div class="row">
    <div class="col-xs-12">

    <div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo __d('school', 'student_class'); ?></h3>
			<div class="box-tools pull-right">
                <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-plus"></i>') . __('add'), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
            </div>
		</div>	
			<div class="box-body table-responsive">
                <table id="StudentClasses" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id',			__('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('school_id',	__d('school', 'school')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('school_class_id',	__d('school', 'school_class')); ?></th>
							
							<th class="text-center"><?php echo $this->Paginator->sort('student_id',	__d('member', 'student')); ?></th>
							<!-- <th class="text-center"><?php echo $this->Paginator->sort('type',				__('type')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('class_no',			__d('school', 'class_no')); ?></th>
							 -->
							 <th class="text-center"><?php echo $this->Paginator->sort('enabled',			__('enabled')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('created',			__('created')); ?></th>
							<th class="text-center"><?php echo __('operation'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($studentClasses as $studentClass): ?>
						<tr>
							<td class="text-center"><?php echo h($studentClass['StudentClass']['id']); ?>&nbsp;</td>
						
							<td class="text-center">
								<?php 
								
									if (isset($studentClass['School']['SchoolLanguage'])) {
										echo $this->Html->link(
											reset($studentClass['School']['SchoolLanguage'])['name'] . " (" . $studentClass['School']['school_code'] . ")", array(
											'plugin' => 'school', 
											'controller' => 'schools', 
											'action' => 'view', $studentClass['School']['id'])
										); 
									} 
								?>
							</td>
							<td class="text-center">
								<?php echo $this->Html->link($studentClass['SchoolClass']['name'], array('plugin' => 'school', 'controller' => 'school_classes', 'action' => 'view', $studentClass['SchoolClass']['id'])); ?>
							</td>
							<td class="text-center">
								<?php 
								
									if (isset($studentClass['Student']['MemberLanguage'])) {
										echo $this->Html->link(reset($studentClass['Student']['MemberLanguage'])['name'], array(
											'controller' => 'members', 'action' => 'view', $studentClass['Student']['id']));
									}
								?>
							</td>
							
							<!-- <td class="text-center">
								<?php if ($studentClass['StudentClass']['type'] == array_search('Primary Class', $type)) { ?>
										<label class="label label-success"> <?= __d('school', 'primary_class'); ?> </label> 
						
								<?php } else { ?>
									<label class="label label-warning"> <?= __d('school', 'second_class'); ?> </label> 

								<?php } ?>
							</td>

							<td class="text-center"><?php echo h($studentClass['StudentClass']['class_no']); ?>&nbsp;</td>
							 -->

							 <td class="text-center">
								<?= $this->element('view_check_ico',array('_check'=>$studentClass['StudentClass']['enabled'])) ?>
							</td>
					
							<td class="text-center"><?php echo h($studentClass['StudentClass']['created']); ?>&nbsp;</td>
							<td class="text-center">
								
								<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('action' => 'view', $studentClass['StudentClass']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('view'))); ?>
								<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>'), array('action' => 'edit', $studentClass['StudentClass']['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('edit'))); ?>
								<?php echo $this->Form->postLink(__('<i class="glyphicon glyphicon-trash"></i>'), array('action' => 'delete', $studentClass['StudentClass']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('delete')), __('Are you sure you want to delete # %s?', $studentClass['StudentClass']['id'])); ?>
								
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
	echo $this->Html->script('CakeAdminLTE/pages/admin_student_class.js?v=' . date('U') , array('inline' => false));
?>


<script type="text/javascript">
	$(document).ready(function(){
		ADMIN_STUDENT_CLASS.school_class_id = '<?= isset($school_class_id_selected) ? $school_class_id_selected : ""; ?>'
		ADMIN_STUDENT_CLASS.url_get_school_class 	= '<?= Router::url(array('plugin' => 'member', 'controller' => 'student_classes', 'action' => 'get_school_class')); ?>';
		ADMIN_STUDENT_CLASS.url_get_member 			= '<?= Router::url(array('plugin' => 'member', 'controller' => 'members', 'action' => 'get_list_student')); ?>';
		ADMIN_STUDENT_CLASS.noneSelectedText  		= '<?= __('please_select'); ?>';
		ADMIN_STUDENT_CLASS.init_page();

		
		<?php if (!(isset($data_search['school_class_id']) && $data_search['school_class_id'])) { ?>
			ADMIN_STUDENT_CLASS.add_page();
		<?php } ?>
		
	
	});
</script>