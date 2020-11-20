
<div style="margin-bottom: 20px !important; min-height: 30px">
	<?php echo $this->Html->css('datatables/dataTables.bootstrap'); 
		echo $this->element('menu/top_menu');
	?>
</div>

<div class="row m-0">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('member', 'assignments'); ?></h3>

				<div class="box-tools m-10 text-right">

					<?php
						echo $this->Html->link(__('<i class="glyphicon glyphicon-plus"></i>') . __('add'), 
												array('controller'=>'teacher_portals', 'action' => 'assignment_create', 'plugin'=>''), 
												array('class' => 'btn btn-primary', 'escape' => false)); 
					?>
				</div>
			</div>	

			<div class="box-body table-responsive table-assignment">
				<table id="TeacherCreateLesson" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id',				__('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('teacher',		__d('member', 'teacher')); ?></th>
							<th class="text-center title"><?php echo $this->Paginator->sort('name',			__( 'name')); ?></th>
							<th class="text-center description"><?php echo $this->Paginator->sort('description',	__('description')); ?></th>
							
							<th class="text-center"><?php echo $this->Paginator->sort('school_id',		__d('school', 'school')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('group',			__d('member', 'group')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('subject_id',		__d('member', 'subject')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('deadline',		__d('member', 'deadline')); ?></th>
							<th class="text-center"><?php echo __d('member', 'download_as_assignment'); ?></th>
							<th class="text-center"><?php echo __d('member', 'student_submission'); ?></th>
							<th class="text-center"></th>
							<!-- check student have class yet?? if yes => show -->
						</tr>
					</thead>

					<tbody>
						<?php foreach ($teacherCreateAssignments as $val) { ?>
							<tr> 
								<td class="text-center"><?php echo $val['TeacherCreateAssignment']['id']; ?></td>

								<td class="text-center">
									<?php 

										$teachers_participants = $val['TeacherAssignmentsParticipant'];
										$teachers = array();
										foreach ($teachers_participants as $v) {
											$teachers[] = reset($v['Teacher']['MemberLanguage'])['name'];
										}

										echo implode(", ", $teachers);
									?>
								</td>
								<td class="text-center"><?php echo $val['TeacherCreateAssignment']['name']; ?></td>
								<td class="text-center"><?php echo $val['TeacherCreateAssignment']['description']; ?></td>
								
								<td class="text-center">
									<?php 
									if (isset($val['School']['SchoolLanguage'])) {
										echo reset($val['School']['SchoolLanguage'])['name']; 
									}
									?>
								</td>
								<td class="text-center">
									<?php
									// if (isset($val['SchoolClass'])) {
									// 	echo h($val['SchoolClass']['name']); 
									// }
									if (isset($val['SchoolsGroup']) && !empty($val['SchoolsGroup']['SchoolsGroupsLanguage'])) {
										echo reset($val['SchoolsGroup']['SchoolsGroupsLanguage'])['name']; 
									}
									?>
								</td>
								<td class="text-center">
									<?php 
									if (isset($val['SchoolSubject']['SchoolSubjectLanguage'])) {
										echo reset($val['SchoolSubject']['SchoolSubjectLanguage'])['name']; 
									}
									?>
								</td>

								<td class="text-center">
									<?php
										$dtime = strtotime($val['TeacherCreateAssignment']['deadline']);
										echo date( Environment::read('locale_format.'.$this->Session->read('Config.language')), $dtime); 
									?>
								</td>
								<td class="text-center">
									<?php foreach($val['TeacherCreateAssignmentMaterial'] as $v) { ?>
										<a href="<?= Router::url('/', true) . $v['path']; ?>" target="_blank" download="<?= $v['name']; ?>"> 
											<i class="fa fa-download"></i>
										</a>
									<?php } ?>
								</td>
								<td class="text-center">
									<?php 
										// pr($val);
										echo $this->Html->link(__('<i class="fa fa-eye"></i>') .''. __d('member', 'views'), 
												array('controller'=>'teacher_portals', 'action' => 'student_submission', 'plugin'=>'', $val['TeacherCreateAssignment']['id']), 
												array('class' => 'btn btn-primary', 'escape' => false)); 
									?>
								</td>
								<td class="text-center">
									<?php 
										// pr($val);
										echo $this->Html->link(__('<i class="fa fa-pencil"></i>'), 
												array('controller'=>'teacher_portals', 'action' => 'assignment_edit', 'plugin'=>'', $val['TeacherCreateAssignment']['id']), 
												array('class' => 'btn btn-warning btn-xs', 'escape' => false)); 

										echo "&nbsp;";
										if(isset($val['SchoolsGroup']) && !empty($val['SchoolsGroup']['SchoolsGroupsLanguage'])){
											echo $this->Html->link(__('<i class="fa fa-trash"></i>'), 
													'javascript: void(0)', 
													array('class' => 'btn btn-danger', 'onclick'=> 'ASSIGNMENT.confirm_delete_assignment('.$val['TeacherCreateAssignment']['id'].', \''.$val['TeacherCreateAssignment']['name'].'\', \''.reset($val['SchoolsGroup']['SchoolsGroupsLanguage'])['name'].'\')', 'escape' => false)); 
										}
									?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->
		</div><!-- /.box box-primary -->
		<?php  echo $this->element('Paginator'); ?> 
	</div><!-- xs-12 -->
</div> <!-- row -->

<?php
	echo $this->Html->script('plugins/datatables/jquery.dataTables');
	echo $this->Html->script('plugins/datatables/dataTables.bootstrap');
	echo $this->Html->script('pages/assignments_teacher.js?v='.date('U'));
?>
<script type="text/javascript">
	$(document).ready(function(){
		ASSIGNMENT.init_page();
	})
</script>




