
<div style="margin-bottom: 20px !important; min-height: 30px">
	<?php echo $this->Html->css('datatables/dataTables.bootstrap'); 
		echo $this->element('menu/top_menu');
	?>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('member', 'assignments'); ?></h3>

				<div class="box-tools pull-right"></div>
			</div>	

			<div class="box-body table-responsive table-assignment">
				<table id="TeacherCreateLesson" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id',				__('id')); ?></th>

							<th class="text-center title"><?php echo $this->Paginator->sort('name',			__( 'name')); ?></th>
							<th class="text-center description"><?php echo $this->Paginator->sort('description',		__('description')); ?></th>
							
							<th class="text-center"><?php echo $this->Paginator->sort('school_id',		__d('school', 'school')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('class_id',		__d('member', 'class')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('subject_id',		__d('member', 'subject')); ?></th>
							
							<th class="text-center"><?php echo $this->Paginator->sort('deadline',		__d('member', 'deadline_for_submission')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('deadline',		__d('member', 'submission_time')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('score',			__d('member', 'score')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('feedback',		__d('member', 'feedback')); ?></th>
						
							<th class="text-center"><?php echo __d('member', 'download_as_assignment'); ?></th>
							<th class="text-center"><?php echo __d('member', 'submit_assignment'); ?></th>
							<th class="text-center"><?php echo __d('member', 'view_assignment_feedback'); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($teacherCreateAssignments as $val) { ?>
							<tr>
								<td class="text-center"><?php echo $val['TeacherCreateAssignment']['id']; ?></td>
								<td class="text-center"><?php echo $val['TeacherCreateAssignment']['name']; ?></td>
								<td class="text-center original-text"><?php echo $val['TeacherCreateAssignment']['description']; ?></td>
								
								<td class="text-center">
									<?php 
									if (isset($val['School']['SchoolLanguage'])) {
										echo reset($val['School']['SchoolLanguage'])['name']; 
									}
									?>
								</td>
								<td class="text-center">
									<?php 
									if (isset($val['SchoolClass'])) {
										echo $val['SchoolClass']['name']; 
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
									<?php
										if(isset($val['StudentAssignmentSubmission']) && !empty($val['StudentAssignmentSubmission'])){
											$dtime = strtotime($val['StudentAssignmentSubmission'][0]['upload_time']);
											echo date( Environment::read('locale_format.'.$this->Session->read('Config.language')), $dtime); 
										}
									?>
								</td>

								<td class="text-center">

									<?php if (!empty(reset($val['StudentAssignmentSubmission'])['score'])) { ?>
										<label class="label label-success"> 
											<?php echo reset($val['StudentAssignmentSubmission'])['score'];  ?>
										</label>
									<?php }  ?>
								
								</td>

								<td class="text-center">
									<?php if(isset($val['StudentAssignmentSubmission']) && !empty($val['StudentAssignmentSubmission'])){
										echo reset($val['StudentAssignmentSubmission'])['feedback'];
									} ?>
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
									if(isset($val['StudentAssignmentSubmission'][0])){
										foreach($val['StudentAssignmentSubmission'][0]['StudentAssignmentSubmissionMaterial'] as $v) { ?> 
											<a href="<?= Router::url('/', true) . $v['path']; ?>" target="_blank" download="<?= $v['name']; ?>"> 
												<i class="fa fa-download"></i>
											</a>
									<?php } }
									if( $val['TeacherCreateAssignment']['deadline'] >= date('Y-m-d H:i:s')){
										if (count($val['StudentAssignmentSubmission']) > 0) {
											$dtime = strtotime($val['StudentAssignmentSubmission'][0]['upload_time']);
											// echo date( Environment::read('locale_format.'.$this->Session->read('Config.language')), $dtime);
											// echo "&nbsp;&nbsp;";
											// display resubmit button condition: 
											// - deadline not now 
											// - dont get any score from teacher
											if ( empty(reset($val['StudentAssignmentSubmission'])['score'])) {
													echo $this->Html->link(__('<i class="fa fa-pencil-square-o"></i>') .'&nbsp'. __d('member', 'resubmit'), 
													array(	'action' => 'assignment_submit', 
															'controller' => 'student_portals',
															$val['TeacherCreateAssignment']['id'],
															1), 
													array('class' => 'btn btn-primary', 'escape' => false)); 
											}


										} else {
											echo $this->Html->link(__('<i class="glyphicon glyphicon-plus"></i>') .'&nbsp'. __('submit'), 
												array(	'action' => 'assignment_submit', 
														'controller' => 'student_portals',
														$val['TeacherCreateAssignment']['id'], 
														0),
												array('class' => 'btn btn-primary', 'escape' => false)); 
										}
									}
									?>
								</td>
								<td>
									<?php 
									if(isset($val['StudentAssignmentSubmission'][0])){
										foreach($val['StudentAssignmentSubmission'][0]['TeacherFeedbackAssignmentMaterial'] as $v) { ?> 
											<a href="<?= Router::url('/', true) . $v['path']; ?>" target="_blank" download="<?= $v['name']; ?>"> 
												<i class="fa fa-download"></i>
											</a>
									
									<?php } } ?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->
		</div><!-- /.index -->
		
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