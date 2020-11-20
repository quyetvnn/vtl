<div class="form-group videos-upload">
	<?php 
		if( isset($videos) && !empty($videos) ){
			foreach ($videos as $key => $video) :
	?>

		<div class="well well-sm">
			<div class="row videos-upload-row">
				<div class="col-xs-4 video-type">
					<h4 class="">
						<?php echo $video['name_eng']; ?>
					</h4>
				</div>

				<div class="col-xs-7">
					<?php 
						if ($video['type'] == 'link') {
							echo $this->Html->link('http://'.$video['path']);
						}elseif ($video['type'] == 'file') {
							echo $this->Html->media(Router::url('/',true).$video['path'], array(
								'fullBase' => true,
								'type' => 'video',
							));
						}
						echo $this->Form->input('Video.Video.', array(
							'id'=>'video_type',
							'class' => 'form-control',
							'value' => $video['id'],
							// 'div' => 'col-xs-11',
							'type' => 'hidden',
							// 'empty' => 'select video',
						)); 
					?>
				</div>

				<div class="col-xs-1 videos-buttons text-right">
					<?php
						echo $this->Html->link('<i class="fa fa-eye-slash"></i>', '#', array(
							'class' => 'btn-remove-uploaded-video',
							'data-video-id' => $video['id'],
							'escape' => false
						));
					?>
				</div>
			</div>
		</div>

	<?php
			endforeach;
		}
	?>

	<div class="row videos-upload-row">
		<div class="col-xs-12 text-center">
			<?php 
				echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> '.__('Add video'), '#', array(
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

		$('.btn-remove-uploaded-video').on('click', function( e ){
			e.preventDefault();

			var video_id = $(this).data('video-id');

			var remove_hidden_input = '<input type="hidden" name="data[remove_video][]" value="'+video_id+'">';

			article_videos.count--;
			
			$(this).parents('.videos-upload').append( remove_hidden_input );
			$(this).closest(".well").remove();
		});

		$('.btn-new-video').on('click', function( e ){
			e.preventDefault();

			var url = cakephp.base + '<?php echo $_plugin; ?>/<?php echo $_controller; ?>/add_new_video_edit';

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
				},
				error: function( result ){
					// console.log('error :');
					// console.log( result );
				}
			});
		});
	});
</script>