<?php
	echo $this->element('menu/top_menu');
?>
<?php
	if(empty($school_detail['banner'])){
    	$avatar_random = array(1, 2, 3, 4);

    	$school_detail['banner'] = Router::url('/', true).'img/school-page/cover-1.jpg';

    }
?>
<div class="container-fluid school-landing-page school-banner height-30 p-0 bg-full" style="background-image: url(<?=$school_detail['banner']?>); ">
	<div class="container">
		<div class="row">
			<div class="col-md-3 grp-relative-school-avatar">
				<div class="school-basic">
					<div class="school-avatar">
						<?php 
							if(isset($school_detail['logo']) && !empty($school_detail['logo'])){
								echo $this->Html->image($school_detail['logo'], ['alt' => '', 'class' => "img-responsive"]);
							}else{ ?>
								<span class='default-text-avatar'><?=$school_detail['minimal_name']?></span>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container school-landing-page">
	<div class="row m-10">
		<div class="col-md-3 school-left-sidebar">
			<div class="school_name text-center">
				<p><?php echo $school_detail['name']?></p>
			</div>
		</div>

		<div class="col-md-6 school_page_middle">
			<?php echo $this->Html->image('school-page/coming-soon-'.$this->Session->read('Config.language').'.png', ['alt' => '', 'class' => "img-responsive"])?>
			<!-- <img class="img-responsive" src="./images/Coming-soon-en.png" alt="" style=""> -->
		</div>

		<div class="col-md-3 school_page_right">
			<ul class="school_detail" style="list-style: none;">
				<li class="row school_aboutus" style="margin-bottom: 3rem;">
					<div class="col-md-12">
						<h5 class="school-info-label" style="font-size: 2rem; color: #cbcbcb;"><?=__d('member', 'about_us')?></h5>
						<p class="text-about-school" style="text-align: justify; overflow-wrap: break-word;">
							<?php echo $school_detail['about_us']; ?>
						</p>
					</div>
				</li>
				<li class="row school_phone" style="margin-bottom: 0.5rem;">
					<div class="col-md-2 col-xs-2 icon_left" style="padding: 0 10px;">
						<?php echo $this->Html->image('school-page/phone.png', ['alt' => '', 'class' => "school-info-label img-responsive"])?>
					</div>
					<div class="col-md-10 col-xs-10">
						<p><?php echo $school_detail['phone_number']; ?></p>
					</div>
				</li>
				<li class="row school_email" style="margin-bottom: 0.5rem;">
					<div class="col-md-2 col-xs-2 icon_left" style="padding: 0 10px;">
						<?php echo $this->Html->image('school-page/email.png', ['alt' => '', 'class' => "school-info-label img-responsive"])?>
					</div>
					<div class="col-md-10 col-xs-10">
						<p><?php echo $school_detail['email']; ?></p>
					</div>
				</li>
				<li class="row school_address" style="margin-bottom: 0rem;">
					<div class="col-md-2 col-xs-2 icon_left" style="padding: 0 10px;">
						<?php echo $this->Html->image('school-page/location.png', ['alt' => '', 'class' => "school-info-label img-responsive"])?>
					</div>
					<div class="col-md-10 col-xs-10">
						<p><?php echo $school_detail['address']; ?></p>
					</div>
				</li>
			</ul>
		</div>
	</div>			
</div>