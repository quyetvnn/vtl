<!-- Modal school application submit success -->
<div class="modal a4l-modal modal-success " id="modal-success" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-close-school-application-label">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body teacher-create-lesson text-center">
        <div class="row m-0 flex-center">
          <?=$this->Html->image('icon-success.png', ['width' => "70px"]); ?>
        </div>
        <h3 class="text-green" id="short-message"> <?=__d('member', 'successfully_submit')?> </h3>
        <p class="message text-dark-liver" id="long-message"><?=__d('member', 'submit_create_school_success')?> </p>
      </div>
      <div class="modal-footer">
        <div class="row m-0 flex-center">
          <button class="btn btn-w-radius btn-min-width-210 btn-green" type="button" data-dismiss="modal" aria-label="Close"><?=__d('member', 'complete')?></button>
        </div>
        
      </div>
    </div>
  </div>
</div>
<!-- Modal school application submit success -->

<!-- Modal school application approved -->

  <div class="modal a4l-modal modal-success fade " id="modal-approve-school" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-close-school-application-label">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-body teacher-create-lesson text-center">
          <div class="row m-0 flex-center">
            <?=$this->Html->image('cert.png', ['width' => "70px"]); ?>
          </div>
          <h3 class="text-green" id="short-message"> <?=__d('member', 'school_approval_completed')?> </h3>
          <p class="message text-dark-liver" id="long-message"> <?=__d('member', 'school_approval_completed_message')?></p>
        </div>
        <div class="modal-footer">
          <div class="row m-0 flex-center">
            <a href="#" class="btn btn-w-radius btn-green" id="url-landing-access"><?=__d('member', 'start_to_manage_the_school')?></a>
          </div>
          <div class="row m-0 flex-center">
            <p class="text-green mt-10">
              <a href="<?=Router::url('/', true)?>"  class="text-green">
                <?=__d('member', 'later')?>
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Modal school application approved -->

<!-- Modal school application close modal confirm -->
<div class="modal a4l-modal modal-warning" id="modal-confirm-close-school-application" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-close-school-application-label">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-body teacher-create-lesson text-center">
        <p class="message text-dark-liver" id="modal-confirm-close-school-application-label"><?=__d('member', 'confirm_leaving_create_school')?></p>
      </div>
      <div class="modal-footer ">
        <div class="row m-0 flex-center">
          <button class="btn btn-w-radius btn-min-width-210 btn-green" type="button" onclick="SCHOOL_WELCOME.quit_form_school_application(false)"><?=__d('member', 'back_to_form')?></button>
        </div>
        <div class="row mt-10 flex-center">
          <button class="btn btn-w-radius btn-min-width-210 btn-green-o" onclick="SCHOOL_WELCOME.quit_form_school_application(true)"><?=__d('member', 'leave')?></button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal school application close modal confirm -->

<!-- Modal reset password -->
<div class="modal a4l-modal modal-warning" id="modal-reset-password" tabindex="-1" role="dialog" aria-labelledby="modal-reset-password-label">
  <div class="modal-dialog modal-md" role="document">
    <form class="modal-content" id="form_reset_password">
      <div class="modal-body teacher-create-lesson">
        <p class="message text-dark-liver text-center" id="modal-reset-password-label"><?=__d('member', 'reset_password')?></p>
        <div class="row m-0">
          <div class="col-md-12 p-0 form-group">
            <label><?=__d('member', 'current_password')?></label>
            <input type="password" class="form-control a4l-input" id="old_password" placeholder="<?=__d('member', 'current_password')?>" />
          </div>
          <div class="col-md-12 p-0 form-group">
            <label><?=__d('member', 'new_password')?></label>
            <input type="password" class="form-control a4l-input" id="new_password" placeholder="<?=__d('member', 'new_password')?>" />
          </div>
          <div class="col-md-12 p-0 form-group">
            <label><?=__d('member', 'repeat_new_password')?></label>
            <input type="password" class="form-control a4l-input" id="repeat_new_password" placeholder="<?=__d('member', 'repeat_new_password')?>" />
          </div>
          <div class="col-md-12">
            <p class="error text-red" id="reset-password-error"></p>
          </div>
        </div>
      </div>
      <div class="modal-footer ">
        <div class="row m-0 flex-end">
          <div class="col-md-3 col-xs-6">
            <button class="btn btn-w-radius btn-green-o" data-dismiss="modal" aria-label="Close"><?=__d('member', 'leave')?></button>
          </div>
          <div class="col-md-3 col-xs-6">
            <button class="btn btn-w-radius btn-green" type="submit" id="btn-submit-reset-password" disabled><?=__d('member', 'submit')?></button>
          </div>
        </div>
      </div>
     </form>
  </div>
