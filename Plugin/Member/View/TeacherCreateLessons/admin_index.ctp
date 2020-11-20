
<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('member', 'admin_teacher_create_lesson'); ?></h3>
			</div>	

			<div class="box-body table-responsive">
				<table id="TeacherCreateLesson" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id',				__('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('school',			__d('member', 'school')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('title',			__d('member', 'title')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('list_class',		__d('member', 'list_class')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('teacher_id',		__d('member', 'teacher_id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('list_teacher',	__d('member', 'list_teacher')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('start_time',		__d('member', 'start_time')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('duration_hours',			__d('member', 'duration')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('duration_minutes',		__d('member', 'duration minutes')); ?></th>
							
							<th class="text-center"><?php echo __('operation'); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($teacherCreateLessons as $val): 
							$is_show = false;
							$is_show_edit 	= false;
							$is_show_delete = false;

							$teacher_id = $val['TeacherCreateLesson']['teacher_id'];
							if ($teacher_id == $current_user_id) {
								$is_show = true;
								$is_show_edit 	= true;
								$is_show_delete = true;
							}

							if (!is_null($val['TeacherCreateLesson']['list_teacher'])) {
								$list_teacher = json_decode($val['TeacherCreateLesson']['list_teacher']);
								foreach ($list_teacher as $v) {
									if ($v == $current_user_id) {
										$is_show = true;
									}
								}
							}
							
							if (!$is_show) {
								continue;	// bypass
							}
							
						?>
							<tr>
								<td class="text-center"><?php echo h($val['TeacherCreateLesson']['id']); ?>&nbsp;</td>
								<td class="text-center"><?php 
									
									if (isset($val['School']['SchoolLanguage'])) {
										echo h(reset($val['School']['SchoolLanguage']))['name']; 
									}
									?>&nbsp;
								</td>
								<td class="text-center"><?php 
									
									echo h($val['TeacherCreateLesson']['lesson_title']);
									
									?>&nbsp;
								</td>
								<td class="text-center">
									<?php 
										$list_class = $val['TeacherCreateLesson']['list_class'];
										if (!is_null($list_class)) {
											foreach ($schoolClasses as $key => $v) {
												foreach (json_decode($list_class) as $class) {
													if ($class == $key) { 
														echo h($v) . ", "; 
													}
												}
											}
										}
									?>
								</td>
								<td class="text-center">
									<?php 
									
										if (isset($val['Teacher']['MemberLanguage'])) {
											echo h(reset($val['Teacher']['MemberLanguage']))['name']; 
										}
									
									?>&nbsp;</td>
							
								<td class="text-center">
									<?php 
										$list_teacher = $val['TeacherCreateLesson']['list_teacher'];
										if (!is_null($list_teacher)) {
											foreach ($teachers as $key => $v) {
												foreach (json_decode($list_teacher) as $t) {
													if ($t == $key) { 
														echo h($v) . ", "; 
													}
												}
											}
										}
									?>


								</td>
								<td class="text-center"><?php echo h($val['TeacherCreateLesson']['start_time']); ?>&nbsp;</td>
							
								<td class="text-center"><?php echo h($val['TeacherCreateLesson']['duration_hours']); ?>&nbsp;</td>
								<td class="text-center">
									<?php 
										$minute = $val['TeacherCreateLesson']['duration_minutes'];
										switch ($minute) {
											case 0: 
												echo "0";
												break;
											case 1: 
												echo "15";
												break;
											case 2: 
												echo "30";
												break;
											case 3: 
												echo "45";
												break;
										}
										
									?>&nbsp;
								</td>
							
								
								<td class="text-center">
									<?php 

										if ($is_show_edit) {
											echo $this->Html->link(__('<i class="fa fa-pencil"></i>'), array(

												'admin'	=> true,
												'plugin' => 'member', 
												'controller' => 'teacher_create_lessons', 
												'action' => 'edit', 
												$val['TeacherCreateLesson']['id']), 
												array('class' => 'btn btn-warning btn-xs', 
														'escape' => false, 
														'data-toggle'=>'tooltip',
														'title' => __('edit'))); 
										}

										if ($is_show_delete) {
											echo $this->Form->postLink(__('<i class="fa fa-remove"></i>'), array(
												'admin'	=> true,
												'plugin' => 'member', 
												'controller' => 'teacher_create_lessons', 
												'action' => 'delete', 
												$val['TeacherCreateLesson']['id']),  
												array('class' => 'btn btn-danger btn-xs', 
														'escape' => false, 'data-toggle'=>'tooltip', 
														'title' => __('delete')), __('Are you sure you want to delete # %s?', $val['TeacherCreateLesson']['id'])); 
										}
										
									?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->
		</div><!-- /.index -->
		<?php // echo $this->element('Paginator'); ?>	</div><!-- /#page-content .col-sm-9 -->
</div><!-- /#page-container .row-fluid -->

<?php
	echo $this->Html->script('plugins/datatables/jquery.dataTables');
	echo $this->Html->script('plugins/datatables/dataTables.bootstrap');
?>
<script type="text/javascript">
	$(function() {
		// $("#TablePricePrivateTutors").dataTable();
	});
</script>