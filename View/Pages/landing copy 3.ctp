


<div class="pull-right"> 
	<img src="img/Topbar/Icon/Search.png" alt="Search" class="navigate-bar" />
	<img src="img/Topbar/Icon/Schedule.png" alt="Schedule" class="navigate-bar"/>
	<img src="img/Topbar/Icon/Notice.png" alt="Notice" class="navigate-bar"/>
	<button onclick="document.getElementById('id01').style.display='block'" class="btn btn-large">Login</button>
	
</div>

<div class="green"> 4月20日 (一) 上午 4:29 </div>

<h1> use您好，陳大文！今天您有 4 堂課 </h1>
<div class="row">
	<?php
		echo $this->Html->link(
			'<div class="col-md-2 round-border item-active">
			<!-- <img src="img/menu.png" alt="no img" /> -->
			
			<span class="header-image">  </span> 
			<h3 class="header"> 中文 </h3> 
			<div class="body">
			<div class="text">
				<img src="img/Lesson-Card/Overrides/Icon/Tutor-white.png" alt="Tutor-white" class="landing-tutor-icon"/> 郭老師
			</div>
			<div class="text">
				<img src="img/Lesson-Card/Overrides/Icon/Time-white.png" alt="Time-white" class="landing-time-icon"/>  09:30 - 10:30 
			</div>
			</div>
			<div class="pull-right">
				進入教室 >
			</div>
		</div>',
			array( 'controller' => 'pages', 'action' => 'login', 'admin' => false ),
			array('escape' => false)
		);
	?>

	<div class="col-md-2 child-round-border">
		<!-- <img src="img/menu.png" alt="no img" /> -->
		
		<span class="header-image">  </span> 
		<h3 class="header"> 中文 </h3> 
		<div class="body">
			<div class="text">
				<img src="img/Lesson-Card/Overrides/Icon/Tutor-grey.png" alt="Tutor-grey" class="landing-tutor-icon"/> 郭老師
			</div>
			<div class="text">
				<img src="img/Lesson-Card/Overrides/Icon/Time-grey.png" alt="Time-grey" class="landing-time-icon"/>  09:30 - 10:30 
			</div>
		</div>
		<div class="pull-right">
			6小時16分後 上課
		</div>
	</div>

	<div class="col-md-2 child-round-border">
		<!-- <img src="img/menu.png" alt="no img" /> -->
		
		<span class="header-image">  </span> 
		<h3 class="header"> 中文 </h3> 
		<div class="body">
			<div class="text">
				<img src="img/Lesson-Card/Overrides/Icon/Tutor-grey.png" alt="Tutor-grey" class="landing-tutor-icon"/> 郭老師
			</div>
			<div class="text">
				<img src="img/Lesson-Card/Overrides/Icon/Time-grey.png" alt="Time-grey" class="landing-time-icon"/>  09:30 - 10:30 
			</div>
		</div>
		<div class="pull-right">
			6小時16分後 上課
		</div>
	</div>

	<div class="col-md-2 child-round-border">
		<!-- <img src="img/menu.png" alt="no img" /> -->
		
		<span class="header-image">  </span> 
		<h3 class="header"> 中文 </h3> 
		<div class="body">
			<div class="text">
				<img src="img/Lesson-Card/Overrides/Icon/Tutor-grey.png" alt="Tutor-grey" class="landing-tutor-icon"/> 郭老師
			</div>
			<div class="text">
				<img src="img/Lesson-Card/Overrides/Icon/Time-grey.png" alt="Time-grey" class="landing-time-icon"/>  09:30 - 10:30 
			</div>
		</div>
		<div class="pull-right">
			6小時16分後 上課
		</div>
	</div>
</div>

<div class="row" style="margin-top: 30px">
	<div class="col-md-3">
		<img src="img/Lesson-card/live.png" alt="Live" style="width:20%" />
	
		30人正在上課...
	</div>
</div>

<div class="row">
	<div class="second-text"> 還沒完成的課程 (7) </div>
</div>

<div class="row third">
	<div class="col-md-3">
		<div class="video">
			<iframe src="https://www.youtube.com/embed/qMPXZhqXHrM" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>

		<div class="row video-content">
			<div class="col-md-2">
				<span class='avatar'></span>
			</div>
			<div class="col-md-10">
				<div class='title'> 美術第5課 - 跟Ms Chung一齊畫TOTORO</div>
				<div class='view'> 28位同學已觀看．1日前</div>
			
			</div>
		</div>

	</div>
	
</div>
<!-- 
<div id="id01" class="w3-modal">
  <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

	<div class="w3-center"><br>
	  <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
	  <img src="img_avatar4.png" alt="Avatar" style="width:30%" class="w3-circle w3-margin-top">
	</div>

	<form class="w3-container" action="">
	  <div class="w3-section">
		<label><b>Username</b></label>
		<input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Username" name="usrname" required>
		<label><b>Password</b></label>
		<input class="w3-input w3-border" type="password" placeholder="Enter Password" name="psw" required>
		<button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">Login</button>
		<input class="w3-check w3-margin-top" type="checkbox" checked="checked"> Remember me
	  </div>
	</form>

	<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
	  <button onclick="document.getElementById('id01').style.display='none'" type="button" class="w3-button w3-red">Cancel</button>
	  <span class="w3-right w3-padding w3-hide-small">Forgot <a href="#">password?</a></span>
	</div>

  </div>
</div>
</div> -->