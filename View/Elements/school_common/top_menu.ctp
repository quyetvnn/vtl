<?php
	echo $this->Html->script('pages/school/common.js?v='.date('U'));
?>
<script type="text/javascript">
	$(document).ready(function() {
		SCHOOL_COMMON.init_page('<?=$school_detail["id"]?>');
	});
</script>
<?php
	if(empty($school_detail['banner'])){
    	$avatar_random = array(1, 2, 3, 4);

    	$school_detail['banner'] = Router::url('/', true).'img/school-page/cover-1.jpg';

    }
?>
<div class="container-fluid school-landing-page school-banner height-30 p-0 bg-full" style="background-image: url(<?=$school_detail['banner']?>); ">
	<div class="update-banner">
		<button class="btn btn-white" id="trigger_update_banner">
			<?=__d('member', 'change_cover_photo')?>
		</button>
		<input type="file" class="hidden" name="update_banner" id="update_banner" accept=".jpg, .jpeg, .png, .gif">
	</div>
</div>
<?php
   if(isset($school_detail) && !empty($school_detail) && $allow_edit_school_info){
?>
<div class="modal a4l-modal fade" id="modal-school-edit" tabindex="-1" role="dialog" aria-labelledby="modal-school-application-label">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form class="modal-login" id="frm-edit-school" onsubmit="SCHOOL_LANDING.edit_school(event)">
        <h4 class="modal-title text-center text-green" id="modal-school-application-label"><?=__d('member', 'school_information')?></h4>
        <div class="modal-body teacher-create-lesson">
            <div class="row m-0 grp_about_us">
               <div class="col-md-12 p-0 form-group input-w-icon-t m-0 textarea-w-icon-t">
                  <textarea class="form-control a4l-input required" placeholder="<?=__d('member', 'school_profile')?>" id="school_about" rows="5"><?=(isset($school_detail['about_us']) && !empty($school_detail['about_us']))?trim($school_detail['about_us']):''?></textarea>
                  <span class="icon icon-organization-green"></span>
              </div>
              <p class="text-red error-msg"></p>
            </div>
            
            <div class="row grp_phone_number">
              <div class="col-md-12 form-group input-w-icon-t m-0 ">
                <input type="text" class="form-control a4l-input m-0" id="school_phone_number" placeholder="<?=__d('member', 'contact_no')?>" 
                        value="<?=(isset($school_detail['phone_number']) && !empty($school_detail['phone_number']))?$school_detail['phone_number']:''?>"/>
                <span class="icon left-20 icon-mobile-green"></span>
              </div>
              <p class="text-red error-msg"></p>
            </div>
            <div class="row m-0 grp_email">
               <div class="col-md-12 p-0 form-group input-w-icon-t m-0">
                  <input type="text" class="form-control a4l-input required" id="school_email" placeholder="<?=__d('member', 'email')?>" 
                        value="<?=(isset($school_detail['email']) && !empty($school_detail['email']))?$school_detail['email']:''?>" />
                  <span class="icon icon-envelope-o-green-light"></span>
              </div>
              <p class="text-red error-msg"></p>
            </div>
            <div class="row m-0 grp_address">
				<div class="col-md-12 p-0 form-group input-w-icon-t m-0 textarea-w-icon-t">
					<textarea class="form-control a4l-input" placeholder="<?=__d('member', 'address')?>" id="school_address" rows="3"><?=(isset($school_detail['address']) && !empty($school_detail['address']))?trim($school_detail['address']):''?></textarea>
					<span class="icon icon-address-green"></span>
				</div>
              	<p class="text-red error-msg"></p>
            </div>
            <div class="row m-0 grp_error text-center">
                <p class="text-red error-msg"></p>
            </div>
        </div>
        <div class="modal-footer flex-center">
            <button class="btn btn-w-radius btn-green btn-min-width-210" id="submit-edit-school" type="submit"><?=__d('member', 'save')?></button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php } ?>