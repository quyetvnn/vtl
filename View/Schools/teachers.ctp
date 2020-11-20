<?= $this->element('menu/top_menu') ?>
<?= $this->element('school_common/top_menu') ?>
<div class="school-left-sidebar">
	<?= $this->element('school_common/left_sidebar');?>
</div>
<div class="school-content">
	<div class="school-landing-page" >
		<div class="row m-10" style="padding-bottom: 100px; margin-bottom: 0;">
			<div class="col-md-11 p-0">
				
				<div class="row m-0 teacher-addon">
					<div class="col-md-9 p-0">
						<?php
								
							echo $this->Form->create('School', array(
								'url' => array('plugin' => '', 'controller' => 'schools', 'action' => 'teachers', $school_detail['school_code']),
								'class' => 'form_filter hidden',
								'id' => "form_export_teacher",
								'type' => 'get',
							));
					
								
							echo $this->Form->input(__d('member', 'export_teacher'), array(
								'div' => false,
								'label' => false,
								'type' => 'submit',
								'name' => 'button_export_teacher',
								'escape' => false,
								'class' => 'btn btn-w-radius btn-green-o mr-10',
								'id' => 'submit_export_teacher'
							));      

							echo $this->Form->end();
						?>

						<?php  ?>
					</div>
				</div>

				<div class="row m-0">
					<table class="table a4l-table a4l-table-teacher" id="table_school_teachers">
						<thead>
							<tr>
								<th><?=__d('member', 'teacher_name_platform_account')?></th>
								<th><?=__d('member', 'show_name')?></th>
								<th></th>
							</tr>
						</thead>
						
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal a4l-modal fade" id="modal-teacher-info" tabindex="-1" role="dialog" aria-labelledby="modal-school-application-label">
  <div class="modal-dialog modal-sm-450px" role="document">
    <div class="modal-content p-0">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
        <div class="modal-body teacher-create-lesson">
            <center class="group-img-radius icon-school p-0">
	            <div class="box-img border-grey">
	            	<img src="" class="profile-image hidden" id="member-profile-image"/>
	              	<span class='default-text-avatar hidden' id="member-default-text-avatar"></span>
	            </div>
	            <h4 class="text-green" id="member_full_name">Han Tran</h4>
	         </center>
	         <div class="row m-0">
	         	<ul class="staff-info p-0">
	         		<li class="info-item flex-start">
	         			<span class="icon icon-tutor"></span>
	         			<p class="member_name member_roles" id="member_nick_name">
	         				<span>Han Tran</span>
	         				<span class="">管理員</span>
							<span class="">老師</span>
	         			</p>
	         		</li>
	         		<li class="info-item flex-start">
	         			<span class="icon icon-envelope-o"></span>
						<span class="text-madras" id="member_email">Sunstra.wai@gmail.com</span>
	         		</li>
	         		<li class="info-item flex-start">
	         			<span class="icon icon-class"></span>
						<span class="text-madras" id="member_class">4A、4B、5A</span>
	         		</li>
	         	</ul>
	         </div>
        </div>
        <hr class="m-0">
        <div class="modal-footer flex-center">
            <a class="text-green" href="javascript:void(0)" data-dismiss="modal" aria-label="Close" onclick="TEACHER.edit_member_school_profile()">
            	<i class="fa fa-pencil"></i>
            	<?=__('edit')?>
            </a>
        </div>
    </div>
  </div>
</div>

