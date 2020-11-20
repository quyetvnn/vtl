<div class="col-xs-12">
	<div class="col-xs-4">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">
					<?php if (isset($_data['name_zho'])) echo h($_data['name_zho']); ?>
				</h3>
			</div>

			<div class="box-body">
				<?php if (isset($_data['content_zho'])) echo $_data['content_zho']; ?>
			</div>

			<div class="box-body">
				<?php if (isset($_data['link_zho'])) echo  $this->Html->link($_data['link_zho'],$_data['link_zho']); ?>
			</div>
		</div>
	</div>

	<div class="col-xs-4">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">
					<?php if (isset($_data['name_chi'])) echo h($_data['name_chi']); ?>
				</h3>
			</div>

			<div class="box-body">
				<?php if (isset($_data['content_chi'])) echo $_data['content_chi']; ?>
			</div>

			<div class="box-body">
				<?php if (isset($_data['link_chi'])) echo  $this->Html->link($_data['link_chi'],$_data['link_chi']); ?>
			</div>
		</div>
	</div>

	<div class="col-xs-4">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">
					<?php if (isset($_data['name_eng'])) echo h($_data['name_eng']); ?>
				</h3>
			</div>

			<div class="box-body">
				<?php if (isset($_data['content_eng'])) echo $_data['content_eng']; ?>
			</div>

			<div class="box-body">
				<?php if (isset($_data['link_eng'])) echo  $this->Html->link($_data['link_eng'],$_data['link_eng']); ?>
			</div>
		</div>
	</div>
</div><!-- /#page-container .row-fluid -->


	<?php 
		if( isset($_images) && !empty($_images) ){
			foreach ($_images as $key => $image) {
	?>
				<div class="col-xs-4">
					<div class="box box-primary productbox">
						<div class="box-body text-center">
							<div class="caption">
								<h4><?php echo $image['image_description']; ?></h4>
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

	<div tabindex="-1" class="modal fade image-modal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
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

		<?php 
		if( isset($_videos) && !empty($_videos) ){
			foreach ($_videos as $key => $video) {
	?>
				<div class="col-xs-4">
					<div class="box box-primary productbox">
						<div class="box-body text-center">
							<div class="caption">
								<h4><?php echo $video['name_eng']; ?></h4>
							</div>

							<div class="imgthumb img-responsive">
								<?php 
									echo $this->Html->media(Router::url('/',true).$video['path'],array(
												'class' => 'img-thumbnail img-responsive',
										));
								?>
							</div>
						</div>
					</div>
				</div>
	<?php 
			}
		}
	?>
