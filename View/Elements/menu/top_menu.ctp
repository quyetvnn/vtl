<?php
    $show_name   = '';
    $avatar      = '';
    if(isset($current_user) && !empty($current_user)){
		$avatar = isset($current_user['tmp_avatar'])?$current_user['tmp_avatar']: '';
		$show_name = isset($current_user['nick_name']) && !empty($current_user['nick_name']) ? $current_user['nick_name'] : $current_user['full_name'];

		if(isset($current_user['avatar']) && $current_user['avatar']!=''){
			$avatar = $current_user['avatar'];
		}
    	
    }
?>
<div class="row show-desktop topbar-custom m-0" style="min-height: 100px">
	<!-- <div class="search-top text-center col-md-6 nopadding">
		<form method="GET" class="search-group">
			<div class="input-w-icon-t">
				<input type="text" name="inp_search" class="form-control" placeholder="搜尋">
				<span class="fa fa-search icon"></span>
			</div>
		</form>
	</div> -->
	<div  class="col-md-12 main-topbar nopadding">
		<?php  $params = $this->request->params; ?>
		<?php if (isset($current_user) && !empty($current_user)) { 
			if ($current_user['is_teacher']){?>
				<div class="topbar-item support-info n-toggle-dropdown">
					<span class="icon icon-add"></span>
					<ul class="n-dropdown-content text-left">
						<li>
							<div class="icon icon-create-class"></div>
								<?php
									echo $this->Html->link(
										__d('member', 'add_class'),
										array(
											'plugin' => '', 
											'controller' => 'teacher_portals', 
											'action' => 'add',
											'admin' => false,
										), 
										array('escape' => false)
									); 
								?>
		                    
		                </li>
		                <li>
		                    <div class="icon icon-upload-materials"></div>
		                    <?php
								echo $this->Html->link(
									__d('member', 'add_homework'),
									array(
										'plugin' => '', 
										'controller' => 'teacher_portals', 
										'action' => 'assignment_create',
										'admin' => false,
									), 
									array('escape' => false)
								); 
							?>
		                </li>
		                <!-- <li>
		                    <div class="icon icon-upload-videos"></div>
		                    <?=__d('member', 'upload_videos')?>
		                </li> -->
					 </ul>
				</div>
			<?php } ?>
			<?php if( $current_user['is_teacher'] || $current_user['is_student']){ ?>
				<div class="topbar-item support-info n-toggle-dropdown">
					<span class="icon icon-schedule"></span>
					<div class="n-dropdown-content">
						<ul class=" text-left">
							<?php if(isset($current_user['member_role'][Environment::read('role.student')])){
								foreach ($current_user['member_role'][Environment::read('role.student')] as $key => $role){?>
									<li class='itm-title'>
										<?=__d('member', 'student_role')?> (<?=$role['School']['SchoolLanguage'][0]['name']?>)
									</li>
									<li>
										<div class="icon icon-create-class"></div>
											<?php
												echo $this->Html->link(
													__d('member', 'admin_teacher_create_lesson'),
													array(
														'plugin' => '', 
														'controller' => 'student_portals', 
														'action' => 'browse',
														$role['School']['school_code'],
														'admin' => false,
													), 
													array('escape' => false)
												); 
											?>
					                    
					                </li>
					                <li>
					                    <div class="icon icon-upload-materials"></div>
					                    <?php
											echo $this->Html->link(
												__d('member', 'assignments'),
												array(
													'plugin' => '', 
													'controller' => 'student_portals', 
													'action' => 'assignments',
													$role['School']['school_code'],
													'admin' => false,
												), 
												array('escape' => false)
											); 
										?>
					                </li>
					        <?php } } ?>
				            <?php if(isset($current_user['member_role'][Environment::read('role.teacher')])){
				            			foreach ($current_user['member_role'][Environment::read('role.teacher')] as $key => $role){?>
									<li class='itm-title'>
										<?=__d('member', 'teacher_role')?> (<?=$role['School']['SchoolLanguage'][0]['name']?>)
									</li>
					            	<li>
										<div class="icon icon-create-class"></div>
											<?php
												echo $this->Html->link(
													__d('member', 'admin_teacher_create_lesson'),
													array(
														'plugin' => '', 
														'controller' => 'teacher_portals', 
														'action' => 'browse',
														$role['School']['school_code'],
														'admin' => false,
													), 
													array('escape' => false)
												); 
											?>
					                    
					                </li>
					                <li>
					                    <div class="icon icon-upload-materials"></div>
					                    <?php
											echo $this->Html->link(
												__d('member', 'assignments'),
												array(
													'plugin' => '', 
													'controller' => 'teacher_portals', 
													'action' => 'assignments',
													$role['School']['school_code'],
													'admin' => false,
												), 
												array('escape' => false)
											); 
										?>
					                </li>
					        <?php } } ?>
						 </ul>
					</div>
				</div>
			<?php } ?>

			<div class="topbar-item support-info n-toggle-dropdown logged-user" id="menu-user">
				<div class="toggle-pane group-img-radius pointer clearfix">
					<span style="margin-right: 10px"><?=$show_name?></span>
					<div class="box-img pull-right mr-0">
						<?php
							echo $this->Html->image($avatar, ['alt' => $show_name, 'class' => "profile-image"]);
						?>
					</div>
				</div>
				<div class="n-dropdown-content user-pane">
					<ul class="language-info user-pane text-left hidden" id="language-pane">
						<li>
							<span class="fa fa-arrow-left pointer" onclick="COMMON.show_menu('#user-pane')"></span>
						</li>
						<?=$this->element('language_detail')?>
					</ul>
					<ul class="support-info user-pane text-left hidden" id="support-pane">
						<li>
							<span class="fa fa-arrow-left pointer" onclick="COMMON.show_menu('#user-pane')"></span>
						</li>
						<?=$this->element('help_detail')?>
					</ul>
					<ul class="text-left" id="user-pane">
						<li class="title">
		                    <?=__d('member', 'my_page')?>
		                </li>
		                <li class="group-img-radius clearfix">
		                	<div class="box-img pull-left">
		                		<?php echo $this->Html->image($avatar, ['alt' => $show_name, 'class' => "profile-image"]); ?>
							</div>
		                    <div class="addon-text"><?=$show_name?></div>
		                </li>

		                <?php  if(isset($current_user['member_role'][Environment::read('role.school-admin')])){?>
		                <li class="p-0">
		                	<hr class="line-light">
		                </li>
		                <li>
		                	<?php
		                		echo $this->Html->link(__d('member', 'membership'), 
		                								array(
															'plugin' => '', 
															'controller' => 'schools', 
															'action' => 'payment',
															'admin' => false
														), 
														array('escape' => false)
													);
		                	?>
		                </li>
		            	<?php } ?>
						<?php if(isset($current_user['schools']) && !empty($current_user['schools'])){?>
		                	<li class="p-0">
			                	<hr class="line-light">
			                </li>
			                <li class="title">
			                	<?=__d('member', 'my_community')?>
			                </li>
			                <?php foreach($current_user['schools'] as $school){ 
			                		if(!empty($school['avatar'])){
		                				$avatar_school = $this->Html->image($school['avatar'], ['alt' => $school['name'], 'class' => "profile-image"]); 
		                			}else{
		                				$avatar_school = "<span class='default-text-avatar'>".$school['minimal_name']."</span>";
		                			}
					        ?>

					        	<li class="group-img-radius clearfix">
									<?php 
										echo $this->Html->link('
											<div class="box-img pull-left">'.$avatar_school.'</div>
											<div class="addon-text">'.$school['name']. '</div>',
											array(
												'plugin' => '', 
												'controller' => 'schools', 
												'action' => 'landing',
												isset($school['School']['school_code']) ? $school['School']['school_code'] : array(),
												'admin' => false,		// edit
											), 
											array('escape' => false)
										); 
									?>
				                </li>
							<?php } 
						} ?>
		                <li class="p-0">
		                	<hr class="line-light">
		                </li>
		                <li class="clearfix pointer" onclick="COMMON.show_menu('#language-pane')">
		                	<?=__d('member', 'language')?>
		                	<span class="fa fa-angle-right m-0 p-0 arrow-right pull-right"></span>
		                </li>
		                <li class="clearfix pointer" onclick="COMMON.show_menu('#support-pane')">
		                	<?=__d('member', 'help')?>
		                	<span class="fa fa-angle-right m-0 p-0 arrow-right pull-right"></span>
		                </li>
		                <?php if($current_user['is_self_register']){ ?>
		                <li>
		                	<?php
		                		echo $this->Html->link(__d('member', 'create_school'), 
		                								array(
															'plugin' => '', 
															'controller' => 'schools', 
															'action' => 'welcome',
															'admin' => false
														), 
														array('escape' => false)
													);
		                	?>
		                </li>
		            	<?php } ?>
		                <?php if($current_user['is_school_admin']){ ?>
		                	<li>
			                	<a href="<?=Router::url('/', true).'admin'?>"><?=__d('member', 'school_control_panel')?></a>
			                </li>
		                <?php } ?>
		                <li class="clearfix">
		                	<a href="javascript:void(0)" data-toggle="modal" data-target="#modal-reset-password" data-backdrop="static"><?=__d('member', 'reset_password')?></a>
		                </li>
		                <li class="clearfix">
		                	<a href="javascript:COMMON.logout()"><?=__d('member', 'logout')?></a>
		                </li>
					 </ul>
				</div>
			</div>
				
			<?php } else { ?>
				
				<div class="topbar-item language-info n-toggle-dropdown">
					<span class="icon-locale"></span>
					<span class="fa fa-chevron-down"></span>
					<ul class="n-dropdown-content text-center">
						<?=$this->element('language_detail')?>
					 </ul>
				</div>
				<?php
            		echo $this->Html->link(__d('member', 'create_school'), 
            								array(
												'plugin' => '', 
												'controller' => 'schools', 
												'action' => 'welcome',
												'admin' => false
											), 
											array('escape' => false, 'class' => 'topbar-item')
										);
            	?>
				<div class="topbar-item support-info n-toggle-dropdown">
					<?php echo __d('member', 'technical_support')?>
					<ul class="n-dropdown-content text-left">
						<?=$this->element('help_detail');?>
					 </ul>
				</div>
				<a href="javascript:COMMON.trigger_form_login('register')" class="topbar-item" >
					<?php echo  __d('member', 'sign_up')?>
				</a>
				<button class="button_login text-dark-green"
						style="box-shadow: 0 2px 6px 0 rgba(169, 169, 169, 0.4);" 
						onclick="COMMON.trigger_form_login('login')" 
						class="btn btn-large"> 
					<?=  __('login'); ?> 
				</button>

		<?php  } ?>

	</div> <!-- end pull right -->
</div>
