<div class="form-group">
	<?php echo $this->Form->label($field_name); ?>
    <div class="input-group ico_bg_color" style="width: 30%;">
		<?php echo $this->Form->input($field_name, array(
			'label' => $field_name,
			'class' => 'form-control',
			'label' => false,
			'type' => 'text',
		)); ?>
		<div class="input-group-addon">
        	<i></i>
        </div>
	</div>
</div><!-- .form-group -->

<?php 
	echo $this->Html->css('bootstrap-colorpicker.min');
	echo $this->Html->script('bootstrap-colorpicker.min');
 ?>

<script type="text/javascript">
	$('.ico_bg_color').colorpicker({
		format:'hex'
	});
</script>