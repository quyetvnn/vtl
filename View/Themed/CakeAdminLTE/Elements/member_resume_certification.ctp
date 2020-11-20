
<div class="form-group  member-resume-certification" >

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
								'label' 	=> __d('member', "certification_name") )); ?>
						</div><!-- .form-group -->
					</div>

					<div class="col-md-5" >
						<div class="form-group">
							<?php echo $this->Form->input($obj_resume . 'Year..years', array(
								'class' => 'form-control', 
								'required' => 'required',
								'value'		=> isset($value['years']) ? $value['years'] : '',
								'label' 	=>  __d('member', "years") )); ?>
						</div><!-- .form-group -->
					</div>

					<div class="col-md-1 images-buttons text-right" >
						<?php
							echo $this->Html->link('<i class="glyphicon glyphicon-remove"></i>', '#', array(
								'class' => 'btn-remove-resume-certification',
								'data-resume-certification' => $value['id'],
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
		
			<div class="col-md-6" >
				<div class="form-group">
					<?php echo $this->Form->input($obj_resume . 'Description..description', array(
						'class' => 'form-control', 
						'label' 	=> __d('member', "certification_name") )); ?>
				</div><!-- .form-group -->
			</div> <!-- div 2 -->

			<div class="col-md-5" >
				<div class="form-group">
					<?php 
						echo $this->Form->input($obj_resume . 'Year..years', array(
							'class' => 'form-control teacher_experience_years', 
							'label' 	=> __d('member', "years") )); 
					?>
				</div><!-- .form-group -->	
			</div> <!-- div 3 -->

			<div class="col-md-1  images-buttons text-right">
				<?php

					echo $this->Html->link('<i class="glyphicon glyphicon-remove"></i>', '#', array(
						'class' => 'btn-remove-certification',
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
					'class' => 'btn btn-primary btn-add-certification',
					'escape' => false
				));
			?>
		</div>
	</div> <!-- row -->
</div><!-- .form-group -->

<script type="text/javascript" charset="utf-8">
	var section_type_certification = { count: 0 };

	$(document).ready(function(){
		section_type_certification.count 	= $('.member-resume-certification > .well').length;
		$('.btn-remove-certification').on('click', function( e ){
			e.preventDefault();
			section_type_certification.count--;
			$(this).closest(".well").remove();
		});

		$('.btn-remove-resume-certification').on('click', function( e ){
            e.preventDefault();  
			var id = $(this).data('data-resume-certification-id');
			var remove_hidden_input = '<input type="hidden" name="data[remove_award][]" value="' + id + '">';
			section_type_certification.count--;

			$(this).parents('.member-resume-certification').append(remove_hidden_input);
			$(this).closest(".well").remove();
		});
		
		$('.btn-add-certification').on('click', function(e) {
			e.preventDefault();

			var url 			= '<?php echo $member_resume_url; ?>';
			var obj_resume 		= '<?php echo $obj_resume; ?>';
			var type 			= '<?php echo $type; ?>';
			var btn_name 		= '<?php echo $btn_add_name; ?>';

			var sections 		= section_type_certification;

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
						$('.member-resume-certification > .member-resume-education-row').before( result );

					} else {
						$('.member-resume-certification > .well').eq( counter ).after( result );
					}

					sections.count++;

					$('.btn-remove-certification').on('click', function( e ){
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