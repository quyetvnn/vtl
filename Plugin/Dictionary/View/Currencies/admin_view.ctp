<div class="row">
    <div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __d('dictionary','currency'); ?></h3>

				<div class="box-tools pull-right">
                    <?php 
                        if(isset($permissions['Currency']['edit']) && ($permissions['Currency']['edit'] == true)){
                            echo $this->Html->link('<i class="fa fa-pencil"></i> '.__d('dictionary','edit_currency'), array('action' => 'edit', $currency['Currency']['id']), array('class' => 'btn btn-primary', 'escape' => false));
                        } 
                    ?>
	            </div>
			</div>
			
			<div class="box-body table-responsive">
                <table id="Currencies" class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td><strong><?php echo __d('dictionary','id'); ?></strong></td>
							<td>
								<?php echo h($currency['Currency']['id']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('dictionary','slug'); ?></strong></td>
							<td>
								<?php echo h($currency['Currency']['slug']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('dictionary','rate_to_usd'); ?></strong></td>
							<td>
								<?php echo h($currency['Currency']['rate_to_usd'] + 0); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('enabled'); ?></strong></td>
							<td>
								<?php echo $this->element('view_check_ico',array('_check'=>$currency['Currency']['enabled'])) ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('updated'); ?></strong></td>
							<td>
								<?php echo h($currency['Currency']['updated']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('updated_by'); ?></strong></td>
							<td>
								<?php echo h($currency['UpdatedBy']['email']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('created'); ?></strong></td>
							<td>
								<?php echo h($currency['Currency']['created']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('created_by'); ?></strong></td>
							<td>
								<?php echo h($currency['CreatedBy']['email']); ?>
							</td>
						</tr>
					</tbody>
				</table><!-- /.table table-striped table-bordered -->
			</div><!-- /.table-responsive -->
		</div><!-- /.view -->
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
	</div>
</div>

