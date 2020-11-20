<?php
    $params = $this->request->params;
    $school_active = '';
    $home_active = '';
    $library_active = '';
    $member_active = '';

    if(($params['controller'] == 'teacher_portals' && $params['action']=='index') || 
        ($params['controller'] == 'student_portals' && $params['action']=='index') ||
        ($params['controller'] == 'pages' && $params['action']=='landing')){
        $school_active = 'active';
    }else if(($params['controller'] == 'teacher_portals' && $params['action']=='library') || 
                ($params['controller'] == 'student_portals' && $params['action']=='library')){
        $library_active = 'active';
    }else if($params['controller'] == 'pages' && (  $params['action']=='login' || 
                                                    $params['action']=='register' || 
                                                    $params['action']=='profile' ||
                                                    $params['action']=='support')){
        $member_active = 'active';
    }
?>

<div class="row show-mobile menu-mobile">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <div class="pull-left">
                    <?php
                        if (isset($current_user) && !empty($current_user)) {
                            if (isset($current_user['is_teacher']) && $current_user['is_teacher']) {
                                echo $this->Html->link(
                                    $this->Html->image('all-4-learn-logo-bilingual-white.png?v=2', ['alt' => 'leARN', 'height'=>'100%']), 
                                    array(
                                        'plugin' => '', 
                                        'controller' => 'teacher_portals', 
                                        'action' => 'index',
                                        'admin' => false,
                                    ), 
                                    array('class' => 'navbar-brand', 'escape' => false)
                                ); 
                            } else if (isset($current_user['is_student']) && $current_user['is_student'] ) {
                                echo $this->Html->link(
                                    $this->Html->image('all-4-learn-logo-bilingual-white.png?v=2', ['alt' => 'leARN', 'height'=>'100%']), 
                                    array(
                                        'plugin' => '', 
                                        'controller' => 'student_portals', 
                                        'action' => 'index',
                                        'admin' => false,
                                    ), 
                                    array('class' => 'navbar-brand', 'escape' => false)
                                ); 
                            } else {
                                echo $this->Html->link(
                                    $this->Html->image('all-4-learn-logo-bilingual-white.png?v=2', ['alt' => 'leARN', 'height'=>'100%']),
                                    array(
                                        'plugin' => '',
                                        'controller' => 'pages', 
                                        'action' => 'landing',
                                        'admin' => false,
                                    ), 
                                    array('class' => 'navbar-brand', 'escape' => false)
                                ); 
                            }
                        } else {
                            echo $this->Html->link(
                                $this->Html->image('all-4-learn-logo-bilingual-white.png?v=2', ['alt' => 'leARN', 'height'=>'100%']),
                                array(
                                    'plugin' => '',
                                    'controller' => 'pages', 
                                    'action' => 'landing',
                                    'admin' => false,
                                ), 
                                array('class' => 'navbar-brand', 'escape' => false)
                            ); 
                        }
                    ?> 
                </div>
                <div class="pull-right">
                    <?php
                        if (isset($current_user) && !empty($current_user)) {
                            if(isset($current_user['is_teacher']) && $current_user['is_teacher']){
                                ?>
                                <a href="#" class="navbar-brand" data-toggle="collapse" data-target="#create-menu-teacher" aria-expanded="false">
                                    <?=$this->Html->image('topbar/icon/add-white.png', ['alt' => '', 'class' => "navigate-bar"])?>
                                </a>
                                <a href="#" class="navbar-brand" data-toggle="collapse" data-target="#browse-menu" aria-expanded="false" >
                                    <?=$this->Html->image('topbar/icon/schedule-white.png', ['alt' => '', 'class' => "navigate-bar"])?>
                                </a>
                    <?php } else if(isset($current_user['is_student']) && $current_user['is_student']){ ?>
                                <a href="#" class="navbar-brand" data-toggle="collapse" data-target="#browse-menu" aria-expanded="false">
                                    <?=$this->Html->image('topbar/icon/schedule-white.png', ['alt' => '', 'class' => "navigate-bar"])?>
                                </a>
                    <?php   }   }?>
                </div>
            </div>

            <?php  
            if (isset($current_user) && !empty($current_user)) { 
                    if((isset($current_user['is_teacher']) && $current_user['is_teacher']) || (isset($current_user['is_student']) && $current_user['is_student']) ) { ?>
            <div class="collapse navbar-collapse topbar-dropdown " id="browse-menu">
                <ul class="n-dropdown-content text-right ">
                    <?php if(isset($current_user['member_role'][Environment::read('role.student')])){
                            foreach ($current_user['member_role'][Environment::read('role.student')] as $key => $role){ ?>
                        <li class="itm-title text-left">
                            <?=__d('member', 'student_role')?> (<?=$role['School']['SchoolLanguage'][0]['name']?>)
                        </li>
                        <li>
                           <div class="icon icon-create-class"></div>
                            <?php
                                echo $this->Html->link(
                                    __d('member', 'admin_teacher_create_lesson'),
                                    array(
                                        'plugin' => '', 
                                        'controller' => 'student_portals', 
                                        'action' => 'browse',
                                        $role['School']['school_code'],
                                        'admin' => false,
                                    ), 
                                    array('escape' => false)
                                ); 
                            ?>
                        </li>
                        <li class="group-img-radius clearfix">
                            <div class="icon icon-upload-materials"></div>
                            <?php
                                echo $this->Html->link(
                                    __d('member', 'assignments'),
                                    array(
                                        'plugin' => '', 
                                        'controller' => 'student_portals', 
                                        'action' => 'assignments',
                                        $role['School']['school_code'],
                                        'admin' => false,
                                    ), 
                                    array('escape' => false)
                                ); 
                            ?>
                        </li>
                    <?php } } ?>
                    <?php if(isset($current_user['member_role'][Environment::read('role.teacher')])){
                            foreach ($current_user['member_role'][Environment::read('role.teacher')] as $key => $role){ ?>
                        <li class="itm-title text-left">
                            <?=__d('member', 'teacher_role')?> (<?=$role['School']['SchoolLanguage'][0]['name']?>)
                        </li>
                        <li>
                           <div class="icon icon-create-class"></div>
                            <?php
                                echo $this->Html->link(
                                    __d('member', 'admin_teacher_create_lesson'),
                                    array(
                                        'plugin' => '', 
                                        'controller' => 'teacher_portals', 
                                        'action' => 'browse',
                                        $role['School']['school_code'],
                                        'admin' => false,
                                    ), 
                                    array('escape' => false)
                                ); 
                            ?>
                        </li>
                        <li class="group-img-radius clearfix">
                            <div class="icon icon-upload-materials"></div>
                            <?php
                                echo $this->Html->link(
                                    __d('member', 'assignments'),
                                    array(
                                        'plugin' => '', 
                                        'controller' => 'teacher_portals', 
                                        'action' => 'assignments',
                                        $role['School']['school_code'],
                                        'admin' => false,
                                    ), 
                                    array('escape' => false)
                                ); 
                            ?>
                        </li>
                    <?php } } ?>
                </ul>
            </div>

            <div class="collapse navbar-collapse topbar-dropdown" id="create-menu-teacher">
                <ul class="n-dropdown-content text-right ">
                    <li>
                       <div class="icon icon-create-class"></div>
                        <?php
                            echo $this->Html->link(
                                __d('member', 'add_class'),
                                array(
                                    'plugin' => '', 
                                    'controller' => 'teacher_portals', 
                                    'action' => 'add',
                                    'admin' => false,
                                ), 
                                array('escape' => false)
                            ); 
                        ?>
                    </li>
                    <li class="group-img-radius clearfix">
                        <div class="icon icon-upload-materials"></div>
                        <?php
                            echo $this->Html->link(
                                __d('member', 'add_homework'),
                                array(
                                    'plugin' => '', 
                                    'controller' => 'teacher_portals', 
                                    'action' => 'assignment_create',
                                    'admin' => false,
                                ), 
                                array('escape' => false)
                            ); 
                        ?>
                    </li>
                </ul>
            </div>
            <?php } } ?>
            </div>
    </nav>
