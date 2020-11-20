<?php if (isset($current_user) && !empty($current_user)) {  ?>
    <div class="col-md-12 lst-url">
        <p class="text-grey"><?=__d('member', 'my_page')?></p>
        <ul>
            <li class="group-img-radius clearfix">
                <div class="box-img pull-left">
                    <?php
                        echo $this->Html->image($avatar, ['alt' => $show_name, 'class' => "profile-image"]);
                    ?>
                </div>
                <div class="addon-text pull-left"><?=$show_name?></div>
            </li>
        </ul>
    </div>
    <?php if($current_user['is_school_admin']){ ?>
    <hr>
    <div class="col-md-12 lst-url">
        <ul>
            <li>
                <?php
                    echo $this->Html->link(__d('member', 'membership'), 
                                            array(
                                                'plugin' => '', 
                                                'controller' => 'schools', 
                                                'action' => 'payment',
                                                'admin' => false
                                            ), 
                                            array('escape' => false)
                                        );
                ?>
            </li>
        </ul>
    </div>
    <?php } ?>
    <?php if ( isset($current_user['schools']) && count($current_user['schools'])>0){?>
    <hr>
    <div class="col-md-12 lst-url">
        <p class="text-grey"><?=__d('member', 'my_community')?></p>
        <ul>
            <?php foreach($current_user['schools'] as $school){ ?>
                <li class="group-img-radius clearfix">
                    <?php
                       if(!empty($school['avatar'])){
                            $avatar_school = $this->Html->image($school['avatar'], ['alt' => $school['name'], 'class' => "profile-image"]); 
                        }else{
                            $avatar_school = "<span class='default-text-avatar'>".$school['minimal_name']."</span>";
                        }
                        echo $this->Html->link('
                            <div class="box-img pull-left">'.$avatar_school.'</div>
                            <div class="addon-text pull-left">'.$school['name'].'</div>',
                            array(
                                'plugin' => '', 
                                'controller' => 'schools', 
                                'action' => 'landing',
                                $school['School']['school_code'],
                                'admin' => false,       // edit
                            ), 
                            array('escape' => false, 'class'=>'p-0')
                        ); 
                    ?>
                </li>
        <?php }  ?>
        </ul>
    </div>
    <?php } 
} ?>
<hr>
<div class="col-md-12 lst-url menu-section support-info">
    <ul class="text-left">
        <li>
            <span class="icon icon-help"></span>
            <?php
                echo $this->Html->link(__d('member', 'help'), 
                                        array(
                                            'plugin' => '', 
                                            'controller' => 'pages', 
                                            'action' => 'support',
                                            'admin' => false
                                        ), 
                                        array('escape' => false, 'class' => 'text-dark-liver')
                                    );
            ?>
        </li>
        <?php if( !isset($current_user) || empty($current_user) || $current_user['is_self_register']){ ?>
            <li>
                <span class="icon icon-establish-school"></span>
                <?php
                    echo $this->Html->link(__d('member', 'create_school'), 
                                            array(
                                                'plugin' => '', 
                                                'controller' => 'schools', 
                                                'action' => 'welcome',
                                                'admin' => false
                                            ), 
                                            array('escape' => false, 'class' => 'text-dark-liver')
                                        );
                ?>
            </li>
        <?php } ?>
        <?php if(isset($current_user) && !empty($current_user)){ ?>
            <?php if($current_user['is_school_admin']){ ?>
                <li>
                    <span class="icon icon-control-panel"></span>
                    <a href="<?=Router::url('/', true).'admin'?>"><?=__d('member', 'school_control_panel')?></a>
                </li>
            <?php } ?>
            <li class="clearfix">
                <span class="icon icon-password-dark"></span>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-reset-password" data-backdrop="static"><?=__d('member', 'reset_password')?></a>
            </li>
            <li>
                <span class="icon icon-logout-mobile"></span>
                <a href="javascript:COMMON.logout()"><?=__d('member', 'logout')?></a>
            </li>
        <?php } ?>
     </ul>
</div>
<hr>
<div class="col-md-12 menu-section language-info">
    <?php $current_language = $this->Session->read('Config.language'); ?>
    <ul>
        <?=$this->element('language_detail')?>
    </ul>
</div>
<div class="col-md-12 menu-section flex-center">
    <p class="text-center mt-10">
        <a class="text-grey" href="<?=Router::url('/', true)?>uploads/terms_and_condition_<?=$this->Session->read('Config.language')?>.html" ><?=__d('member', 'term')?></a> 
        <a class="text-grey" href="<?=Router::url('/', true)?>uploads/privacy_policy_<?=$this->Session->read('Config.language')?>.html" ><?=__d('member', 'privacy_policy')?></a>
    </p>
</div>
