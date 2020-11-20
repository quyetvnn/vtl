<div class="form-group  member-resume-education" >

<?php 
	if (isset($this->request->data['MemberResumeDetail']) && !empty($this->request->data['MemberResumeDetail'])) {
		foreach ($this->request->data['MemberResumeDetail'] as $key => $value) :
			if ($value['type'] == $type) {
			
?>
			<div class="well well-sm">
				<div class="row member-resume-education-row">

					<div class="col-md-4">
						<div class="form-group">
							<?php echo $this->Form->input($obj_resume . 'School..school', array(
								'class' => 'form-control', 
								'value'		=> isset($value['school']) ? $value['school'] : '',
								'label' 	=> __d('member', "school") )); ?>
						</div><!-- .form-group -->
					</div>

					<div class="col-md-4" >
						<div class="form-group">
							<?php echo $this->Form->input($obj_resume .  'Description..description', array(
								'class' => 'form-control', 
								'value'		=> isset($value['description']) ? $value['description'] : '',
								'label' 	=>  __d('member', "description") )); ?>
						</div><!-- .form-group -->
					</div>

					<div class="col-md-3" >
						<div class="form-group">
							<?php echo $this->Form->input($obj_resume . 'Year..years', array(
								'class' => 'form-control', 
								'value'		=> isset($value['years']) ? $value['years'] : '',
								'label' 	=>  __d('member', "xue_wei") )); ?>
						</div><!-- .form-group -->
					</div>

					<div class="col-md-1 images-buttons text-right" >
						<?php
							echo $this->Html->link('<i class="glyphicon glyphicon-remove"></i>', '#', array(
								'class' => 'btn-remove-resume-education',
								'data-resume-education-id' => $value['id'],
								'escape' => false
							));
						?>			
					</div>

				</div>
			</div>
<?php
			}
		endforeach;
	}
?>
	
<?php if (strpos($this->request->params['action'], 'edit') === false): 	// add	?>
	<div class="well well-sm">
		<div class="row member-resume-education-row">	

			<div class="col-md-4" >
				<div class="form-group">
					<?php echo $this->Form->input($obj_resume . 'School..school', array(
						'class' 	=> 'form-control', 
						'label' 	=>  __d('member', "school") )); ?>
				</div><!-- .form-group -->
			</div> <!-- div 1 -->

			<div class="col-md-4" >
				<div class="form-group">
					<?php echo $this->Form->input($obj_resume . 'Description..description', array(
						'class' => 'form-control', 
						'label' 	=>  __d('member', "xue_wei") )); ?>
				</div><!-- .form-group -->
			</div> <!-- div 2 -->

			<div class="col-md-3" >
				<div class="form-group">
					<?php 
						echo $this->Form->input($obj_resume . 'Year..years', array(
							'class' => 'form-control', 
							'label' 	=>  __d('member', "years") )); 
					?>
				</div><!-- .form-group -->	
			</div> <!-- div 3 -->

			<div class="col-md-1 images-buttons text-right">
				<?php

					echo $this->Html->link('<i class="glyphicon glyphicon-remove"></i>', '#', array(
						'class' => 'btn-remove-education',
						'escape' => false
					));
				?>
			</div>
		</div>

		<div class="row">
			<div class="form-group-label col-xs-12">
				<span class="image-type-limitation"></span>
			</div>
		</div>
	</div>
<?php endif ?>

	<div class="row member-resume-education-row">
		<div class="col-xs-12 text-center">
			<?php
			
				print $this->Html->link('<i class="glyphicon glyphicon-plus"></i> '. $btn_add_name, '#', array(
					'class' => 'btn btn-primary btn-add-education',
					'escape' => false
				));
			?>
		</div>
	</div> <!-- row -->
</div><!-- .form-group -->

<script type="text/javascript" charset="utf-8">
	var section_type_education  	 	= { count: 0 };

	$(document).ready(function(){
		section_type_education.count 			= $('.member-resume-education > .well').length;


		$('.btn-remove-education').on('click', function( e ){
			e.preventDefault();

			section_type_education.count--;
			$(this).closest(".well").remove();
		});

		$('.btn-remove-resume-education').on('click', function( e ){

			e.preventDefault();

			var id = $(this).data('data-resume-education-id');
			var remove_hidden_input = '<input type="hidden" name="data[remove_education][]" value="' + id + '">';
			section_type_education.count--;

			$(this).parents('.member-resume-education').append(remove_hidden_input);
			$(this).closest(".well").remove();
		});
		

		$('.btn-add-education').on('click', function(e) {
			e.preventDefault();

			var url 			= '<?php echo $member_resume_url; ?>';
			var obj_resume 		= '<?php echo $obj_resume; ?>';
			var type 			= '<?php echo $type; ?>';
			var btn_name 		= '<?php echo $btn_add_name; ?>';

			var sections 		= section_type_education;

			COMMON.call_ajax({
				type: "POST",
				url: url,
				dataType: 'html',
				cache: false,
				data: {
					count: 			sections.count,
					obj_resume: 	obj_resume,
					type:			type,
					btn_add_name:	btn_name,
				},
				success: function(result) {

					var counter = (sections.count - 1);

					if( counter < 0 ){
						$('.member-resume-education > .member-resume-education-row').before( result );

					} else {
						$('.member-resume-education > .well').eq( counter ).after( result );
					}

					sections.count++;

					$('.btn-remove-education').on('click', function( e ){
						e.preventDefault();
						sections.count--;
						$(this).closest(".well").remove();
					});
				},
				error: function(result) {
					console.log(result);
				}
			});
		});
	});
</script>