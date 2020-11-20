<?php 
	if ( (isset($languages) && !empty($languages)) && (isset($all_languages) && !empty($all_languages)) ):
 ?>

<?php foreach ($all_languages as $key => $all_language): ?>
	<div class="form-group ">
		<div class="well well-sm">
			<div class="row ">
				<div class="col-xs-2">
					<h3><?php echo $all_language['alias']; ?></h3>
				</div>
				<?php 
				
					echo $this->Form->input($_model.'.'.$key.'.id', array(
						'type' => 'hidden',
					));

					if (isset($languages[$key]['alias'])) {
						$alisa = array(
							'type' => 'hidden',
						);
					}else{
						$alisa = array(
							'type' => 'hidden',
							'value' => $all_language['alias'],
						);
					}
					echo $this->Form->input($_model.'.'.$key.'.alias', $alisa);

					echo $this->Form->input($_model.'.'.$key.'.name', array(
						'class' => 'form-control',
						'div' => 'col-xs-5',
					));

					echo $this->Form->input($_model.'.'.$key.'.description', array(
						'class' => 'form-control',
						'div' => 'col-xs-5',
					));

				?>
			</div>
		</div>
	</div><!-- .form-group -->	
<?php endforeach ?>


<?php endif; ?>
