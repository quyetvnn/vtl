<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- <title>-->
			<?php //echo $title_for_layout; ?>
		<!-- </title>  -->

		<title>全民學習</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="google-signin-client_id" content="582353043070-t8da0egb0o77s203r4sofvj3h4u65q4l.apps.googleusercontent.com">

		<?php
			echo $this->Html->meta('icon');	

			echo $this->Html->css(array(	/// put to webroot
				'fontawesome.min.css',
				'ionicons.min.css',
				'reset',
				'CakeAdminLTE',
				'bootstrap337',
				'datetimepicker/bootstrap-datetimepicker.min',
				'bootstrap-select/bootstrap-select.min',
				'jquery-ui',
				'slick',
				'slick-theme',
				'fancybox/jquery.fancybox'
			));
			echo $this->Html->css('style.css?v='.date('U'));	

			echo $this->fetch('css');

			echo $this->Html->script(array(
				'jquery.min',
				'jquery-ui.min',
				'bootstrap337',
				'plugins/jquery.dataTables.min',
				'plugins/dataTables.bootstrap.min'
			), array(
				'block' => 'scriptTop'
			));
			echo $this->fetch('scriptTop');	
		?>
	</head>

	<body class="skin-blue fixed <?=$this->Session->read('Config.language')?>">
		<div id='loadingDiv' style="display: none">
		    <span class="ajax-loader"></span>
		 </div> 
		<?php // echo $this->element('menu/top_menu'); ?>
			<div class="main-sidebar">
				<?php 
					echo $this->element('menu/left_sidebar'); 
				?>
			</div>
			<div class="main-content <?=isset($layout_class)?$layout_class:''?>" >
				<section class="content-header">
					<?php echo $this->flash->render(); ?>
					<?php echo $this->fetch('content'); ?>
                </section> 
			</div>
			<script src="https://apis.google.com/js/platform.js"></script>
			<?= $this->element('modal', array('request' => $this->request)); ?>
		<?php
			echo $this->Html->script(array(
				'plugins/datepicker/bootstrap-datepicker',
				'moment.min',
				'plugins/datetimepicker/bootstrap-datetimepicker.min',
				'plugins/bootstrap-select/bootstrap-select.min',
				'plugins/fancybox/jquery.fancybox',
				'bootbox.min',
				'slick.min',
				'sprintf.min',
				'jquery.validate.min.js'
			), array(
				'block' => 'scriptBottom'
			));

			echo $this->Html->script('common.js?v='.date('U'));
			echo $this->Html->script('service.js?v='.date('U'));

			echo $this->fetch('scriptBottom');
			echo $this->fetch('script');
		?>
		<script type="text/javascript">
			var base_url ='';
			var base_api_url ='';
			var cfg_lang = '';
			var gg_client_id = '';
			$(document).ready(function() {
				base_url = "<?=Router::url('/', true)?>";
				base_api_url = "<?=Router::url('/', true)?>";
				cfg_lang = "<?=$this->Session->read('Config.language')?>";
				gg_client_id = "<?=Environment::read('gg_app.client_id')?>";
				COMMON.init_page(cfg_lang, base_url, base_api_url, gg_client_id);
			});
			
			$('.btn-change-language').on('click', function(){
				COMMON.cfg_lang = $(this).data('lang');
				$('<form action="<?php echo $this->here; ?>" method="post"><input name="set_new_language" value="' + $(this).data('lang') + '"/></form>')
					.appendTo('body').submit();
			});
		</script>
	</body>
</html>