<style>
	.error-message 
	{
		color: red;
	}
</style>
<div class="row">
    <div class="col-xs-12 col-xs-offset-0">
		<div class="box box-primary">
			<div class="box-header">
			    <h3 class="box-title"><?php echo __d('administration','edit_administrator'); ?></h3>
			</div>
			<div class="box-body">
			    <?php echo $this->Form->create('Administrator', array('role' => 'form')); ?>
                    <fieldset>
                        <?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php 
                                        echo $this->Form->input('Role.roles', array(
                                            'class' => 'form-control',
                                            'type' => 'select',
                                            'multiple' => 'checkbox',
                                            'options' => $roles,
                                            'value'=> $current_roles,
                                            'required' => 'required',
                                            'label' => '<font color="red">*</font>'.__d('administration','role'),
                                        ));
                                    ?>	
                                </div>
                            </div> <!-- end col-md-3 -->
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php if(isset($is_admin) && $is_admin){ ?>
                                        <div class="form-group">
                                            <?php 
                                                $company_ddl = array(
                                                    'class' => 'form-control selectpicker',
                                                    'data-live-search' => true,
                                                    'id' => 'company_id',
                                                    'label' => __d('administration','company'),
                                                    'required' => 'false',
                                                );

                                                if (isset($is_admin) && $is_admin == true)   {
                                                    $company_ddl['empty'] = __('please_select');
                                                }
                                                echo $this->Form->input('school_id', $company_ddl);
                                            ?>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group">
                                            <label for="selectpicker_company"><?= '<font color="red">*</font>'.__d('coupon','company'); ?></label>
                                            <input class="form-control" type="text" readonly="readonly" value="<?= isset($companies[$company_selected]) ? $companies[$company_selected]: "" ?>" />
                                            <?= $this->Form->input('company_id', array(
                                                    'type' => 'hidden',
                                                    'value' => $company_selected
                                                )); ?>
                                        </div>
                                    <?php }  ?>
                                </div>	
                            </div>
                         
                        </div>
                        <div class="form-group">
                            <?php echo $this->Form->input('name', array(
                                'class' => 'form-control',
                                'label' => __d('administration','name'),
                                'required' => 'required',
                                'label' => '<font color="red">*</font>'  . __d('administration','name')
                            )); ?>
                        </div><!-- .form-group -->

                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('email', array(
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'placeholder' => 'e.g. admin@'.Environment::read('company.email_domain'),
                                    'label' => '<font color="red">*</font>'  . __d('administration','email')
                                )); 
                            ?>
                        </div><!-- .form-group -->

                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('phone', array(
                                    'class' => 'form-control',
                                    'id' => 'txt_phone',
                                    'required' => 'required',
                                    'label' => '<font color="red">*</font>'  . __d('administration','phone'),
                                    'placeholder' => 'e.g. 34666778',
                                )); 
                            ?>
                        </div><!-- .form-group -->

						<div class="form-group">
							<?php echo $this->Form->input('enabled', array('class' => 'form-control', 'label' => __('enabled'))); ?>
                        </div>

                        <div class="pull-right">
                            <?php echo $this->Form->submit(__('submit'), array(
                                'id' => 'checkBtn',
                                'class' => 'btn btn-large btn-primary')); ?>
                        </div>
                    </fieldset>
                <?php echo $this->Form->end(); ?>
			</div>
		</div><!-- /.form -->
	</div><!-- /#page-content .col-sm-9 -->
</div><!-- /#page-container .row-fluid -->
<?php
	echo $this->Html->script('CakeAdminLTE/pages/admin_administrator', array('inline' => false));
?>
<script type="text/javascript">
	$(document).ready(function(){
        COMMON.init_element_number($('#txt_phone'));
		ADMIN_ADMINISTRATOR.url_get_brand_data = '<?= Router::url(array('plugin' => 'company', 'controller' => 'brands', 'action' => 'data_select')); ?>';
		// ADMIN_ADMINISTRATOR.init_select_brand($("#company_id"), $("#brand_id"));
 	});
</script>