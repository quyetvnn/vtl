<div class="form-group">
	<div class="input select">
		<label for="selectpicker_brand">品牌</label>
		<select 
			name="data[Brand][Brand][]" 
			id="selectpicker_brand" 
			class="form-control selectpicker"
			title="請選擇"
			data-live-search="true"
			data-hide-disabled="true"
			multiple="true"
			data-actions-box="true"
		>
			<?php echo $brands; ?>
		</select>
	</div>
</div>

<div class="form-group">
	<div class="input select">
		<label for="selectpicker_shop">店鋪(如未指定品牌店舖，預設該品牌所有分店適用)</label>
		<select 
			name="data[Shop][Shop][]" 
			id="selectpicker_shop" 
			class="form-control selectpicker"
			title="請選擇"
			data-live-search="true"
			multiple="true"
			data-hide-disabled="true"
			data-actions-box="true"
		>
			<?php echo $shops; ?>
		</select>
	</div>
</div>

<script type="text/javascript">
	$(function (){

		var $selectpicker_brand = $('#selectpicker_brand');
		var $selectpicker_shop = $('#selectpicker_shop');

		//onchange brand
		$selectpicker_brand.on('changed.bs.select', function (e) {
			var $_val = $(this).val();
			change_brands($_val);
		});

		$selectpicker_brand.on('loaded.bs.select', function (e) {
			var $_val = $(this).val();
			change_brands($_val);
		});

		

		function change_brands ($_brand_arr){

			$selectpicker_shop.find('optgroup').attr('disabled','true');
			$selectpicker_shop.find('optgroup option').attr('disabled','true');

			if ($.isArray($_brand_arr)) {
				console.log('is an array');

				$selectpicker_shop.removeAttr('disabled');

				$.each($_brand_arr, function (k,v){
					console.log(v);
					$selectpicker_shop.find('optgroup[brand-id='+ v +']').removeAttr('disabled');
					$selectpicker_shop.find('optgroup[brand-id='+ v +'] option').removeAttr('disabled');
				});
			}else{
				console.log('is not an array');
				$selectpicker_shop.attr('disabled','true');
			}

			$selectpicker_shop.selectpicker('refresh');
		}

	});
</script>