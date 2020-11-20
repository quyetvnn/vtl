<div class="studentClasses form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Add Student Class'); ?></h1>
			</div>
		</div>
	</div>



	<div class="row">
		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Actions'); ?></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">

																<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Student Classes'), array('action' => 'index'), array('escape' => false)); ?></li>
									<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Members'), array('controller' => 'members', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Student'), array('controller' => 'members', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Schools'), array('controller' => 'schools', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New School'), array('controller' => 'schools', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List School Classes'), array('controller' => 'school_classes', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New School Class'), array('controller' => 'school_classes', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('StudentClass', array('role' => 'form')); ?>

				<div class="form-group">
					<?php echo $this->Form->input('student_id', array('class' => 'form-control', 'placeholder' => 'Student Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('school_id', array('class' => 'form-control', 'placeholder' => 'School Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('school_class_id', array('class' => 'form-control', 'placeholder' => 'School Class Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('class_no', array('class' => 'form-control', 'placeholder' => 'Class No'));?>
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
