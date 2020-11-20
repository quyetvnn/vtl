<?php

	$str_data = file_get_contents("video.json");
	$data = json_decode($str_data,true);

	foreach ($data as $key) {
?>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<div class="videoWrapper">
			<iframe src="<?php echo $key['url']; ?>" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
		</div>

		<div class="row video-content">
			<div class="col-md-2 col-xs-2">
				<div class='avatar-demo'><img src="/img/temp_/all4learn_avator.png"></div>
			</div>
			<div class="col-md-10 col-xs-10">
				<p class="text-title"><?php echo $key['title']; ?></p>
				<p class="text-desc"><?php echo $key['author']; ?></p>
			</div>
		</div>
	</div>
	
<?php
			
	}
?>	
