<div class="teacherCreateLessons view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Teacher Create Lesson'); ?></h1>
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
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Teacher Create Lesson'), array('action' => 'edit', $teacherCreateLesson['TeacherCreateLesson']['id']), array('escape' => false)); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Teacher Create Lesson'), array('action' => 'delete', $teacherCreateLesson['TeacherCreateLesson']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $teacherCreateLesson['TeacherCreateLesson']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Teacher Create Lessons'), array('action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Teacher Create Lesson'), array('action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Schools'), array('controller' => 'schools', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New School'), array('controller' => 'schools', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List School Classes'), array('controller' => 'school_classes', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New School Class'), array('controller' => 'school_classes', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Members'), array('controller' => 'members', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Teacher'), array('controller' => 'members', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">			
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<tbody>
				<tr>
		<th><?php echo __('Id'); ?></th>
		<td>
			<?php echo h($teacherCreateLesson['TeacherCreateLesson']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('School'); ?></th>
		<td>
			<?php echo $this->Html->link($teacherCreateLesson['School']['id'], array('controller' => 'schools', 'action' => 'view', $teacherCreateLesson['School']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('School Class'); ?></th>
		<td>
			<?php echo $this->Html->link($teacherCreateLesson['SchoolClass']['name'], array('controller' => 'school_classes', 'action' => 'view', $teacherCreateLesson['SchoolClass']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Teacher'); ?></th>
		<td>
			<?php echo $this->Html->link($teacherCreateLesson['Teacher']['id'], array('controller' => 'members', 'action' => 'view', $teacherCreateLesson['Teacher']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Start Time'); ?></th>
		<td>
			<?php echo h($teacherCreateLesson['TeacherCreateLesson']['start_time']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Duration'); ?></th>
		<td>
			<?php echo h($teacherCreateLesson['TeacherCreateLesson']['duration']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Meeting'); ?></th>
		<td>
			<?php echo h($teacherCreateLesson['TeacherCreateLesson']['meeting']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Created'); ?></th>
		<td>
			<?php echo h($teacherCreateLesson['TeacherCreateLesson']['created']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Created By'); ?></th>
		<td>
			<?php echo h($teacherCreateLesson['TeacherCreateLesson']['created_by']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Updated'); ?></th>
		<td>
			<?php echo h($teacherCreateLesson['TeacherCreateLesson']['updated']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Updated By'); ?></th>
		<td>
			<?php echo h($teacherCreateLesson['TeacherCreateLesson']['updated_by']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>

