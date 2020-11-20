<?php 
	if ( (isset($languages_list) && !empty($languages_list)) ):

	if ($_model_languages) {
		$_model_languages = Hash::combine($_model_languages,'{n}.alias','{n}');
	}	
 ?>

<?php foreach ($languages_list as $key => $language): ?>
	<div class="form-group ">
		<div class="well well-sm">
			<div class="row ">
				<div class="col-xs-2">
					<h3><?php echo $language['alias']; ?></h3>
				</div>
				<?php 

					if (isset($_model_languages[$language['alias']])) {
						$id = array(
							'type' => 'hidden',
							'value' => $_model_languages[$language['alias']]['id'],
						);
						$alisa = array(
							'type' => 'hidden',
							'value' => $_model_languages[$language['alias']]['alias'],
						);
						$name = array(
							'class' => 'form-control',
							'div' => 'col-xs-5',
							'value' => $_model_languages[$language['alias']]['name'],
						);
						$description = array(
							'class' => 'form-control',
							'div' => 'col-xs-5',
							'value' => $_model_languages[$language['alias']]['description'],
						);

						$address = array(
							'class' => 'form-control',
							'div' => 'col-xs-5 col-xs-offset-2',
							'value' => $_model_languages[$language['alias']]['address'],
						);
						$contact = array(
							'class' => 'form-control',
							'div' => 'col-xs-5',
							'value' => $_model_languages[$language['alias']]['contact'],
						);
						$opening = array(
							'class' => 'form-control',
							'div' => 'col-xs-5 col-xs-offset-2',
							'value' => $_model_languages[$language['alias']]['opening'],
						);

						$promotion_title = array(
							'class' => 'form-control',
							'div' => 'col-xs-5',
							'value' => $_model_languages[$language['alias']]['promotion_title'],
							'type' => 'textarea',
						);
						$promotion_url = array(
							'class' => 'form-control',
							'div' => 'col-xs-5 col-xs-offset-2',
							'value' => $_model_languages[$language['alias']]['promotion_url'],
							'type' => 'textarea',
						);
						
					}else{
						$id = array(
							'type' => 'hidden',
							'value' => '',
						);
						$alisa = array(
							'type' => 'hidden',
							'value' => $language['alias'],
						);
						$name = $description  = $contact =array(
							'class' => 'form-control',
							'div' => 'col-xs-5 ',
							'value' => '',
						); 
						$address = $opening = array(
							'class' => 'form-control',
							'div' => 'col-xs-5 col-xs-offset-2',
							'value' => '',
						); 
						$promotion_title =  array(
							'class' => 'form-control',
							'type' => 'textarea',
							'div' => 'col-xs-5',
						);

						$promotion_url = array(
							'class' => 'form-control',
							'type' => 'textarea',
							'div' => 'col-xs-5 col-xs-offset-2',
						);
						
					}
				
					echo $this->Form->input($_model.'.'.$key.'.id', $id);
					
					echo $this->Form->input($_model.'.'.$key.'.alias', $alisa);

					echo $this->Form->input($_model.'.'.$key.'.name', $name);

					echo $this->Form->input($_model.'.'.$key.'.description', $description);

					echo $this->Form->input($_model.'.'.$key.'.address', $address );
					echo $this->Form->input($_model.'.'.$key.'.contact', $contact );
					echo $this->Form->input($_model.'.'.$key.'.opening', $opening );
					echo $this->Form->input($_model.'.'.$key.'.promotion_title', $promotion_title );
					echo $this->Form->input($_model.'.'.$key.'.promotion_url', $promotion_url );


				?>
			</div>
		</div>
	</div><!-- .form-group -->	
<?php endforeach ?>


<?php endif; ?>
