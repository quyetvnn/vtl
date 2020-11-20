<?php 
	echo $this->element('menu/top_menu');
?>
<div class="container modal-login menu-mobile">
	<?php if(!$school_info){?>
		<p class="switch-modal text-center">
		  <strong class="item active"><?=  __('login'); ?> </strong>
		  <?php
		  	echo $this->Html->link(
	            '/'.__d('member', 'sign_up'),
	            array(
	                'plugin' => '', 
	                'controller' => 'pages', 
	                'action' => 'register',
	                'admin' => false,
	            ), 
	            array('escape' => false, 'class'=>" item pointer trigger-active-register ")
	        );
		  ?>
		</p>
	<?php }else{?>
		<div class="modal-body p-0">
		  <div class="w3-modal-header text-center">
		    <center class="group-img-radius icon-school">
		      <div class="box-img border-grey">
		        <?php 
		          if($school_info['avatar']!=''){
		            echo $this->Html->image($school_info['avatar'], ['class' => "profile-image"]); 
		          }
		          
		        ?>
		      </div>
		    </center>
		    <h3 class="text-green"><?=__d('member', 'invitation_letter')?></h3>
		  </div>
		  <div class="text-center text-dark-liver mbt-50">
		    <?=__d('member', 'please_complete_the_form_below_to_activate_your_account')?>
		  </div>
		</div>
	<?php } ?>
	<?= $this->element('social_login_method') ?>
	<?= $this->element('form_login') ?>
	<?= $this->element('menu/mobile_menu') ?>
</div>