<aside class="left-side sidebar-offcanvas">
	<section class="sidebar">
        <ul class="sidebar-menu">
            <?php if(isset($permissions) && $permissions) { ?>
               
                <!-- Start Plugin::Administration  -->
                <?php if(   (isset($permissions['Administrator']['view']) && ($permissions['Administrator']['view'] == true)) ||
                            (isset($permissions['Permission']['view']) && ($permissions['Permission']['view'] == true)) || 
                            (isset($permissions['Role']['view']) && ($permissions['Role']['view'] == true))) { ?>
                    <li class="treeview <?php echo ($this->params['plugin'] == 'administration'?' active':'');?>">
                        <a href="#">
                            <i class="fa fa-user"></i>
                            <span><?php echo __('administrator'); ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">

                         <?php if( isset($permissions['MemberManageSchool']['view']) && ($permissions['MemberManageSchool']['view'] == true) ){ ?>
                                <li class="<?= ($this->params['controller'] == 'member_manage_schools'?' active':'');?>">
                                    <?php
                                        echo $this->Html->link(
                                            '<i class="fa fa-angle-double-right"></i>' . __d('member', 'member_manage_schools'),
                                            array( 'plugin' => 'member', 'controller' => 'member_manage_schools', 'action' => 'index', 'admin' => true ),
                                            array('escape' => false)
                                        );
                                    ?>
                                </li>
                            <?php } ?>

                            <?php if( isset($permissions['Administrator']['view']) && ($permissions['Administrator']['view'] == true) ){ ?>
                                <li class="<?= ($this->params['controller'] == 'administrators'?' active':'');?>">
                                    <?php
                                        echo $this->Html->link(
                                            '<i class="fa fa-angle-double-right"></i>' . __('administrators'),
                                            array( 'plugin' => 'administration', 'controller' => 'administrators', 'action' => 'index', 'admin' => true ),
                                            array('escape' => false)
                                        );
                                    ?>
                                </li>
                            <?php } ?>
                            <?php if( isset($permissions['Permission']['view']) && ($permissions['Permission']['view'] == true) ){ ?>
                                <li class="<?= ($this->params['controller'] == 'permissions'?' active':'');?>">
                                    <?php
                                        echo $this->Html->link(
                                            '<i class="fa fa-angle-double-right"></i>' . __('permissions'),
                                            array( 'plugin' => 'administration', 'controller' => 'permissions', 'action' => 'index', 'admin' => true ),
                                            array('escape' => false)
                                        );
                                    ?>
                                </li>
                            <?php } ?>
                            <?php if( isset($permissions['Role']['view']) && ($permissions['Role']['view'] == true) ){ ?>
                                <li class="<?= ($this->params['controller'] == 'roles'?' active':'');?>">
                                    <?php
                                        echo $this->Html->link(
                                            '<i class="fa fa-angle-double-right"></i>' . __('roles'),
                                            array( 'plugin' => 'administration', 'controller' => 'roles', 'action' => 'index', 'admin' => true ),
                                            array('escape' => false)
                                        );
                                    ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <!-- End Plugin::Administration  -->
                <!-- Start Plugin::Company  -->
               

                <!-- school -->
                <?php if ($is_admin || $role_school_admin) { ?>
                    <!-- Start Plugin::School -->
                    <li class="treeview <?php echo ($this->params['plugin'] == 'school'?' active':'');?>">
                        <a href="#">
                            <i class="fa fa-book"></i>
                            <span><?php echo __d('school', 'school'); ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= ($this->params['controller'] == 'schools'?' active':'');?>">
                            <?php
                                echo $this->Html->link(
                                    '<i class="fa fa-angle-double-right"></i>' . __d('school', 'schools'),
                                    array( 'plugin' => 'school', 'controller' => 'schools', 'action' => 'index', 'admin' => true ),
                                    array('escape' => false)
                                );
                            ?>
                            </li>
                            <li class="<?= ($this->params['controller'] == 'school_subjects'?' active':'');?>">
                            <?php
                                echo $this->Html->link(
                                    '<i class="fa fa-angle-double-right"></i>' . __d('school', 'school_subjects'),
                                    array( 'plugin' => 'school', 'controller' => 'school_subjects', 'action' => 'index', 'admin' => true ),
                                    array('escape' => false)
                                );
                            ?>
                            </li>

                            <li class="<?= ($this->params['controller'] == 'school_classes'?' active':'');?>">
                            <?php
                                echo $this->Html->link(
                                    '<i class="fa fa-angle-double-right"></i>' . __d('school', 'school_classes'),
                                    array( 'plugin' => 'school', 'controller' => 'school_classes', 'action' => 'index', 'admin' => true ),
                                    array('escape' => false)
                                );
                            ?>
                            </li>
                        </ul>
                    </li>
                
                <?php } ?>

                <!-- member -->
                <?php if ($is_admin || $role_school_admin){ ?>
                    <li class="treeview <?php echo ($this->params['plugin'] == 'member'?' active':'');?>">
                        <a href="#">
                            <i class="fa fa-book"></i>
                            <span><?php echo __d('member', 'add_member'); ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php if ($is_admin) { ?>
                            <li class="<?= ($this->params['controller'] == 'members_credits' && $this->params['action'] == "admin_index" ? ' active' : '');?>">
                            <?php
                               echo $this->Html->link(
                                   '<i class="fa fa-angle-double-right"></i>' . __d('member', 'members_credits'),
                                   array( 'plugin' => 'member', 'controller' => 'members_credits', 'action' => 'index', 'admin' => true ),
                                   array('escape' => false)
                               );
                            ?>
                           </li>
                            <?php } ?>

                            <li class="<?= ($this->params['controller'] == 'invite_member_histories' && $this->params['action'] == "admin_index" ? ' active' : '');?>">
                            <?php
                               echo $this->Html->link(
                                   '<i class="fa fa-angle-double-right"></i>' . __d('member', 'invite_member_histories'),
                                   array( 'plugin' => 'member', 'controller' => 'invite_member_histories', 'action' => 'index', 'admin' => true ),
                                   array('escape' => false)
                               );
                            ?>
                           </li>

                            <li class="<?= ($this->params['controller'] == 'members' && $this->params['action'] == "admin_index" ? ' active' : '');?>">
                            <?php
                               echo $this->Html->link(
                                   '<i class="fa fa-angle-double-right"></i>' . __d('member', 'member'),
                                   array( 'plugin' => 'member', 'controller' => 'members', 'action' => 'index', 'admin' => true ),
                                   array('escape' => false)
                               );
                            ?>
                           </li>

                            <li class="<?= ($this->params['controller'] == 'member_login_methods' && $this->params['action'] == "admin_index" ? ' active' : '');?>">
                            <?php
                               echo $this->Html->link(
                                   '<i class="fa fa-angle-double-right"></i>' . __d('member', 'member_login_method'),
                                   array( 'plugin' => 'member', 'controller' => 'member_login_methods', 'action' => 'index', 'admin' => true ),
                                   array('escape' => false)
                               );
                           ?>
                           </li>

                           <li class="<?= ($this->params['controller'] == 'student_classes'?' active':'');?>">
                            <?php
                                echo $this->Html->link(
                                    '<i class="fa fa-angle-double-right"></i>' . __d('school', 'student_classes'),
                                    array( 'plugin' => 'member', 'controller' => 'student_classes', 'action' => 'index', 'admin' => true ),
                                    array('escape' => false)
                                );
                            ?>
                            </li>
                     

                            <li class="<?= ($this->params['controller'] == 'members' && $this->params['action'] == "admin_import_student" ? ' active' : '');?>">
                           
                            <?php
                                echo $this->Html->link(
                                    '<i class="fa fa-angle-double-right"></i>' . __d('member', 'import_student'),
                                    array( 'plugin' => 'member', 'controller' => 'members', 'action' => 'import_student', 'admin' => true ),
                                    array('escape' => false)
                                );
                            ?>
                            </li>
                        

                            <li class="<?= ($this->params['controller'] == 'members' && $this->params['action'] == "admin_import_teacher" ? ' active' : '');?>">
                      
                            <?php
                                echo $this->Html->link(
                                    '<i class="fa fa-angle-double-right"></i>' . __d('member', 'import_teacher'),
                                    array( 'plugin' => 'member', 'controller' => 'members', 'action' => 'import_teacher', 'admin' => true ),
                                    array('escape' => false)
                                );
                            ?>
                            </li>

                            <li class="<?= ($this->params['controller'] == 'import_histories' && $this->params['action'] == "admin_index" ? ' active' : '');?>">
                            <?php
                               echo $this->Html->link(
                                   '<i class="fa fa-angle-double-right"></i>' . __d('member', 'import_histories'),
                                   array( 'plugin' => 'member', 'controller' => 'import_histories', 'action' => 'index', 'admin' => true ),
                                   array('escape' => false)
                               );
                            ?>
                            </li>

                            

                          
                        </ul>
                    </li>
                <?php } ?>
               
                <?php if( isset($permissions['Vocabulary']['view']) && $permissions['Vocabulary']['view'] == true) { ?>

                    <li class="treeview <?php echo ($this->params['plugin'] == 'dictionary'?' active':'');?>">
                        <a href="#">
                            <i class="fa fa-book"></i>
                            <span><?= __('dictionary'); ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= ($this->params['controller'] == 'vocabularies'?' active':'');?>"><?php
                                echo $this->Html->link(
                                    '<i class="fa fa-angle-double-right"></i>' . __('vocabularies'),
                                    array( 'plugin' => 'dictionary', 'controller' => 'vocabularies', 'action' => 'index', 'admin' => true ),
                                    array('escape' => false)
                                );
                            ?></li>
                            <li class="<?= ($this->params['controller'] == 'image_types'?' active':'');?>"><?php
                                echo $this->Html->link(
                                    '<i class="fa fa-angle-double-right"></i>' . __('image_types'),
                                    array( 'plugin' => 'dictionary', 'controller' => 'image_types', 'action' => 'index', 'admin' => true ),
                                    array('escape' => false)
                                );
                            ?></li>
                        </ul>
                    </li> 
                <?php } ?>

                <li>
                    <?php echo $this->Html->link(
                        '<i class="fa fa-dashboard"></i>' . __('go_back_to_frontend'),
                        array( 'plugin' => '', 'controller' => 'pages', 'action' => 'landing', 'admin' => false ),
                        array('escape' => false)
                    );
                    ?>
                </li>

                <li>
                    <?php echo $this->Html->link(
                        '<i class=""></i>' .  Environment::read('site.name'),
                        array( 'plugin' => '', 'controller' => 'pages', 'action' => 'landing', 'admin' => false ),
                        array('escape' => false)
                    ); ?>
                </li>

                <?php if (!$is_admin &&  !$role_school_admin) { ?>
				<li class="text-center active">
					<?php 
						echo $this->Html->link(__('sign_in_first'), array(
							'plugin' => 'administration',
							'controller' => 'administrators',
							'action' => 'login',
							'admin' => true
						)); 
					?>
				</li>
            <?php } 
            } ?>
        </ul>
	</section>
</aside>
