<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>

<?= $this->element('School.School_filter', array(
	'data_search' => $data_search
)); ?>

<div class="row">
    <div class="col-xs-12">

    <div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo __d('school', 'schools'); ?></h3>
			<div class="box-tools pull-right">

				<?php 
					// if (!$school_id) {
					// 	echo $this->Html->link(__('<i class="glyphicon glyphicon-plus"></i>') . __('add'), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); 
					// }
				?>
            </div>
		</div>	
			<div class="box-body table-responsive">
                <table id="Schools" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id', __('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('school_code',		__d('school', 'school_code')); ?></th>
							<th class="text-center"><?php echo __d('school', 'school_logo'); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('email',	__d('member', 'email')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('name', __('name')); ?></th>
							<!-- <th class="text-center"><?php // echo $this->Paginator->sort('credit_charge',	__d('school', 'credit_charge')); ?></th>
							<th class="text-center"><?php //echo $this->Paginator->sort('credit',			__d('school', 'credit')); ?></th>
							<th class="text-center"><?php //echo $this->Paginator->sort('phone_number',	__d('member', 'phone_number')); ?></th> -->
							<th class="text-center"><?php echo $this->Paginator->sort('status',			__('status')); ?></th>
						
							<!-- <th class="text-center"><?php //echo $this->Paginator->sort('address',		__d('school', 'address')); ?></th>
							<th class="text-center"><?php //echo $this->Paginator->sort('created',		__('created')); ?></th>
							<th class="text-center"><?php //echo $this->Paginator->sort('created_by',		__('created_by')); ?></th> -->
							<th class="text-center"><?php echo __('operation'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($schools as $school): ?>
							<tr>
								<td class="text-center"><?php echo h($school['School']['id']); ?>&nbsp;</td>
								<td class="text-center"><?php echo h($school['School']['school_code']); ?>&nbsp;</td>
								<td class="text-center">
									<?php echo isset($school['SchoolImage']) && !empty($school['SchoolImage']) && reset($school['SchoolImage'])["path"] ? 
										$this->Html->image('../'. reset($school['SchoolImage'])["path"], array('class' => 'img-thumbnail preview')) : ""; ?>
								</td>
								<td class="text-center"><?php echo h($school['School']['email']); ?>&nbsp;</td>
							
								<td class="text-center"><?= isset(reset($school['SchoolLanguage'])['name']) ? reset($school['SchoolLanguage'])['name'] : ''; ?> &nbsp;</td>
								<!-- <td class="text-center" ><?php //echo h(number_format($school['School']['credit_charge'], 0)); ?>&nbsp;</td>
								<td class="text-center red" style="font-weight: bold"><?php //echo h(number_format($school['School']['credit'], 0)); ?>&nbsp;</td>
								<td class="text-center"><?php //echo h($school['School']['phone_number']); ?>&nbsp;</td> -->
								<td class="text-center">
									<?php
										if ($school['School']['status'] == array_search('Normal', $status)) { ?>
											<label class="label label-success"> <?= __d('school', 'normal'); ?> </label> 
									
									<?php } elseif ($school['School']['status'] == array_search('Blocked', $status)) { ?>
										<label class="label label-danger"> <?= __d('school', 'blocked'); ?> </label> 
									
									<?php } else { ?>
										<label class="label label-warning"> <?= __d('school', 'closed'); ?> </label> 
									<?php } ?>
								
								</td>
							
								<!-- <td class="text-center"><?php //echo h($school['School']['address']); ?>&nbsp;</td>
								<td class="text-center"><?php //echo h($school['School']['created']); ?>&nbsp;</td>
								<td class="text-center"><?php //echo h($school['CreatedBy']['email']); ?>&nbsp;</td> -->
								
								<td class="text-center">
									<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('action' => 'view', $school['School']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('view'))); ?>
									<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>'), array('action' => 'edit', $school['School']['id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('edit'))); ?>
									<?php 
									if (!$school_id) {
										echo $this->Form->postLink(__('<i class="glyphicon glyphicon-trash"></i>'), array('action' => 'delete', $school['School']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('delete')), __('Are you sure you want to delete # %s?', $school['School']['id']));
									} 
									?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->
			
			
		</div><!-- /.index -->
	
	</div><!-- /#page-content .col-sm-9 -->
	<?php echo $this->element('Paginator'); ?>	</div><!-- /#page-content .col-sm-9 -->
</div><!-- /#page-container .row-fluid -->
