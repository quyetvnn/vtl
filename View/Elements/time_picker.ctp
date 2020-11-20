<div class="form-group">
    <?php

    	$label = isset($label) ? $label : $field_name;
    	if ($label) {
	    	echo $this->Form->label($label);
    	}
    	if (!isset($placeholder)) {
    		$placeholder = '';
        }
        $id = isset($id) ? $id : $field_name;
    ?>
    <div class="input-group">
		<span class="input-group-addon" ><i class="fa fa-calendar"></i></span>
        <?php
            $option = array(
				'id' => $id,
				'class' => 'form-control timepicker' . (isset($class) ? $class : ''),
				'label' => false,
				'placeholder' => $placeholder,
				'type' => 'search',
                'required' => isset($required) ? $required : false
            );

            if(isset($value) && $value){
                $option['value'] = $value;
            }

			echo $this->Form->input($field_name, $option);
		?>
    </div>
    <!-- /.input group -->
</div>

<script type="text/javascript">
	$(function (){
            $('#<?= $id ?>').datetimepicker({
                'showClose' : true,
                'format' : "<?= isset($format) ? $format : 'HH:mm'; ?>",
                'useCurrent': false,
                'date': "<?= isset($value) ? $value : '' ?>",
                'viewDate': "<?=  isset($value) ? $value : '' ?>"
            });
    
	});
</script>