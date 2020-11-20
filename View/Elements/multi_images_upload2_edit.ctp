<div class="form-group images-upload">
	<?php 
		if( isset($images) && !empty($images) ){
			foreach ($images as $key => $image) :
	?>

		<div class="well well-sm">
			<div class="row images-upload-row">
				<div class="col-xs-4 image-type">
					<div class="">
						<h4>
							<?php 
								if ( isset($image['ImageType']['slug']) ) {
									echo $image['ImageType']['slug'];
								}
							?>
						</h4>
					</div>
				</div>

				<div class="col-xs-7">
					<?php 
						print $this->Html->image('../'.$image[$_model]['path'], array(
							'class' => 'img-thumbnail preview',
						));
					?>
				</div>

				<div class="col-xs-1 images-buttons text-right">
					<?php
						//print 
						$this->Html->link('<i class="fa fa-eye-slash"></i>', '#', array(
							'class' => 'btn-remove-uploaded-image',
							'data-image-id' => $image[$_model]['id'],
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

	<div class="row images-upload-row">
		<div class="col-xs-12 text-center">
			<?php 
				//print 
				$this->Html->link('<i class="glyphicon glyphicon-plus"></i> '.__('Add Image'), '#', array(
					'class' => 'btn btn-primary btn-new-image',
					'escape' => false
				));
			?>
		</div>
	</div>
</div><!-- .form-group -->

<script type="text/javascript" charset="utf-8">
	var article_images = { count: 0 };

	$(document).ready(function(){
		article_images.count = $('.images-upload > .well').length;

		$('.btn-remove-uploaded-image').on('click', function( e ){
			e.preventDefault();

			var image_id = $(this).data('image-id');

			var remove_hidden_input = '<input type="hidden" name="data[remove_image][]" value="'+image_id+'">';

			article_images.count--;
			
			$(this).parents('.images-upload').append( remove_hidden_input );
			$(this).closest(".well").remove();
		});

		$('.btn-new-image').on('click', function( e ){
			e.preventDefault();

			var url = cakephp.base + '<?php echo $_plugin; ?>/<?php echo $_controller; ?>/add_new_image';

			COMMON.call_ajax({
				type: "POST",
				url: url,
				dataType: 'html',
				cache: false,
				data: {
					count: article_images.count,
				},
				success: function( result ){
					var counter = (article_images.count - 1);

					if( counter < 0 ){
						$('.images-upload > .images-upload-row').before( result );
					} else {
						$('.images-upload > .well').eq( counter ).after( result );
					}

					article_images.count++;
				},
				error: function( result ){
					// console.log('error :');
					// console.log( result );
				}
			});
		});
	});
</script>