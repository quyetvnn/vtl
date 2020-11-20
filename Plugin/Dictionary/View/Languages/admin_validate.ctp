<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo __d('dictionary','import_translations'); ?></h3>
			</div>

			<div class="box-body table-responsive">
				<?php echo $this->Form->create('Language', array('role' => 'form','type' => 'file')); ?>
					<fieldset>
						<!--
						<div class="form-group">
							<?php echo $this->Form->input('alias', array('class' => 'form-control','label'=>__d('dictionary','alias'))); ?>
						</div>
						-->
						<br/><br/><br/>
						<div class="form-group">
							<label for="errlog">Err Log : </label>
							<div id="errlog" style="height:300px; overflow-y:scroll;outline:1px solid rgb(0,0,0,0.5);padding:10px;">
								<?php
									$ctr = 1;
									foreach($short_msg as $msg) {
										if ($msg !== '') {
											echo($ctr.'. ');
										}
										echo($msg."<br/>");
										$ctr++;
									}
								?>
							</div>
						</div>

					</fieldset>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#btn-submit").click(function () {
			setTimeout(function () { $("#btn-submit").prop('disabled', true); }, 0);
		});        
    });
</script>