</div>


<section class="menu-image sidebar-fx-left " >
    <div class="show-desktop">
        <?php
            if(isset($current_user) && !empty($current_user)){
                if (isset($current_user['is_teacher']) && $current_user['is_teacher']) {
                    echo $this->Html->link(
                        // '<div class="icon icon-open-menu"> </div>'.
                        '<div class="logo-learn im-white">
                            '.$this->Html->image("learn-logo-white.png", ["alt" => "leARN"]).'
                        </div>', 
                        array(
                            'plugin' =>"",
                            'controller' => 'teacher_portals', 
                            'action' => 'index',
                            'admin' => false,
                        ), 
                        array('class' => 'brand-top', 'escape' => false)
                    ); 
                } else if ( isset($current_user['is_student']) && $current_user['is_student'] ) {
                    echo $this->Html->link(
                        // '<div class="icon icon-open-menu"> </div>'.
                        '<div class="logo-learn im-white">
                            '.$this->Html->image("learn-logo-white.png", ["alt" => "leARN"]).'
                        </div>', 
                        array(
                            'plugin' =>"",
                            'controller' => 'student_portals', 
                            'action' => 'index',
                            'admin' => false,
                        ), 
                        array('class' => 'brand-top', 'escape' => false)
                    ); 
                } else {
                    echo $this->Html->link(
                        // '<div class="icon icon-open-menu"> </div>'.
                        '<div class="logo-learn im-white">
                            '.$this->Html->image("learn-logo-white.png", ["alt" => "leARN"]).'
                        </div>',
                        array(
                            'plugin' =>"",
                            'controller' => 'pages', 
                            'action' => 'landing',
                            'admin' => false,

                        ), 
                        array('class' => 'brand-top', 'escape' => false)
                    ); 
                }
            }else{
                echo $this->Html->link(
                    // '<div class="icon icon-open-menu"> </div>'.
                    '<div class="logo-learn im-white">
                        '.$this->Html->image("learn-logo-white.png", ["alt" => "leARN"]).'
                    </div>',
                    array(
                        'plugin' =>"",
                        'controller' => 'pages', 
                        'action' => 'landing',
                        'admin' => false,

                    ), 
                    array('class' => 'brand-top', 'escape' => false)
                ); 
            }
            ?>
    </div>

    <?php  ?>
                                
    <ul class="sidebar-menu p-0 m-0">
        <?php 
            if (isset($current_user) && !empty($current_user)) { ?>
            <?php if( isset($current_user['is_teacher']) && $current_user['is_teacher']){ ?>
                <li class="item item-3 <?= $school_active ?>"> 
                    <?php
                        echo $this->Html->link(
                                '<div class="icon-sidebar home"> </div>'.
                                '<div class="sidebar-icon-text">'.__d('member', 'explore').'</div>', 
                                array(
                                    'plugin' => '', 
                                    'controller' => 'teacher_portals', 
                                    'action' => 'index',
                                    'admin' => false,
                                ), 
                                array('escape' => false)
                            ); 
                    ?>
                </li>
                <li class="item item-3 <?= $library_active ?>">
                    <?php
                        echo $this->Html->link(
                            '<div class="icon-sidebar library"> </div>'.
                            '<div class="sidebar-icon-text">'.__d('member', 'library').'</div>',
                            array(
                                'plugin' =>"",
                                'controller' => 'teacher_portals', 
                                'action' => 'library'
                            ), 
                            array('escape' => false)
                        ); 
                    ?>
                </li>
            <?php }else if(isset($current_user['is_student']) && $current_user['is_student']){ ?>
                <li class="item item-3 <?= $school_active ?>"> 
                    <?php
                        echo $this->Html->link(
                                '<div class="icon-sidebar home"> </div>'.
                                '<div class="sidebar-icon-text">'.__d('member', 'explore').'</div>', 
                                array(
                                    'plugin' => '', 
                                    'controller' => 'student_portals', 
                                    'action' => 'index',
                                    'admin' => false,
                                ), 
                                array('escape' => false)
                            ); 
                    ?>
                </li>
                <li class="item item-3 <?= $library_active ?>">
                    <?php
                        echo $this->Html->link(
                            '<div class="icon-sidebar library"> </div>'.
                            '<div class="sidebar-icon-text">'.__d('member', 'library').'</div>',
                            array(
                                'plugin' =>"",
                                'controller' => 'student_portals', 
                                'action' => 'library'
                            ), 
                            array('escape' => false)
                        ); 
                    ?>
                </li>
        <?php }else { ?>
        <li class="item item-3 <?= $school_active ?>">
             <?php
                echo $this->Html->link(
                    '<div class="icon-sidebar home"> </div>'.
                    '<div class="sidebar-icon-text">'.__d('member', 'explore').'</div>',
                    array(
                        'plugin' =>"",
                        'controller' => 'pages', 
                        'action' => 'landing'
                    ), 
                    array('escape' => false)
                ); 
            ?>
        </li>   
        <?php } ?> 
        <li class="item item-3 show-mobile group-img-radius <?=$member_active?>"> 
            <?php
                $avatar = isset($current_user['tmp_avatar'])?$current_user['tmp_avatar']: '';
                if(isset($current_user['avatar']) && $current_user['avatar']!=''){
                    $avatar = $current_user['avatar'];
                }
                $avatar = !empty($avatar)?$this->Html->image( $avatar , ['class' => "profile-image"]):'';
                echo $this->Html->link(
                    '<div class="box-img m-0">'.$avatar.'</div>'.
                    '<div class="sidebar-icon-text">'.__d('member','member').'</div>',
                    array(
                        'plugin' =>"",
                        'controller' => 'pages', 
                        'action' => 'profile'
                    ), 
                    array('escape' => false)
                ); 
            ?>
        </li>
    <?php }else{ ?>
        <li class="item item-2 <?= $school_active ?>">
            <?php
                echo $this->Html->link(
                    '<div class="icon-sidebar home"> </div>'.
                    '<div class="sidebar-icon-text">'.__d('member', 'explore').'</div>',
                    array(
                        'plugin' =>"",
                        'controller' => 'pages', 
                        'action' => 'landing'
                    ), 
                    array('escape' => false)
                ); 
            ?>
            
        </li>
        <li class="item item-2 show-mobile <?=$member_active?>"> 
            <?php
                echo $this->Html->link(
                    '<div class="icon-sidebar member"> </div>'.
                    '<div class="sidebar-icon-text">'.__('login').'</div>',
                    array(
                        'plugin' =>"",
                        'controller' => 'pages', 
                        'action' => 'login'
                    ), 
                    array('escape' => false)
                ); 
            ?>
        </li>

    <?php } ?>

        <!-- <li class="item"> 
            <div class="icon-sidebar subscription"> </div>
            <div class="sidebar-icon-text">訂閱 </div>
        </li> -->
    </ul>
    <div class="show-desktop copywrite term-condition flex-center" style="position: absolute; bottom: 0; font-size: 0.75em; width: 100%;">
        <p class="text-center" style="color: #fff">
            <a style="color: #fff" href="<?=Router::url('/', true)?>uploads/terms_and_condition_<?=$this->Session->read('Config.language')?>.html" ><?=__d('member', 'term')?></a> | 
            <a style="color: #fff" href="<?=Router::url('/', true)?>uploads/privacy_policy_<?=$this->Session->read('Config.language')?>.html" ><?=__d('member', 'privacy_policy')?></a>
        </p>
    </div>
</section>