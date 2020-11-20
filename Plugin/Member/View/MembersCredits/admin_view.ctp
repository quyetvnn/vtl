
<div class="row">
    <div class="col-xs-12">
		
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __d('member', 'members_credit'); ?></h3>
			
			</div>
			
			<div class="box-body table-responsive">
                <table id="MembersCredits" class="table table-bordered table-striped">
					<tbody>
						<tr>		
							<td><strong><?php echo __('id'); ?></strong></td>
							<td>
								<?php echo h($membersCredit['MembersCredit']['id']); ?>
								&nbsp;
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __d('school', 'school'); ?></strong></td>
							<td>
								<?php if (isset($membersCredit['School']['SchoolLanguage'])) {
										echo $this->Html->link(reset($membersCredit['School']['SchoolLanguage'])['name'], array(
											'plugin' => 'school', 'controller' => 'schools', 'action' => 'view', $membersCredit['School']['id']));
									}
								?>
							
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __d('member', 'school_admin'); ?></strong></td>
							<td>
								<?php  if (isset($membersCredit['Member']['MemberLanguage'])) {
										echo h(reset($membersCredit['Member']['MemberLanguage'])['name']);
									}
								?>
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __d('credit', 'credit_type'); ?></strong></td>
							<td>
								<?php if ($membersCredit['CreditType']['CreditTypeLanguage']) {
										echo h(reset($membersCredit['CreditType']['CreditTypeLanguage'])['name']);
										
								} ?>
							</td>
						</tr>
						<tr>	
							<td><strong><?php echo __d('member', 'pay_dollar_ref'); ?></strong></td>
							<td>
								<?php echo h($membersCredit['MembersCredit']['pay_dollar_ref']); ?>
								&nbsp;
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __d('school', 'credit'); ?></strong></td>
							<td class="red" style="font-weight: bold">
								<?php echo h(number_format($membersCredit['MembersCredit']['credit'], 0)); ?>
								&nbsp;
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __('remark'); ?></strong></td>
							<td>
								<?php echo h($membersCredit['MembersCredit']['remark']); ?>
								&nbsp;
							</td>
						</tr>
					
					
						<tr>		
							<td><strong><?php echo __('updated'); ?></strong></td>
							<td>
								<?php echo h($membersCredit['MembersCredit']['updated']); ?>
								&nbsp;
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __('updated_by'); ?></strong></td>
							<td>
								<?php echo h($membersCredit['UpdatedBy']['email']); ?>
								&nbsp;
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __('created'); ?></strong></td>
							<td>
								<?php echo h($membersCredit['MembersCredit']['created']); ?>
								&nbsp;
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __('created_by'); ?></strong></td>
							<td>
								<?php echo h($membersCredit['CreatedBy']['email']); ?>
								&nbsp;
							</td>
						</tr>					
					</tbody>
				</table><!-- /.table table-striped table-bordered -->
			</div><!-- /.table-responsive -->
			
		</div><!-- /.view -->

			
	</div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->

