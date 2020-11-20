
<div class="row">
    <div class="col-xs-12">
		
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __d('school', 'school'); ?></h3>
				<div class="box-tools pull-right">
	                <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>') . __('edit'), array('action' => 'edit', $school['School']['id']), array('class' => 'btn btn-primary', 'escape' => false)); ?>
	            </div>
			</div>
			
			<div class="box-body table-responsive">
                <table id="Schools" class="table table-bordered table-striped">
					<tbody>
						<tr>		
						<td><strong><?php echo __('id'); ?></strong></td>
							<td>
								<?php echo h($school['School']['id']); ?>
								&nbsp;
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __d('school', 'school_code'); ?></strong></td>
							<td>
								<?php echo h($school['School']['school_code']); ?>
								&nbsp;
							</td>
						</tr>
						<tr>	
							<td><strong><?php echo __d('member', 'email'); ?></strong></td>
							<td>
								<?php echo h($school['School']['email']); ?>
								&nbsp;
							</td>
						</tr>	
						<tr>	
							<td><strong><?php echo __d('member', 'phone_number'); ?></strong></td>
							<td>
								<?php echo h($school['School']['phone_number']); ?>
								&nbsp;
							</td>
						</tr>

						<tr>	
							<td><strong><?php echo __('status'); ?></strong></td>
							<td>
								<?php
									if ($school['School']['status'] == array_search('Normal', $status)) { ?>
											<label class="label label-success"> <?= __d('school', 'normal'); ?> </label> 
									
									<?php } elseif ($school['School']['status'] == array_search('Blocked', $status)) { ?>
										<label class="label label-danger"> <?= __d('school', 'blocked'); ?> </label> 
									
									<?php } else { ?>
										<label class="label label-warning"> <?= __d('school', 'closed'); ?> </label> 
									<?php } 
								?>
							</td>
						</tr>

						<tr>		
							<td><strong><?php echo __d('school', 'credit_charge'); ?></strong></td>
							<td>
								<?php echo h(number_format($school['School']['credit_charge'], 0)); ?>
								&nbsp;
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __d('school', 'credit'); ?></strong></td>
							<td class="red" style="font-weight: bold" >
								
								<?php echo h(number_format($school['School']['credit'], 0)); ?>
								&nbsp;
							</td>
						</tr>
					
					
						<tr>		
							<td><strong><?php echo __d('school', 'address'); ?></strong></td>
							<td>
								<?php echo h($school['School']['address']); ?>
								&nbsp;
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('created'); ?></strong></td>
							<td>
								<?php echo h($school['School']['created']); ?>
								&nbsp;
							</td>
						</tr>
					
						<tr>		
							<td><strong><?php echo __('created_by'); ?></strong></td>
							<td>
								<?php echo h($school['CreatedBy']['email']); ?>
								&nbsp;
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __('updated'); ?></strong></td>
							<td>
								<?php echo h($school['School']['updated']); ?>
								&nbsp;
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __('updated_by'); ?></strong></td>
							<td>
							<?php echo h($school['UpdatedBy']['email']); ?>
								&nbsp;
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
								'images' => $images,
							)); ?>
						</div>
					</div>
                </div>

			</div><!-- /.table-responsive -->
			
		</div><!-- /.view -->
			
	</div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->

