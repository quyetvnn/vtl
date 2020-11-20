<div style="margin-bottom: 20px !important; min-height: 30px">
	<?php echo $this->element('menu/top_menu'); ?>
</div>
<div class="container teacher-create-lesson">
	<div class="col-md-12">
		<h3><?php echo __d('member', 'teacher_feedback_assignment'); ?></h3>
	</div>
	<form class="col-md-8 form-data">
		<div class="row m-0">
			<label class="normal-weight col-md-12 p-0"><?=__d('member', 'score')?></label>
			<div class="col-md-8 p-0 pointer clearfix" >
				<input class="form-control a4l-input required" id="score" value="<?=$studentAssignmentSubmission['StudentAssignmentSubmission']['score']?>" />
			</div>
		</div>
		<div class="row m-0">
			<label class="normal-weight col-md-12 p-0"><?=__d('member', 'feedback')?></label>
			<div class="col-md-8 p-0 pointer clearfix" >
				<input class="form-control a4l-input required" id="feedback" value="<?=$studentAssignmentSubmission['StudentAssignmentSubmission']['feedback']?>"/>
			</div>
		</div>
		<div class="row m-0">
			<label class="normal-weight col-md-12 p-0"><?=__d('member', 'remark').__d('member', 'internal_view_only')?> </label>
			<div class="col-md-8 p-0 pointer clearfix" >
				<input class="form-control a4l-input required" id="remark" value="<?=$studentAssignmentSubmission['StudentAssignmentSubmission']['remark']?>" />
			</div>
		</div>
		<?php if($resubmit==0){ ?>
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
		<?php } ?>
		
		<div class="row m-0">
			<button class="btn btn-w-radius btn-green" id="btn-submit-create-assignment" type="button" onclick="SUBMISSION_FEEDBACK_CREATE.submit_teacher_create_submission_feeback()"><?=__d('member', 'complete')?></button>
		</div>
	</form>
</div>

<?php
	echo $this->Html->script('pages/submission_feedback_create.js?v='.date('U'));
?>
<script type="text/javascript">
	$(document).ready(function() {
		SUBMISSION_FEEDBACK_CREATE.init_page("<?=$this->request->params['pass'][0]?>");
	});
</script>