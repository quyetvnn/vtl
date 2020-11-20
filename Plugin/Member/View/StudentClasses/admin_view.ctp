
<div class="row">
    <div class="col-xs-12">
		
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __d('school', 'student_class'); ?></h3>
				<div class="box-tools pull-right">
	                <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>') . __('edit') , array('action' => 'edit', $studentClass['StudentClass']['id']), array('class' => 'btn btn-primary', 'escape' => false)); ?>
	            </div>
			</div>
			
			<div class="box-body table-responsive">
                <table id="StudentClasses" class="table table-bordered table-striped">
					<tbody>
						<tr>		
							<td>
								<strong><?php echo __('id'); ?></strong></td>
								<td>
									<?php echo h($studentClass['StudentClass']['id']); ?>
									&nbsp;
								</td>
							</tr>
							<tr>		
								<td><strong><?php echo __d('member', 'student'); ?></strong></td>
								<td>
									
									<?php 
										if ($studentClass['Student']['MemberLanguage']) {
											echo reset($studentClass['Student']['MemberLanguage'])['name'];
										}
									?>
									&nbsp;
								</td>
							</tr>
							<tr>		
								<td><strong><?php echo __d('school', 'school'); ?></strong></td>
								<td>
									<?php
									if ($studentClass['School']['SchoolLanguage']) {
										echo $this->Html->link(reset($studentClass['School']['SchoolLanguage'])['name'], array('plugin' => 'school', 'controller' => 'schools', 'action' => 'view', $studentClass['School']['id']), array('class' => '')); 
									} ?>
									&nbsp;
								</td>
							</tr>
							<tr>		
								<td><strong><?php echo __d('school', 'school_class'); ?></strong></td>
								<td>
									<?php echo h($studentClass['SchoolClass']['name']);  ?>
									&nbsp;
								</td>
							</tr>
							
							<tr>		
								<td><strong><?php echo __('enabled'); ?></strong></td>
								<td>
									<?= $this->element('view_check_ico',array('_check'=>$studentClass['StudentClass']['enabled'])) ?>
									&nbsp;
								</td>
							</tr>
							<tr>		
								<td><strong><?php echo __('created'); ?></strong></td>
								<td>
									<?php echo h($studentClass['StudentClass']['created']); ?>
									&nbsp;
								</td>
							</tr>
						
							<tr>		
								<td><strong><?php echo __('created_by'); ?></strong></td>
								<td>
									<?php echo h($studentClass['CreatedBy']['email']); ?>
									&nbsp;
								</td>
							</tr>
							<tr>		
								<td><strong><?php echo __('updated'); ?></strong></td>
								<td>
									<?php echo h($studentClass['StudentClass']['updated']); ?>
									&nbsp;
								</td>
							</tr>
							<tr>		
								<td><strong><?php echo __('updated_by'); ?></strong></td>
								<td>
									<?php echo h($studentClass['UpdatedBy']['email']); ?>
									&nbsp;
								</td>
							</tr>					
					</tbody>
				</table><!-- /.table table-striped table-bordered -->
			</div><!-- /.table-responsive -->
			
		</div><!-- /.view -->

			
	</div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->

