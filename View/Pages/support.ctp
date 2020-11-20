<?php 
	echo $this->element('menu/top_menu');
?>
<div class="col-md-12 menu-section support-info">
    <ul class="text-left">
    	<li>
    		<a href="javascript:window.history.back();" class="text-dark-liver">
    			<span class="fa fa-long-arrow-left"></span>
    		</a>
    	</li>
        <?=$this->element('help_detail');?>
     </ul>
</div>