<div class="form-group images-upload">

    <?php 
        if( isset($this->request->data[$images_model]) && !empty($this->request->data[$images_model]) ){
            foreach ($this->request->data[$images_model] as $key => $image) :
                if(isset($image['path']) && $image['path']){
    ?>
                <div class="well well-sm">
                    <div class="row images-upload-row">

                        <div class="col-xs-7">
                            <?php
                                print $this->Html->image('../'.$image['path'], array(
                                    'class' => 'img-thumbnail preview',
                                ));
                            ?>
                        </div>

                        <div class="col-xs-1 images-buttons text-right">
                            <?php
                                print $this->Html->link('<i class="glyphicon glyphicon-remove"></i>', '#', array(
                                    'class' => 'btn-remove-uploaded-image',
                                    'data-image-id' => $image['id'],
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
        
    <?php if (strpos($this->request->params['action'], 'edit') != 0): ?>

        <div class="well well-sm">
            <div class="row images-upload-row">
                <?php 
                    echo $this->Form->input($images_model.'..image', array(
                        'div'    => 'col-xs-7',
                        'type'   => 'file',
                        'accept' => "image/*",
                        'label'  => $label, 
                        'id'     => 'image_id',
                        'required' => $required,
                    ));
                ?>

                <div class="form-group-label col-xs-12">
                    <span class="image-type-limitation"></span>
                </div>
            </div>
        </div>

       
    <?php endif ?>

</div><!-- .form-group -->

<div class="row">
    <div class="col-sm-12">
        <img id="display-image" class="img-responsive"/>
    </div>
</div>

<script type="text/javascript" charset="utf-8">
	var article_images = { count: 0 };

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#display-image').attr('src', e.target.result);
                $('#display-image').css({'width': '100%'});
                $('#display-image').css({'alt': 'image'});
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

	$(document).ready(function(){
		article_images.count = $('.images-upload > .well').length;

        // display image
        $('#image_id').change(function(){
            readURL(this);
        });

		$('.btn-remove-uploaded-image').on('click', function( e ){
			e.preventDefault();

			var image_id = $(this).data('image-id');

			var remove_hidden_input = '<input type="hidden" name="data[remove_image][]" value="'+image_id+'">';

			article_images.count--;
			
			$(this).parents('.images-upload').append( remove_hidden_input );
			$(this).closest(".well").remove();
		});
	});
</script>