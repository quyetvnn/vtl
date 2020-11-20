<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?php
				echo $this->Html->image('Error-404-m.png', ['alt' => 'page not found', 'width' => "100%"]);
			?>
		</div>
	</div>
	<div class="row text-center">
		<p class="text-purple" style="font-size: 1.5em; margin: 20px 0;">
			<?php echo __d('member', 'page_not_found'); ?>
		</p>
	</div>
	<div class="row text-center">
		<button class="btn btn-green btn-w-radius" style="width: 300px;"><?php echo __d('member', 'back_to_home'); ?></button>
	</div>
</div>
