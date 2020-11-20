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
					}else{
						$id = array(
							'type' => 'hidden',
							'value' => '',
						);
						$alisa = array(
							'type' => 'hidden',
							'value' => $language['alias'],
						);
						$name = $description = array(
							'class' => 'form-control',
							'div' => 'col-xs-5',
							'value' => '',
						);
					}
				
					echo $this->Form->input($_model.'.'.$key.'.id', $id);
					
					echo $this->Form->input($_model.'.'.$key.'.alias', $alisa);

					echo $this->Form->input($_model.'.'.$key.'.name', $name);

					echo $this->Form->input($_model.'.'.$key.'.description', $description);

				?>
			</div>
		</div>
	</div><!-- .form-group -->	
<?php endforeach ?>


<?php endif; ?>
