<?php echo $this->Form->create('Member', array('role' => 'form', 'class'=>'active-login', 'id'=>'form-login')); ?>
  <div class="grp-username">
    <div class="input-w-icon-t">
      <input type="search" name="username" id="login-username" class="form-control a4l-input"  onKeyDown="if(event.keyCode === 32) return false;" placeholder="<?php echo  __d('member', 'enter_usename')?>">
      <span class="icon-username icon"></span>
    </div>
    <p class="text-red error-msg"></p>
  </div>
    
  <div class="grp-password">
    <div class="input-w-icon-t">
      <input name="password" 
          class="form-control a4l-input"  
          id="login-password" 
          onKeyDown="if(event.keyCode === 32) return false;" 
          type="password" 
          placeholder="<?php echo  __d('member', 'enter_password')?>">
      <span class="icon-password icon"></span>
      <span class="unit pointer toggle-password" ><?php echo  __d('member', 'show')?></span>
      <span class="unit pointer toggle-password hidden" ><?php echo  __d('member', 'hide')?></span>
    </div>
    <p class="text-red error-msg"></p>
  </div>
  
  <p class="text-right pointer" data-toggle="modal" data-target="#modal-forget-password" data-backdrop="static"><?=__d('member', 'forget_password')?></p>
  <div class="row">
    <div class="col-md-10">
      <p class="text-left mt-10"><?php echo  __d('member', 'enter_school_code')?></p>
      <input  name="school_code" id="login-school-code" class="kl_input-field bg-grey" type="text" placeholder="" />
    </div>
  </div>
  <p class="text-red login-error error-msg mbt-50"></p>
<?php
    echo $this->Form->submit(__('login'), array(
      'style' => 'width: 100%; text-align: center',
      'class' => 'btn btn-w-radius btn-green'
    ));  
?>
<?php echo $this->Form->end(); ?>