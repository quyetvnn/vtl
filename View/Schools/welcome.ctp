<?= $this->element('menu/top_menu') ?>
<div class="container-fluid welcome-page full-height p-0">
	<div class="row m-0 " >
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-9 main-content-welcome">
							<h3 class="why-choose text-blacl-olive">	
								<?=__d('member', 'why_choose')?>
								<?php echo $this->Html->image('logo-oneline.png', ['alt' => '', 'height'=>'44px'])?>
							</h3>

              <?=$this->element('body/why_choose_us_'.$this->Session->read('Config.language'))?>
							<div class="flex-center flex-self-end">
								<?php if(!isset($current_user['token'])){ ?>
									<button class="btn btn-w-radius btn-green self-center" onclick="SCHOOL_WELCOME.apply_now()">
										<?=__d('member', 'apply_now')?>
									</button>
								<?php }else{ ?>
									<button class="btn btn-w-radius btn-green btn-min-width-210 self-center" data-toggle="modal" data-target="#modal-school-application" data-backdrop="static" >
										<?=__d('member', 'apply_now')?>
									</button>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal a4l-modal fade" id="modal-school-application" tabindex="-1" role="dialog" aria-labelledby="modal-school-application-label">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <form class="modal-login" id="frm-crt-school" onsubmit="SCHOOL_WELCOME.create_school(event)">
        <div class="modal-body teacher-create-lesson">
        	<h4 class="modal-title modal-title-default text-dark-liver" id="modal-school-application-label"><?=__d('member', 'create_school')?></h4>
            <div class="row m-0 grp_school_name">
               <div class="col-md-12 p-0 form-group input-w-icon-t m-0">
                  <input type="text" class="form-control a4l-input"  required name="school_name" id="school_name" placeholder="<?=__d('member', 'organization_school_name')?>" />
                  <span class="icon icon-organization-green"></span>
              </div>
              <p class="text-red error-msg"></p>
            </div>
            <div class="row m-0 grp_school_code">
               <div class="col-md-12 p-0 form-group input-w-icon-t m-0">
                  <input type="text" class="form-control a4l-input" required name="school_code" id="school_code" placeholder="<?=__d('member', 'organization_school_code')?> (<?=__d('member', 'organization_school_code_placeholder')?>)" />
                  <span class="icon icon-organization-green"></span>
              </div>
              <p class="text-red error-msg"></p>
            </div>
            <div class="row">
              <div class="col-md-4 form-group input-w-icon-t m-0">
                <select class="form-control a4l-input m-0" required id="school_title" name="school_title"  placeholder="<?=__d('member', 'title')?>">
                  <option value="mr"><?=__d('member', 'mr')?></option>
                  <option value="mrs"><?=__d('member', 'mrs')?></option>
                  <option value="ms"><?=__d('member', 'ms')?></option>
                </select>
                <span class="icon left-20 icon-user-green"></span>
              </div>
              <div class="col-md-8 form-group grp_contact_person">
                <input type="text" class="form-control a4l-input m-0" required name="school_contact_person" id="school_contact_person" placeholder="<?=__d('member', 'contact_person')?>"/>
                <p class="text-red error-msg"></p>
              </div>
            </div>
            <div class="row grp_phone_number">
              <div class="col-md-12 form-group input-w-icon-t m-0 ">
                <input type="text" class="form-control a4l-input m-0" id="school_phone_number" name="school_phone_number" placeholder="<?=__d('member', 'contact_no')?>"/>
                <span class="icon left-20 icon-mobile-green"></span>
              </div>
              <p class="text-red error-msg"></p>
            </div>
            <div class="row m-0 grp_email">
               <div class="col-md-12 p-0 form-group input-w-icon-t m-0">
                  <input type="text" class="form-control a4l-input" required id="school_email" name="school_email" placeholder="<?=__d('member', 'email')?>" />
                  <span class="icon icon-envelope-o-green-light"></span>
              </div>
              <p class="text-red error-msg"></p>
            </div>

            <div class="row m-0 grp_address">
              <div class="col-md-12 p-0 form-group input-w-icon-t m-0 textarea-w-icon-t">
                  <textarea class="form-control a4l-input" name="school_address" placeholder="<?=__d('member', 'address')?>" id="school_address" rows="3"></textarea>
                  <span class="icon icon-address-green"></span>
              </div>
              <p class="text-red error-msg"></p>
            </div>
            <div class="row mbt-30 grb-dropfile">
              <div class="row m-0">
                <div class="col-md-6 p-0 text-grey-light">
                  <?=__d('member', 'business_registration_proof')?>
                </div>
                <div class="col-md-6 p-0 text-right text-grey">
                   pdf, jpg, jpeg, png
                </div>
              </div>
              <div class="row m-0">
                <div class="col-md-12 p-0 import-file-area pointer">
                  <p class="text-grey-light"><span class="fa fa-cloud-upload"></span><?=__d('member', 'upload_file_or_drag_it_here')?></p>
                  <p class="text-grey-light">(<?=sprintf( __d('member', 'upload_max_size_file'), '15MB')?>)</p>
                </div>
                <input type="file" class="hidden" id="upload-material" accept=".pdf, .jpg, .jpeg, .png" multiple/>
                <div class="col-md-12 p-0 ">
                  <ul class="lst-imported-file" id="lst-imported-material"></ul>
                </div>
              </div>
              <p class="text-red error-msg"></p>
            </div>
            <div class="row m-0 grp_error text-center">
                <p class="text-red error-msg"></p>
            </div>
        </div>
        <div class="modal-footer flex-center">
            <button class="btn btn-w-radius btn-green btn-min-width-210" id="submit-create-school" type="submit" disabled><?=__d('member', 'submit')?></button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
	echo $this->Html->script('pages/school/school_welcome.js?v='.date('U'));
?>
<script type="text/javascript">
	$(document).ready(function() {
		SCHOOL_WELCOME.init_page();
	});
</script>