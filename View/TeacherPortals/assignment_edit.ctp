<?php
	$addition_data = '';
?>
<div style="margin-bottom: 20px !important; min-height: 30px">
	<?php echo $this->element('menu/top_menu');?>
</div>
<div class="container teacher-create-lesson">
	<div class="col-md-12">
		<h3><?php echo __d('member', 'edit_homework'); ?></h3>
	</div>
	<form class="col-md-8 form-data">
		<div class="row mbt-30 group-icon-top icon-school">
			<label class="normal-weight col-md-12 p-0"><?=__d('member', 'school')?></label>
			<div class="col-md-8 pointer clearfix p-0">
				<select name="school_id" class="a4l-input form-control " id="school_id_add" disabled>
					<?php if(isset($current_user['member_role'][Environment::read('role.teacher')])){
								foreach ($current_user['member_role'][Environment::read('role.teacher')] as $key => $role){
									$addition_data .= '<input type="hidden" id="school-code-'.$role['school_id'].'" value="'.$role['School']['school_code'].'" />';
									$addition_data .= '<input type="hidden" id="school-name-'.$role['school_id'].'" value="'.$role['School']['SchoolLanguage'][0]['name'].'" />';
					?>
						<option value="<?=$role['school_id']?>"<?=$role['school_id']==$assignment['School']['id']?'selected':''?>>
							<?=$role['School']['SchoolLanguage'][0]['name']?>
						</option>
					<?php } } ?>
				</select>
				<?=$addition_data?>
			</div>
		</div>
		<div class="row mbt-30">
			<label class="normal-weight col-md-12 p-0"><?=__d('member', 'class')?></label>
			<div class="col-md-8 pointer p-0 clearfix">
				<input type="text" class="form-control a4l-input" name="" value="<?=$assignment['SchoolClass']['name']?>" disabled>
			</div>
		</div>
		<div class="row mbt-30">
			<label class="normal-weight col-md-12 p-0"><?=__d('member', 'subject')?></label>
			<div class="col-md-8 pointer p-0 clearfix">
				<input type="text" class="form-control a4l-input" name="" value="<?=$assignment['SchoolSubject']['SchoolSubjectLanguage'][0]['name']?>" disabled>
			</div>
		</div>
		<div class="row mbt-30 group-icon-top icon-subject">
			<label class="normal-weight col-md-12 p-0"><?=__d('member', 'homework_name')?></label>
			<div class="col-md-12 p-0 pointer clearfix" >
				<input class="form-control a4l-input required" id="assignment_title" placeholder="<?=__d('member', 'homework_name_sample')?>" value="<?=$assignment['TeacherCreateAssignment']['name']?>" />
			</div>
		</div>
		<div class="row mbt-30">
			<label class="normal-weight"><?=__d('member', 'homework_guidelines')?> (<?=__d('member', 'optional')?>)</label>
			<div class="col-md-12 p-0">
				<textarea class="a4l-input" style="width: 100%" placeholder="<?=__d('member', 'homework_guidelines_sample')?>" id="assignment_description" rows="7"><?=$assignment['TeacherCreateAssignment']['description']?></textarea>
			</div>
		</div>
		<div class="row mbt-30 grb-dropfile">
			<div class="row m-0">
				<div class="col-md-6 p-0">
					<?=__d('member', 'file')?> (<?=__d('member', 'optional')?>)
				</div>
				<div class="col-md-6 p-0 text-right text-grey">
					<a href="javascript:void(0)" data-toggle="tooltip" title="<?=implode(', ', Environment::read('allow_file_upload'))?>" class="text-green">
						<?=__d('member', 'supported_file')?> <i class="fa fa-question-circle" aria-hidden="true"></i>
					</a>
				</div>
			</div>
			<div class="row m-0">
				<div class="col-md-12 p-0 import-file-area pointer">
					<p class="text-grey-light"><span class="fa fa-cloud-upload"></span><?=__d('member', 'upload_file_or_drag_it_here')?></p>
					<p class="text-grey-light">(<?=sprintf( __d('member', 'upload_max_size_file'), '15MB')?>)</p>
				</div>
				<input type="file" class="hidden" id="upload-material" accept="<?=implode(', ', Environment::read('allow_file_upload'))?>" multiple/>
				<div class="col-md-12 p-0 ">
					<ul class="lst-imported-file bg-grey list-style-none p-0" id="lst-current-material">
						<?php foreach ($assignment['TeacherCreateAssignmentMaterial'] as $i => $material) { ?>
							<li class="item" id="material-<?=$material['id']?>">
								<a download="<?=$material['name']?>" href="<?=Router::url('/', true).$material['path']?>"><p class="file-name m-0"><?=$material['name']?></p></a>
								<p class="file-info text-grey"><?=$material['size']?> 
									Bytes <span class="fa fa-circle seperate"></span><?=$material['type']?>
								</p>
								<span class="fa fa-trash text-red remove-file pointer" onclick="ASSIGNMENT_EDIT.toggle_current_material(<?=$material['id']?>)"></span>
								<span class="fa fa-undo text-green remove-file hidden pointer" onclick="ASSIGNMENT_EDIT.toggle_current_material(<?=$material['id']?>)"></span>
							</li>
						<?php } ?>
					</ul>
					<ul class="lst-imported-file list-style-none p-0" id="lst-imported-material"></ul>
				</div>
			</div>
		</div>
		<div class="row m-0 group-icon-top icon-date">
			<label class="col-md-12 p-0 normal-weight"><?=__d('member', 'deadline_for_submission')?></label>
			<div class="col-md-8 a4l-datetimepicker pl-0">
				<?php
					echo $this->element('datetime_picker',array(
							'format' => 'YYYY-MM-DD',
							'class' => ' a4l-input custom-datetime-picker required ',
							'field_name' => '',
							'value' => $assignment['TeacherCreateAssignment']['deadline'],
							'placeholder' => __d('member', 'sample_date'),
							'id' 		=> 'assignment_date',
						));
				?>
			</div>
			<div class="col-md-4 a4l-datetimepicker pr-0">
				<?php
					echo $this->element('time_picker',array(
									'format' => 'HH:mm',
									'class' => ' a4l-input custom-datetime-picker required ',
									'field_name' => '',
									'value' =>  $assignment['TeacherCreateAssignment']['deadline'],
									'placeholder' => __d('member', 'to'),
									'id' 		=> 'assignment_time',
								));
				?>
			</div>
		</div>
		<div class="row m-0">
			<button class="btn btn-w-radius btn-green mt-10" id="btn-submit-create-assignment" type="button" onclick="ASSIGNMENT_EDIT.submit_teacher_edit_assignment()"><?=__d('member', 'complete')?></button>
		</div>
	</form>
</div>
<?php
	echo $this->Html->script('pages/assignment_edit.js?v='.date('U'));
?>
<script type="text/javascript">
	$(document).ready(function() {
		ASSIGNMENT_EDIT.school_id = "<?=$assignment['School']['id']?>";
		ASSIGNMENT_EDIT.class_id = "<?=$assignment['SchoolClass']['id']?>";
		ASSIGNMENT_EDIT.subject_id = "<?=$assignment['SchoolSubject']['id']?>";
		ASSIGNMENT_EDIT.init_page(<?=$assignment['TeacherCreateAssignment']['id']?>);
	});
</script>