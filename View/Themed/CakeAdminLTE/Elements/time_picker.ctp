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
				'type' => 'text',
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
                'pickDate': false,
                'defaultDate': "<?= isset($value) ? $value : '' ?>",
                'format': 'HH:mm',
            });
    
	});
</script>