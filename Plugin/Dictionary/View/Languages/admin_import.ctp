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

						<div class="form-group">
							<input type="file" name="data[Language][file]" accept=".xlsx">
						</div>

						<?php echo $this->Form->submit(__('submit'), array('id'=> 'btn-submit','class' => 'btn btn-large btn-primary')); ?>
						<br/><br/><br/>
						<div class="form-group <?= $class_hidden ?>">
							<label for="errlog">Err Log : </label>
							<textarea class="form-control" rows="10" id="errlog" readonly><?php
									$ctr = 1;
									foreach($short_msg as $msg) {
										echo($ctr.'. '.$msg."\n");
										$ctr++;
									}
								?>
							</textarea>
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