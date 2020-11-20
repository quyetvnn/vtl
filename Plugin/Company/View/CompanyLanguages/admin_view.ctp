<div class="row">
    <div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __d('company','company_language'); ?></h3>

				<div class="box-tools pull-right">
	                <?php echo $this->Html->link(__('<i class="fa fa-pencil"></i>' . __('edit')), array('action' => 'edit', $companyLanguage['CompanyLanguage']['id']), array('class' => 'btn btn-primary', 'escape' => false)); ?>
	            </div>
			</div>
			
			<div class="box-body table-responsive">
                <table id="CompanyLanguages" class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td><strong><?php echo __('id'); ?></strong></td>
							<td>
								<?php echo h($companyLanguage['CompanyLanguage']['id']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','company'); ?></strong></td>
							<td>
								<?php echo $this->Html->link($companyLanguage['Company']['email'], array('controller' => 'companies', 'action' => 'view', $companyLanguage['Company']['id']), array('class' => '')); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('alias'); ?></strong></td>
							<td>
								<?php echo h($companyLanguage['CompanyLanguage']['alias']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','name'); ?></strong></td>
							<td>
								<?php echo h($companyLanguage['CompanyLanguage']['name']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','description'); ?></strong></td>
							<td>
								<?php echo h($companyLanguage['CompanyLanguage']['description']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','address'); ?></strong></td>
							<td>
								<?php echo h($companyLanguage['CompanyLanguage']['address']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','about'); ?></strong></td>
							<td>
								<?php echo h($companyLanguage['CompanyLanguage']['about']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','terms'); ?></strong></td>
							<td>
								<?php echo h($companyLanguage['CompanyLanguage']['terms']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','privacy'); ?></strong></td>
							<td>
								<?php echo h($companyLanguage['CompanyLanguage']['privacy']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','hotline'); ?></strong></td>
							<td>
								<?php echo h($companyLanguage['CompanyLanguage']['hotline']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('company','service_time'); ?></strong></td>
							<td>
								<?php echo h($companyLanguage['CompanyLanguage']['service_time']); ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

			
	</div>

</div>