<div class="modal a4l-modal fade" id="modal-edit-member" tabindex="-1" role="dialog" aria-labelledby="modal-school-application-label">
  <div class="modal-dialog modal-sm-450px" role="document">
    <div class="modal-content p-0">
		<div class="modal-header row m-0">
			<div class="col-md-8 p-0">
				<h3 class="text-dark-liver">編輯老師</h3>
			</div>
			<div class="col-md-4 p-0 flex-end">
				<h3><span class="fa fa-trash text-green"></span></h3>
			</div>
			
		</div>
        <div class="modal-body teacher-create-lesson">
	        <form class="row m-0 form-member form-w-validator" id="form-edit-member">
	         	<input type="hidden" name="id" id="member_id" value="">
	         	<div class="col-md-12 p-0 form-group ">
	         		<div class="input-w-icon-t multi-select">
	         			<select class="form-control a4l-input multi-select selectpicker" id="current_roles" name="current_roles" title="<?=__('roles')?>" multiple required>
						  	<option value="<?=Environment::Read('role.teacher')?>"><?=__d('member', 'teacher_role')?></option>
						  	<option value="<?=Environment::Read('role.school-admin')?>"><?=__d('member', 'school_admin')?></option>
						</select>
						<span class="icon icon-role"></span> 
	         		</div>
	         	</div>
	         	<div class="col-md-12 p-0 form-group">
	         		<div class="input-w-icon-t">
	         			<input type="text" name="current_name" placeholder="<?=__d('member', 'name')?>" class="form-control a4l-input" id="member-name">
	         			<span class="icon icon-user-green"></span>
	         		</div>
	         	</div>
	         	<div class="col-md-12 p-0 form-group">
	         		<div class="input-w-icon-t">
	         			<input type="text" name="current_email" placeholder="<?=__d('member', 'email')?>" class="form-control a4l-input" id="member-email">
	         			<span class="icon icon-envelope-o-green-light"></span>
	         		</div>
	         	</div>
	         	<div class="col-md-12 p-0 form-group">
	         		<div class="input-w-icon-t">
	         			<input type="text" name="current_phone_number" placeholder="<?=__d('member', 'phone_number')?>" class="form-control a4l-input" id="member-phone">
	         			<span class="icon icon-mobile-green"></span>
	         		</div>
	         	</div>
	         	<div class="col-md-12 m-0 p-0">
	         		<p class="text-red error" id="edit_member_error"></p>
	         	</div>
	         	<div class="col-md-12 p-0 flex-center">
		            <button type="submit" class="btn btn-w-radius btn-green"><?=__d('member', 'save')?></button>
		            <a type="button" class="text-dark-liver mt-10" data-dismiss="modal" aria-label="Close">
		            	<?=__('close')?>
		            </a>
		        </div>
	        </form>
        </div>
    </div>
  </div>
</div>

<div class="modal a4l-modal fade" id="modal-create-member" tabindex="-1" role="dialog" aria-labelledby="modal-school-application-label">
	<div class="modal-dialog modal-sm-450px" role="document">
    <div class="modal-content p-0">
		<div class="modal-header row m-0">
			<div class="col-md-8 p-0">
				<h3 class="text-dark-liver"><?=__d('member', 'create_member')?></h3>
			</div>
			<div class="col-md-4 p-0 flex-end">
				<h3><span class="fa fa-trash text-green" onclick="TEACHER.reset_form()"></span></h3>
			</div>
			
		</div>
        <div class="modal-body teacher-create-lesson">
	        <form class="row m-0 form-member form-w-validator" id="form-create-member">
	         	<input type="hidden" name="school" value="<?=$school_detail['id']?>">
	         	<div class="col-md-12 p-0 form-group ">
	         		<div class="input-w-icon-t multi-select">
	         			<select class="form-control a4l-input multi-select selectpicker" id="dataPicker" name="member_roles" title="<?=__('roles')?>" multiple required>
						  	<option value="<?=Environment::Read('role.teacher')?>"><?=__d('member', 'teacher_role')?></option>
						  	<option value="<?=Environment::Read('role.school-admin')?>"><?=__d('member', 'school_admin')?></option>
						</select>
						<span class="icon icon-role"></span> 
	         		</div>
	         	</div>
	         	<div class="col-md-12 p-0 form-group">
	         		<div class="input-w-icon-t">
	         			<input type="text" name="member_username" placeholder="<?=__d('member', 'enter_usename')?>" class="form-control a4l-input" id="member-username">
	         			<span class="icon icon-user-green"></span>
	         		</div>
	         	</div>
	         	<div class="col-md-12 p-0 form-group">
	         		<div class="input-w-icon-t">
	         			<input type="password" name="member_password" placeholder="<?=__d('member', 'enter_password')?>" class="form-control a4l-input" id="member-password">
	         			<span class="icon icon-password-green"></span>
	         			<span class="unit pointer toggle-password" ><?php echo  __d('member', 'show')?></span>
        				<span class="unit pointer toggle-password hidden" ><?php echo  __d('member', 'hide')?></span>
	         		</div>
	         	</div>
	         	<div class="col-md-12 p-0 form-group">
	         		<div class="input-w-icon-t">
	         			<input type="text" name="member_name" placeholder="<?=__d('member', 'name')?>" class="form-control a4l-input" id="member-name">
	         			<span class="icon icon-user-green"></span>
	         		</div>
	         	</div>
	         	<div class="col-md-12 p-0 form-group">
	         		<div class="input-w-icon-t">
	         			<input type="text" name="member_email" placeholder="<?=__d('member', 'email')?>" class="form-control a4l-input" id="member-email">
	         			<span class="icon icon-envelope-o-green-light"></span>
	         		</div>
	         	</div>
	         	<div class="col-md-12 p-0 form-group">
	         		<div class="input-w-icon-t">
	         			<input type="text" name="member_phone_number" placeholder="<?=__d('member', 'phone_number')?>" class="form-control a4l-input" id="member-phone">
	         			<span class="icon icon-mobile-green"></span>
	         		</div>
	         	</div>
	         	<div class="col-md-12 m-0 p-0">
	         		<p class="text-red error" id="create_member_error"></p>
	         	</div>
	         	<div class="col-md-12 p-0 flex-center">
		            <button type="submit" class="btn btn-w-radius btn-green"><?=__d('member', 'create_member')?></button>
		            <a type="button" class="text-dark-liver mt-10" data-dismiss="modal" aria-label="Close">
		            	<?=__('close')?>
		            </a>
		        </div>
	        </form>
        </div>
    </div>
  </div>
