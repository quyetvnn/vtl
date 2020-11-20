<div style="margin-bottom: 20px !important; min-height: 30px">
	<?php
		echo $this->element('menu/top_menu');
	?>
</div>
<div class="container teacher-create-lesson">
	<form class="col-md-8 form-data">
		<input type="hidden" value="<?=$id?>" id="teacher_create_assignment_id" />
		<input type="hidden" value="<?=$resubmit?>" id="resubmit" />
		<div class="row mbt-30 grb-dropfile">
			<div class="row m-0">
				<div class="col-md-6 p-0">
					<?=__d('member', 'upload_finished_assignment')?>
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
		<div class="row m-0">
			<button class="btn btn-w-radius btn-green" id="btn-submit-lesson" type="button" onclick="ASSIGNMENT_SUBMIT.submit_student_assignment()"><?=__d('member', 'submit')?></button>
		</div>
	</form>
</div>
<?php
	echo $this->Html->script('pages/assignment_submit.js?v='.date('U'));
?>
<script type="text/javascript">
	$(document).ready(function() {
		ASSIGNMENT_SUBMIT.init_page();
	});
</script>