</div>
<!-- Modal reset password -->

<!-- Modal forget password -->
<div class="modal a4l-modal modal-login" id="modal-forget-password" tabindex="-1" role="dialog" aria-labelledby="modal-forget-password-label">
  <div class="modal-dialog modal-sm-450px" role="document">
    <form class="modal-content p-0" id="form_forget_password">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="text-center">
          <h3 class="text-green"><?=__d("member", 'forget_password')?></h3>
          <p class="text-dark-liver"><?=__d('member', 'enter_email_reset_password')?></p>
        </div>
      </div>
      <div class="modal-body ">
        <div class="row m-0 flex-center">
          <div class="col-md-10 p-0 input-w-icon-t form-group">
            <input type="text" 
                name="email" 
                id="forget_pw_email" 
                class="form-control a4l-input"  
                onKeyDown="if(event.keyCode === 32) return false;">
            <span class="icon-envelope-o icon"></span>
          </div>
          <div class="col-md-12">
            <p class="error text-red" id="forget-password-error"></p>
          </div>
        </div>
      </div>
      <div class="modal-footer ">
        <div class="row m-0 flex-center">
          <div class="col-md-10 p-0 form-group">
            <button class="btn btn-w-radius btn-width-100 btn-green" type="submit" id="btn-submit-forget-password"><?=__d('member', 'submit')?></button>
          </div>
        </div>
        <div class="row m-0 flex-center">
          <p><?=__d('member', 'remmeber_password')?> <a class="text-green" data-dismiss="modal" href="javascript:void(0)" onclick="COMMON.trigger_form_login('login')"><?=__d('member', 'try_to_login')?></a></p>
        </div>
      </div>
     </form>
  </div>
</div>
<!-- Modal forget password -->
<?php
  $params = $request->params;
?>
<?php if($params['controller'] == 'pages' && $params['action']=='forgot_password'){?>
<!-- Modal reset forget password -->
<div class="modal a4l-modal modal-login" id="modal-reset-forget-password" tabindex="-1" role="dialog" aria-labelledby="modal-reset-password-label">
  <div class="modal-dialog modal-sm-450px" role="document">
    <?php echo $this->Form->create('pages', array('role' => 'form', 'class' => 'modal-content', 'id'=>'form_reset_forget_password')); ?>
    <!-- <form class="modal-content" id="form_reset_forget_password"> -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <center>
          <?=$this->Html->image('all-4-learn-logo-bilingual-colour.png', ['width' => "260px"]); ?>
        </center>
      </div>
      <div class="modal-body teacher-create-lesson">
        <p class="message text-dark-liver text-center" id="modal-reset-password-label"><?=__d('member', 'reset_your_password')?></p>
        <div class="row m-0 flex-center">
          <div class="col-md-10 p-0">
            <div class="row m-0">
              <div class="col-md-12 p-0" id="grp-forget-reset-password">
                <div class="input-w-icon-t p-0 form-group">
                  <input  type="password" 
                          name = "reset_forget_password"
                          id="reset_forget_password" 
                          class="form-control a4l-input m-0"  
                          placeholder="<?=__d('member', 'please_enter_new_password')?>">
                  <span class="icon icon-password"></span>
                </div>
                <p class="error text-red"></p>
              </div>
              <div class="col-md-12 p-0" id="grp-forget-reset-password-confirm">
                <div class="input-w-icon-t p-0 form-group">
                  <input  type="password" 
                          name = "reset_forget_password_confirm"
                          id="reset_forget_password_confirm" 
                          class="form-control a4l-input m-0"  
                          placeholder="<?=__d('member', 'confirm_your_new_password')?>">
                  <span class="icon icon-password"></span>
                </div>
                <p class="error text-red"></p>
              </div>

              <div class="col-md-12">
                <p class="error text-red" id="reset-password-error"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer ">
        <div class="row m-0 flex-center">
          <div class="col-md-10 p-0">
            <button class="btn btn-w-radius btn-green btn-width-100" type="submit"><?=__d('member', 'reset_password')?></button>
          </div>
        </div>
      </div>
      <?php echo $this->Form->end(); ?>
     <!-- </form> -->
  </div>
</div>
<!-- Modal reset forget password -->

<script>
  $(document).on('ready', function(){ $('#modal-reset-forget-password').modal({'backdrop': 'static'}); })
</script>
<?php } ?>


