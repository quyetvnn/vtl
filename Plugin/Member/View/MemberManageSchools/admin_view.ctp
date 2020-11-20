
<div class="row">
    <div class="col-xs-12">
		
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __d('member', 'member_manage_school'); ?></h3>
			
			</div>
			
			<div class="box-body table-responsive">
                <table id="MemberManageSchools" class="table table-bordered table-striped">
					<tbody>
						<tr>		
							<td><strong><?php echo __('id'); ?></strong></td>
							<td>
								<?php echo h($memberManageSchool['MemberManageSchool']['id']); ?>
								&nbsp;
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __d('school', 'school'); ?></strong></td>
							<td>
								<?php 
									
									if (isset($memberManageSchool['School']['SchoolLanguage'])) {
										echo $this->Html->link(reset($memberManageSchool['School']['SchoolLanguage'])['name'], array('plugin' => 'school', 'controller' => 'schools', 'action' => 'view', $memberManageSchool['School']['id'])); 
									}
								?>
								
								&nbsp;
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __d('member', 'member'); ?></strong></td>
							<td>
								<?php 
									if (isset($memberManageSchool['Member'])) {
										echo h($memberManageSchool['Member']['username']);
									}
								?>
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __d('administration', 'administrator'); ?></strong></td>
							<td>
								<?php
									if (isset($memberManageSchool['Administration'])) {
										echo h($memberManageSchool['Administration']['name']);
									}
								?>
							</td>
						</tr>
					
					
						<tr>		
							<td><strong><?php echo __('created'); ?></strong></td>
							<td>
								<?php echo h($memberManageSchool['MemberManageSchool']['created']); ?>
								&nbsp;
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __('created_by'); ?></strong></td>
							<td>
								<?php echo h($memberManageSchool['CreatedBy']['email']); ?>
								&nbsp;
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __('updated'); ?></strong></td>
							<td>
								<?php echo h($memberManageSchool['MemberManageSchool']['updated']); ?>
								&nbsp;
							</td>
						</tr>	
						<tr>		
							<td><strong><?php echo __('updated_by'); ?></strong></td>
							<td>
								<?php echo h($memberManageSchool['UpdatedBy']['email']); ?>
								&nbsp;
							</td>
						</tr>				
					</tbody>
				</table><!-- /.table table-striped table-bordered -->
			</div><!-- /.table-responsive -->
			
		</div><!-- /.view -->

			
	</div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->

