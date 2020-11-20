
<div class="form-group  member-resume-teacher-experience" >

<?php 
	if (isset($this->request->data['MemberResumeDetail']) && !empty($this->request->data['MemberResumeDetail'])) {
		foreach ($this->request->data['MemberResumeDetail'] as $key => $value) :
			if ($value['type'] == $type) {
?>
			<div class="well well-sm">
				<div class="row member-resume-education-row">
			
					<div class="col-md-6" >
						<div class="form-group">
							<?php echo $this->Form->input($obj_resume .  'Description..description', array(
								'class' => 'form-control', 
								'required' => 'required',
								'value'		=> isset($value['description']) ? $value['description'] : '',
								'label' 	=>  '<font class="text-red"> * </font>' . __d('member', "teacher_experience_name") )); ?>
						</div><!-- .form-group -->
					</div>

					<div class="col-md-6" >
						<div class="form-group">
							<?php echo $this->Form->input($obj_resume . 'Year..years', array(
								'class' => 'form-control teacher_experience_years', 
								'required' => 'required',
								'value'		=> isset($value['years']) ? $value['years'] : '',
								'label' 	=>  '<font class="text-red"> * </font>' . __d('member', "teacher_experience") )); ?>
						</div><!-- .form-group -->
					</div>

					<div class="col-md-6 text-right" >
						<?php
							
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


			<div class="col-md-6" >
				<div class="form-group">
					<?php echo $this->Form->input($obj_resume .  'Description..description', array(
						'class' => 'form-control', 
						'required' => 'required',
						'value'		=> isset($value['description']) ? $value['description'] : '',
						'label' 	=>   '<font class="text-red"> * </font>' . __d('member', "teacher_experience_name") )); ?>
				</div><!-- .form-group -->
			</div>
		
			<div class="col-md-6" >
				<div class="form-group">
					<?php 
						echo $this->Form->input($obj_resume . 'Year..years', array(
							'class' => 'form-control teacher_experience_years', 
							'required' => 'required',
							'label' 	=>  '<font class="text-red"> * </font>' . __d('member', "teacher_experience") )); 
					?>
				</div><!-- .form-group -->	
			</div> 


			<div class="col-md-6  text-right">
				<?php

	
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

</div><!-- .form-group -->

<script type="text/javascript" charset="utf-8">
	var section_type_teacher_experience = { count: 0 };

	$(document).ready(function(){
		section_type_teacher_experience.count 	= $('.member-resume-teacher-experience > .well').length;
	
		$('.btn-remove-teacher-experience').on('click', function( e ){
			e.preventDefault();
			section_type_teacher_experience.count--;
			$(this).closest(".well").remove();
		});

		$('.btn-remove-resume-teacher-experience').on('click', function( e ){
            e.preventDefault();

			var id = $(this).data('data');
			var remove_hidden_input = '<input type="hidden" name="data[remove_MemberTeacherExperience][]" value="' + id + '">';
			section_type_teacher_experience.count--;

			$(this).parents('.member-resume-teacher-experience').append(remove_hidden_input);
			$(this).closest(".well").remove();
		});
		
		$('.btn-add-teacher-experience').on('click', function(e) {
			e.preventDefault();

			var url 			= '<?php echo $member_resume_url; ?>';
			var obj_resume 		= '<?php echo $obj_resume; ?>';
			var type 			= '<?php echo $type; ?>';
			var btn_name 		= '<?php echo $btn_add_name; ?>';

			var sections 		= section_type_teacher_experience;

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
						$('.member-resume-teacher-experience > .member-resume-education-row').before( result );

					} else {
						$('.member-resume-teacher-experience > .well').eq( counter ).after( result );
					}

					sections.count++;

					$('.btn-remove-teacher-experience').on('click', function( e ){
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