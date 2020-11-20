<div class="row">
    <div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __d('company','company'); ?></h3>

				<div class="box-tools pull-right">
	                <?php echo $this->Html->link('<i class="fa fa-pencil"></i> '.__d('company','edit_company'), array('action' => 'edit', $company['Company']['id']), array('class' => 'btn btn-primary', 'escape' => false)); ?>
	            </div>
			</div>
			
			<div class="box-body table-responsive">
                <table id="Companies" class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td><strong><?php echo __('id'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['id']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('email'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['email']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','facebook'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['facebook']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','instagram'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['instagram']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','twitter'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['twitter']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','website'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['website']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','wechat'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['wechat']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','weibo'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['weibo']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','whatsapp'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['whatsapp']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','youtube'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['youtube']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','remark'); ?></strong></td>
							<td>
								<?php echo $company['Company']['remark']; ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','contact_person'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['contact_person']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','contact_email'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['contact_email']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','contact_phone'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['contact_phone']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','contact_job_title'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['contact_job_title']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('enable'); ?></strong></td>
							<td>
								<?php echo $this->element('view_check_ico',array('_check'=>$company['Company']['enabled'])) ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('updated'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['updated']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('updated_by'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['updated_by']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('created'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['created']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('created_by'); ?></strong></td>
							<td>
								<?php echo h($company['Company']['created_by']); ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div> <!-- end row -->

<div class="row">
	<div class="col-md-12">

		<?php echo $this->element('content_view',array(
			'languages' => $languages,
			'language_input_fields' => $language_input_fields,
		)); ?>
	</div>
</div> <!-- end row -->


	


