<div class="form-group images-upload">

<?php 
	if( isset($this->request->data[$images_model]) && !empty($this->request->data[$images_model]) ){
		foreach ($this->request->data[$images_model] as $key => $image) :
			if(isset($image['path']) && $image['path']){
?>
			<div class="well well-sm">
				<div class="row images-upload-row">

					<div class="col-xs-3">
						<?php
							print $this->Html->image('../'.$image['path'], array(
								'class' => 'img-thumbnail preview',
							));
						?>
					</div>

					<?php 
						if (!isset($can_remove) || (isset($can_remove) && $can_remove)) { ?>
						<div class="col-xs-9 images-buttons text-right">
							<?php
								print $this->Html->link('<i class="glyphicon glyphicon-remove"></i>', '#', array(
									'class' => 'btn-remove-uploaded-image',
									'data-image-id' => $image['id'],
									'escape' => false
								));
							?>
						</div>
						<?php }
					?>
				</div>
			</div>
<?php
			}
		endforeach;
	}
?>
	
<?php if (strpos($this->request->params['action'], 'edit') === false): ?>
	<div class="well well-sm">
		<div class="row images-upload-row">
			<?php 
				echo $this->Form->input($images_model.'..image', array(
					'div' => 'col-xs-11',
					'type' => 'file',
					'accept' => "image/*",
					'label' => __("image")
				));
			?>

			<div class="col-xs-1 images-buttons text-right">
				<?php
					echo $this->Html->link('<i class="glyphicon glyphicon-remove"></i>', '#', array(
						'class' => 'btn-remove-image',
						'escape' => false
					));
				?>
			</div>

			<div class="form-group-label col-xs-12">
				<span class="image-type-limitation"></span>
			</div>
		</div>
	</div>
<?php endif ?>

<?php 

	if (!isset($can_add) || (isset($can_add) && $can_add)) {   ?>
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
	<?php 
	} 
?>
	
</div><!-- .form-group -->

<script type="text/javascript" charset="utf-8">
	var article_images = { count: 0 };
	max_image =  '<?= isset($total_image) && !empty($total_image) && $total_image > 1 ?  $total_image - 1 : 0 ?>';

	$(document).ready(function(){
		article_images.count = $('.images-upload > .well').length;
		
		$('.btn-remove-image').on('click', function( e ){
			e.preventDefault();

			article_images.count--;
			$('.btn-new-image').show();
			$(this).closest(".well").remove();
		});

		$('.btn-remove-uploaded-image').on('click', function( e ){
			e.preventDefault();

			var image_id = $(this).data('image-id');

			var remove_hidden_input = '<input type="hidden" name="data[remove_image][]" value="'+image_id+'">';

			article_images.count--;
			$('.btn-new-image').show();
			console.log ('add show attribute');
			
			$(this).parents('.images-upload').append( remove_hidden_input );
			$(this).closest(".well").remove();
		});

		$('.btn-new-image').on('click', function( e ){
			e.preventDefault();

			var url = '<?php echo $add_new_images_url; ?>';
			article_images.count = $('.images-upload > .well').length;	// count again
			
			if (max_image > 0 && article_images.count >= max_image) {
				$('.btn-new-image').hide();
				console.log ('add hidden attribute');
			}
		
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

					if( counter < 0 ){
						$('.images-upload > .images-upload-row').before( result );

					} else {
						$('.images-upload > .well').eq( counter ).after( result );
					}

					article_images.count++;

					$('.btn-remove-image').on('click', function(e) {
						e.preventDefault();

						article_images.count--;
						$('.btn-new-image').show();
						$(this).closest(".well").remove();
					});
				},
				error: function(result) {
					console.log(result);
				}
			});
		});
	});
</script>