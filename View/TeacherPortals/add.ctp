<?= $this->element('menu/top_menu') ?>
<?php
	$addition_data = '';
?>
<style>
	.icon.icon-text-time:after{
		content: '<?=__d("member", "time")?>';
	}
</style>
<div class="container teacher-create-lesson">
	<div class="row">
		<div class="col-md-12">
			<h3><?=__d('member', 'add_class')?></h3>
		</div>
		<form class="col-md-7 form-data" id="teacher-create-lesson-form">
			<input type="hidden" name="school_subject" id="subject_id" value=""  required/>
			<input type="hidden" name="school_class" value="" required/>
			<input type="hidden" name="school_teacher" value="" />
			<div class="row mbt-30 group-icon-top icon-school">
				<label class="normal-weight col-md-12 p-0"><?=__d('member', 'school')?></label>
				<div class="col-md-8 pointer clearfix p-0">
					<select name="school_id" class="a4l-input form-control " id="school_id_add" required>
						<option value=""><?=__d('member', 'choose_a_school')?></option>
						<?php
							if(isset($current_user['member_role'][Environment::read('role.teacher')])){
								foreach ($current_user['member_role'][Environment::read('role.teacher')] as $key => $role){
									$addition_data .= '<input type="hidden" id="school-code-'.$role['school_id'].'" value="'.$role['School']['school_code'].'" />';
									$addition_data .= '<input type="hidden" id="school-name-'.$role['school_id'].'" value="'.$role['School']['SchoolLanguage'][0]['name'].'" />';
						?>
							<option value="<?=$role['school_id']?>" 
									<?=count($current_user['member_role'][Environment::read('role.teacher')])==1?'selected':''?>>
									<?=$role['School']['SchoolLanguage'][0]['name']?> (<?=$role['School']['school_code']?>)
							</option>
							
						<?php } } ?>
					</select>
					<?=$addition_data?>
				</div>
				
			</div>

			<div class="row mbt-30">
				<label class="normal-weight col-md-12 p-0"><?=__d('member', 'class')?></label>
				<div class="col-md-8 a4l-input pointer clearfix" onclick="TEACHER_CREATE_LESSON.call_modal_class(true)">
					<p class="pull-left default-text class-option-name" ><?=__d('member', 'choose_a_class')?></p>
					<p class="pull-left text-dark-green hidden" id="class-option-name"></p>
					<span class="fa fa-angle-down text-grey arrow-right pull-right"></span>
				</div>
			</div>

			<div class="row mbt-30 group-icon-top icon-subject">
				<label class="normal-weight col-md-12 p-0"><?=__d('member', 'subject')?></label>
				<div class="col-md-8 a4l-input pointer clearfix" onclick="TEACHER_CREATE_LESSON.call_modal_subject(true)">
					<p class="pull-left default-text subject-option-name" ><?=__d('member', 'select_account')?></p>
					<p class="pull-left text-dark-green hidden" id="subject-option-name"></p>
					<span class="fa fa-angle-down text-grey arrow-right pull-right"></span>
				</div>
			</div>
			<div class="row mbt-30">
				<label class="normal-weight col-md-12 p-0"><?=__d('member', 'title')?></label>
				<div class="col-md-12 p-0 pointer clearfix" >
					<input class="form-control a4l-input" id="lesson_title" required placeholder="<?=__d('member', 'for_example_liu_hefa_and_brain_map')?>" />
				</div>
			</div>
			<div class="row mbt-30">
				<label class="normal-weight"><?=__d('member', 'which_name_do_you_want_the_class_card_to_display')?></label>
				<div class="col-md-12 p-0 grp-radio">
					<input type="radio" required name="display_name" id="display_name-subject" value="subject">
					<label class="normal-weight" for="display_name-subject"> <?=__d('member', 'subject')?> </label>

					<input type="radio" required name="display_name" id="display_name-lesson_title" value="lesson_title">
					<label class="normal-weight" for="display_name-lesson_title"> <?=__d('member', 'title')?> </label>
				</div>
			</div>
			<!-- <div class="row mbt-30">
				<label class="normal-weight"><?=__d('member', 'about_this_lesson')?> (<?=__d('member', 'optional')?>)</label>
				<div class="col-md-12 p-0">
					<textarea class="a4l-input" style="width: 100%" placeholder="<?=__d('member', 'lesson_description_sample')?>" id="lesson_description" rows="15"></textarea>
				</div>
			</div> -->
			<!-- <div class="row mbt-30 grb-dropfile">
				<div class="row m-0">
					<div class="col-md-6 p-0">
						<?=__d('member', 'teaching_material')?> (<?=__d('member', 'optional')?>)
					</div>
					<div class="col-md-6 p-0 text-right text-grey">
						 docx, ppt, xls, xlsx, pdf, jpg, jpeg, png
					</div>
				</div>
				<div class="row m-0">
					<div class="col-md-12 p-0 import-file-area pointer">
						<p class="text-grey-light"><span class="fa fa-cloud-upload"></span><?=__d('member', 'upload_file_or_drag_it_here')?></p>
						<p class="text-grey-light">(<?=__d('member', 'less_than_5mb_per_file')?>)</p>
					</div>
					<input type="file" class="hidden" id="upload-material" accept=".docx, .ppt, .xls, .xlsx, .pdf, .jpg, .jpeg, .png" multiple/>
					<div class="col-md-12 p-0 ">
						<ul class="lst-imported-file" id="lst-imported-material"></ul>
					</div>
				</div>
			</div> -->
			<div class="row mbt-30 group-icon-top icon-people">
				<label class="normal-weight col-md-12 p-0"><?=__d('member', 'co_teaching')?> (<?=__d('member', 'optional')?>)</label>
				<div class="col-md-8 a4l-input pointer clearfix" onclick="TEACHER_CREATE_LESSON.call_modal_teacher(true)"> 
					<p class="pull-left default-text teacher-option-name" id="teacher-option-name-default-text"><?=__d('member', 'choose_a_teacher')?></p>
					<p class="pull-left text-dark-green hidden teacher-option-name" id="teacher-option-name"></p>
					<span class="fa fa-angle-down text-grey arrow-right pull-right"></span>
				</div>
			</div>
			<div class="row mbt-30">
				<label class="normal-weight col-md-12 p-0"><?=__d('member', 'you_can_also_invite_other_teachers_to_observe')?> (<?=__d('member', 'optional')?>)</label>
				<div class="col-md-8 a4l-input pointer clearfix" onclick="TEACHER_CREATE_LESSON.call_modal_attend_teacher(true)">
					<p class="pull-left default-text attend-teacher-option-name" id="attend-teacher-option-name-default-text"><?=__d('member', 'choose_a_teacher')?></p>
					<p class="pull-left text-dark-green attend-teacher-option-name hidden" id="attend-teacher-option-name"></p>
					<span class="fa fa-angle-down text-grey arrow-right pull-right"></span>
				</div>
			</div>
			<div class="row mbt-30 group-icon-top icon-date">
				<label class="normal-weight col-md-12 pl-0"><?=__d('member', 'date_n_time')?></label>
				<div class="col-md-8 pl-0 a4l-datetimepicker input-w-icon-t pointer clearfix">
					<?php
						echo $this->element('datetime_picker',array(
								'format' => 'YYYY-MM-DD',
								'class' => ' a4l-input custom-datetime-picker m-0 no-text-indent ',
								'required' 	=> 'required',
								'field_name' => '',
								'minDate' => date('Y-m-d'),
								'placeholder' => __d('member', 'sample_date'),
								'id' 		=> 'lesson_date',
							));
					?>
					<span class="icon-calendar icon unit"></span>
				</div>
				<div class="col-md-4 p-0 a4l-datetimepicker input-w-icon-t pointer clearfix">
					<?php
						echo $this->element('time_picker',array(
								'format' => 'HH:mm',
								'class' => ' a4l-input custom-datetime-picker m-0 ',
								'field_name' => '',
								'required' 	=> 'required',
								'disabled' =>  'disabled',
								'placeholder' => __d('member', 'start_time'),
								'id' 		=> 'start_time',
							));
					?>
					<span class="icon-text-time icon"></span>
					<span class="fa fa-angle-down text-grey arrow-right unit"></span>
				</div>
			</div>
			<div class="row mbt-30">
				<div class="col-md-12 p-0">
					<div class="col-md-8 pl-0 pointer clearfix">
						<?php
							echo $this->Form->input('duration_hour_id', array(
								'class' => ' a4l-input form-control m-0 ',
								'empty' => __d('member', "please_select_hours"),
								'value' => array(),
								'required' 	=> 'required',
								'placeholder' => '小時',
								'id'=>"duration_hours",
								'name'=>"duration_hours",
								'label' => '<label class="normal-weight">'.__d('member', 'duration').'</label>'
							));
						?>
					</div>
					<div class="col-md-4 p-0 pointer clearfix">
						<?php
							echo $this->Form->input('duration_minute_id', array(
								'class' => ' a4l-input form-control ',
								'empty' => __d('member', "please_select_minute"),
								'value' => array(),
								'required' 	=> 'required',
								'placeholder' => '分鐘',
								'id'=>"duration_minutes",
								'name'=>"duration_minutes",
								'label' => ''
							));
						?>
					</div>
				</div>
			</div>
			<div class="row mbt-30">
				<label class="normal-weight col-md-12 p-0"><?=__d('member', 'repeat')?></label>
				<div class="col-md-12 p-0 grp-radio">
					<input type="radio" required name="cycle" id="cycle-1" value="10">
					<label class="normal-weight" for="cycle-1"> <?=__d('member', 'no_repeat')?> </label>

					<input type="radio" required name="cycle" id="cycle0" value="0">
					<label class="normal-weight" for="cycle0"> <?=__d('member', 'every_day')?> </label>

					<input type="radio" required name="cycle" id="cycle1" value="1">
					<label class="normal-weight" for="cycle1"> <?=__d('member', 'weekly')?> </label>
					<!-- <label class="normal-weight"><input type="radio" class="required" name="repeat" value="每月"> 每月 </label> -->
				</div>
				<div class="col-md-12 p-0 grp-frequency grp-radio hidden" id="grp-frequency">
					<input type="radio" name="allow_frequency" id="allow_frequency1" value = "1"/>
					<label class="normal-weight" for="allow_frequency1"> <?=__d('member', 'repeat')?> </label>

					<select class="a4l-input form-control input-100" id="frequency" name="frequency">
						<option value="1" selected>1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
					
					<!-- <input type="text" class="a4l-input form-control input-50" name="frequency" id="frequency"/> -->
					<label class="normal-weight" for="frequency"> <?=__d('member', 'after')?> (<?=__d('member', 'limit_frequence')?>)</label>
					
				</div>
			</div>
			<div class="row mbt-30 group-icon-top icon-video">
				<label class="normal-weight col-md-12 p-0"><?=__d('member', 'after_the_live_broadcast_should_the_video_be_opened_for_students_to_relive').' '.__d('member', 'record_note')?></label>
				<div class="col-md-12 p-0 grp-radio">
					<input type="radio" required id="allow_playback0" name="allow_playback" value="0">
					<label class="normal-weight" for="allow_playback0"> <?=__('no') ?> </label>
					<input type="radio" required id="allow_playback1" name="allow_playback" value="1">
					<label class="normal-weight" for="allow_playback1"> <?=__('yes')?> </label>
				</div>
			</div>
			<div class="row m-0">
				<button class="btn btn-w-radius btn-green" id="btn-submit-lesson" type="button" onclick="TEACHER_CREATE_LESSON.submit_create_lesson()" disabled><?=__d('member', 'submit')?></button>
			</div>
			<div id="modal-subject" class="w3-modal modal-600 teacher-create-lesson">
				<div class="w3-modal-content ">
					<div class="bg-white">
						<div class="close-modal">
							<span onclick="TEACHER_CREATE_LESSON.call_modal_subject(false)" title="Close Modal" style="">&times;</span>
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
							</div>
						</div>
						<div class="text-center">
							<button class="btn btn-w-radius btn-green" onclick="TEACHER_CREATE_LESSON.confirm_modal_subject()" id="btn-confirm-subject" disabled>
								<?=__d('member', 'determine')?>
							</button>
						</div>
					</div>
				</div>
			</div>

			<div id="modal-classes" class="w3-modal modal-600 teacher-create-lesson">
				<div class="w3-modal-content ">
					<div class="bg-white">
						<div class="close-modal">
							<span onclick="TEACHER_CREATE_LESSON.call_modal_class(false)" title="Close Modal" style="">&times;</span>
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
							<button class="btn btn-w-radius btn-green" onclick="TEACHER_CREATE_LESSON.confirm_modal_class()" id="btn-confirm-class" disabled>
								<?=__d('member', 'determine')?>
							</button>
						</div>
					</div>
				</div>
			</div>

			<div id="modal-teachers" class="w3-modal modal-600 teacher-create-lesson">
				<div class="w3-modal-content ">
					<div class="bg-white">
						<div class="close-modal">
							<span onclick="TEACHER_CREATE_LESSON.call_modal_teacher(false)" title="Close Modal" style="">&times;</span>
						</div>
						<div class="modal-body">
							<div class="w3-modal-header">
								<h3><?=__d('member', 'choose_a_teacher_to_teach_together')?> <span>(<?=__d('member', 'multiple_choice')?>)</span></h3>
							</div>
							<div class="row m-0">
								<div class="col-md-12 p-0">
									<h5 class="col-md-12 p-0"><?=__d('member', 'all_teachers')?></h5>
									<div class="col-md-12 p-0" id="lst-current-teachers"></div>
								</div>
							</div>
						</div>
						<div class="text-center">
							<button class="btn btn-w-radius btn-green" onclick="TEACHER_CREATE_LESSON.confirm_modal_teacher()" id="btn-confirm-teacher">
								<?=__d('member', 'determine')?>
							</button>
						</div>
					</div>
				</div>
			</div>

			<div id="modal-attend-teacher" class="w3-modal modal-600 teacher-create-lesson">
				<div class="w3-modal-content ">
					<div class="bg-white">
						<div class="close-modal">
							<span onclick="TEACHER_CREATE_LESSON.call_modal_attend_teacher(false)" title="Close Modal" style="">&times;</span>
						</div>
						<div class="modal-body">
							<div class="w3-modal-header">
								<h3><?=__d('member', 'choose_a_teacher_to_teach_together')?> <span>(<?=__d('member', 'multiple_choice')?>)</span></h3>
							</div>
							<div class="row m-0">
								<div class="col-md-12 p-0">
									<h5 class="col-md-12 p-0"><?=__d('member', 'all_teachers')?></h5>
									<div class="col-md-12 p-0" id="lst-attend-teacher"></div>
								</div>
							</div>
						</div>
						<div class="text-center">
							<button class="btn btn-w-radius btn-green" onclick="TEACHER_CREATE_LESSON.confirm_modal_attend_teacher()" id="btn-confirm-attend-teacher">
								<?=__d('member', 'determine')?>
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>

		<div class="col-md-5">
			<div class="card-lesson live">
				<div class="row group-img-radius">
					<?php
						if(isset($current_user['member_role'][Environment::read('role.teacher')])){
							$count = 0;
							foreach ($current_user['member_role'][Environment::read('role.teacher')] as $school){
								if(!empty($school['avatar'])){
	                				$avatar_school = $this->Html->image($school['avatar'], ['alt' => $school['name'], 'class' => "profile-image"]); 
	                			}else{
	                				$avatar_school = "<span class='default-text-avatar'>".$school['minimal_name']."</span>";
	                			}
	                			$hidden ='hidden';
	                			if($count == 0) {
	                				$hidden = '';
	                				$count++;
	                			}
	                			?>
	                			<div class="box-img border-grey pull-left avatar-lesson-card <?=$hidden?>" id="school-image-<?=$school['school_id']?>">
	                				<?=$avatar_school?>
	                			</div>
							<?php }
						}
					?>
					<div class="addon-text" >
						<h3 id="lesson-title-preview"></h3>
					</div>
				</div>
				<div class="row summary m-0">
					<ul>
						<li class="item">

							<span class="icon icon-school-white"></span>
							<?php
								if(isset($current_user['member_role'][Environment::read('role.teacher')])){
									foreach ($current_user['member_role'][Environment::read('role.teacher')] as $school){
							?>
								<span class="text-madras" id="preview-school-name"><?=$school['name']?></span>
							<?php  break;} } ?>
						</li>
						<li class="item">
							<span class="icon icon-tutor-white"></span>
							<span class="text-madras" id="lesson-co-teaching"><?=$current_user['name']?></span>
						</li>
						<li class="item">
							<span class="icon icon-clock-white"></span>
							<span class="text-madras" id="lesson-start-time"></span>
							 - 
							<span class="text-madras" id="lesson-end-time"></span>
						</li>
					</ul>
				</div>
			</div>
			<p class="text-center text-grey">
				<?=__d('member', 'the_class_card_will_be_displayed_on_each_participant_homepage_on_the_day_of_class')?>
			</p>
		</div>
	</div>
</div>

<?php
	echo $this->Html->script('pages/teacher_create_lesson.js?v='.date('U'));
?>
<script type="text/javascript">
	$(document).ready(function() {
		TEACHER_CREATE_LESSON.init_page();
	});
</script>