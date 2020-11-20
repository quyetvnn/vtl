<?php 
	if (empty($_controller) || empty($_model) ) {
		echo '_controller, _model is empty';
	}
 ?>
<div class="form-group videos-upload">
	<div class="well well-sm">
		<div class="row videos-upload-row">

			<?php echo $this->Form->input('Video.Video', array(
				'id'=>'video_type',
				'class' => 'form-control',
				'div' => 'col-xs-11',
				'type' => 'select',
				'empty' => 'select video',
			)); ?>

			<div class="col-xs-1 videos-buttons text-right">
				<?php
					print $this->Html->link('<i class="fa fa-eye-slash"></i>', '#', array(
						'class' => 'btn-remove-video',
						'escape' => false
					));
				?>
			</div>

			<div class="form-group-label col-xs-12">
				<span class="video-type-limitation"></span>
			</div>
		</div>
	</div>

	<div class="row videos-upload-row">
		<div class="col-xs-12 text-center">
			<?php 
				print $this->Html->link('<i class="glyphicon glyphicon-plus"></i> '.__('Add video'), '#', array(
					'class' => 'btn btn-primary btn-new-video',
					'escape' => false
				));
			?>
		</div>
	</div>
</div><!-- .form-group -->

<script type="text/javascript" charset="utf-8">
	var article_videos = { count: 0 };

	$(document).ready(function(){
		article_videos.count = $('.videos-upload > .well').length;

		$('.btn-remove-video').on('click', function( e ){
			e.preventDefault();

			article_videos.count--;

			$(this).closest(".well").remove();
		});

		$('.btn-new-video').on('click', function( e ){
			e.preventDefault();

			var url = cakephp.base + '<?php echo $_plugin; ?>/<?php echo $_controller; ?>/add_new_video';

			COMMON.call_ajax({
				type: "POST",
				url: url,
				dataType: 'html',
				cache: false,
				data: {
					count: article_videos.count,
				},
				success: function( result ){
					var counter = (article_videos.count - 1);

					if( counter < 0 ){
						$('.videos-upload > .videos-upload-row').before( result );
					} else {
						$('.videos-upload > .well').eq( counter ).after( result );
					}

					article_videos.count++;

					$('.btn-remove-video').on('click', function( e ){
						e.preventDefault();

						article_videos.count--;

						$(this).closest(".well").remove();
					});
				},
				error: function( result ){
					// console.log('error :');
					// console.log( result );
				}
			});
		});
	});
</script>