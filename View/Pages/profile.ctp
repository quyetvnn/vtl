<?php 
	echo $this->element('menu/top_menu');
	$show_name = '';
    $avatar = '';
    if(isset($current_user) && !empty($current_user)){
        $show_name = isset($current_user['nick_name']) && !empty($current_user['nick_name']) ? $current_user['nick_name'] : $current_user['full_name'];
        
        $avatar = isset($current_user['tmp_avatar'])?$current_user['tmp_avatar']: '';

        if(isset($current_user['avatar']) && $current_user['avatar']!=''){
            $avatar = $current_user['avatar'];
        }
        
    }
?>
<div class="row menu-mobile">
    <div class="container-fluid">
		<div class="navbar-collapse" id="bs-example-navbar-collapse-1">
	        <?=$this->element('menu/mobile_menu', array('show_name' => $show_name, 'avatar'=>$avatar))?>
	    </div>
	</div>
</div>