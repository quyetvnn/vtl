<div class="form-group images-upload">

	<div class="well well-sm">
		<div class="row images-upload-row">
			<div class="col-xs-11">
				<label><?=__("file")?></label><br>
				<button type="button" class="btn btn-primary" id="trigger_file"><?=__d('member', 'choose_file')?></button>
				<span id="selected_file_name"><?=__d('member', 'no_file_choosen')?></span>
			</div>
			
			<?php 
				echo $this->Form->input('..file', array(
					'div' => 'col-xs-11',
					'type' => 'file',
					'accept' => '.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel',
					// 'accept' => "file/*",
					'label' => '',
					'class' => ' hidden ',
					'id' => 'file_element'
				));
			?>

			<div class="form-group-label col-xs-12">
				<span class="image-type-limitation"></span>
			</div>
		</div>
	</div>
	
</div><!-- .form-group -->

<script type="text/javascript" charset="utf-8">
	var article_images = { count: 0 };
	max_image =  '<?= isset($total_image) && !empty($total_image) && $total_image > 1 ?  $total_image - 1 : 0 ?>';

	$(document).ready(function(){
		article_images.count = $('.images-upload > .well').length;

	});
	$(document).on("change", "#file_element", function(){
		var input = $(this)[0];
       	$("#selected_file_name").html(input.files[0]['name']);
	})
	$(document).on("click", "#trigger_file", function(){
		$("#file_element").click();
	})
</script>