<?= $this->element('menu/top_menu') ?>
<?= $this->element('school_common/top_menu') ?>
<div class="school-left-sidebar">
	<?= $this->element('school_common/left_sidebar');?>
</div>
<div class="school-content">
	<div class="school-landing-page" >
		<div class="row m-10" style="padding-bottom: 100px; margin-bottom: 0;">
			<div class="col-md-11 p-0">
				<div class="row m-0 function-left">
					<div class="col-md-9 p-0">
						<button class="btn btn-w-radius btn-green-o mr-10" data-toggle="modal" data-target="#modal-create-category" data-backdrop="static">
							<i class="fa fa-plus"></i> <?=__d('member', 'create_category')?>
						</button>
						<button class="btn btn-w-radius btn-green-o mr-10" data-toggle="modal" data-target="#modal-create-group" data-backdrop="static">
							<i class="fa fa-plus"></i> <?=__d('member', 'create_group')?>
						</button>
					</div>
					<div class="col-md-3 p-0 function-right flex-end">
						<ul class="combo-icon">
							<li class="item">
								<i class="fa fa-th-large" aria-hidden="true"></i>
							</li>
							<li class="item">
								<i class="fa fa-bars" aria-hidden="true"></i>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal a4l-modal fade" id="modal-create-category" tabindex="-1" role="dialog" aria-labelledby="modal-school-application-label">
	<div class="modal-dialog modal-sm-450px" role="document">
    <div class="modal-content p-0">
		<div class="modal-header row m-0">
			<div class="col-md-8 p-0">
				<h3 class="text-dark-liver"><?=__d('member', 'create_category')?></h3>
			</div>
			
		</div>
        <div class="modal-body teacher-create-lesson">
	        <form class="row m-0 form-member form-w-validator" id="form-create-category">
	         	<input type="hidden" name="school" value="<?=$school_detail['id']?>">
	         	
	         	<div class="col-md-12 p-0 form-group">
	         		<div class="input-w-icon-t">
	         			<input type="text" name="category_name" placeholder="<?=__d('member', 'enter_category_name')?>" class="form-control a4l-input" id="category_name">
	         			<span class="icon icon-user-green"></span>
	         		</div>
	         	</div>
	         	<p class="text-dark-liver"><?=__d('member', 'category_name_sample')?></p>
	         	<div class="col-md-12 m-0 p-0">
	         		<p class="text-red error" id="create_category_error"></p>
	         	</div>
	         	<div class="col-md-12 p-0 flex-center">
		            <button type="submit" class="btn btn-w-radius btn-green" id="btn-submit-create-category" disabled><?=__d('member', 'create_category')?></button>
		            <a type="button" class="text-dark-liver mt-10" data-dismiss="modal" aria-label="Close">
		            	<?=__('close')?>
		            </a>
		        </div>
	        </form>
        </div>
    </div>
  </div>
</div>

<div class="modal a4l-modal fade" id="modal-create-group" role="dialog" aria-labelledby="modal-school-application-label">
	<div class="modal-dialog modal-sm-450px" role="document">
    <div class="modal-content p-0">
		<div class="modal-header row m-0">
			<div class="col-md-8 p-0">
				<h3 class="text-dark-liver"><?=__d('member', 'create_group')?></h3>
			</div>
			
		</div>
        <div class="modal-body teacher-create-lesson">
	        <form class="row m-0 form-member form-w-validator" id="form-create-group">
	         	<input type="hidden" name="school" value="<?=$school_detail['id']?>">
	         	<div class="col-md-12 p-0 form-group">
	         		<div class="input-w-icon-t">
	         			<input type="text" name="group_name" placeholder="<?=__d('member', 'enter_group_name')?>" class="form-control a4l-input" id="group_name">
	         			<span class="icon icon-user-green"></span>
	         		</div>
	         	</div>

	         	<div class="col-md-12 p-0 form-group ">
	         		<div class="input-w-icon-t a4l-input a4l-select2">
	         			<select class="form-control " id="select-a4l-category" name="member_roles" placeholder="<?=__d('member', 'enter_group_name')?>" required></select>
						<span class="icon icon-role"></span> 
	         		</div>
	         	</div>

	         	<div class="col-md-12 m-0 p-0">
	         		<p class="text-red error" id="create_group_error"></p>
	         	</div>
	         	<div class="col-md-12 p-0 flex-center">
		            <button type="submit" class="btn btn-w-radius btn-green" id="btn-submit-create-group" disabled><?=__d('member', 'create_group')?></button>
		            <a type="button" class="text-dark-liver mt-10" data-dismiss="modal" aria-label="Close">
		            	<?=__('close')?>
		            </a>
		        </div>
	        </form>
        </div>
    </div>
  </div>
</div>
<?php
	echo $this->Html->script('pages/school/category.js?v='.date('U'));
	echo $this->Html->script('pages/school/group.js?v='.date('U'));
?>
<script type="text/javascript">
	$(document).ready(function() {
		SCHOOL_CATEGORY.init_page("<?=Router::url('/', true)?>");
		SCHOOL_GROUP.init_page();
	});
</script>
