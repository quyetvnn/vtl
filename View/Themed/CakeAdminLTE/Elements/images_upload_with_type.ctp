<div class="form-group images-upload">

<?php 
	if( isset($this->request->data[$images_model]) && !empty($this->request->data[$images_model]) ){
		foreach ($this->request->data[$images_model] as $key => $image) :
			if(isset($image['path']) && $image['path']){
?>
			<div class="well well-sm">
				<div class="row images-upload-row">
					<div class="col-xs-4 image-type">
						<h4>
							<?php
								if (isset($image['image_type_id'])) {
									echo isset($imageTypes[$image['image_type_id']]) ? $imageTypes[$image['image_type_id']] : "";
								}
							?>
						</h4>
					</div>

					<div class="col-xs-7 text-right">
						<?php
							print $this->Html->image('../'.$image['path'], array(
								'class' => 'img-thumbnail preview',
							));
						?>
					</div>

					<div class="col-xs-1 images-buttons text-right">
						<?php
							print $this->Html->link('<i class="glyphicon glyphicon-remove"></i>', '#', array(
								'class' => 'btn-remove-uploaded-image',
								'data-image-id' => $image['id'],
								'escape' => false
							));
						?>
					</div>
				</div>
			</div>
<?php
			}
		endforeach;
	}
?>
	<div class="row images-upload-row">
		<div class="col-xs-12 text-center">
			<?php
				print $this->Html->link('<i class="glyphicon glyphicon-plus"></i> '.__('add_image'), '#', array(
					'class' => 'btn btn-primary btn-new-image',
					'escape' => false
				));
			?>
		</div>
	</div>
</div><!-- .form-group -->

<script type="text/javascript" charset="utf-8">
	var article_images = { count: 0 };

	// $(document).on('click', '.btn-remove-image', function(e){	// btn-remove-image not from this file, we should use this method
	// 	e.preventDefault();

	// 	console.log('btn-remove-image click');
	// 	article_images.count = $('.images-upload > .well').length;
	// 	article_images.count--;

	// 	$(this).closest(".well").remove();

	// 	var limit = '',
	// 	if (limit > 0 && article_images.count < limit) {
	// 		$('.btn-new-image').show();
	// 		console.log("btn-remove-image: article_images.count" + article_images.count);
	// 		console.log("btn-remove-image: limit " + limit);
	// 	} 
    // });

	$(document).ready(function(){
		article_images.count = $('.images-upload > .well').length;

		var url = '<?php echo $add_new_images_url; ?>';


		var limit = '<?= isset($limit) ? $limit : 0; ?>';
		if (limit > 0 && article_images.count >= limit) {
			$('.btn-new-image').hide();
		}


		$('.btn-remove-uploaded-image').on('click', function( e ){
			e.preventDefault();
			console.log('btn-remove-uploaded-image click');
			var image_id = $(this).data('image-id');

			var remove_hidden_input = '<input type="hidden" name="data[remove_image][]" value="'+image_id+'">';
			article_images.count = $('.images-upload > .well').length;
			article_images.count--;
			
			$(this).parents('.images-upload').append( remove_hidden_input );
			$(this).closest(".well").remove();

			var limit = '<?= isset($limit) ? $limit : 0 ?>';
			if (limit > 0 && article_images.count < limit) {
				$('.btn-new-image').show();
				console.log("btn-remove-uploaded-image: article_images.count" + article_images.count);
				console.log("btn-remove-uploaded-image: limit " + limit);
			}
		});

		$('.btn-new-image').on('click', function( e ){
			e.preventDefault();
		
			COMMON.call_ajax({
				type: "POST",
				url: url,
				dataType: 'html',
				cache: false,
				data: {
					count: article_images.count,
					images_model: '<?php echo $images_model; ?>',
					base_model: '<?php echo isset($base_model) ? $base_model : ''; ?>',
				},
				success: function( result ){
					var counter = (article_images.count - 1);
					var limit = '<?= isset($limit) ? $limit : 0; ?>';

					if( counter < 0 ){
						$('.images-upload > .images-upload-row').before( result );
					} else {
						$('.images-upload > .well').eq( counter ).after( result );
					}

					article_images.count++;
					if (limit > 0 && article_images.count >= limit) {
						$('.btn-new-image').hide();
					}


					$('.btn-remove-image').on('click', function( e ){		// we cannot trigger the click event on another form but we can trigger on ajax call
						e.preventDefault();

						article_images.count--;
						if (limit > 0 && article_images.count < limit) {
							$('.btn-new-image').show();
						}

						$(this).closest(".well").remove();
					});
				},
				error: function( result ){
					//console.log('error :');
					console.log( result );
				}
			});
		});
	});
</script>