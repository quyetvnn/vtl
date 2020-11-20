

<?php echo $this->Form->create('SchoolClass', array('role' => 'form', 'type' => 'get', 
						'id' => 'frm_add_all_student_to_class', 'enctype'=>"multipart/form-data"  )); ?>

<div class="row">
    <div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('school', 'upgrade_class'); ?></h3>
			</div>	

			<div class="row mg-bottom-10">
				<div class="col-xs-0 col-md-3"> </div>
				<div class="col-xs-6 col-md-3">
					<?php		
						echo $this->Form->input('class_id', array(
							'class' => 'form-control',
							'label' => false,
							'required' => 'required',
						)); 
					?>
				</div>
				<div class="col-xs-6 col-md-3">
					<button class="btn btn-primary" type ="submit" id="add_student_to_class" name="add_student_to_class"  value="<?php echo __d('school', 'add_all_student_to_class'); ?>">
						<i class="glyphicon glyphicon-plus"></i> <?php echo __d('school', 'add_student_to_class'); ?>
					</button>
				</div>
				<div class="col-xs-0 col-md-3"> </div>
			</div>
				
			

			<?php 

				if (count($studentClasses) <= 0) {
					echo "<div style='text-align:center; font-weight: bold; font-size: 2em; padding-bottom: 50px'>" . __d('member', 'this_class_empty_student') . "</div>";
					return;
				}

			?>

			<div class="box-body table-responsive">
				<table id="upgrade-class" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"> 

								<input type='checkbox' id='chk-all-student' name='chk-all-student' />
								<?php 
								// echo $this->Form->input('chk-all-student', array(
								// 							'type' => 'checkbox',
								// 							'label' => false,
								// 							'name' => 'chk-all-student',
								// 							'hiddenField' => true,
								// 							'id' => 'chk-all-student'
								// ));
								?>
							</th>
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
							<td class="text-center">  

								<input type='checkbox'  class='choose_id' name='choose_id[]' value="<?php echo $studentClass['Student']['id']; ?>" /> 
								<?php
								// echo $this->Form->input('choose_id[]', array(
								// 						'type' => 'checkbox',
								// 						'label' => false,
								// 						'value' => $studentClass['Student']['id'],
								// 						'id' => 'choose_id'
								// ));
								?>
								</td>
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
			
			<div class="box-body table-responsive">
				<div class="row">
<!-- 				
					<div class="col-xs-3">	
					</div>
					<div class="col-xs-3">
					
					</div>
					<div class="col-xs-3">
						<?php
							// echo $this->Form->input(__d('school', 'add_student_to_class'), array(
							// 	'div' => false,
							// 	'label' => false,
							// 	'type' => 'submit',
							// 	'name' => 'add_student_to_class',
							// 	'class' => 'btn btn-success btn-sm filter-button'
							// ));
						?>
					</div> -->
		
				</div>
			</div>
		</div><!-- /.index -->
	
	</div><!-- /#page-content .col-sm-9 -->
</div><!-- /#page-container .row-fluid -->

<?php echo $this->Form->end(); ?>




<?php
	echo $this->Html->script('CakeAdminLTE/common.js?v=' . date('U'), array('inline' => false));
	echo $this->Html->script('CakeAdminLTE/pages/admin_upgrade_class.js?v=' . date('U'), array('inline' => false));
?>

<script type="text/javascript">
	$(document).ready(function(){
		ADMIN_UPGRADE_CLASS.UPGRADE_CLASS_TEXT 		= '<?= __d('school', 'upgrade_class_text');?>';
		ADMIN_UPGRADE_CLASS.init_page();
	});

</script>


	