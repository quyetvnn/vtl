<?php 
	echo $this->element('menu/top_menu');
	$name = "";
?>


<? if ($count == 0) { ?>
	<h2> <?php echo __d('member', 'no_recording_video'); ?> </h2>
	
<?php } else { ?>

	<h2> <?=__d('member', 'recording_video')?> </h2>
	<div class="row">
	<?php 
			$is_first_item = true;
			foreach($teacherCreateLessonsRecordings as $val): 
				$TeacherCreateLesson = $val['TeacherCreateLesson'];
				$School        = $val['School'];
				$Teacher 	   = $val['Teacher'];
				$SchoolSubject = $val['SchoolSubject'];
				$school_avatar = '';
		?>
		<div class="card-lesson bg-card-grey col-md-3">
			<a href="<?= $val['TeacherCreateLesson']['recording_video'] ?>"  target="_blank">
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
							 	echo $school_avatar;
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
							<span class="fa fa-graduation-cap"></span>
							<span class="text-madras"><?=$School['SchoolLanguage'][0]['name']?></span>
						</li>
						<li class="item">
							<span class="fa fa-user-o"></span>
							<span class="text-madras">
								<?php 
									if(isset($Teacher['MemberLanguage'][0]['name'])){
										echo $Teacher['MemberLanguage'][0]['name'];
									}else echo '-';
								?>
							</span>
						</li>
						<li class="item">
							<span class="fa fa-clock-o"></span>
							<span class="text-madras" id="lesson-start-time"><?=$TeacherCreateLesson['start_hour']?></span>
							- 
							<span class="text-madras" id="lesson-end-time"><?=$TeacherCreateLesson['end_hour']?></span>
						</li>
					</ul>
				</div>
				<div class="row m-0 lesson-router text-right">
					<!-- <a href="<?=$TeacherCreateLesson['meeting']?>" class="a4l-a text-dark-green"><?=__d('member', 'view_video')?><span class="fa fa-angle-right" style="margin-left: 5px;"></span></a> -->
				</div>
			</a>
		</div>
		<?php 
			endforeach; 
		?>
	</div>

<?php } ?>