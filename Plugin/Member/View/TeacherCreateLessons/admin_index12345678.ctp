


<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('member', 'Teacher Create Lesson'); ?></h3>
			</div>	

			<div class="box-body table-responsive">
				<table id="TeacherCreateLesson" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id',				__('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('school',			__d('member', 'school')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('lesson_title',		__d('member', 'lesson_title')); ?></th>
							
							<th class="text-center"><?php echo $this->Paginator->sort('list_class',		__d('member', 'list_class')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('teacher_id',		__d('member', 'teacher_id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('list_teacher',	__d('member', 'list_teacher')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('allow_playback',		__d('member', 'recording_video')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('start_time',		__d('member', 'start_time')); ?></th>
							<th class="text-center"><?php echo __d('member', 'duration'); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('meeting',				__d('member', 'meeting')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('recording_video',				__d('member', 'recording_video')); ?></th>
							<th class="text-center"><?php echo __('operation'); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php 
						

							foreach ($teacherCreateLessons as $val): ?>
							<tr>
								<td class="text-center"><?php echo h($val['TeacherCreateLesson']['id']); ?>&nbsp;</td>
								<td class="text-center"><?php 
									
									if (isset($val['School']['SchoolLanguage'])) {
										echo h(reset($val['School']['SchoolLanguage']))['name']; 
									}
									?>&nbsp;
								</td>
								<td class="text-center"><?php echo h($val['TeacherCreateLesson']['lesson_title']); ?>&nbsp;</td>
							
							
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

								<td class="text-center">
									<?= $this->element('view_check_ico',array('_check'=>$val['TeacherCreateLesson']['allow_playback'])) ?>
								</td>
								<td class="text-center"><?php echo h($val['TeacherCreateLesson']['start_time']); ?>&nbsp;</td>
							
								<td class="text-center">
									<?php 
										if (($val['TeacherCreateLesson']['duration_hours']) == 0) {
											echo h($val['TeacherCreateLesson']['duration_minutes']) . "m";
										} elseif ($val['TeacherCreateLesson']['duration_minutes'] == 0) {
											echo h($val['TeacherCreateLesson']['duration_hours']) . "h";
										} else {
											echo h($val['TeacherCreateLesson']['duration_hours']) . "h:" . $val['TeacherCreateLesson']['duration_minutes'] . "m";
										}

									?>
								</td>
							
								<td class="text-center">
									<a href="<?php echo h($val['TeacherCreateLesson']['meeting']);?>">
											<?php echo h($val['TeacherCreateLesson']['meeting']);?>
										</a>
								</td>
								<td class="text-center">
										<a href="<?php echo h($val['TeacherCreateLesson']['recording_video']);?>">
											<?php echo h($val['TeacherCreateLesson']['recording_video']);?>
										</a>
										&nbsp;
								</td>
							
								<td class="text-center">
									<?php 

										echo $this->Html->link(__('<i class="fa fa-pencil"></i>'), array(

											'admin'	=> true,
											'plugin' => 'member', 
											'controller' => 'teacher_create_lessons', 
											'action' => 'edit12345678', 
											$val['TeacherCreateLesson']['id']), 
											array('class' => 'btn btn-warning btn-xs', 
													'escape' => false, 
													'data-toggle'=>'tooltip',
													'title' => __('edit'))); 
									?>

									&nbsp;
									<?	echo $this->Form->postLink(__('<i class="fa fa-remove"></i>'), array(
											'admin'	=> true,
											'plugin' => 'member', 
											'controller' => 'teacher_create_lessons', 
											'action' => 'delete12345678', 
											$val['TeacherCreateLesson']['id']),  
											array('class' => 'btn btn-danger btn-xs', 
													'escape' => false, 'data-toggle'=>'tooltip', 
													'title' => __('delete')), __('Are you sure you want to delete # %s?', $val['TeacherCreateLesson']['id'])); 
										
									?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->
		</div><!-- /.index -->
		<?php echo $this->element('Paginator'); ?>	</div><!-- /#page-content .col-sm-9 -->
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