<div class="well well-sm">
	<div class="row images-upload-row">
		<?php 
			echo $this->Form->input($images_model.'..image_type_id', array(
				'class' => 'form-control image-type',
				'div' => 'col-xs-4',
                'empty' => __("please_select"),
                'label' => __("image_type"),
			));

			echo $this->Form->input($images_model.'..image', array(
				'div' => 'col-xs-7',
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
