<div class="pull-right"> 
	<?php // $this->Html->image('topbar/icon/search.png', ['alt' => '', 'class' => "navigate-bar"]); ?>		

	<?php 
		echo $this->Html->link(
			$this->Html->image('topbar/icon/add.png', ['alt' => '', 'class' => "navigate-bar"]), 
			
			array(
				'plugin' => 'member', 
				'controller' => 'teacher_create_lessons', 
				'action' => 'index',
				'admin' => false,
			), 
			array('escape' => false)
		); 
	?>

	<?php 
		echo $this->Html->link(
			$this->Html->image('topbar/icon/schedule.png', ['alt' => '', 'class' => "navigate-bar"]), 
			
			array(
				'plugin' => 'member', 
				'controller' => 'teacher_create_lessons', 
				'action' => 'index',
				'admin' => true,
			), 
			array('escape' => false)
		); 
	?>

	<?php // $this->Html->image('topbar/icon/notice.png', ['alt' => '', 'class' => "navigate-bar"]); ?>
	  
	<button class="button_login" onclick="document.getElementById('login').style.display='block'" class="btn btn-large">
 		<?= '登入' // __('login'); ?>
	</button>


	<?php 
		//foreach($available_language as $lang) {	
	?>
		
		<!-- <a href="javascript:" class="btn-change-language" data-lang="<?php // $lang ?>">
			<?php //echo $this->Html->image('flags/'.$lang.'.png', array(
				//'style' => 'width: 30px',
				//'alt' => __($lang.'_name'))); ?> <?php // __($lang.'_name') ?>
		</a> -->
	<?php
		//}
	?>	
</div>



<div id="login" class="w3-modal">
    <div class="w3-modal-content " style="padding-top: 30px; max-width:450px; min-height: 450px">

		<div class="pull-right" style="margin-top: -30px; margin-right: 20px"><br>
			<span onclick="document.getElementById('login').style.display='none'" class="" title="Close Modal">&times;</span>
		</div>

	
		<?php echo $this->Form->create('Member', array('role' => 'form', 'url' => '/login')); ?>
			<fieldset>
				<div class="center">
					<?= $this->Html->image('login/logo.jpg', ['alt' => '', 'style' => "margin-bottom: 30px; width: 50%;"]); ?>
      
				</div>
				<div class="row" style="padding-bottom: 20px">


					<div class="col-xs-2 col-md-2">	</div>
					<div class="col-xs-3 col-md-3">	<label><b>帳戶</b></label></div>
					
					<div class="col-xs-5 col-md-5">	
						<input class="form-control" type="text" placeholder="進入帳戶名稱" name="username" required>
					</div>
					<div class="col-xs-2 col-md-2">	</div>
				</div>

				<div class="row" style="padding-bottom: 20px">
					<div class="col-xs-2 col-md-2">	</div>
					<div class="col-xs-3 col-md-3">	<label><b>密碼</b></label></div>
					
					<div class="col-xs-5 col-md-5">	
						<input class="form-control" type="password" placeholder="密碼" name="password" required>
					</div>
					<div class="col-xs-2 col-md-2">	</div>
				</div>
					
				<div class="row" style="padding-bottom: 20px">
					<div class="col-xs-2 col-md-2">	</div>
					<div class="col-xs-3 col-md-3">	<label><b>學校編號</b></label></div>
					
					<div class="col-xs-5 col-md-5">	
						<input class="form-control" type="text" placeholder="學校編號" name="school_code">
			
					</div>
					<div class="col-xs-2 col-md-2">	</div>
				</div>

				<div class="row" style="padding-bottom: 30px">
					<div class="col-xs-2 col-md-2">	</div>
					<div class="col-xs-8 col-md-8">	
					<?php
						echo $this->Form->submit(__('login'), array(
							'style' => 'color: white; border-radius: 30px !important; width: 100%; text-align: center',
							'class' => 'btn btn-success btn-block btn-flat'
						));
					?>
					</div>
				
					<div class="col-xs-2 col-md-2">	</div>
				</div>
			</fieldset>
		<?php echo $this->Form->end(); ?>

	</div>
</div> <!-- end login -->