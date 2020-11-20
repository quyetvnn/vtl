<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

<?php echo $this->Html->docType('html5'); ?> 
<html>
	<head>
		<?php echo $this->Html->charset(); ?>

		<style>
			
			/* .box-body {
				height: 500px;
				overflow: auto; 	
			}  */
			table th {
				position: sticky;
				top: 0;
			}
			th {
				background-color: #00802b;
				color: white; 
			}

			th a{
				color: white; 
			}
			
		</style>

		<title>
			<?php echo Environment::read('site.name'); ?>:
			<?php echo $title_for_layout; ?>
		</title>

		<meta name="keywords" content="<?php echo Environment::read('site.keywords'); ?>">

		<meta name="description" content="<?php echo Environment::read('site.description'); ?>">

		<?php 
			echo $this->Html->meta('icon');
			echo $this->Html->meta(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no']);
			echo $this->fetch('meta');

			echo $this->Html->css('bootstrap.min.css');
		    echo $this->Html->css('fontawesome.min.css');
			echo $this->Html->css('ionicons.min.css');			
			
			/**
			 * 3rd party DateTime Picker
			 * @link http://www.malot.fr/bootstrap-datetimepicker/
			 */
			echo $this->Html->css(array(
				//'datepicker/datepicker3',
				'datetimepicker/bootstrap-datetimepicker.min',
				'bootstrap-select/bootstrap-select.min',
				'google-font',
				'jquery-ui',
				// 'upload',
				'fancybox/jquery.fancybox',
			));

			echo $this->Html->css('CakeAdminLTE.css?v='.date('U'));
			echo $this->Html->css('backend.css?v=' . date('U'));

			echo $this->fetch('css');

			echo $this->Html->script(array(
				'jquery.min',
				'jquery-ui.min',
                'bootstrap.min',
                'jquery.validate.min',	// fix display hidden required field from language
				'bootbox.min',
			), array(
				'block' => 'scriptTop'
			));

		
			echo $this->fetch('scriptTop');			
		?>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js" type="text/javascript" charset="utf-8"></script>
         -->

		<style>
		 	table th {
				position: sticky;
				top: 0;
			}
			th {
				background-color: #00802b;
				color: white; 
			}

			th a{
				color: white; 
			}
		</style>

		<script type="text/javascript" charset="utf-8">
			var cakephp = {
				base: "<?= Router::url('/'); ?>",
			}
		</script>
	</head>
	<body class="skin-blue fixed">
		<?php echo $this->element('menu/top_menu'); ?>
		<div class="wrapper row-offcanvas row-offcanvas-left">
			<?php echo $this->element('menu/left_sidebar'); ?>
		
			<!-- Right side column. Contains the navbar and content of the page -->
		    <aside class="right-side">  
		    	<section class="content-header">
				    <h1>
				        <?= $title_for_layout; ?>
				        <small><?= __('console') ?></small>
				    </h1>
				    <ol class="breadcrumb">
                         <li>
							<?php //echo __('home'); ?>
                        </li>
						
						<li class="active">
							<?php // echo $title_for_layout; ?>
						</li>
				    </ol>
					<div style='margin-top: 20px;' >
						<?= $this->Session->flash(); ?>
						<?php echo $this->fetch('content'); ?>
					</div>
                </section> 
			</aside><!-- /.right-side -->
		</div><!-- ./wrapper -->
		<?php
			echo $this->Html->script(array(
				//'plugins/datepicker/bootstrap-datepicker',
				'CakeAdminLTE/moment.min',
				'plugins/datetimepicker/bootstrap-datetimepicker.min',
				'CakeAdminLTE/app',
				//'ckeditor/ckeditor',
				'plugins/bootstrap-select/bootstrap-select.min',
				'plugins/fancybox/jquery.fancybox',
				//'upload',
				'CakeAdminLTE/common'
			), array(
				'block' => 'scriptBottom'
			));

		
			echo $this->fetch('scriptBottom');
			echo $this->fetch('script');
		?>
		<script type="text/javascript">
			$('.btn-change-language').on('click', function(){
				$('<form action="<?php echo $this->here; ?>" method="post"><input name="set_new_language" value="' + $(this).data('lang') + '"/></form>')
					.appendTo('body').submit();
			});
			COMMON.base_url = "<?= Router::url('/'); ?>";
		</script>
	</body>
</html>
<?php //echo $this->element('sidebar_select'); ?>