</div>
<div class="modal a4l-modal fade" id="modal-import-member" tabindex="-1" role="dialog" aria-labelledby="modal-import-member-label">
	<div class="modal-dialog modal-sm-450px" role="document">
	    <form class="modal-content p-0" id="form-import-teacher">
	    	<input type="hidden" name="school" value="<?=$school_detail['id']?>">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
	        <div class="modal-body teacher-create-lesson">
	        	<div class="row m-0">
	        		<?php 
                        echo $this->element('files_upload',array());
                    ?>
	        	</div>
	        	<div class="row m-0">
                   	<h4> <?=__d('member', 'download_template')?> </h4>
                    <?php $path = Router::url('/', true) . 'uploads/import/All4LeARN_teacher_import.xlsx' ?>
                    <a href="<?= $path ?>" target="_blank" download="All4LeARN_teacher_import.xlsx"> 
                        <i class="fa fa-download"></i>
                    </a>
                </div>

                <div>
                    <h4> <?=__d('member', 'description')?> </h4>
                </div>
                <ul>
                    <li class="text-dark-liver"> 
                    	<?=sprintf(__d('member', 'required_inport_teacher'), 
                                    sprintf(__d('member', 'field_import'), __d('member', 'username'), 'Username'), 
                                    sprintf(__d('member', 'field_import'), __d('member', 'enter_password'), 'Password'), 
                                    sprintf(__d('member', 'field_import'), __d('member', 'last_name'), 'Last Name'), 
                                    sprintf(__d('member', 'field_import'), __d('member', 'first_name'), 'First Name'))?>
                    </li>
                    <li class="text-dark-liver"> 
                    	<?=sprintf(__d('member', 'optional_inport'), 
                                    sprintf(__d('member', 'field_import'), __d('member', 'email'), 'Email'), 
                                    sprintf(__d('member', 'field_import'), __d('member', 'phone_number'), 'Phone Number'))?>
                    </li>
                    <li class="text-dark-liver"> 
                    	<?=sprintf(__d('member', 'field_defined'), 
                                    sprintf(__d('member', 'field_import'), __d('member', 'username'), 'Username'), 
                                    __d('member', 'username_defined'))?>
                    </li>
                </ul>
	        </div>
	        
	        <div class="col-md-12">
         		<p class="text-red error" id="import_teacher_error"></p>
         	</div>
         	<hr class="col-md-12 p-0 m-0">
	        <div class="modal-footer flex-center">
	        	<button type="submit" class="btn btn-w-radius btn-green"><?=__d('member', 'import_file_teacher')?></button>
	        </div>
	    </form>
	  </div>
</div>
<?php
	echo $this->Html->script('plugins/datatables/jquery.dataTables');
	echo $this->Html->script('plugins/datatables/dataTables.bootstrap');
	echo $this->Html->script('plugins/datatables/dataTables.buttons.min');
	echo $this->Html->script('pages/school/teacher.js?v='.date('U'));
?>
<script type="text/javascript">
	$(document).ready(function() {
		TEACHER.init_page();
	});
</script>
