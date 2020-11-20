<?php
	$lesson = (isset($lesson) ? $lesson : array());
	$TeacherCreateLesson = $lesson['TeacherCreateLesson'];
	$School        = $lesson['School'];
	$Teacher 	   = $lesson['Teacher'];
	$SchoolSubject = $lesson['SchoolSubject'];
	$is_live = isset($is_live) ? $is_live : false;
	$is_nearly_live = isset($is_nearly_live) ? $is_nearly_live : false;
	$role = isset($role) ? $role : Environment::read("role.teacher");
	$school_avatar = '';
	$duration_in_second = $TeacherCreateLesson['duration_minutes']*60 + $TeacherCreateLesson['duration_hours']*60*60;
	$duration_remain = $TeacherCreateLesson['duration_minutes']*60 + $TeacherCreateLesson['duration_hours']*60*60;
?>
<div class="card-lesson bg-card-grey <?=$is_live?'live':''?>" id="card-<?=$TeacherCreateLesson['id']?>">
	<?php if($is_overlapped){ ?>
		<div class="is_overlapped">
			<i class="fa fa-exclamation-triangle" aria-hidden="true" data-toggle="tooltip" title="<?=__d('member', 'overlap_notice')?>"></i>
		</div>
	<?php } ?>
	<div class="row group-img-radius">
		<div class="box-img border-grey pull-left">
			<?php foreach($School['SchoolImage'] as $item){ 
						if($item['image_type_id']==1){
							$school_avatar = $this->Html->image(Router::url('/', true).$item['path'], ['class' => "profile-image"]);
							break;
				 		} 
				 	} 
				 	if(empty($school_avatar)){
				 		$school_avatar = "<span class='default-text-avatar'>".$this->App->get_minimal_name($School['SchoolLanguage'][0]['name'])."</span>";
				 	}
				 	echo $school_avatar
			?>
		</div>
		<div class="addon-text" >
			<h3 id="lesson-title-preview">
				<?=$TeacherCreateLesson['display_card_subject']?$SchoolSubject['SchoolSubjectLanguage'][0]['name']:$TeacherCreateLesson['lesson_title']?>
			</h3>
		</div>
	</div>
	<div class="row summary m-0">
		<ul>
			<li class="item">
				<span class="icon icon-school p-0"></span>
				<span class="text-madras"><?=$School['SchoolLanguage'][0]['name']?></span>
			</li>
			<li class="item">
				<?php if($role==Environment::read("role.teacher")){ ?>
					<span class="icon icon-class"></span>
					<span class="text-madras">
						<?php 
							$lst_teacher = array();
							foreach($TeacherCreateLesson['list_class_name'] as $t) {
								array_push($lst_teacher, $t);
							} 
							if(count($lst_teacher)>0){
								echo implode(__d('member', 'symbol_comma'), $lst_teacher);
							}else{
								echo "-";
							}
						?>
					</span>
				<?php }else if($role==Environment::read("role.student")){?>
					<span class="icon icon-tutor"></span>
					<span class="text-madras">
						<?php 
							if(isset($Teacher['MemberLanguage'][0]['name'])){
								echo $Teacher['MemberLanguage'][0]['name'];
							}else echo '-';
						?>
					</span>
				<?php } ?>
			</li>
			<li class="item">
				<span class="icon icon-clock"></span>
				<span class="text-madras" id="lesson-start-time"><?=$TeacherCreateLesson['start_hour']?></span>
				 - 
				<span class="text-madras" id="lesson-end-time"><?=$TeacherCreateLesson['end_hour']?></span>
			</li>
			<?php if($role==Environment::read("role.teacher")){ ?>
				<li class="item a4l-a text-madras m-0">
					<?= __d('member', 'host_key').': 233242';?>
				</li>
			<?php } ?>
		</ul>
	</div>
	<div class="row m-0 lesson-router text-right" >
		
			<a  id="card-link-<?=$TeacherCreateLesson['id']?>" 
				target = "_blank" 
				href="<?=$role==Environment::read("role.teacher")?$TeacherCreateLesson['meeting']:'javascript:void(0)'?>" 
				class="a4l-a text-madras <?=$is_live?'':'hidden'?>"
				<?=$role==Environment::read("role.student")?'onclick="student_visit_zoom_link(event, '.$TeacherCreateLesson["id"].')"':''?> >

					<?=__d('member', 'enter_the_classroom')?>
					<span class="fa fa-angle-right" style="margin-left: 5px;"></span>
			</a>
			<a target="_blank" id="meeting-url-action-<?=$TeacherCreateLesson['id']?>" href="#"></a>
		
		<p class="text-red" id="countdown-<?=$TeacherCreateLesson['id']?>"></p>
	</div>
	<script type="text/javascript">
			$(document).ready(function(){
				var is_nearly_live = <?=$is_nearly_live?$is_nearly_live:'0'?>;
				var is_live = <?=$is_live?$is_live:'0'?>;
				var item_count_live, item_count_near;
				var now = 0;
				function countdown_near_live(){
					now+=1;
					var to_interval = '<?php echo strtotime($TeacherCreateLesson["start_time"]) ?>';

					var distance = to_interval - now ;

					var minutes = Math.floor((distance % ( 60 * 60)) / ( 60));
					var seconds = Math.floor((distance % ( 60)));
					var message = '';

					if(minutes==0){
						message = sprintf(lang.lesson_count_no_minute, seconds);
					}else{
						message = sprintf(lang.lesson_count, minutes, seconds);
					}
					document.getElementById("countdown-"+"<?=$TeacherCreateLesson['id']?>").innerHTML = message;

					// If the count down is finished, write some text
					if (distance < 0) {
						is_nearly_live = 0;
						document.getElementById("countdown-"+"<?=$TeacherCreateLesson['id']?>").innerHTML = lang.lesson_preparing;
					}
					if(distance<-30){
						clearInterval(item_count_near);
						now = parseInt(to_interval);
						item_count_live = setInterval(countdown_live, 1000);
						$("#card-"+"<?=$TeacherCreateLesson['id']?>").addClass('live');
						$("#countdown-"+"<?=$TeacherCreateLesson['id']?>").addClass('hidden');
						$("#card-link-"+"<?=$TeacherCreateLesson['id']?>").removeClass('hidden');
					}
				}
				function countdown_live(){
					now +=  1;
					var to_interval_start_time = '<?php echo strtotime($TeacherCreateLesson["start_time"]) ?>';
					var distance_start_time = to_interval_start_time - now;
					if(distance_start_time<=0 && distance_start_time >= -30 ){
						$("#card-link-"+"<?=$TeacherCreateLesson['id']?>").addClass('hidden');
						document.getElementById("countdown-"+"<?=$TeacherCreateLesson['id']?>").innerHTML = lang.lesson_preparing;
					}else{
						$("#card-link-"+"<?=$TeacherCreateLesson['id']?>").removeClass('hidden');
						$("#countdown-"+"<?=$TeacherCreateLesson['id']?>").addClass('hidden');
					}
					// Find the distance between now and the count down date
					var to_interval = '<?php echo strtotime($TeacherCreateLesson["end_time"]) ?>';

					var distance = to_interval - now ;
					
					if(distance <= 120){
						document.getElementById("card-link-"+"<?=$TeacherCreateLesson['id']?>").innerHTML = lang.lesson_remain_no_time;
						$("#card-link-"+"<?=$TeacherCreateLesson['id']?>").prop("onclick", null).off("click").attr('href', 'javascript:void(0)').attr('target', '_self');
					}
					if(distance <= 60){
						$("#card-link-"+"<?=$TeacherCreateLesson['id']?>").html(lang.lesson_expired);
						$("#card-"+"<?=$TeacherCreateLesson['id']?>").removeClass('live');
					}
					if (distance < 0) {
						clearInterval(item_count_live);
						$("#card-link-"+"<?=$TeacherCreateLesson['id']?>").prop("onclick", null).off("click").attr('href', 'javascript:void(0)').attr('target', '_self');
						$("#card-"+"<?=$TeacherCreateLesson['id']?>").css('display', 'none');
					}
		        };
		        
				if(is_nearly_live==1){
					now = parseInt('<?=time()?>');
					item_count_near = setInterval(countdown_near_live, 1000);
				}
				if(is_live==1){
					now = parseInt('<?=time()?>');
					item_count_live = setInterval(countdown_live, 1000);
				}
				
			})
			
			function openInNewTab(href) {
			  Object.assign(document.createElement('a'), {
			    target: '_blank',
			    href,
			  }).click();
			}
			function student_visit_zoom_link(e, teacher_create_lesson_id){
				e.preventDefault();
				e.stopPropagation();
				var data_form = {
	            	teacher_create_lesson_id: teacher_create_lesson_id
	            }
	            COMMON.call_ajax({
	            	url: COMMON.base_api_url+'api/member/teacher_create_lessons/student_visit_zoom_link.json',
	            	type: 'POST',
                    data: data_form,
                    dataType: 'json',
                    beforeSend: function(){
                    	$("#loadingDiv").css("display","none");
                    },
                    success: function(resp){
                    	if(resp.status === 200){
                    		var data_lesson = resp.params;
                    		if(data_lesson['meeting']!=undefined && data_lesson['meeting']!=null && data_lesson['meeting']!=''){
                    			var meeting = data_lesson['meeting'];
                    			bootbox.alert(sprintf(lang.enter_meeting_url, meeting));
                    		}else{
                    			bootbox.alert(sprintf(lang.error_meeting_url, "<?=$School['SchoolLanguage'][0]['name']?>"));
                    		}
                    	}
                    }
	            });
			}
	</script>
</div>

	
