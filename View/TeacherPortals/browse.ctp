
<div style="margin-bottom: 20px !important; min-height: 30px">
	<?php echo $this->Html->css('datatables/dataTables.bootstrap'); 
		echo $this->element('menu/top_menu');
	?>
</div>

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
							<th class="text-center"><?php echo $this->Paginator->sort('list_class',		__d('member', 'class')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('teacher_id',		__d('member', 'teacher_id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('list_teacher',	__d('member', 'co_teaching')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('start_time',		__d('member', 'start_time')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('end_time',		__d('member', 'end_time')); ?></th>
						
							<th class="text-center"><?php echo __d('member', 'duration'); ?></th>
							<th class="text-center"><?php echo __('operation'); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($teacherCreateLessons as $val): 
						
							$is_show_edit 	= false;
							$is_show_delete = false;

							$teacher_id = $val['TeacherCreateLesson']['teacher_id'];

							if ($teacher_id == $current_user_id) {
								if (date('Y-m-d H:i:s', strtotime($val['TeacherCreateLesson']['end_time'])) >= date('Y-m-d H:i:s')) {
									$is_show_edit 	= true;
									$is_show_delete = true;
								}
							}
							
						?>
							<tr>
								<td class="text-center"><?php echo $val['TeacherCreateLesson']['id']; ?></td>
								<td class="text-center"><?php 
									
									if (isset($val['School']['SchoolLanguage'])) {
										echo reset($val['School']['SchoolLanguage'])['name']; 
									}
									?>
								</td>
								<td class="text-center"><?php 
									
									echo $val['TeacherCreateLesson']['lesson_title'];
									
									?>
								</td>
								<td class="text-center">
									
									<?php 
										$list_class = $val['TeacherCreateLesson']['list_class'];
										if (!is_null($list_class)) {
											$lesson_class = json_decode($list_class);
											$tmp = array_filter($schoolClasses, function($key) use ($lesson_class){
												if(in_array($key, $lesson_class)) return true;
												return false;
											}, ARRAY_FILTER_USE_KEY);
											echo implode(', ', $tmp);
										}
									?>
								</td>
								<td class="text-center">
									<?php 
										if (isset($val['Teacher']['MemberLanguage'])) {
											echo reset($val['Teacher']['MemberLanguage'])['name']; 
										}
									
									?></td>
							
								<td class="text-center">
									<?php 
										$list_teacher = $val['TeacherCreateLesson']['list_teacher'];
										if (!is_null($list_teacher)) {
											$lesson_teacher = json_decode($list_teacher);
											$tmp = array_filter($teachers, function($key) use ($lesson_teacher){
												if(in_array($key, $lesson_teacher)) return true;
												return false;
											}, ARRAY_FILTER_USE_KEY);
											echo implode(', ', $tmp);
										}
									?>
								</td>
								<td class="text-center">
									<?php
										$dtime = strtotime($val['TeacherCreateLesson']['start_time']);
										echo date( Environment::read('locale_format.'.$this->Session->read('Config.language')), $dtime); 
									?>
								</td>
								<td class="text-center">
									<?php
										$dtime = strtotime($val['TeacherCreateLesson']['end_time']);
										echo date( Environment::read('locale_format.'.$this->Session->read('Config.language')), $dtime); 
									?>
								</td>
							
								<td class="text-center">
									<?php 
										if (($val['TeacherCreateLesson']['duration_hours']) == 0) {
											echo $val['TeacherCreateLesson']['duration_minutes'] . "m";
										} elseif ($val['TeacherCreateLesson']['duration_minutes'] == 0) {
											echo $val['TeacherCreateLesson']['duration_hours'] . "h";
										} else {
											echo $val['TeacherCreateLesson']['duration_hours'] . "h:" . $val['TeacherCreateLesson']['duration_minutes'] . "m";
										}

									?>
								</td>

								<!-- <td class='text-center'>
									<?php 

										// if ($is_show_student_assignment_submission) {

											// echo $this->Html->link(__('<i class="fa fa-download"></i>'), array(
											// 	'admin'	=> false,
											// 	'plugin' => '', 
											// 	'controller' => 'teacher_portals', 
											// 	'action' => 'show_all_assignment', 
											// 	$val['TeacherCreateLesson']['id']), 
											// 	array('class' => 'btn btn-primary btn-xs', 
											// 			'escape' => false, 
											// 			'data-toggle'=>'tooltip',
											// 			'title' => __('download'))); 
										// }
									?>
								</td> -->

								<!-- <td class='text-center'>
									<?php 

										// if ($is_show_create_assignment) {
										// 	echo $this->Html->link(__('<i class="fa fa-plus"></i>'), array(
										// 		'admin'	=> false,
										// 		'plugin' => '', 
										// 		'controller' => 'teacher_portals', 
										// 		'action' => 'add_assignment', 
										// 		$val['TeacherCreateLesson']['id']), 
										// 		array('class' => 'btn btn-success btn-xs', 
										// 				'escape' => false, 
										// 				'data-toggle'=>'tooltip',
										// 				'title' => __d('member', 'add_assignment'))); 
										// }
									?>
								</td> -->
								
								<td class="text-center">
									<?php 
										if ($is_show_edit) {
											echo $this->Html->link(__('<i class="fa fa-pencil"></i>'), array(

												'admin'	=> false,
												'plugin' => '', 
												'controller' => 'teacher_portals', 
												'action' => 'edit', 
												$val['TeacherCreateLesson']['id']), 
												array('class' => 'btn btn-warning btn-xs', 
														'escape' => false, 
														'data-toggle'=>'tooltip',
														'title' => __('edit'))); 
										}
									?>
									
									<?php 
										if ($is_show_delete) {
											echo $this->Form->postLink(__('<i class="fa fa-remove"></i>'), array(
												'admin'	=> false,
												'plugin' => '', 
												'controller' => 'teacher_portals', 
												'action' => 'delete', 
												$val['TeacherCreateLesson']['id'],
												$val['School']['school_code']),
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