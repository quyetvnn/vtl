<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __('push'); ?></h3>
				
				<div class="box-tools pull-right">
                    <?php
                    if(isset($permissions['Push']['add']) && ($permissions['Push']['add'] == true)){
                        echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i>' . __('add'), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); 
                    }
                    ?>
				</div>
			</div>	

			<div class="box-body table-responsive">
				<table id="Pushes" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id', 			__('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('push_group', 	__d('push', 'push_group')); ?></th>
						
							<th class="text-center"><?php echo $this->Paginator->sort('push_method', 	__d('push', 'push_method')); ?></th>
						
							<th class="text-center"><?php echo $this->Paginator->sort('title',		 			__d('push', 'title')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('short_description', 		__d('push', 'message')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('enabled', __('enabled')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('created', __('created')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('created_by', __('created_by')); ?></th>
							<th class="text-center"><?php echo __('operation'); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($pushes as $push): ?>
							<tr>
								<td class="text-center"><?php echo h($push['Push']['id']); ?>&nbsp;</td>

								<td class="text-center">
									<?php 
										// 1 => 'System Maintennace',
										// 2 => 'Promotion',
										// 3 => 'Course Information',	
										// 4 => 'Payment Information',
										// 5 => 'System Annoument',

										switch ($push['Push']['push_group']) {
											case array_search('System Maintennace', $push_group): ?>
												<label class='label label-danger'> <?= __d('push', 'system_maintennace') ?> </label> 

											<?php break;
											case array_search('Promotion', $push_group): ?>
												<label class='label label-warning'> <?= __d('push', 'promotion')  ?> </label> 

											<?php break;
											case array_search('Course Information', $push_group): ?>
												<label class='label label-success'> <?= __d('push', 'course_information') ?> </label> 
											
											<?php break;
											case array_search('Payment Information', $push_group): ?>
												<label class='label label-primary'> <?= __d('push', 'payment_information')  ?> </label> 
											
											<?php break;
											case array_search('System Annoument', $push_group): ?>
												<label class='label label-info'> <?= __d('push', 'system_annoument') ?> </label> 

											<?php break;
										
										}
									?>
								</td> 


								<td class="text-center">
									<?php 
										switch ($push['Push']['push_method']) {
											case array_search('Push to all', $push_method): ?>
												<label class='label label-warning'> <?= __d('push', 'push_to_all') ?> </label> 

											<?php break;
											case array_search('Push to all (student)', $push_method): ?>
												<label class='label label-warning'> <?= __d('push', 'push_to_all') .  " " . __d('member', 'student') ?> </label> 

											<?php break;
											case array_search('Push to all (teacher)', $push_method): ?>
												<label class='label label-warning'> <?= __d('push', 'push_to_all') .  " " . __d('member', 'teacher') ?> </label> 
											
											<?php break;
											case array_search('Push to someone (student)', $push_method): ?>
												<label class='label label-primary'> <?= __d('push', 'push_to_someone') .  " " . __d('member', 'student') ?> </label> 
											
											<?php break;
											case array_search('Push to someone (teacher)', $push_method): ?>
												<label class='label label-primary'> <?= __d('push', 'push_to_someone') .  " " . __d('member', 'teacher') ?> </label> 

											<?php break;
											case array_search('Push to criteria', $push_method): ?>
												<label class='label label-success'> <?= __d('push', 'push_to_criteria') ?> </label> 
												<?php break;
										}
									?>
								</td> 

							
								<td class="text-center">
									<?php 
										if (isset($push['PushLanguage'])) {
											echo h(reset($push['PushLanguage'])['title']); 
										}
									?>&nbsp;
								</td>

								<td class="text-center">
									<?php 
										if (isset($push['PushLanguage'])) {
											echo h(reset($push['PushLanguage'])['short_description']); 
										}
									?>&nbsp;
								</td>
							
								<td class="text-center">
									<?php echo $this->element('view_check_ico', array('_check' => $push['Push']['enabled'])); ?>
								</td>
								<td class="text-center"><?php echo h($push['Push']['created']); ?>&nbsp;</td>
								<td class="text-center">
									<?php 
										if($push['Push']['created_by'] == 0) {
											echo h('CRONJOB');
										} else {
											echo h($push['CreatedBy']['email']); 
										}
									?>&nbsp;
								</td>
								<td class="text-center">
									<?php 
										echo $this->Html->link(__('<i class="fa fa-eercast"></i>'), array('plugin' => 'push', 'controller' => 'pushes', 'action' => 'view', $push['Push']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('view')));
										echo "&nbsp;";

										if ($push['Push']['enabled'] && isset($permissions['Push']['edit']) && ($permissions['Push']['edit'] == true)) {
                                        	echo $this->Form->postLink(__('<i class="fa fa-ban"></i>'), array('plugin' => 'push', 'controller' => 'pushes', 'action' => 'disable', $push['Push']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('disabled')), sprintf(__('are_you_sure_to_disable'), $push['Push']['id']));
									
									    } 
									?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->
		</div><!-- /.index -->
		<?php echo $this->element('Paginator'); ?>	</div><!-- /#page-content .col-sm-9 -->
</div><!-- /#page-container .row-fluid -->

<script type="text/javascript">
	$(document).ready(function(){
		
    });
</script>