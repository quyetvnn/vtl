
<div class="row">
    <div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
                <h3 class="box-title"><?php echo __d('member', 'import_teacher'); ?></h3>
                <div class="pull-right"> <h5 class="box-title red"><?php echo __('required'); ?></h5></div>
			</div>
			<div class="box-body table-responsive">
		
                <?php echo $this->Form->create('Member', array('role' => 'form', 'type' => 'file')); ?>

                    <div class="form-group">
                        <?php 

                            echo $this->Form->input('school_id', array(
                                'class' => 'form-control',
                                'value' => $school_id,
                                'required' => 'required',
                                'empty' => __('please_select'),
                                'label' => "<font class='red'> * </font>" . __d('school','school'),
                            ));
                        ?>
					</div><!-- .form-group -->

                    <?php 
                        echo $this->element('files_upload',array());
                    ?>

                    <div class="panel panel-success">
                        
                        <div class="panel-body">
                            <div>
                               <h4> <?=__d('member', 'download_template')?> </h4>
                          
                                <?php $path = Router::url('/', true) . 'uploads/import/All4LeARN_teacher_import.xlsx' ?>
                                <a href="<?= $path ?>" target="_blank" download="All4LeARN_teacher_import.xlsx"> 
                                    <i class="fa fa-download"></i>
                                </a>
                            </div>

                            <div>
                                <h4> <?=__d('member', 'description')?> </h4>
                            </div>
                            <ul style="text-align:justify">
                                <li> <?=sprintf(__d('member', 'required_inport_teacher'), 
                                                sprintf(__d('member', 'field_import'), __d('member', 'username'), 'Username'), 
                                                sprintf(__d('member', 'field_import'), __d('member', 'enter_password'), 'Password'), 
                                                sprintf(__d('member', 'field_import'), __d('member', 'display_name'), 'Display Name'))?> </li>
                                <li> <?=sprintf(__d('member', 'optional_inport'), 
                                                sprintf(__d('member', 'field_import'), __d('member', 'email'), 'Email'), 
                                                sprintf(__d('member', 'field_import'), __d('member', 'phone_number'), 'Phone Number'))?>  </li>
                                <li> <?=sprintf(__d('member', 'field_defined'), 
                                                sprintf(__d('member', 'field_import'), __d('member', 'username'), 'Username'), 
                                                __d('member', 'username_defined'))?></li>
                            </ul>
                        </div>
                    </div>


                    <div class="panel panel-success">
                        <div class="panel-body">
                            <h4> <?= __d('member', 'import_teacher')?></h4>
                            <div class="box-body table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><?php echo "Username" ?></th>
                                            <th class="text-center"><?php echo "Password" ?></th>
                                            <th class="text-center"><?php echo "Display Name" ?></th>
                                            <th class="text-center"><?php echo "Email (Optional)" ?></th>
                                            <th class="text-center"><?php echo "Phone number (Optional)" ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center"><?php echo "eg: tea0001" ?></td>
                                            <td class="text-center"><?php echo "eg: 88888888" ?></td>
                                            <td class="text-center"><?php echo "eg: 陳星星" ?></td>
                                            <td class="text-center"><?php echo "eg: chengxingxing@gmail.com" ?></td>
                                            <td class="text-center"><?php echo "eg: 83476948" ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><?php echo "eg: tea0002" ?></td>
                                            <td class="text-center"><?php echo "eg: 88888888" ?></td>
                                            <td class="text-center"><?php echo "eg: 趙達達" ?></td>
                                            <td class="text-center"><?php echo "eg: zhaodada@gmail.com" ?></td>
                                            <td class="text-center"><?php echo "eg: 83742322" ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    

                    <?php echo $this->Form->submit(__('submit'), array('class' => 'btn btn-large btn-primary')); ?>
                <?php echo $this->Form->end(); ?>

            </div><!-- /.form -->
    
        </div><!-- /#page-content .col-sm-9 -->
    </div><!-- /#page-container .row-fluid -->
</div>