<?php echo $this->Form->create('Member', array('role' => 'form', 'class'=>'active-register', 'id'=>'form-register')); ?>
    <p class="text-center text-grey"><?php echo  __d('member', 'create_new_account')?></p>
    <div class=grp-username>
      <div class="input-w-icon-t">
        <input  type="text" 
            name="username" 
            id="register-username" 
            class="form-control a4l-input"  
            onKeyDown="if(event.keyCode === 32) return false;" 
            placeholder="<?php echo  __d('member', 'create_new_usename')?>">
        <span class="icon-username icon"></span>
      </div>
      <p class="text-red error-msg"></p>
    </div>
    
    <!-- <div class=grp-lastname>
      <div class="input-w-icon-t">
        <input type="text" 
            name="lastname" 
            id="register-lastname" 
            class="form-control a4l-input"  
            onKeyDown="if(event.keyCode === 32) return false;" 
            placeholder="<?php echo  __d('member', 'last_name')?>">
        <span class="icon-user icon"></span>
      </div>
      <p class="text-red error-msg"></p>
    </div> -->
    
    <div class=grp-name>
      <div class="input-w-icon-t">
        <input type="text" 
            name="name" 
            id="register-name" 
            class="form-control a4l-input"
            placeholder="<?php echo  __d('member', 'name')?>">
        <span class="icon-user icon"></span>
      </div>
      <p class="text-red error-msg"></p>
    </div>
    <div class="grp-email">
      <div class="input-w-icon-t">
        <input type="text" 
            name="email" 
            id="register-email" 
            class="form-control a4l-input"  
            onKeyDown="if(event.keyCode === 32) return false;" 
            value="<?=isset($school_info)&&isset($school_info['email_link'])?$school_info['email_link']:'' ?>"
            placeholder="<?php echo  __d('member', 'email')?>"
            <?=isset($school_info) && !empty($school_info)?'disabled':'' ?>
             />
        <span class="icon-envelope-o icon"></span>
      </div>
      <p class="text-red error-msg"></p>
    </div>
    <div class="row nopadding grp-phone-number">
      <div class="col-md-12 input-w-icon-t ">
        <input type="text" name="phone-number" id="register-phone-number" class="form-control a4l-input nomargin" placeholder="<?php echo  __d('member', 'phone_number')?>">
        <span class="icon icon-mobile"></span>
      </div>
      <p class="text-red error-msg"></p>
    </div>
    <div class="grp-password ">
      <div class="input-w-icon-t">
        <input name="password" 
            class="form-control a4l-input" 
            id="register-password" 
            onKeyDown="if(event.keyCode === 32) return false;" 
            type="password" 
            placeholder="<?php echo  __d('member', 'create_new_password')?>">
        <span class="icon-password icon"></span>
        <span class="unit pointer toggle-password" ><?php echo  __d('member', 'show')?></span>
        <span class="unit pointer toggle-password hidden" ><?php echo  __d('member', 'hide')?></span>
      </div>
      <p class="text-red error-msg"></p>
    </div>
    <?php if(isset($school_info) && !empty($school_info)){?>
      <div class="row">
        <div class="col-md-10">
          <p class="text-left text-green mt-10"><?=__d('member', 'use_invitation_code')?> (<?=__d('member', 'optional')?>)</p>
          <input  name="school_code" id="register-school-code" class="kl_input-field bg-grey" type="text" placeholder="" />
        </div>
      </div>
    <?php } ?>
    <p class="text-red error-msg signup-error mbt-50"></p>
    <?php
      echo $this->Form->submit(__d('member', 'sign_up'), array(
        'style' => 'width: 100%; text-align: center',
        'class' => 'btn btn-w-radius btn-green'
      ));
      
    ?>
    <p class="text-center m-10"><?=__d('member', 'term_n_privacy')?>
    <a href="<?=Router::url('/', true)?>uploads/terms_and_condition_<?=$this->Session->read('Config.language')?>.html" class="text-green"><?=__d('member', 'term')?></a>
    <?php echo __d('member', 'and') ?>
    <a href="<?=Router::url('/', true)?>uploads/privacy_policy_<?=$this->Session->read('Config.language')?>.html" class="text-green"><?=__d('member', 'privacy_policy')?></a>

      <?php
        // echo $this->Html->link(
        //                 __d('member', 'term'),
        //                 array(
        //                     'plugin' => '', 
        //                     'controller' => 'pages', 
        //                     'action' => 'term_n_conditions',
        //                     'admin' => false,
        //                 ), 
        //                 array('escape' => false, 'class'=>" text-green", 'target'=>"_blank")
        //             );
       
        // echo $this->Html->link(
        //     __d('member', 'privacy_policy'),
        //     array(
        //         'plugin' => '', 
        //         'controller' => 'pages', 
        //         'action' => 'privacy_policy',
        //         'admin' => false,
        //     ), 
        //     array('escape' => false, 'class'=>" text-green", 'target'=>"_blank")
        // );
      ?>
    </p>
<?php echo $this->Form->end(); ?>