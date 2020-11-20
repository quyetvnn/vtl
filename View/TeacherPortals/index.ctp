

<?php 
	echo $this->element('menu/top_menu');
	$name = "";
				
	if (isset($current_user) && $current_user!='') {
		$name = isset($current_user['nick_name']) && !empty($current_user['nick_name']) ? $current_user['nick_name'] : $current_user['full_name'];
	}
?>

<div class="row m-0">
	<div class="col-xs-12">

<?php if ($count == 0) { ?>
	<h2 class="main-title"><?=__d('member', 'hello')?> <font style="color:green; font-weight: bold"> <?= $name ?> </font> ！<?=__d('member', 'you_have_no_class_today')?> </h2>
<?php }else if($count == 1){ ?>
	<h2 class="main-title"><?=__d('member', 'hello')?> <font style="color:green; font-weight: bold"> <?= $name ?> </font> ！<?= sprintf(__d('member', 'today_you_have'), 1);?> </h2>
<?php } else { ?>
	<h2 class="main-title"><?=__d('member', 'hello')?> <font style="color:green; font-weight: bold"> <?= $name ?> </font> ！<?= sprintf(__d('member', 'you_have_many_class_today'), $count);?> </h2>
<?php } ?>

	</div>
</div>

<div class="row group-card-lesson" >
	<div class=" lesson-slider" >
		<?php 
			foreach($lst_active_lesson as $lesson){ 
				echo $this->element('card_lesson',array(
									'lesson' => $lesson,
									'is_live' => true,
									'is_nearly_live' => false,
									'is_overlapped' => in_array($lesson['TeacherCreateLesson']['id'], $lst_overlapped_id),
									'role' => Environment::read("role.teacher")
								));
			}
		?>
		<?php 
			foreach($lst_nearly_active_lesson as $lesson){ 
				echo $this->element('card_lesson',array(
									'lesson' => $lesson,
									'is_live' => false,
									'is_nearly_live' => true,
									'is_overlapped' => in_array($lesson['TeacherCreateLesson']['id'], $lst_overlapped_id),
									'role' => Environment::read("role.teacher")
								));
			}
		?>
		<?php 
			foreach($lst_inactive_lesson as $lesson){ 
				echo $this->element('card_lesson',array(
									'lesson' => $lesson,
									'is_live' => false,
									'is_nearly_live' => false,
									'is_overlapped' => in_array($lesson['TeacherCreateLesson']['id'], $lst_overlapped_id),
									'role' => Environment::read("role.teacher")
								));
			}
		?>
	</div>
</div>


<?php // echo $this->element('Paginator'); ?>


<?php 
	echo $this->element('body/recommended_video');
?>