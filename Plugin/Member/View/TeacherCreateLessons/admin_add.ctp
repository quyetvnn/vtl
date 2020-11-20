<div class="teacherCreateLessons form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __d('member', 'admin_add_teacher_create_lesson'); ?></h1>
			</div>
		</div>
	</div>



	<div class="row">
		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('operation'); ?></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">

																<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Teacher Create Lessons'), array('action' => 'index'), array('escape' => false)); ?></li>
									<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Schools'), array('controller' => 'schools', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New School'), array('controller' => 'schools', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List School Classes'), array('controller' => 'school_classes', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New School Class'), array('controller' => 'school_classes', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Members'), array('controller' => 'members', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Teacher'), array('controller' => 'members', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('TeacherCreateLesson', array('role' => 'form')); ?>

				<div class="form-group">
					<?php echo $this->Form->input('school_id', array('class' => 'form-control', 'placeholder' => 'School Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('school_class_id', array('class' => 'form-control', 'placeholder' => 'School Class Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('teacher_id', array('class' => 'form-control', 'placeholder' => 'Teacher Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('start_time', array('class' => 'form-control', 'placeholder' => 'Start Time'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('duration', array('class' => 'form-control', 'placeholder' => 'Duration'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('meeting', array('class' => 'form-control', 'placeholder' => 'Meeting'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('created_by', array('class' => 'form-control', 'placeholder' => 'Created By'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('updated_by', array('class' => 'form-control', 'placeholder' => 'Updated By'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
