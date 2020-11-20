	<div class="row">
	<?php 

		if( isset($_images) && !empty($_images) ){
			foreach ($_images as $key => $image) {
	?>
				<div class="col-xs-4">
					<div class="box box-primary productbox">
						<div class="box-body text-center">
							<div class="caption">
								<h4><?= isset($image['name']) ? $image['name'] : '' ?></h4>
							</div>

							<div class="imgthumb img-responsive">
								<?php 
									echo $this->Html->link(
										$this->Html->image(
											'../'.$image['path'], array(
												'class' => 'img-thumbnail preview img-responsive',
											)
										), '#', array(
											'data-toggle' => "modal",
											'data-target' => "#lightbox",
											'escape' => false
										)
									);
								?>
							</div>
						</div>
					</div>
				</div>
	<?php 
			}
		}
	?>
	</div>

	<div tabindex="-1" class="modal fade image-modal" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header show-image-modal-header">
					<button class="close" type="button" data-dismiss="modal">
						<i class="fa fa-remove"></i>
					</button>
					<h3 class="modal-title"></h3>
				</div>

				<div class="modal-body text-center"></div>

				<div class="modal-footer">
					<button class="btn btn-default" data-dismiss="modal"><?php echo __('close'); ?></button>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" charset="utf-8" async defer>
		$(document).ready(function() {
			$('.preview').click(function(){
				$('.modal-body').empty();

			  	var title = $(this).attr("title");

			  	var img = '<img src="'+$(this).attr('src')+'">';
			  	
			  	$('.modal-title').html(title);
			  	$( img ).appendTo('.modal-body');
			  	$('.image-modal').modal({show:true});
			});
		});
	</script>

