<div class="row">
    <div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __d('dictionary','language'); ?></h3>

				<div class="box-tools pull-right">
	                <?php if(isset($permissions['Language']['edit']) && ($permissions['Language']['edit'] == true)){  
                        echo $this->Html->link('<i class="fa fa-pencil"></i> '.__d('dictionary','edit_language'), array('action' => 'edit', $language['Language']['id']), array('class' => 'btn btn-primary', 'escape' => false)); 
                    } ?>
	            </div>
			</div>
			<div class="box-body table-responsive">
                <table id="Languages" class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td><strong><?php echo __d('dictionary','id'); ?></strong></td>
							<td>
								<?php echo h($language['Language']['id']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('dictionary','alias'); ?></strong></td>
							<td>
								<?php echo h($language['Language']['alias']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('dictionary','is_default'); ?></strong></td>
							<td>
                                <?php echo $this->element('view_check_ico',array('_check'=>$language['Language']['is_default'])) ?> 
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('enabled'); ?></strong></td>
							<td>
                                <?php echo $this->element('view_check_ico',array('_check'=>$language['Language']['enabled'])) ?> 
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('updated'); ?></strong></td>
							<td>
								<?php echo h($language['Language']['updated']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('updated_by'); ?></strong></td>
							<td>
								<?php echo h($language['UpdatedBy']['email']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('created'); ?></strong></td>
							<td>
								<?php echo h($language['Language']['created']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('created_by'); ?></strong></td>
							<td>
								<?php echo h($language['CreatedBy']['email']); ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

			
	</div>

</div>

