<div class="studentClasses view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Student Class'); ?></h1>
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
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Student Class'), array('action' => 'edit', $studentClass['StudentClass']['id']), array('escape' => false)); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Student Class'), array('action' => 'delete', $studentClass['StudentClass']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $studentClass['StudentClass']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Student Classes'), array('action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Student Class'), array('action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Members'), array('controller' => 'members', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Student'), array('controller' => 'members', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Schools'), array('controller' => 'schools', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New School'), array('controller' => 'schools', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List School Classes'), array('controller' => 'school_classes', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New School Class'), array('controller' => 'school_classes', 'action' => 'add'), array('escape' => false)); ?> </li>
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
			<?php echo h($studentClass['StudentClass']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Student'); ?></th>
		<td>
			<?php echo $this->Html->link($studentClass['Student']['id'], array('controller' => 'members', 'action' => 'view', $studentClass['Student']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('School'); ?></th>
		<td>
			<?php echo $this->Html->link($studentClass['School']['id'], array('controller' => 'schools', 'action' => 'view', $studentClass['School']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('School Class'); ?></th>
		<td>
			<?php echo $this->Html->link($studentClass['SchoolClass']['name'], array('controller' => 'school_classes', 'action' => 'view', $studentClass['SchoolClass']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Class No'); ?></th>
		<td>
			<?php echo h($studentClass['StudentClass']['class_no']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Created'); ?></th>
		<td>
			<?php echo h($studentClass['StudentClass']['created']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Updated'); ?></th>
		<td>
			<?php echo h($studentClass['StudentClass']['updated']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Created By'); ?></th>
		<td>
			<?php echo h($studentClass['StudentClass']['created_by']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Updated By'); ?></th>
		<td>
			<?php echo h($studentClass['StudentClass']['updated_by']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>

