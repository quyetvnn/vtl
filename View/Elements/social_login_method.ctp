<ul class="social_login_method">
    <li class="item pointer" onclick="COMMON.fb_login()">
        <strong class="fa fa-facebook" style="font-size: 1.75em;" aria-hidden="true"></strong>
    </li>
    <!-- <li class="item pointer">
        <a href="<?=$login_gg_url?>" class="text-dark-liver">
            <strong class="fa fa-google" style="font-size: 1.75em;" aria-hidden="true"></strong>
        </a>
    </li> -->
    <!-- <strong class="fa fa-google" id="element_gg_signin" style="font-size: 1.75em; display: none;" aria-hidden="true"></strong> -->
</ul>
<?php
    $state = 'fb_redirect_infomation';
    if(isset($request->query) && !empty($request->query)){
        $state = json_encode($request->query);

    }
?>
<form class="hidden" id="login_fb_form" method="GET" action="https://www.facebook.com/v7.0/dialog/oauth">
	<input type="hidden" name="client_id" value="<?=Environment::read('fb_app.client_id')?>">
	<input type="hidden" name="redirect_uri" value="<?=Router::url('/', true)?>fb_login_redirect">
	<input type="hidden" name="response_type" value="code">
    <input type="hidden" name="scope" value="email,public_profile">
    <input type="hidden" name="profile_fields" value="id,name,email,first_name,last_name,profile_pic">
    <input type="hidden" name="auth_type" value="rerequest">
	<input type="hidden" name="state" value='<?=$state?>'>
</form>