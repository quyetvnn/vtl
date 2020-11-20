<div class="row">
    <div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __d('dictionary','vocabulary'); ?></h3>

				<div class="box-tools pull-right">
	                <?php if(isset($permissions['Vocabulary']['edit']) && ($permissions['Vocabulary']['edit'] == true)){
                        echo $this->Html->link('<i class="fa fa-pencil"></i> '.__d('dictionary','edit_vocabulary'), array('action' => 'edit', $vocabulary['Vocabulary']['id']), array('class' => 'btn btn-primary', 'escape' => false));  
                    } ?>
	            </div>
			</div>
			
			<div class="box-body table-responsive">
                <table id="Vocabularies" class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td><strong><?php echo __d('dictionary','id'); ?></strong></td>
							<td>
								<?php echo h($vocabulary['Vocabulary']['id']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('dictionary','parent_vocabulary'); ?></strong></td>
							<td>
								<?php echo $this->Html->link($vocabulary['ParentVocabulary']['slug'], array('controller' => 'vocabularies', 'action' => 'view', $vocabulary['ParentVocabulary']['id']), array('class' => '')); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __d('dictionary','slug'); ?></strong></td>
							<td>
								<?php echo h($vocabulary['Vocabulary']['slug']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('enabled'); ?></strong></td>
							<td>
								<?php echo $this->element('view_check_ico',array('_check'=>$vocabulary['Vocabulary']['enabled'])) ?> 
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('updated'); ?></strong></td>
							<td>
								<?php echo h($vocabulary['Vocabulary']['updated']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('updated_by'); ?></strong></td>
							<td>
								<?php echo h($vocabulary['CreatedBy']['email']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('created'); ?></strong></td>
							<td>
								<?php echo h($vocabulary['Vocabulary']['created']); ?>
							</td>
						</tr>
						<tr>
							<td><strong><?php echo __('created_by'); ?></strong></td>
							<td>
								<?php echo h($vocabulary['UpdatedBy']['email']); ?>
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

