<?php 
	if (empty($_controller) || empty($_model) ) {
		echo '_controller, _model is empty';
	}
 ?>
<div class="form-group images-upload">
	<div class="well well-sm">
		<div class="row images-upload-row">
			<?php 
				echo $this->Form->input($_model.'..image', array(
					'div' => 'col-xs-4',
					'type' => 'file',
					'accept' => "image/*",
				));

				echo $this->Form->input($_model.'..image_description', array(
					'class' => 'form-control',
					'div' => 'col-xs-7',
				));
			?>

			<div class="col-xs-1 images-buttons text-right">
				<?php
					print $this->Html->link('<i class="fa fa-eye-slash"></i>', '#', array(
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

	<div class="row images-upload-row">
		<div class="col-xs-12 text-center">
			<?php 
				print $this->Html->link('<i class="glyphicon glyphicon-plus"></i> '.__('Add Image'), '#', array(
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

		$('.btn-remove-image').on('click', function( e ){
			e.preventDefault();

			article_images.count--;

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

					$('.btn-remove-image').on('click', function( e ){
						e.preventDefault();

						article_images.count--;

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