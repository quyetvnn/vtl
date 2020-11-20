
<div class="row">
    <div class="col-xs-12">
		
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?= __d('member', 'subject'); ?></h3>
				<div class="box-tools pull-right">
	                <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>' . __('edit')), array('action' => 'edit', $schoolSubject['SchoolSubject']['id']), array('class' => 'btn btn-primary', 'escape' => false)); ?>
	            </div>
			</div>
			
			<div class="box-body table-responsive">
                <table id="SchoolSubjects" class="table table-bordered table-striped">
					<tbody>
						<tr>		
							<td><strong><?php echo __('id'); ?></strong></td>
							<td>
								<?php echo h($schoolSubject['SchoolSubject']['id']); ?>
								&nbsp;
							</td>
						</tr>
						<tr>		
							<td><strong><?php echo __d('school', 'school'); ?></strong></td>
							<td>
								<?php echo $this->Html->link(reset($schoolSubject['School']['SchoolLanguage'])['name'], array(
									'controller' => 'schools', 'action' => 'view', $schoolSubject['SchoolSubject']['school_id']), array('class' => '')); ?>
								&nbsp;
							</td>
							</tr>
							<td><strong><?php echo __d('member', 'subject'); ?></strong></td>
							<td>
								<?php 	
										if (isset($schoolSubject['SchoolSubjectLanguage']) && isset($schoolSubject['SchoolSubjectLanguage'][0])) {
											echo h(reset($schoolSubject['SchoolSubjectLanguage'])['name']); 
										}
								?>
							</td>
							</tr>

							<tr>
								<td><strong><?php echo __('enabled'); ?></strong></td>
									<td>
										<?= 
											$this->element('view_check_ico',array('_check'=>$schoolSubject['SchoolSubject']['enabled']))
										?>
										
									</td>
							</tr>			
						</tbody>
				</table><!-- /.table table-striped table-bordered -->
			</div><!-- /.table-responsive -->
			
		</div><!-- /.view -->

	
			
	</div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->

