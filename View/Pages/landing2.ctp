


<div class="pull-right"> 
<!--
	<img src="img/topbar/icon/search.png" alt="Search" class="navigate-bar" />
-->
	<img src="img/topbar/icon/schedule.png" alt="Schedule" class="navigate-bar"/>
	<img src="img/topbar/icon/notice.png" alt="Notice" class="navigate-bar"/>
	<button style="border-radius: 45px 45px 45px 45px;
    -moz-border-radius: 45px 45px 45px 45px;
    -webkit-border-radius: 45px 45px 45px 45px;
    border: 2px solid #165c30; padding-right: 30px; background: url(/img/temp_/logged_in_icon.png) no-repeat scroll 7px 7px; padding-right: 45px;
    padding-top: 10px;
    background: url(/img/temp_/logged_in_icon.png) no-repeat scroll 7px 7px;
    background-position: 90%;
    background-size: 31px;" onclick="document.getElementById('login').style.display='block'" class="btn btn-large">
 
		登入
		<?php
			// echo $this->Html->link(
			// 	'Login',
			// 	array( 'controller' => 'pages', 'action' => 'student_portal', 'admin' => false ),
			// 	array('escape' => false)
			// );
		?>
	</button>
	
</div>
<!--
<div class="green"> 4月20日 (一) 上午 4:29 </div>
-->
<div class="row">
	<div class="col-sd-8 col-md-12 ">
		<div class="center" style="margin-top: 20px">
		<!-- remarked by Kelvin for urgent amendment -->
		<!--
			<iframe width="560" height="315"
				src="https://www.youtube.com/embed/2mO0Hc7sMVU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
			</iframe>
		-->
		<iframe src="https://player.vimeo.com/video/406276436" width="640" height="400" frameborder="0" allow="autoplay; fullscreen" allowfullscreen>
		</iframe>
		</div>
	</div>
</div>


<div class="row">
	<div class="second-text"> 推薦影片 </div>
</div>

<div class="row third box">
	<div class="col-sm-3 col-md-3">
		<div class="video">
		<iframe src="https://player.vimeo.com/video/406276436" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
			<!-- remarked by Kelvin for urgent amendment -->
			<!-- <iframe src="https://www.youtube.com/embed/2mO0Hc7sMVU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
		</div>

		<div class="row video-content">
			<div class="col-md-2">
				<span class='avatar'></span>
			</div>
			<div class="col-md-10">
				<div class='title'> 全民學習 勞校長講話 </div>
				<div class='view'> 28位同學已觀看．1日前</div>
			
			</div>
		</div>

	</div>
	<div class="col-sm-3 col-md-3">
		<div class="video">
		<iframe src="https://player.vimeo.com/video/406276606" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
		</div>

		<div class="row video-content">
			<div class="col-md-2">
				<span class='avatar'></span>
			</div>
			<div class="col-md-10">
				<div class='title'> 全民學習 高永民醫生講話 </div>
				<div class='view'> 128位同學已觀看．2日前</div>
			
			</div>
		</div>
	</div>
</div>

  <div id="login" class="w3-modal">
    <div class="w3-modal-content " style="padding-top: 30px; max-width:450px; min-height: 450px">

      <div class="pull-right" style="margin-top: -30px; margin-right: 30px"><br>
        <span onclick="document.getElementById('login').style.display='none'" class="" title="Close Modal" style="cursor: pointer; color: #c6c6c6; font-size:2.5em;">&times;</span>
      </div>

			
		<div class="center">
<!-- remarked by Kelvin for urgent amendment -->
			
	<div id="kl_loginDIV">
	<center>
	<img src="img/temp_/all-4-learn-logo-bilingual-colour.png"
	     srcset="img/all-4-learn-logo-bilingual-colour@2x.png 2x,
	             img/all-4-learn-logo-bilingual-colour@3x.png 3x"
	     class="kl_all4learn-logo-bilingual-colour">
	 </center>

	<form>
		<div class="kl_form-item">
			<input id="kl_login_id" class="kl_input-field" type="text" placeholder="輸入帳戶名稱" />
	    
	  </div>
	  <div class="kl_form-item">
	    <input id="kl_password" class="kl_input-field" type="password" placeholder="輸入密碼" />
	  </div>
	  <div class="kl_form-item">
	  	<span class="kl_field-hints">請提供學校編號 (如有)</span>
	  	
	    <input id="kl_school_code" class="kl_input-field" type="text" placeholder="" />
	    
	  </div>
	  <div class="kl_form-item">
	  	<a href="/student_portal">
	    	<input id="kl_submit_button" class=="kl_ssubmit_button kl_input-field" type="sumbit" value="登入"/>
	    </a>
			<span class="kl_school_code_hints">沒有帳戶名稱及密碼？請聯絡貴校校務處</span>
	  </div>
	</form>	
	
	
	
	
	
	</div>
					
<!--
			<img src="img/temp_/all4learn.png" alt="LEARN"  style="margin-bottom: 30px; width: 50%;" />
		</div>
		<div class="row" style="padding-bottom: 20px">


			<div class="col-xs-2 col-md-2">	</div>
			<div class="col-xs-3 col-md-3">	<label><b>帳戶</b></label></div>
			
			<div class="col-xs-5 col-md-5">	
				<input class="form-control" type="text" placeholder="進入帳戶名稱" name="user_name" required>
			</div>
			<div class="col-xs-2 col-md-2">	</div>
		</div>

		<div class="row" style="padding-bottom: 20px">
			<div class="col-xs-2 col-md-2">	</div>
			<div class="col-xs-3 col-md-3">	<label><b>密碼</b></label></div>
			
			<div class="col-xs-5 col-md-5">	
				<input class="form-control" type="password" placeholder="密碼" name="password" required>
			</div>
			<div class="col-xs-2 col-md-2">	</div>
		</div>
			
		<div class="row" style="padding-bottom: 20px">
			<div class="col-xs-2 col-md-2">	</div>
			<div class="col-xs-3 col-md-3">	<label><b>學校編號</b></label></div>
			
			<div class="col-xs-5 col-md-5">	
				<input class="form-control" type="text" placeholder="學校編號" name="school_code">
	
			</div>
			<div class="col-xs-2 col-md-2">	</div>
		</div>

		<div class="center" style="margin-bottom: 30px">
			<div class="btn btn-success"  style = 'color: white; border-radius: 30px !important; width: 200px;'>
			
				<?php
					echo $this->Html->link(
						'登入',
							array('controller' => 'pages', 'action' => 'student_portal', 'admin' => false),
							array(
								'style' => 'color: white;',
								'escape' => false
							)
						);
				?>
			</div>
		</div>
-->
    </div>
  </div>
  
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>

<script type="text/javascript" src="js/jquery.fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js"></script>

