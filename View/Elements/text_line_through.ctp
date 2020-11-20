<?php if(isset($_is_through) && $_is_through){ ?>
	<span class="text-line-through" ><?php echo h($_text); ?></span>&nbsp;
<?php }else{ ?>
	<span><?php echo h($_text); ?></span>&nbsp;
<?php } ?>