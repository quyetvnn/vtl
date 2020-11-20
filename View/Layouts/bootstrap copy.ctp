<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
			<?php echo $title_for_layout; ?>
		</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<?php
			echo $this->Html->meta('icon');

			echo $this->fetch('meta');

			echo $this->Html->css(
				'custom_admin'
			);

			echo $this->fetch('css');
		?>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Latest compiled and minified Font-awesome CSS -->
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

		<!-- Latest compiled and minified CSS for DataTable -->
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<!-- Latest compiled and minified JavaScript for DataTable -->
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js" type="text/javascript" charset="utf-8"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
			<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->

	</head>

	<body class="dashboard">

		<div class="container-fluid display-table">

			<h1 style="font-weight: bold; font-size: 3em; text-align: center; padding: 20px;">
				<?php print "Bootstrap Frontend Layout."; ?>
			</h1>

			<div class="sidebar hidden-xs col-sm-1 col-md-2 display-table-cell v-align box">
				<div class="logo">
					
				</div>

				<div class="navigation">
					<?php echo $this->Element('vertical-sidebar'); ?>
				</div>
			</div>

			<div class="content col-sm-11 col-md-offset-2 col-md-10 display-table-cell v-align">
				<div class="row">
					<header>
						<div class="col-md-7">
							<nav class="navbar-default pull-left">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle collapsed" data-toggle="offcanvas" data-target="#side-menu" aria-expanded="false">
										<span class="sr-only">Toggle navigation</span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
								</div>
							</nav>
						</div>
						<div class="col-md-5">
							<div class="header-rightside">
								<ul class="list-inline header-top pull-right">
									<li class="dropdown">
										<?php
											if( $this->Session->check('Admin.name') ){
										?>
												<a href="#" class="dropdown-toggle" data-toggle="dropdown">
													<?php print $this->Session->read('Admin.name'); ?><b class="caret"></b>
												</a>

												<ul class="dropdown-menu">
													<li>
														<div class="navbar-content">
															<ul>
																<li>
																	<?php 
																		print $this->Html->link(__('Logout'), array(
																			'plugin' => 'auth', 'controller' => 'admins', 'action' => 'logout', 'admin' => true
																		)); 
																	?>
																</li>
															</ul>
														</div>
													</li>
												</ul>
										<?php
											} else {
												print $this->Html->link(__('Logout'), array(
													'plugin' => 'auth', 'controller' => 'admins', 'action' => 'login', 'admin' => true
												)); 
											}
										?>
									</li>
								</ul>
							</div>
						</div>
					</header>
				</div>

				<div class="col-xs-12">
					<?php echo $this->Flash->render(); ?>

					<?php 
						print $this->Element('hero_banner');
					?>

					<?php echo $this->fetch('content'); ?>
				</div>
			</div>
		</div>

		<?php echo $this->fetch('script'); ?>

		<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){

			});
		</script>
	</body>
</html>