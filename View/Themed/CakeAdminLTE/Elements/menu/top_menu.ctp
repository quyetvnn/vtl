<style type="text/css" media="screen">
	.header .navbar-custom-menu,
	.header .navbar-right {
		float: right; position: relative; z-index: 1001;
	}

	.header .navbar-custom-menu > .navbar-nav>li {
		position: relative;
	}

	.header .navbar-custom-menu > .navbar-nav > li > a {
	    color: #FFFFFF;
	}

	.header .navbar-custom-menu > .navbar-nav > li > a:hover,
	.header .navbar-custom-menu > .navbar-nav > li > a:active,
	.header .navbar-custom-menu > .navbar-nav > li.open > a{
		background: rgba(0, 0, 0, 0.1);
		color: #f6f6f6;
	}

	.header .navbar-custom-menu > .navbar-nav > li > .dropdown-menu {
		position: absolute;
		right: 0;
		left: auto;
	}

	.header .navbar-custom-menu > .navbar-nav > .language > a {
		padding-top: 5px;
		padding-bottom: 5px;
	}

	.header .navbar-custom-menu > .navbar-nav > .language > a img {
		width: 40px;
		margin-right: 10px;
	}

	.header .navbar-custom-menu > .navbar-nav > .language > .dropdown-menu img {
		width: 50px;
	}

	.header .navbar-custom-menu > .navbar-nav > .user-menu{
		margin-right: 30px;
	}

	.header .navbar-custom-menu > .navbar-nav > .user-menu > .dropdown-menu > li.user-header{
		height: auto;
	}

	.header .navbar-custom-menu > .navbar-nav > .user-menu > .dropdown-menu > li.user-header > p{
		font-size: 20px;
	}

	.header .navbar-custom-menu > .navbar-nav > .user-menu > .dropdown-menu > li.user-header > ul{
		margin: 0; text-align: left; list-style-type: disc; color: #FFFFFF;
	}
</style>

<!-- header logo: style can be found in header.less -->
<header class="header">

	<div class="logo"> <?= $this->Html->image(Router::url('/', true).'img/LeARN-Logo-white.png', ['alt' => Environment::read('site.name'), 'class' => "profile-image", 'style'=>'height: 80%']) ;?> </div>

	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Sidebar toggle button-->
		<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
		<div class="navbar-right"></div>
	</nav>
	<div class="navbar-custom-menu">
		<ul class="nav navbar-nav">
            <?php if(isset($current_user)){ ?>
			<li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="hidden-xs">
                        <?php 
                            $Hour = date('G');
                            if ($Hour >= 5 && $Hour <= 11) {
                                $greeting =  __('good_morning');
                            } 
                            else if ($Hour >= 12 && $Hour <= 18) {
                                $greeting = __('good_afternoon');
                            } 
                            else if ($Hour >= 19 || $Hour <= 4) {
                                $greeting = __('good_evening');
                            }

                            echo $greeting . ", " . (isset($current_user['name']) ? $current_user['name'] : ''); 
                        ?>
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li class="user-header">
						<p><?= 
							isset($current_user['name']) ? $current_user['name'] : ''; 
						?></p>
                        <?php if( !empty($current_user['Role']) ){?>
                            <ul>
                                <?php foreach ($current_user['Role'] as $role) { ?>
                                    <li><?= $role['name']; ?></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>

                    <li class="user-footer">
                        <div class="pull-left">
                            <?php 
                                // $this->Html->link(__('Profile'), array(
                                //     'plugin' => 'administration', 'controller' => 'administrators', 'action' => 'view', 'admin' => true, $current_user['id']
                                // ), array('class' => 'btn btn-default btn-flat'));
                            ?>
                        </div>
                        <div class="pull-right">
                            <?= 
                                $this->Html->link(__('Sign out'), array(
                                    'plugin' => 'administration', 'controller' => 'administrators', 'action' => 'logout', 'admin' => true
                                ), array('class' => 'btn btn-default btn-flat'));
                            ?>
                        </div>
                    </li>
                </ul>
			</li>
            <?php } ?>
			<li class="dropdown user user-menu">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<span class="hidden-xs">
						<?php 
							$tmp_lang = $this->Session->read('Config.language');

							//echo $this->Html->image('flags/'.$tmp_lang.'.png', array('alt' => __($tmp_lang.'_name'))) . "<span>".__($tmp_lang.'_short_name')."</span>";
						?>

						<span>
							<?php echo __($tmp_lang.'_language'); ?>
						</span>
					</span>
				</a>

				<ul class="dropdown-menu" style="width: 50px !important">
					<?php 
						foreach($available_language as $lang) {				
					?>
						<li>
							<a href="javascript:" class="btn-change-language" data-lang="<?= $lang ?>">
								<?php 
									//echo $this->Html->image('flags/'.$lang.'.png', array('alt' => __($lang.'_name'))); ?> <?php //__($lang.'_name') 
									
									echo __($lang.'_name');
								?>
							</a>
						</li>
					<?php
						}
					?>			
				</ul>
			</li>
		</ul>
	</div>
</header>