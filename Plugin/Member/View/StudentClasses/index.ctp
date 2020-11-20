

<?php 
	echo $this->element('menu/top_menu');
	$name = "";

	$current_user = $this->Session->read('Member.current');
				
	if ($current_user) {
		$name = isset($current_user['Member']['MemberLanguage']) ? reset($current_user['Member']['MemberLanguage'])['name'] : array();
	}

?>

<? if ($count == 0) { ?>
	<h2>  <font style="color:green; font-weight: bold"> <?= $name ?>  </font> 你好！你今天沒有課堂 </h2>

<?php } else { ?>
	<h2>  <font style="color:green; font-weight: bold"> <?= $name ?> </font> 你好！今天你有 <?= $count ?> 課堂 </h2>

<?php } ?>

<div class="row" style='margin-top: 20px;'>

	<?php 
		$is_first_item = true;
		foreach($teacherCreateLessons as $val): 
			$is_show = false;
			foreach($studentClasses as $student): 
			
				$list_class  = $val['TeacherCreateLesson']['list_class'];
				if (!is_null($list_class) && !empty($list_class)) {
					foreach (json_decode($list_class) as $class) {
						if ($class == $student['StudentClass']['school_class_id']) {
							$is_show = true;
						}
					}
				}
			endforeach; 

			if (!$is_show) {
				continue;
			}

			$is_active = false;
			if ($is_first_item) {
				$is_active = true;
			}

	?>

			<a href="<?= $val['TeacherCreateLesson']['meeting'] ?>"  target="_blank">
				<div class="col-md-2 lesson <?= ($is_active) ? 'lesson-active' : '' ?>">
					<span class="header-image">  </span> 
					<h3 class="header"> <?= $val['TeacherCreateLesson']['lesson_title']; ?> </h3> 
					<div class="body">
						<div class="text">
							<?php 
								echo $this->Html->image('lesson-card/overrides/icon/tutor-white.png', ['alt' => '', 'class' => "landing-tutor-icon"]); 
								echo isset($val['Teacher']['MemberLanguage']) ? reset($val['Teacher']['MemberLanguage'])['name'] : array();
							?>
						</div>
						<div class="text">
							<?php 
								echo $this->Html->image('lesson-card/overrides/icon/time-white.png', ['alt' => '', 'class' => "landing-time-icon"]);

								$start_time = date('H:i', strtotime($val['TeacherCreateLesson']['start_time']));
								$duration_hour = $val['TeacherCreateLesson']['duration_hours'];
								$duration_minute = $val['TeacherCreateLesson']['duration_minutes'];

								$hour = '+' . $duration_hour . ' hour';
								$minute = '+' . $duration_minute . ' minute';

								$end_time = date('H:i', strtotime($val['TeacherCreateLesson']['start_time'] . $hour . $minute));

								echo $start_time . " - " . $end_time;
							?> 
						</div>
					</div>
					<div class="pull-right">
						<?= ($is_active) ? '進入教室 >' : '<div style="height: 25px;"></div>'; ?>
					</div>
				
				</div>
			</a>
		
	<?php 
			$is_first_item = false;
		endforeach; 
	?>
</div>


<?php // echo $this->element('Paginator'); ?>


<?php 
	echo $this->element('body/recommended_video');
?>