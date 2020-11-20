
<div class="row">
	<div class="col-xs-12">
		<div class="second-text"> <?=__d('member', 'recommend_video')?> </div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
	
<?php 
	$str_data = file_get_contents(__DIR__."/recommended_video.json");
	$data = json_decode($str_data,true);

	$randIndex = array_rand($data, 12);
	
	foreach ($randIndex as $index) {
		
?>
		<div class="video-block col-sm-3 col-md-3">
			<div class="videoWrapper">
				<iframe src="<?php echo $data[$index]['url'];?>" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe>
			</div>
	
			<div class="row video-content">
				<div class="video-block-avatar col-md-2 col-xs-2">
					<div class="avatar-demo" style="background-image: url(../img/temp_/<?php echo $data[$index]['icon'];?>_avatar.png);"></div>
				</div>
				<div class="video-block-text col-md-10 col-xs-10">
					<p class="text-title"><?php echo $data[$index]['title']; ?></p>
					<p class="text-desc"><?php echo $data[$index]['author']; ?></p>
				</div>
			</div>
		</div>

<?php
		}
		
?>
<style>
	.video-block {
		display: inline-block;
		vertical-align: top;
	}
	div.video-block:nth-child(4n+1) {
		clear: both;
	} 
	@media only screen and (min-width: 768px) and (max-width: 1366px) {
		.video-block-text {
			padding-right: 10px !important;
			padding-left: 10px !important;
		}
		.video-block-avatar {
			padding-left: 10px !important;
		}
		.video-block-avatar .avatar-demo {
			width: 20px;
			height: 20px;
		}
	}
	@media only screen and (max-width: 767px) {
		.video-block {
			display: block;
		}
	}

</style>

	</div>
</div>