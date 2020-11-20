<div class="row">
    <div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __d('dictionary','image_type'); ?></h3>

				<div class="box-tools pull-right">
	                <?php 
                    if(isset($permissions['ImageType']['edit']) && ($permissions['ImageType']['edit'] == true)){ 
                        echo $this->Html->link('<i class="fa fa-pencil"></i> '.__d('dictionary','edit_image_type'), array('action' => 'edit', $imageType['ImageType']['id']), array('class' => 'btn btn-primary', 'escape' => false)); 
                    }
                    ?>
	            </div>
			</div>
			
			<div class="box-body table-responsive">
                <table id="ImageTypes" class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td><strong><?php echo __d('dictionary','id'); ?></strong></td>
							<td>
								<?php echo h($imageType['ImageType']['id']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('dictionary','slug'); ?></strong></td>
							<td>
								<?php echo h($imageType['ImageType']['slug']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('enabled'); ?></strong></td>
							<td>
								<?php echo $this->element('view_check_ico',array('_check'=>$imageType['ImageType']['enabled'])); ?>&nbsp;
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('updated'); ?></strong></td>
							<td>
								<?php echo h($imageType['ImageType']['updated']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('updated_by'); ?></strong></td>
							<td>
								<?php echo h($imageType['CreatedBy']['name']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('created'); ?></strong></td>
							<td>
								<?php echo h($imageType['ImageType']['created']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('created_by'); ?></strong></td>
							<td>
								<?php echo h($imageType['UpdatedBy']['email']); ?>
							</td>
						</tr>
					</tbody>
                </table>
			</div>
		</div>
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

