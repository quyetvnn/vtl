
<div class="row">
    <div class="col-xs-12">
		
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __d('school', 'school_class'); ?></h3>
				<div class="box-tools pull-right">
	                <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>') . __("edit"), array('action' => 'edit', $schoolClass['SchoolClass']['id']), array('class' => 'btn btn-primary', 'escape' => false)); ?>
	            </div>
			</div>
			
			<div class="box-body table-responsive">
                <table id="SchoolClasses" class="table table-bordered table-striped">
					<tbody>
						<tr>		
							<td> <strong><?php echo __('id'); ?></strong></td>
							<td>
								<?php echo h($schoolClass['SchoolClass']['id']); ?>
								&nbsp;
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __d('school', 'school'); ?></strong></td>
							<td>
								<?php 
								
									if (isset($schoolClass['School']['SchoolLanguage'])) {
										echo $this->Html->link(reset($schoolClass['School']['SchoolLanguage'])['name'], array('controller' => 'schools', 'action' => 'view', $schoolClass['School']['id']), array('class' => '')); 
								
									} ?>
								&nbsp;
							</td>
						</tr>
						<tr>	
							<td><strong><?php echo __('name'); ?></strong></td>
							<td>
								<?php echo h($schoolClass['SchoolClass']['name']); ?>
								&nbsp;
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __('enabled'); ?></strong></td>
							<td>
								<?= $this->element('view_check_ico',array('_check'=>$schoolClass['SchoolClass']['enabled'])) ?>
								&nbsp;
							</td>
						</tr>	
					</tbody>
				</table><!-- /.table table-striped table-bordered -->
			</div><!-- /.table-responsive -->
			
		</div><!-- /.view -->
	</div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->

<?php echo $this->Form->create('SchoolClass', array('role' => 'form', 'type' => 'get', 'id' => 'frm_add_all_student_to_class' )); ?>

<div class="row">
    <div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('school', 'student_classes'); ?></h3>
				<div class="box-tools pull-right">
					<!-- <input type="hidden" id="add_all_student_to_class" name="add_all_student_to_class" value="0" />
					<?php  //echo $this->Html->link(__('<i class="glyphicon glyphicon-plus"></i>') . __d('school', 'add_all_student_to_class'), 'javascript:trigger_submit_form()', array(
							//'class' => 'btn btn-primary', 'escape' => false)); ?> -->

					<!-- <button class="btn btn-primary" type ="submit" id="add_all_student_to_class" name="add_all_student_to_class"  value="<?php echo __d('school', 'add_all_student_to_class'); ?>">
						<i class="glyphicon glyphicon-plus"></i> <?php echo __d('school', 'add_all_student_to_class'); ?>
					</button> -->
				
					
					<?php 
					
						if (count($studentClasses) > 0) {
							echo $this->Html->link(__('<i class="glyphicon glyphicon-plus"></i>') . __d('school', 'add_all_student_to_class'), array('plugin' => 'school', 'controller' => 'school_classes',  'action' => 'upgrade_class', $schoolClass['SchoolClass']['id']), array('class' => 'btn btn-primary', 'escape' => false)); 
						}
						
					?>

					<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-plus"></i>') . __('add'), array('plugin' => 'member', 'controller' => 'student_classes',  'action' => 'add', $schoolClass['SchoolClass']['id']), array('class' => 'btn btn-primary', 'escape' => false)); ?>
				</div>
			</div>	

			<?php 

				if (count($studentClasses) <= 0) {
					echo "<div style='text-align:center; font-weight: bold; font-size: 2em; padding-bottom: 50px'>" . __d('member', 'this_class_empty_student') . "</div>";
					return;
				}

			?>

			<div class="box-body table-responsive">
				<table id="StudentClasses" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id',					__('id')); ?></th>
						
							<th class="text-center"><?php echo $this->Paginator->sort('student_id',			__d('member', 'student')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('SchoolClass.name',	__d('school', 'school_class')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('created',			__('created')); ?></th>
							<th class="text-center"><?php echo __('operation'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($studentClasses as $studentClass): ?>
						<tr>
					
							<td class="text-center"><?php echo h($studentClass['Student']['id']); ?>&nbsp;</td>
						

							<td class="text-center">
								<?php 
									if (isset($studentClass['Student']['MemberLanguage'])) {
										echo h(reset($studentClass['Student']['MemberLanguage'])['name']);
									
									}
								?>
							</td>

							<td class="text-center">
								<?php 
									if (isset($studentClass['SchoolClass']) && !empty($studentClass['SchoolClass'])) {
										echo ($studentClass['SchoolClass']['name']);
									
									}
								?>
							</td>

					
							<td class="text-center"><?php echo h($studentClass['StudentClass']['created']); ?>&nbsp;</td>
							<td class="text-center">
								<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('plugin' => 'member', 'controller' => 'student_classes', 'action' => 'view', $studentClass['StudentClass']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('view'))); ?>
								<?php echo $this->Form->postLink(__('<i class="glyphicon glyphicon-trash"></i>'), array('plugin' => 'member', 'controller' => 'student_classes', 'action' => 'delete', $studentClass['StudentClass']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' =>__('delete')), __('Are you sure you want to delete # %s?', $studentClass['StudentClass']['id'])); ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->
			
			
		</div><!-- /.index -->
	
	</div><!-- /#page-content .col-sm-9 -->
</div><!-- /#page-container .row-fluid -->

<?php echo $this->Form->end(); ?>


<script>
	function trigger_submit_form(){
		// $("#add_all_student_to_class").val(1);
		// $("#frm_add_all_student_to_class").submit();
	}
	// $(document).on('click', '#add_all_student_to_class', function(){
	// 	$("#frm_add_all_student_to_class").submit();
	// })
</script>




	