<?= $this->element('menu/top_menu') ?>
<style>
	.icon.icon-text-time:after{
		content: '<?=__d("member", "time")?>';
	}
</style>
<?php
	$addition_data = '';
	$lesson = $teacherLesson['TeacherCreateLesson'];
	$list_class = array();
	$list_teacher = array();
	$list_attend_teacher = array();

	if(count($lesson['list_class_name'])>0){
		$list_class = implode(__d('member', 'symbol_comma'), $lesson['list_class_name']);
	}else{
		$list_class =  "";
	}

	if(count($lesson['list_teacher_name'])>0){
		$list_teacher = implode(__d('member', 'symbol_comma'), $lesson['list_teacher_name']);
	}else{
		$list_teacher = "";
	}

	if(count($lesson['list_attend_teacher'])>0){
		$list_attend_teacher = implode(__d('member', 'symbol_comma'), $lesson['list_attend_teacher_name']);
	}else{
		$list_attend_teacher = "";
	}
	
?>
<div class="container teacher-create-lesson">
	<div class="row">
		<div class="col-md-12">
			<h3><?php echo __d('member', 'admin_edit_teacher_create_lesson'); ?></h3>
		</div>
		<form class="col-md-7 form-data" id="teacher-create-lesson-form">
			<input type="hidden" required name="subject_id" id="subject_id" value="<?=$lesson['subject_id']?>" />
			<input type="hidden" required name="list_class" id="list_class" value="<?=implode(',', $lesson['list_class'])?>" />
			<input type="hidden" name="list_teacher" id="list_teacher" value="<?=$lesson['list_teacher']?implode(',', $lesson['list_teacher']):''?>" />
			

			<input type="hidden" name="list_attend_teacher" id="list_attend_teacher" value="<?=$lesson['list_attend_teacher']?implode(',', $lesson['list_attend_teacher']):''?>" />

			<input type="hidden" name="teacher_create_lesson_id" id="teacher_create_lesson_id" value="<?=$lesson['id']?>" />

			<input type="hidden" name="display_card_subject" id="display_card_subject" value="<?=$lesson['display_card_subject']?>" />
			
			<div class="row mbt-30 group-icon-top icon-school">
				<label class="normal-weight col-md-12 p-0"><?=__d('member', 'school')?></label>
				<div class="col-md-8 pointer clearfix p-0">
					<select name="school_id" class="a4l-input form-control " id="school_id_add" disabled>
						<option value=""><?=__d('member', 'choose_a_school')?></option>
						<?php
							if(isset($current_user['member_role'][Environment::read('role.teacher')])){
								foreach ($current_user['member_role'][Environment::read('role.teacher')] as $key => $role){
									$addition_data .= '<input type="hidden" id="school-code-'.$role['school_id'].'" value="'.$role['School']['school_code'].'" />';
									$addition_data .= '<input type="hidden" id="school-name-'.$role['school_id'].'" value="'.$role['School']['SchoolLanguage'][0]['name'].'" />';
						?>
							<option value="<?=$role['school_id']?>" <?=$lesson['school_id']==$role['school_id']?'selected':''?>>
								<?=$role['School']['SchoolLanguage'][0]['name']?>
								(<?=$role['School']['school_code']?>)
							</option>
						<?php } } ?>
					</select>
					<?=$addition_data?>
				</div>
				
			</div>

			<div class="row mbt-30">
				<label class="normal-weight col-md-12 p-0"><?=__d('member', 'class')?></label>
				<div class="col-md-8 a4l-input pointer clearfix" onclick="TEACHER_EDIT_LESSON.call_modal_class(true)">
					<?php if($list_class==''){?>
						<p class="pull-left default-text" id="class-option-name"><?=__d('member', 'choose_a_class')?></p>
					<?php }else{ ?>
						<p class="pull-left text-dark-green" id="class-option-name"><?=$list_class?></p>
					<?php } ?>
					<span class="fa fa-angle-down text-grey arrow-right pull-right"></span>
				</div>
			</div>

			<div class="row mbt-30 group-icon-top icon-subject">
				<label class="normal-weight col-md-12 p-0"><?=__d('member', 'subject')?></label>
				<div class="col-md-8 a4l-input pointer clearfix" onclick="TEACHER_EDIT_LESSON.call_modal_subject(true)">
					<?php if($lesson['subject_name']!=''){?>
						<p class="pull-left text-dark-green" id="subject-option-name"><?=$lesson['subject_name']?></p>
					<?php }else{ ?>
						<p class="pull-left default-text" id="subject-option-name"><?=__d('member', 'select_account')?></p>
					<?php } ?>
					<span class="fa fa-angle-down text-grey arrow-right pull-right"></span>
				</div>
			</div>
			<div class="row mbt-30">
				<label class="normal-weight col-md-12 p-0"><?=__d('member', 'title')?></label>
				<div class="col-md-12 p-0 pointer clearfix" >
					<input class="form-control a4l-input" id="lesson_title" placeholder="<?=__d('member', 'for_example_liu_hefa_and_brain_map')?>" value="<?=$lesson['lesson_title']?>" required/>
				</div>
			</div>
			<div class="row mbt-30 group-icon-top icon-people">
				<label class="normal-weight col-md-12 p-0"><?=__d('member', 'co_teaching')?> (<?=__d('member', 'optional')?>)</label>
				<div class="col-md-8 a4l-input pointer clearfix" onclick="TEACHER_EDIT_LESSON.call_modal_teacher(true)"> 
					<p class="pull-left default-text <?=$list_teacher!=''?'hidden':''?> teacher-option-name" id="teacher-option-name-default-text"><?=__d('member', 'choose_a_teacher')?></p>
					<p class="pull-left text-dark-green <?=$list_teacher==''?'hidden':''?> teacher-option-name" id="teacher-option-name"><?=$list_teacher?></p>
					
					<span class="fa fa-angle-down text-grey arrow-right pull-right"></span>
				</div>
			</div>
			<div class="row mbt-30">
				<label class="normal-weight col-md-12 p-0"><?=__d('member', 'you_can_also_invite_other_teachers_to_observe')?> (<?=__d('member', 'optional')?>)</label>
				<div class="col-md-8 a4l-input pointer clearfix" onclick="TEACHER_EDIT_LESSON.call_modal_attend_teacher(true)">
					<p class="pull-left default-text attend-teacher-option-name <?=$list_attend_teacher!=''?'hidden':''?>" id="attend-teacher-option-name-default-text" ><?=__d('member', 'choose_a_teacher')?></p>
					<p class="pull-left text-dark-green attend-teacher-option-name <?=$list_attend_teacher==''?'hidden':''?>" id="attend-teacher-option-name"><?=$list_attend_teacher?></p>
					
					<span class="fa fa-angle-down text-grey arrow-right pull-right"></span>
				</div>
			</div>
			<div class="row mbt-30 group-icon-top icon-date">
				<label class="normal-weight col-md-12 p-0"><?=__d('member', 'date_n_time')?></label>
				<div class="col-md-8 pl-0 a4l-datetimepicker input-w-icon-t pointer clearfix">
					<?php
						echo $this->element('datetime_picker',array(
								'format' => 'YYYY-MM-DD',
								'class' => ' a4l-input custom-datetime-picker no-text-indent required ',
								'field_name' => '',
								'minDate' => date('Y-m-d'),
								'value' => date('Y-m-d H:i:s', strtotime($lesson["start_time"])),
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
									'class' => ' a4l-input custom-datetime-picker required ',
									'field_name' => '',
									'value' =>  $lesson["start_time"],
									'placeholder' => __d('member', 'from'),
									'id' 		=> 'start_time',
								));
						?>
						<span class="icon-text-time icon"></span>
						<span class="fa fa-angle-down text-grey arrow-right unit"></span>
					</div>
			</div>
			<div class="row mbt-30">
				<label class="normal-weight col-md-12 p-0"><?=__d('member', 'duration')?> </label>
				<div class="col-md-12  p-0">
					<div class="col-md-8 pl-0 pointer clearfix">
						<?php
							echo $this->Form->input('duration_hour_id', array(
								'class' => ' a4l-input form-control required ',
								'empty' => __d('member', "please_select_hours"),
								'value' => array(),
								'required' 	=> 'required',
								'placeholder' => '小時',
								'id'=>"duration_hours",
								'name'=>"duration_hours",
								'value' => isset($lesson["duration_hours"])?$lesson["duration_hours"]:array(),
								'label' => ''
							));
						?>
					</div>
					<div class="col-md-4 p-0 pointer clearfix">
						<?php
							echo $this->Form->input('duration_minute_id', array(
								'class' => ' a4l-input form-control required ',
								'empty' => __d("member", "please_select_minute"),
								'value' => array(),
								'required' 	=> 'required',
								'placeholder' => '分鐘',
								'id'=>"duration_minutes",
								'name'=>"duration_minutes",
								'value' => isset($lesson["duration_minutes"])?$lesson["duration_minutes"]:array(),
								'label' => ''
							));
						?>
					</div>
				</div>
			</div>
			<?php if(date('Y-m-d H:i:s', strtotime($lesson['start_time'])) >= date('Y-m-d H:i:s')){  ?>
				<div class="row mbt-30 group-icon-top icon-video">
					<label class="normal-weight col-md-12 p-0"><?=__d('member', 'after_the_live_broadcast_should_the_video_be_opened_for_students_to_relive').' '.__d('member', 'record_note')?></label>
					<div class="col-md-12 p-0 grp-radio">
						<input type="radio" class="required" id="allow_playback0" name="allow_playback" value="0" <?=$lesson['allow_playback']==0?'checked':''?>>
						<label class="normal-weight" for="allow_playback0"> <?=__('no')?> </label>

						<input type="radio" class="required" id="allow_playback1" name="allow_playback" value="1" <?=$lesson['allow_playback']==1?'checked':''?>>
						<label class="normal-weight" for="allow_playback1"> <?=__('yes')?> </label>
					</div>
				</div>
			<?php } ?>
			<div class="row m-0">
				<button class="btn btn-w-radius btn-green" id="btn-submit-lesson" type="button" onclick="TEACHER_EDIT_LESSON.submit_create_lesson()"><?=__d('member', 'submit')?></button>
			</div>

			<div id="modal-subject" class="w3-modal modal-600 teacher-create-lesson">
				<div class="w3-modal-content ">
					<div class="bg-white">
						<div class="close-modal">
							<span onclick="TEACHER_EDIT_LESSON.call_modal_subject(false)" title="Close Modal" style="">&times;</span>
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
							<button class="btn btn-w-radius btn-green" onclick="TEACHER_EDIT_LESSON.confirm_modal_subject()" id="btn-confirm-subject" >
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
							<span onclick="TEACHER_EDIT_LESSON.call_modal_class(false)" title="Close Modal" style="">&times;</span>
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
							<button class="btn btn-w-radius btn-green" onclick="TEACHER_EDIT_LESSON.confirm_modal_class()" id="btn-confirm-class" >
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
							<span onclick="TEACHER_EDIT_LESSON.call_modal_teacher(false)" title="Close Modal" style="">&times;</span>
						</div>
						<div class="modal-body">
							<div class="w3-modal-header">
								<h3><?=__d('member', 'choose_a_teacher_to_teach_together')?> <span>(<?=__d('member', 'multiple_choice')?>)</span></h3>
							</div>
							<div class="row m-0">
								<div class="col-md-12 p-0">
									<h5 class="col-md-12 p-0"><?=__d('member', 'all_teachers')?></h5>
									<div class="col-md-12 p-0" id="lst-current-teachers">
										
									</div>
								</div>
							</div>
						</div>
						<div class="text-center">
							<button class="btn btn-w-radius btn-green" onclick="TEACHER_EDIT_LESSON.confirm_modal_teacher()" id="btn-confirm-teacher" >
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
							<span onclick="TEACHER_EDIT_LESSON.call_modal_attend_teacher(false)" title="Close Modal" style="">&times;</span>
						</div>
						<div class="modal-body">
							<div class="w3-modal-header">
								<h3><?=__d('member', 'choose_a_teacher_to_teach_together')?> <span>(<?=__d('member', 'multiple_choice')?>)</span></h3>
							</div>
							<div class="row m-0">
								<div class="col-md-12 p-0">
									<h5 class="col-md-12 p-0"><?=__d('member', 'all_teachers')?></h5>
									<div class="col-md-12 p-0" id="lst-attend-teacher">
										
									</div>
								</div>
							</div>
						</div>
						<div class="text-center">
							<button class="btn btn-w-radius btn-green" onclick="TEACHER_EDIT_LESSON.confirm_modal_attend_teacher()" id="btn-confirm-attend-teacher">
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
						$_school = array();
						if(isset($current_user['member_role'][Environment::read('role.teacher')])){
							foreach ($current_user['member_role'][Environment::read('role.teacher')] as $school){
								$hidden ='hidden';
								if($school['school_id']==$lesson['school_id']){
									$_school = $school;
									$hidden = '';
								}
								if(!empty($school['avatar'])){
	                				$avatar_school = $this->Html->image($school['avatar'], ['alt' => $school['name'], 'class' => "profile-image"]); 
	                			}else{
	                				$avatar_school = "<span class='default-text-avatar'>".$school['minimal_name']."</span>";
	                			}
	                			?>
	                			<div class="box-img border-grey pull-left avatar-lesson-card <?=$hidden?>" id="school-image-<?=$school['school_id']?>">
	                				<?=$avatar_school?>
	                			</div>
							<?php } 
						}
						if(empty($_school)){
							$tmpArray = array_values($current_user['member_role'][Environment::read('role.teacher')]);
							$_school = array_shift($tmpArray);
						}
					?>
					<div class="addon-text" >
						<h3 id="lesson-title-preview">
							<?= $lesson['display_card_subject'] == 1 ? $teacherLesson['SchoolSubject']['SchoolSubjectLanguage'][0]['name'] : $lesson['lesson_title']?></h3>
					</div>
				</div>
				<div class="row summary m-0">
					<ul>
						<li class="item">
							<span class="icon icon-school-white"></span>
							<span class="text-madras"><?=$_school['name']?></span>
						</li>
						<li class="item">
							<span class="icon icon-tutor-white"></span>
							<span class="text-madras" id="lesson-co-teaching"><?=$current_user['name']?></span>
						</li>
						<li class="item">
							<span class="icon icon-clock-white"></span>
							<span class="text-madras lesson-start-time"><?php echo date("H:i", strtotime($lesson['start_time'])) ?></span>
							 - 
							<span class="text-madras lesson-end-time"><?php echo date("H:i", strtotime($lesson['end_time'])) ?></span>
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
	echo $this->Html->script('pages/teacher_edit_lesson.js?v='.date('U'));
?>
<script type="text/javascript">
	$(document).ready(function() {
		TEACHER_EDIT_LESSON.init_page();
	});
</script>
