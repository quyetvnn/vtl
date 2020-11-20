<?php
	$addition_data = '';
?>
<div style="margin-bottom: 20px !important; min-height: 30px">
	<?php echo $this->element('menu/top_menu'); ?>
</div>
<div class="container teacher-create-lesson">
	<div class="col-md-12">
		<h3><?php echo __d('member', 'add_homework'); ?></h3>
	</div>
	<form class="col-md-8 form-data">
		<div class="row mbt-30 group-icon-top icon-school">
			<label class="normal-weight col-md-12 p-0"><?=__d('member', 'school')?></label>
			<div class="col-md-8 pointer clearfix p-0">
				<select name="school_id" class="a4l-input form-control " id="school_id_add">
					<option value=""><?=__d('member', 'choose_a_school')?></option>
					<?php
						if(isset($current_user['member_role'][Environment::read('role.teacher')])){
							foreach ($current_user['member_role'][Environment::read('role.teacher')] as $key => $role){
								$addition_data .= '<input type="hidden" id="school-code-'.$role['school_id'].'" value="'.$role['School']['school_code'].'" />';
								$addition_data .= '<input type="hidden" id="school-name-'.$role['school_id'].'" value="'.$role['School']['SchoolLanguage'][0]['name'].'" />';
					?>
						<option value="<?=$role['school_id']?>" 
								<?=count($current_user['member_role'][Environment::read('role.teacher')])==1?'selected':''?>>
							<?=$role['School']['SchoolLanguage'][0]['name']?>
						</option>
					<?php } } ?>
				</select>
				<?=$addition_data?>
			</div>
			
		</div>

		<div class="row mbt-30">
			<label class="normal-weight col-md-12 p-0"><?=__d('member', 'class')?></label>
			<div class="col-md-8 a4l-input pointer clearfix" onclick="ASSIGNMENT_CREATE.call_modal_class(true)">
				<p class="pull-left default-text class-option-name" ><?=__d('member', 'choose_a_class')?></p>
				<p class="pull-left text-dark-green hidden class-option-name" id="class-option-name"></p>
				<span class="fa fa-angle-down text-grey arrow-right pull-right"></span>
			</div>
		</div>
		<div class="row mbt-30">
				<label class="normal-weight col-md-12 p-0"><?=__d('member', 'subject')?></label>
				<div class="col-md-8 a4l-input pointer clearfix" onclick="ASSIGNMENT_CREATE.call_modal_subject(true)">
					<p class="pull-left default-text subject-option-name" ><?=__d('member', 'select_account')?></p>
					<p class="pull-left text-dark-green hidden subject-option-name" id="subject-option-name"></p>
					<span class="fa fa-angle-down text-grey arrow-right pull-right"></span>
				</div>
			</div>

		<div class="row mbt-30 group-icon-top icon-subject">
			<label class="normal-weight col-md-12 p-0"><?=__d('member', 'homework_name')?></label>
			<div class="col-md-12 p-0 pointer clearfix" >
				<input class="form-control a4l-input required" id="assignment_title" placeholder="<?=__d('member', 'homework_name_sample')?>" />
			</div>
		</div>
		<div class="row mbt-30">
			<label class="normal-weight"><?=__d('member', 'homework_guidelines')?> (<?=__d('member', 'optional')?>)</label>
			<div class="col-md-12 p-0">
				<textarea class="a4l-input" style="width: 100%" placeholder="<?=__d('member', 'homework_guidelines_sample')?>" id="assignment_description" rows="15"></textarea>
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
							'minDate' => date("Y-m-d H:i:s"),
							'placeholder' => __d('member', 'sample_date'),
							'id' 		=> 'assignment_date',
						));
				?>
			</div>
			<div class="col-md-4 a4l-datetimepicker pr-0">
				<input id="assignment_time" class="form-control timepicker a4l-input custom-datetime-picker required " placeholder = "<?=__d('member', 'to')?>" type="text" disabled>
			</div>
		</div>
		<div class="row m-0">
			<button class="btn btn-w-radius btn-green" id="btn-submit-create-assignment" type="button" onclick="ASSIGNMENT_CREATE.submit_teacher_create_assignment()" disabled><?=__d('member', 'complete')?></button>
		</div>
	</form>
</div>
<div id="modal-classes" class="w3-modal modal-notification teacher-create-lesson">
	<div class="w3-modal-content ">
		<div class="bg-white">
			<div class="close-modal">
				<span onclick="ASSIGNMENT_CREATE.call_modal_class(false)" title="Close Modal" style="">&times;</span>
			</div>
			<div class="modal-body">
				<div class="w3-modal-header">
					<h3><?=__d('member', 'choose_a_class')?> <span>(<?=__d('member', 'multiple_choice')?>)</span></h3>
				</div>
				<div class="row m-0">
					<div class="col-md-12 p-0">
						<h5 class="col-md-12 p-0"><?=__d('member', 'other_classes')?></h5>
						<div class="col-md-12 p-0" id="lst-current-classes">
							
						</div>
					</div>
				</div>
			</div>
			<div class="text-center">
				<button class="btn btn-w-radius btn-green" onclick="ASSIGNMENT_CREATE.confirm_modal_class()" id="btn-confirm-class" disabled>
					<?=__d('member', 'determine')?>
				</button>
			</div>
		</div>
	</div>
</div>
<div id="modal-subject" class="w3-modal modal-notification teacher-create-lesson">
	<div class="w3-modal-content ">
		<div class="bg-white">
			<div class="close-modal">
				<span onclick="ASSIGNMENT_CREATE.call_modal_subject(false)" title="Close Modal" style="">&times;</span>
			</div>
			<div class="modal-body">
				<div class="w3-modal-header">
					<h3><?=__d('member', 'other_subjects')?></h3>
				</div>
				<div class="row m-0">
					<div class="col-md-12 p-0">
						<h5 class="col-md-12 p-0"><?=__d('member', 'select_account')?></h5>
						<div class="col-md-12 p-0" id="lst-current-subject">
							
						</div>
					</div>
					<!-- <div class="col-md-8">
						<h5>其他科目</h5>
						<div class="p-0 col-md-12" id="lst-all-subject">
							
						</div>
					</div> -->
				</div>
			</div>
			<div class="text-center">
				<button class="btn btn-w-radius btn-green" onclick="ASSIGNMENT_CREATE.confirm_modal_subject()" id="btn-confirm-subject" disabled>
					<?=__d('member', 'determine')?>
				</button>
			</div>
		</div>
	</div>
</div>
<?php
	echo $this->Html->script('pages/assignment_create.js?v='.date('U'));
?>
<script type="text/javascript">
	$(document).ready(function() {
		ASSIGNMENT_CREATE.init_page();
	});
</script>