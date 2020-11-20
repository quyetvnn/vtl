<div class="row">
    <div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __('push'); ?></h3>
				<div class="box-tools pull-right">
	                <?php // echo $this->Html->link('<i class="fa fa-pencil"></i> ' . __('edit'), array('action' => 'edit', $push['Push']['id']), array('class' => 'btn btn-primary', 'escape' => false)); ?>
	            </div>
			</div>
			<div class="box-body">
                <table id="Pushes" class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td><strong><?php echo __('id'); ?></strong></td>
							<td>
								<?php echo h($push['Push']['id']); ?>
							</td>
						</tr>

						<tr>
							<td><strong><?php echo __('push_method'); ?></strong></td>
							<td>
								<?php 
									switch ($push['Push']['push_method']) {
										case array_search('Push to all', $push_method): ?>
											<label class='label label-warning'> <?= __d('push', 'push_to_all') ?> </label> 
										
										<?php break;
										case array_search('Push to all (student)', $push_method): ?>
											<label class='label label-warning'> <?= __d('push', 'push_to_all') . " " . __d('member', 'student')?> </label> 
										
										<?php break;

										case array_search('Push to all (teacher)', $push_method): ?>
											<label class='label label-warning'> <?= __d('push', 'push_to_all') . " " . __d('member', 'teacher')?> </label> 

											<?php break;

										case array_search('Push to someone (student)', $push_method): ?>
											<label class='label label-primary'> <?= __d('push', 'push_to_someone') . " " . __d('member', 'student')?> </label> 

										<?php break;

										case array_search('Push to someone (teacher)', $push_method): ?>
											<label class='label label-primary'> <?= __d('push', 'push_to_someone') . " " . __d('member', 'teacher')?> </label> 

										<?php break;

										case array_search('Push to criteria', $push_method): ?>
											<label class='label label-success'> <?= __d('push', 'push_to_criteria') ?> </label> 
											<?php break;
									}
								
								?>
							</td>
                        </tr>
                        <?php if ($push['Push']['push_method'] == array_search('push-to-someone', $push_method)) { ?>
						<tr>
							<td></td>
							<td><?=  $member_emails != '' ? $member_emails : __d('push', 'nobody_was_sent') ?></td>
                        </tr>
						<?php } ?>
						
						<tr>
							<td><strong><?php echo __d('course', 'course_class'); ?></strong></td>
							<td>
								<?php 
									if (isset($push['CourseClass']['CourseClassLanguage'])) {
										echo h(reset($push['CourseClass']['CourseClassLanguage'])['name']); 
									}
								?>
							</td>
						</tr>
						
						<tr>
							<td><strong><?php echo __('district'); ?></strong></td>
							<td>
								<?php echo $district_id_description;  ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('course', 'course_category'); ?></strong></td>
							<td>
								<?php echo $category_id_description; ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('enabled'); ?></strong></td>
							<td>
								<?php echo $this->element('view_check_ico', array('_check' => $push['Push']['enabled'])); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('updated'); ?></strong></td>
							<td>
								<?php echo h($push['Push']['updated']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('updated_by'); ?></strong></td>
							<td>
								<?php echo h($push['UpdatedBy']['email']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('created'); ?></strong></td>
							<td>
								<?php echo h($push['Push']['created']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('created_by'); ?></strong></td>
							<td>
								<?php echo h($push['CreatedBy']['email']); ?>
							</td>
						</tr>
					</tbody>
				</table><!-- /.table table-striped table-bordered -->

				<div class="row">
					<div class="col-md-12">
						<div class="margin-top-15">
							<?= $this->element('content_view',array(
								'languages' => $languages,
								'language_input_fields' => $language_input_fields,
							)); ?>
						</div>
					</div>
				</div>

			</div><!-- /.table-responsive -->
		</div><!-- /.view -->
	</div><!-- /#page-content .span9 -->
</div><!-- /#page-container .row-fluid -->
<div class="row">
    <!-- start push rule -->
    <div class="col-lg-12 form-group">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?= __d('push', 'push_rule'); ?></h3>
            </div>
            <div class="box-body">
                <?php if(count($push['PushRule']) > 0) { ?>
                    <table id="PushRules" class="table table-bordered table-striped">
						<thead>
                            <tr>
                                <th class="text-center"><?php echo __('id'); ?></th>
                                <th class="text-center"><?php echo __d('push', 'push_type'); ?></th>
                                <th class="text-center"><?php echo __d('push', 'period_start'); ?></th>
                                <th class="text-center"><?php echo __d('push', 'period_end'); ?></th>
                                <th class="text-center"><?php echo __d('push', 'execute_date'); ?></th>
                                <th class="text-center"><?php echo __('execute_time'); ?></th>
								<th class="text-center"><?php echo __('status'); ?></th>
                                <th class="text-center"><?php echo __('enabled'); ?></th>
                                <th class="text-center"><?php echo __('updated'); ?></th>
                                <th class="text-center"><?php echo __('created'); ?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($push['PushRule'] as $pushRule): ?>
                                <tr>
                                    <td class="text-center"><?php echo h($pushRule['id']); ?>&nbsp;</td>
                                    <td class="text-center">
										<?php 
											switch ($pushRule['push_type']) {
												case array_search('Instant', $push_type): ?>
													<label class='label label-danger'> <?= __d('push', 'instant') ?> </label> 
												
												<?php break;
												case array_search('Specific datetime', $push_type): ?>
													<label class='label label-warning'> <?= __d('push', 'specific_datetime') ?> </label> 
		
												<?php break;
												case array_search('Daily', $push_type): ?>
													<label class='label label-success'> <?= __d('push', 'daily') ?> </label> 
													<?php break;
											}
										?>
                                    </td>
                                    <td class="text-center"><?php echo h($pushRule['period_start']); ?>&nbsp;</td>
                                    <td class="text-center"><?php echo h($pushRule['period_end']); ?>&nbsp;</td>
                                    <td class="text-center"><?php echo h($pushRule['execute_date']); ?>&nbsp;</td>
                                    <td class="text-center"><?php echo h($pushRule['execute_time']); ?>&nbsp;</td>
									<td class="text-center">
										<?php 
									
										switch ($pushRule['status']) {
											case array_search('Complete', $status): ?>
												<label class='label label-success'> <?= __d('push', 'complete') ?> </label> 
											
											<?php break;
											case array_search('Pending', $status): ?>
												<label class='label label-danger'> <?= __d('push', 'pending') ?> </label> 
	
											<?php break;
											case array_search('Pushing', $status): ?>
												<label class='label label-warning'> <?= __d('push', 'pushing') ?> </label> 
												<?php break;
										}
										?>&nbsp;
									</td>
                                    <td class="text-center">
										<?php
											echo $this->element('view_check_ico', array('_check' => $push['Push']['enabled'])); 
										?>
									</td>
                                    <td class="text-center"><?php echo h($pushRule['updated']); ?>&nbsp;</td>
                                    <td class="text-center"><?php echo h($pushRule['created']); ?>&nbsp;</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
					</table>
					
					
                <?php }else{ ?>
                    <h4><?= __('no_record') ?></h4>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- end push rule -->
</div>