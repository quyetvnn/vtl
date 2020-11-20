<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>

<?= $this->element('Member.MemberCredit_filter', array(
	'data_search' => $data_search
)); ?>

<div class="row">
    <div class="col-xs-12">

    <div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo __d('member', 'members_credits'); ?></h3>
			<div class="box-tools pull-right">
                <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-plus"></i>') . __('add'), array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
            </div>
		</div>	
			<div class="box-body table-responsive">
                <table id="MembersCredits" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo $this->Paginator->sort('id', 			__('id')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('member_id',		__d('member', 'member')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('school_id',		__d('school', 'school')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('credit_type_id',	__d('credit', 'credit_type')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('pay_dollar_ref',	__d('member', 'pay_dollar_ref')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('credit',			__d('school', 'credit')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('remark',			__('remark')); ?></th>
							
							<th class="text-center"><?php echo $this->Paginator->sort('created',		__('created')); ?></th>
							<th class="text-center"><?php echo $this->Paginator->sort('created_by',		__('created_by')); ?></th>
							<th class="text-center"><?php echo __('operation'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($membersCredits as $membersCredit): ?>
						<tr>
							<td class="text-center"><?php echo h($membersCredit['MembersCredit']['id']); ?>&nbsp;</td>
							<td class="text-center">
								<?php  if (isset($membersCredit['Member']['MemberLanguage'])) {
										echo h(reset($membersCredit['Member']['MemberLanguage'])['name']);
									}
								?>
							</td>
							<td class="text-center">
								<?php if (isset($membersCredit['School']['SchoolLanguage'])) {
										echo $this->Html->link(
											reset($membersCredit['School']['SchoolLanguage'])['name'] . "(" . $membersCredit['School']['school_code'] . ")", array(
											'plugin' => 'school', 'controller' => 'schools', 'action' => 'view', $membersCredit['School']['id']));
									}
								?>
							</td>

							<td class="text-center">
								<?php if ($membersCredit['CreditType']['CreditTypeLanguage']) {
										echo h(reset($membersCredit['CreditType']['CreditTypeLanguage'])['name']);
										
								} ?>
							</td>
							<td class="text-center"><?php echo h($membersCredit['MembersCredit']['pay_dollar_ref']); ?>&nbsp;</td>
							<td class="text-center red" style="font-weight: bold" ><?php echo h(number_format($membersCredit['MembersCredit']['credit'], 0)); ?>&nbsp;</td>
							<td class="text-center"><?php echo h($membersCredit['MembersCredit']['remark']); ?>&nbsp;</td>
							<td class="text-center"><?php echo h($membersCredit['MembersCredit']['created']); ?>&nbsp;</td>
							<td class="text-center"><?php echo h($membersCredit['CreatedBy']['email']); ?>&nbsp;</td>
							<td class="text-center">
								<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('action' => 'view', $membersCredit['MembersCredit']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('view'))); ?>
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