<!-- not yet login -->
<?php if (!isset($current_user) || empty($current_user)) { ?>
<!-- Modal Login / signup -->
<div id="login" class="w3-modal modal-login modal-pretent-page" >
    <div class="w3-modal-content " style="max-width:450px;">
      <div class="bg-white">
        <div class="close-modal skip-step">
          <?php if(isset($school_info) && !empty($school_info)){ ?>
            <span class="fa fa-long-arrow-left backstep" onclick="COMMON.back_to_invitation()"></span>
          <?php } ?>
        <span onclick="COMMON.close_login_form()" title="Close Modal" style="">&times;</span>
      </div>
      <div>
        <div id="kl_loginDIV" class="form-login">
          <?php if(!isset($school_info) || empty($school_info)){?>
            <p class="switch-modal text-center active-login">
              <strong class="item active"><?=  __('login'); ?> </strong>
              <span class="item pointer trigger-active-register">/<?php echo  __d('member', 'sign_up')?></span>
            </p>
            <p class="switch-modal text-center active-register">
              <strong class="item active"><?php echo  __d('member', 'sign_up')?></strong>
              <span class="item pointer trigger-active-login">/<?=  __('login'); ?> </span>
            </p>
          <?php } ?>
          <?php if(isset($school_info) && !empty($school_info)){?>
            <div class="modal-body p-0">
              <div class="w3-modal-header text-center">
                <center class="group-img-radius icon-school">
                  <div class="box-img border-grey">
                    <?php
                      if($school_info['avatar']!=''){
                        echo $this->Html->image($school_info['avatar'], ['class' => "profile-image"]); 
                      }else{
                         $minimal_name = $this->App->get_minimal_name($school_info['name']);
                         echo "<span class='default-text-avatar'>".$minimal_name."</span>";
                      }
                      
                    ?>
                  </div>
                </center>
                <h3 class="text-green"><?=__d('member', 'invitation_letter')?></h3>
              </div>
              <div class="text-center text-dark-liver mbt-50">
                <?=__d('member', 'please_complete_the_form_below_to_activate_your_account')?>
              </div>
            </div>
          <?php } ?>
          <?= $this->element('social_login_method', array('request'=>$request)) ?>
          <?= $this->element('form_login') ?>
          <?= $this->element('form_register') ?>

        </div>   <!-- login -->
      </div> <!-- center -->
      </div>
    
  </div>
</div> <!-- end w3 modal -->
<!-- Modal Login / signup -->

<!-- Modal Veriry email -->
<div id="veriry-email" class="w3-modal modal-notification modal-pretent-page">
  <div class="w3-modal-content p-0 ">
    <div class="bg-white">
      <div class="close-modal">
        <span onclick="COMMON.toggle_modal('veriry-email')" title="Close Modal" style="">&times;</span>
      </div>
      <div class="modal-body">
        <div class="w3-modal-header text-center">
          <h3 class="text-green"><?=__d("member", 'verification_email')?></h3>
        </div>
        <div class="text-center mbt-50" id="validation-info">
          
        </div>
        <p class="text-center"><?=__d("member", 'have_not_received_the_verification_code')?><a class="text-green" href="javascript:COMMON.resend_verify_code()"><?=__d("member", 'resend')?></a></p>
      </div>
      <div class="text-center input-verify row">
        <div class="col-xs-3 p-0 text-center">
          <input type="text" class="form-control item a4l-input validation-code" name="validation_code[]" onkeyup="COMMON.watch_validation_code(this)" maxlength="1" id="code-1" />
        </div>
        <div class="col-xs-3 p-0 text-center">
          <input type="text" class="form-control item a4l-input validation-code" name="validation_code[]" onkeyup="COMMON.watch_validation_code(this)" maxlength="1" id="code-2" />
        </div>
        <div class="col-xs-3 p-0 text-center">
          <input type="text" class="form-control item a4l-input validation-code" name="validation_code[]" onkeyup="COMMON.watch_validation_code(this)" maxlength="1" id="code-3" />
        </div>
        <div class="col-xs-3 p-0 text-center">
          <input type="text" class="form-control item a4l-input validation-code" name="validation_code[]" onkeyup="COMMON.watch_validation_code(this)" maxlength="1" id="code-4" />
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Veriry email -->
<?php } ?>
<!-- Modal Member Invitation -->
<?php if(isset($school_info) && !empty($school_info)){ ?>
<div id="invitation-request-login" class="w3-modal modal-login modal-option-login modal-pretent-page show-modal">
  <div class="w3-modal-content p-0">
    <div class="bg-white">
      <div class="close-modal">
        <span onclick="COMMON.toggle_modal('invitation-request-login')" title="Close Modal" style="">&times;</span>
      </div>
      <div class="modal-body p-0">
        <div class="w3-modal-header text-center">
          <center class="group-img-radius icon-school">
            <div class="box-img border-grey">
              <?php 
                if($school_info['avatar']!=''){
                  echo $this->Html->image($school_info['avatar'], ['class' => "profile-image"]); 
                }else{
                  $minimal_name = $this->App->get_minimal_name($school_info['name']);
                  echo "<span class='default-text-avatar'>".$minimal_name."</span>";
                }
                
              ?>
            </div>
          </center>
          <h3 class="text-green"><?=__d('member', 'invitation_letter')?></h3>
        </div>
        <div class="text-center mbt-50">
          <?php
          if($school_info['role_id']==Environment::read("role.teacher")){
            echo '👋'.__d('member', 'hello_teacher').'「'.$school_info['name'].'」'.sprintf(__d('member', 'i_want_to_invite_you_to_become_a_tutor_of_this_school_are_you_a_member_of_ours'), __d('member', 'teacher'));

          }else if($school_info['role_id']==Environment::read("role.student")){
            echo '👋'.__d('member', 'hello_teacher').'「'.$school_info['name'].'」'.sprintf(__d('member', 'i_want_to_invite_you_to_become_a_tutor_of_this_school_are_you_a_member_of_ours'), __d('member', 'student')); 
          }
          ?>
          
        </div>
      </div>
      <div class="option-login row m-0">
        <div class="form-group">
          <button class="btn btn-green-o btn-w-radius btn-width-100" onclick="COMMON.invitation_code_login()"><?=__d('member', 'i_am_member')?></button>
        </div>
        <div>
          <button class="btn btn-green-o btn-w-radius btn-width-100" onclick="COMMON.invitation_code_register()"><?=__d('member', 'no_i_want_to_register')?></button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<!-- Modal Member Invitation -->

<!-- Modal Signup success -->
<div id="signup-success" class="w3-modal modal-notification modal-pretent-page">
  <div class="w3-modal-content" >
    <div class="bg-white">
      <div class="modal-body">
        <center class="group-img-radius icon-school">
          <div class="box-img border-grey">
            <?php echo $this->Html->image('icon-success.png', ['alt' => '王志宇', 'class' => "profile-image"]); ?>
          </div>
        </center>
        <div class="w3-modal-header text-center">
          <h3 class="text-green"><?=__d("member", "registration_success")?></h3>
        </div>
        <div class="text-center">
          <?=__d("member", "registration_success_message")?>
        </div>
      </div>
      <div class="text-center" style="margin-top: 20px;">
        <button class="btn btn-w-radius btn-width-100 btn-green" onclick="COMMON.start_personal_setting()">
          <?=__d("member", "start_personal_setting")?>
        </button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Signup success -->

<!-- Modal Update profile -->
<div id="update-profile" class="w3-modal modal-notification modal-pretent-page">
  <div class="w3-modal-content modal-login" >
    <div class="bg-white" id="update-nickname-step" style="display: block;">
      <div class="close-modal skip-step">
        <span onclick="COMMON.skip_update_profile('avatar')" title="Close Modal" class="text-grey exit-modal"><?=__d("member", "skip")?></span>
      </div>
      <div class="modal-body">
        <div class="w3-modal-header text-center">
          <h3 class="text-green"><?=__d("member", "your_nickname")?></h3>
        </div>
        <div class="text-center form-login">
          <input  type="text" 
            name="nickname" 
            id="inp-nickname" 
            class="form-control a4l-input">
        </div>
      </div>
      <div class="text-center" style="margin-top: 20px;">
        <button class="btn btn-w-radius btn-green" onclick="COMMON.update_profile_by_attr('nickname')">
          <?=__d("member", "next_step")?>
        </button>
      </div>
      <p class="navigate text-center pointer" onclick="document.getElementById('update-avatar-step').style.display='block';document.getElementById('update-nickname-step').style.display='none';">
        <span class="fa fa-circle item "></span>
        <span class="fa fa-circle-thin item "></span>
      </p>
    </div>
    <div class="bg-white" id="update-avatar-step" style="display: none;">
      <div class="close-modal skip-step">
        <span class="fa fa-long-arrow-left backstep" onclick="document.getElementById('update-avatar-step').style.display='none';document.getElementById('update-nickname-step').style.display='block';"></span>
        <span onclick="COMMON.skip_update_profile('avatar')" title="Close Modal" class="text-grey exit-modal"><?=__d("member", "skip")?></span>
      </div>
      <div class="modal-body">
        <div class="w3-modal-header text-center">
          <h3 class="text-green"><?=__d("member", "add_avatar")?></h3>
        </div>
        <div class="text-center form-login pointer" >
          <center class="group-img-radius icon-school" onclick="COMMON.trigger_choose_avatar()">
            <div class="box-img border-grey">
              <div class="trans-layer">
                <span class="fa fa-camera icon"></span>
              </div>
              <img id="preview-avatar" src="" />
            </div>
          </center>
          <input type="file" id="inp-avatar" class="hidden">
        </div>
        <p class="text-center text-grey"><?=__d("member", 'picture_limit_5MB')?></p>
      </div>
      <div class="text-center" style="margin-top: 20px;">
        <button class="btn btn-w-radius btn-green" onclick="COMMON.update_profile_by_attr('avatar')">
          <?=__d("member", 'complete')?>
        </button>
      </div>
      <p class="navigate text-center pointer" onclick="document.getElementById('update-avatar-step').style.display='none';document.getElementById('update-nickname-step').style.display='block';">
        <span class="fa fa-circle-thin item"></span>
        <span class="fa fa-circle item"></span>
      </p>
    </div>
  </div>
</div>
<!-- Modal Update profile -->
