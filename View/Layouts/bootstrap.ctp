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

		<?php
			echo $this->Html->meta('icon');	//, $this->Html->url('favicon.ico'));	
			echo $this->Html->css(array(	/// put to webroot
				Environment::read('cdn_base_url').'css/fontawesome.min.css',
				Environment::read('cdn_base_url').'css/ionicons.min.css',
				Environment::read('cdn_base_url').'css/bootstrap337',
				Environment::read('cdn_base_url').'css/datetimepicker/bootstrap-datetimepicker.min',
				Environment::read('cdn_base_url').'css/bootstrap-select/bootstrap-select.min',
				Environment::read('cdn_base_url').'css/jquery-ui',
				Environment::read('cdn_base_url').'css/slick',
				Environment::read('cdn_base_url').'css/slick-theme',
				Environment::read('cdn_base_url').'css/fancybox/jquery.fancybox',
				Environment::read('cdn_base_url').'css/select2.min'
			));
			echo $this->Html->css(Environment::read('cdn_base_url').'css/style.css?v='.date('U'));	
			echo $this->Html->css(Environment::read('cdn_base_url').'responsive.css?v='.date('U'));

			echo $this->fetch('css');

			echo $this->Html->script(array(
				Environment::read('cdn_base_url').'js/jquery.min',
				Environment::read('cdn_base_url').'js/jquery-ui.min',
				Environment::read('cdn_base_url').'js/bootstrap337',
				Environment::read('cdn_base_url').'js/plugins/jquery.dataTables.min',
				Environment::read('cdn_base_url').'js/plugins/dataTables.bootstrap.min'
			), array(
				'block' => 'scriptTop'
			));
			echo $this->Html->script('locale/lang.'.$this->Session->read('Config.language').'.js?v='.date('U'));
			echo $this->Html->script('common.js?v='.date('U'));

			echo $this->fetch('scriptTop');	
		?>
		<script type="text/javascript">
			var base_url ='';
			var base_api_url ='';
			var cfg_lang = '';
			$(document).ready(function() {
				base_url = "<?=Router::url('/', true)?>";
				base_api_url = "<?=Router::url('/', true)?>";
				cfg_lang = "<?=$this->Session->read('Config.language')?>";
				COMMON.init_page(cfg_lang, base_url, base_api_url);
			});
			
			$(document).on('click', '.btn-change-language', function(){
				COMMON.cfg_lang = $(this).data('lang');
				$('<form action="<?php echo $this->here; ?>" method="post"><input name="set_new_language" value="' + $(this).data('lang') + '"/></form>')
					.appendTo('body').submit();
			});
		</script>
		<!--
		Mandatory in IE 6, 7, 8 and 9.
		-->
		<!--[if IE]>
		<script type="text/javascript" src="js/jszip-utils-ie.min.js"></script>
		<![endif]-->

	</head>

	<body class="skin-blue fixed <?=$this->Session->read('Config.language')?>">
		<div id='loadingDiv' style="display: none">
		    <span class="ajax-loader"></span>
		 </div> 
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
			
			<?= $this->element('modal', array('request' => $this->request)); ?>
		<?php
			echo $this->Html->script(array(
				Environment::read('cdn_base_url').'js/plugins/datepicker/bootstrap-datepicker',
				Environment::read('cdn_base_url').'js/moment.min',
				Environment::read('cdn_base_url').'js/plugins/datetimepicker/bootstrap-datetimepicker.min',
				Environment::read('cdn_base_url').'js/plugins/bootstrap-select/bootstrap-select.min',
				Environment::read('cdn_base_url').'js/plugins/fancybox/jquery.fancybox',
				Environment::read('cdn_base_url').'js/bootbox.min',
				Environment::read('cdn_base_url').'js/slick.min',
				Environment::read('cdn_base_url').'js/jszip.min',
				Environment::read('cdn_base_url').'js/jszip-utils.min',
				Environment::read('cdn_base_url').'js/filesaver.js',
				Environment::read('cdn_base_url').'js/sprintf.min',
				Environment::read('cdn_base_url').'js/jquery.validate.min.js',
				Environment::read('cdn_base_url').'js/plugins/ckeditor/balloon/ckeditor',
				Environment::read('cdn_base_url').'js/plugins/select2.min'
			), array(
				'block' => 'scriptBottom'
			));

			echo $this->Html->script(Environment::read('cdn_base_url').'js/common.js?v='.date('U'));
			echo $this->Html->script(Environment::read('cdn_base_url').'js/service.js?v='.date('U'));

			echo $this->fetch('scriptBottom');
			echo $this->fetch('script');
		?>
		
		
	</body>
</html>