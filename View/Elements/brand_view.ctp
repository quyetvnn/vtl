<!-- brand -->
<?php if ($brands): ?>
	<h2>&nbsp;<i>Brands:</i></h2>
	<div class="col-xs-12">
	<?php foreach ($brands as $brand): ?>
		<div class="col-xs-4">
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title">
						<?php if (isset($brand_imgs[$brand['brand_id']]) && !empty($brand_imgs[$brand['brand_id']])): ?>
							<img
							style="width: 100px; height: 100px; border-radius: 25%;"  
							src="<?php echo Router::url('/',true).$brand_imgs[$brand['brand_id']]; ?>" />
						<?php endif ?>
						
						<span style="padding-left: 20px;"><?php if (isset($brand['name'])) echo h($brand['name']); ?></span>
					</h3>

	            <div class="box-tools pull-right">
		            <a href="<?php echo Router::url(array('plugin'=>'company','controller'=>'brands','action'=>'view','admin'=>true, $brand['brand_id'])) ?>" class="btn btn-primary">
		            	<i class="fa fa-eercast"></i> View
		            </a>
	            </div>
				</div>

				<div class="box-body">
					<?php foreach ($brand_input_fields as $brand_input_field): ?>
						<?php 

							$ico = '';
							$style = '';

							if ( strpos($brand_input_field, 'name') !== false ) {
								$style = 'font-size: 28px; font-weigth:bold;';
							}

							if (
								strpos($brand_input_field, 'description') !== false
								) {
								$style = 'font-size: 16px; font-style:italic; color: #ccc;';
							}

							if (
								strpos($brand_input_field, 'address') !== false
								) {
								$style = 'font-size: 16px; color: #333;';
								$ico = '<i class="fa fa-map"></i>';
							}

							if (
								strpos($brand_input_field, 'content') !== false ||
								strpos($brand_input_field, 'terms') !== false ||
								strpos($brand_input_field, 'privacy') !== false ||
								strpos($brand_input_field, 'about') !== false
								) {
								$style = 'font-size: 14px; color: #666;';
								$ico = '<i class="fa fa-paragraph"></i> '.ucfirst($brand_input_field);
							}

							if (
								strpos($brand_input_field, 'time') !== false
								) {
								$style = 'font-size: 16px; color: #333;';
								$ico = '<i class="fa fa-clock-o"></i> ';
							}

							if (
								strpos($brand_input_field, 'hotline') !== false ||
								strpos($brand_input_field, 'phone') !== false
								) {
								$style = 'font-size: 16px; color: #333;';
								$ico = '<i class="fa fa-phone"></i> ';
							}

						 ?>
						<div style="padding: 10px 0; <?php echo $style; ?>">
							<?php echo $ico; ?> 
							<?php echo ($brand[$brand_input_field]); ?>
						</div>
					<?php endforeach ?>
				</div>

				<div class="box-body">
					<?php if (isset($_data['link_zho'])) echo  $this->Html->link($_data['link_zho'],$_data['link_zho']); ?>
				</div>
			</div>
		</div>
	<?php endforeach ?>
	</div>
<?php endif ?>
<!-- /brand -->


