<div class="form-group">
	<?php
		echo $this->Form->input('brand_id', array(
			'id' => 'brand_id',
			'class' => 'form-control',
			'empty' => __("請選擇"),
			'label' => '品牌'
		));
	?>
</div><!-- .form-group -->

<div class="form-group">
	<?php
		echo $this->Form->input('shop_id', array(
			'id' => 'shop_id',
			'class' => 'form-control',
			'empty' => __("請選擇"),
			'options' => array(),
			'label' => '店舖'
		));
	?>
</div><!-- .form-group -->	


<script type="text/javascript">
	$(function (){
		var $brand_id = $('#brand_id');
		$brand_id.on('change', function(){

			var brand_id = $(this).val();

			var getShopListUrl = '<?php echo Router::url(array('plugin'=>'company','controller'=>'shops','action'=>'get_shop_list','api' => true, 'ext' => 'json'),true); ?>';

            COMMON.call_ajax({ 
	            url : getShopListUrl,  
	            type : "POST",  
	            data : { 
	            	'brand_id' : brand_id
	            },    
	            success : function( data ){ 
	            	// alert(data['message']);  
	            	var params = data['params'];
	            	var options = '';
	            	$.each(params, function(k,v){
	            		options += '<option value="'+ k +'" > '+ v +' </option>';
	            	});
	            	if (options) {
	            		$('#shop_id').html(options);
	            	}else{
	            		$('#shop_id').html('<option value="">no shop</option>');
	            	}
	            },
	            error : function ( data ){
	            	alert(data['message']);
	            }
            });

		});
	});
</script>