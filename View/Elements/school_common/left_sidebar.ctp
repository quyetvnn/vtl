<?php
	$params = $this->request->params;
	$dashboard_active = '';
    $teacher_active = '';
    $class_active = '';
    switch ( $params['action']) {
    	case 'landing':
    		$dashboard_active = 'active';
    		break;
    	case 'teachers':
    		$teacher_active = 'active';
    		break;
    	case 'classes':
    		$class_active = 'active';
    		break;
    	default:
    		$dashboard_active = 'active';
    		break;
    }
?>
<div class="bounding">
	<div class="grp-relative-school-avatar">
		<div class="school-basic">
			<div class="school-avatar">
				<?php 
					if(isset($school_detail['logo']) && !empty($school_detail['logo'])){
						echo $this->Html->image($school_detail['logo'], ['alt' => '', 'class' => "img-responsive"]);
					}else{ ?>
						<span class='default-text-avatar'><?=$school_detail['minimal_name']?></span>
				<?php } ?>
                <?php if($allow_edit_school_info){ ?>
    				<div class="my-upload pointer" id="trigger_update_logo">
    					<i class="fa fa-camera" aria-hidden="true"></i>
    				</div>
    				<input type="file" name="update_logo" id="update_logo" class="hidden" accept=".jpg, .jpeg, .png, .gif">
                <?php } ?>
			</div>
		</div>
	</div>
	<div class="school_name text-center">
		<p><?php echo $school_detail['name']?></p>
	</div>
	<ul class="lst-url list-style-none p-0">
        <?php foreach ($list_menu as $menu) {
                    if( in_array($menu['menu_id'], $allow_menu_id) ){
            ?>
    		<li class="item <?=$menu['link']['action']==$current_action?'active':''?>">
    			<?php
    				 echo $this->Html->link($menu['title'], $menu['link'], $menu['config']);
    			?>
    		</li>
        <?php } } ?>
	</ul>
</div>
