<?= $this->element('menu/top_menu') ?>
<?= $this->element('school_common/top_menu') ?>
<div class="school-left-sidebar">
	<?= $this->element('school_common/left_sidebar') ?>
</div>
<div class="school-content">
	<div class="school-landing-page">
		<div class="row m-10">
			<div class="col-md-8">
				<div class="row m-0">
					<div class="col-md-12 p-0">
						<div class="row m-0 create-post text-editor">
							<div class="col-md-12 post-preview">
								<div class="row m-0">
									<div class="col-md-1 col-xs-2 group-img-radius">
										<div class="box-img">
											<span class="default-text-avatar">HT</span>
										</div>
									</div>
									<div class="col-md-11 col-xs-10 a4l-contenteditable">
										<div id="post-preview" class="contenteditable"></div>
									</div>
								</div>
							</div>
							<div class="col-md-12 media-preview">
								<ul class="lst-preview-media list-style-none p-0 m-0">
									<li class="item hidden" id="item-preview-media">
										
									</li>
								</ul>
							</div>
							<div class="col-md-12 post-creator">
								<ul class="list-style-none p-0 m-0 list-addon flex-self-start">
									<li class="item text-green pointer" onclick="SCHOOL_LANDING.trigger_upload_post_image()">
										<i class="fa fa-picture-o text-green" aria-hidden="true"></i>
										<?=__d('school', 'image')?>
									</li>
									<input type="file" class="hidden" name="post-image" id="upload-post-image" onchange="SCHOOL_LANDING.upload_post_image(event)">
									<li class="item text-green pointer" data-toggle="modal" data-target="#modal-upload-video" data-backdrop="static">
										<i class="fa fa-video-camera text-green" aria-hidden="true"></i>
										<?=__d('school', 'video')?>
									</li>
									<li class="item text-green pointer" data-toggle="modal" data-target="#modal-insert-link" data-backdrop="static">
										<i class="fa fa-link text-green" aria-hidden="true"></i>
										<?=__d('school', 'link')?>
									</li>
									<li class="item text-grey ml-auto">
										<?=__d('school', 'save_draft')?>
									</li>
									<li class="item">
										<!-- data-toggle="popover" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?" data-placement="bottom" data-container="body" -->
										<button class="btn btn-w-radius btn-green-o" id="post_privacy_toggle"><?=__d('school', 'publish')?> <i class="fa fa-chevron-down" aria-hidden="true"></i></button>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<?php echo $this->Html->image('school-page/coming-soon-'.$this->Session->read('Config.language').'.png', ['alt' => '', 'class' => "img-responsive"])?>
			</div>


			<div class="col-md-3 school_page_right">
				<div class="row m-10">
					<ul class="school_detail list-style-none p-0 ">
						<li class="row" style="margin-bottom: 2rem;">
							<div class="col-md-12 p-0">
								<p class="text-grey">
									<?=__d('member', 'about_us')?>
									<?php if(!empty($school_detail['about_us'])){ ?>
										<span class="text-green pull-right pointer" data-toggle="modal" data-target="#modal-school-edit" data-backdrop="static"><?=__d('member', 'edit')?></span>
									<?php } ?>
								</p>
							</div>
							<?php if(empty($school_detail['about_us']) && $allow_edit_school_info){ ?>
								<div class="row m-0 flex-center group-textarea">
									<p class="text-center"><?=__d('member', 'let_everyone_know_more_about_your_school')?></p>
									<p class="text-green pointer" data-toggle="modal" data-target="#modal-school-edit" data-backdrop="static">
										<i class="fa fa-pencil"></i>
										<?=__d('member', 'edit_introduction')?>
									</p>
									
									
								</div>
							<?php }else if($allow_edit_school_info){ ?>
								<p class="text-green pointer" data-toggle="modal" data-target="#modal-school-edit" data-backdrop="static"><?=__d('member', 'add_email')?></p>
							<?php } ?>
					</li>
					<li class="row school_address" style="margin-bottom: 0rem;">
						<div class="col-md-2 col-xs-2 p-0 icon_left" style="padding: 0 10px;">
							<?php echo $this->Html->image('school-page/location.png', ['alt' => '', 'class' => "school-info-label img-responsive"])?>
						</div>
						<div class="col-md-10 col-xs-10 p-0">
							<?php if(!empty($school_detail['address'])){ ?>
								<p class="original-text">
									<?php echo $school_detail['address']; ?>
									<?php if($allow_edit_school_info){ ?>
										<span class="text-green pull-right pointer" data-toggle="modal" data-target="#modal-school-edit" data-backdrop="static"><?=__d('member', 'edit')?></span>
									<?php } ?>
								</p>
							<?php } ?>
						</li>
						<li class="row school_phone" style="margin-bottom: 0.5rem;">
							<div class="col-md-2 col-xs-2 p-0 icon_left" style="padding: 0 10px;">
								<?php echo $this->Html->image('school-page/phone.png', ['alt' => '', 'class' => "school-info-label img-responsive"])?>
							</div>
							<div class="col-md-10 col-xs-10 p-0">
								<?php if(!empty($school_detail['phone_number'])){ ?>
									<p>
										<?php echo $school_detail['phone_number']; ?>
										<?php if($allow_edit_school_info){ ?>
											<span class="text-green pull-right pointer" data-toggle="modal" data-target="#modal-school-edit" data-backdrop="static"><?=__d('member', 'edit')?></span>
										<?php } ?>
									</p>
								<?php }else if($allow_edit_school_info){ ?>
									<p class="text-green pointer" data-toggle="modal" data-target="#modal-school-edit" data-backdrop="static"><?=__d('member', 'add_phone')?></p>
								<?php } ?>
							</div>
						</li>
						<li class="row school_email" style="margin-bottom: 0.5rem;">
							<div class="col-md-2 col-xs-2 p-0 icon_left" style="padding: 0 10px;">
								<?php echo $this->Html->image('school-page/email.png', ['alt' => '', 'class' => "school-info-label img-responsive"])?>
							</div>
							<div class="col-md-10 col-xs-10 p-0">
								<?php if(!empty($school_detail['email'])){ ?>
									<p>
										<?php echo $school_detail['email']; ?>
										<?php if($allow_edit_school_info){ ?>
											<span class="text-green pull-right pointer" data-toggle="modal" data-target="#modal-school-edit" data-backdrop="static"><?=__d('member', 'edit')?></span>
										<?php } ?>
									</p>
								<?php }else if($allow_edit_school_info){ ?>
									<p class="text-green pointer" data-toggle="modal" data-target="#modal-school-edit" data-backdrop="static"><?=__d('member', 'add_email')?></p>
								<?php } ?>
								
							</div>
						</li>
						<li class="row school_address" style="margin-bottom: 0rem;">
							<div class="col-md-2 col-xs-2 p-0 icon_left" style="padding: 0 10px;">
								<?php echo $this->Html->image('school-page/location.png', ['alt' => '', 'class' => "school-info-label img-responsive"])?>
							</div>
							<div class="col-md-10 col-xs-10 p-0">
								<?php if(!empty($school_detail['address'])){ ?>
									<p>
										<?php echo $school_detail['address']; ?>
										<?php if($allow_edit_school_info){ ?>
											<span class="text-green pull-right pointer" data-toggle="modal" data-target="#modal-school-edit" data-backdrop="static"><?=__d('member', 'edit')?></span>
										<?php } ?>
									</p>
								<?php }else if($allow_edit_school_info){ ?>
									<p class="text-green pointer" data-toggle="modal" data-target="#modal-school-edit" data-backdrop="static"><?=__d('member', 'add_address')?></p>
								<?php } ?>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal insert link -->
<div class="modal a4l-modal modal-success " id="modal-insert-link" tabindex="-1" role="dialog" aria-labelledby="insert-link-label">
	<div class="modal-dialog modal-md" role="document">
		<form class="modal-content" id="form-inser-link" onsubmit="SCHOOL_LANDING.insert_link(event)">
			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h3 id="insert-link-label"><?=__d('school', 'insert_a_link')?></h3>
		     </div>
			<div class="modal-body teacher-create-lesson grey-text">
				<div class="row m-0 ">
					<div class="col-md-12 p-0 input-w-icon-t form-group">
						<input type="text" name="link" id="link"  class="form-control a4l-input m-0" placeholder="<?=__d('school', 'link_here')?>" required>
						<span class="icon fa fa-link"></span>
					</div>
					<div class="col-md-12 p-0 input-w-icon-t form-group ">
						<input type="text" name="text-display" id="text-display"  class="form-control a4l-input m-0" placeholder="<?=__d('school', 'text_to_display')?>" required>
						<span class="icon fa fa-font"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row m-0 flex-end">
				  	<button class="btn btn-w-radius btn-green" type="submit" ><?=__d('member', 'insert')?></button>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- Modal insert link -->

<!-- Modal upload video -->
<div class="modal a4l-modal modal-success " id="modal-upload-video" tabindex="-1" role="dialog" aria-labelledby="upload-video-label">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h3 id="upload-video-label"><?=__d('school', 'publish_a_video')?></h3>
		     </div>
			<div class="modal-body teacher-create-lesson grey-text">
				<div class="row m-0 grb-dropfile">
					<div class="col-md-12 p-0 text-right text-grey">
						<a href="javascript:void(0)" data-toggle="tooltip" title="<?=Environment::read('allow_file_video_upload')?>" class="text-green">
							<?=__d('member', 'supported_file')?> <i class="fa fa-question-circle" aria-hidden="true"></i>
						</a>
					</div>
					<div class="col-md-12 p-0 import-file-area pointer" id="import-post-video" style="height: 40vh;">
						<p class="text-grey-light"><span class="fa fa-cloud-upload"></span><?=__d('member', 'upload_file_or_drag_it_here')?></p>
						<p class="text-grey-light">(<?=sprintf( __d('member', 'upload_max_size_file'), '15MB')?>)</p>
					</div>
					<input type="file" class="hidden" id="upload-post-video" accept="<?=Environment::read('allow_file_video_upload')?>"/>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal upload video -->

<!-- Modal video config -->
<div class="modal a4l-modal modal-success " id="modal-config-video" tabindex="-1" role="dialog" aria-labelledby="config-video-label">
	<div class="modal-dialog modal-lg" role="document">
		<form class="modal-content form-w-validator" id="form-create-post-w-video" onsubmit="SCHOOL_LANDING.create_post(event)">
			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <div class="flex-start align-item-center">
		        	<h3 id="config-video-label"><?=__d('school', 'publish_a_video')?></h3>
		        	<div class="flex-start">
		        		<i class="fa fa-file-video-o" aria-hidden="true"></i>
		        		<p class="d-flex flex-collumn">
		        			<span id="post-video-name"></span>
		        			<span id="post-video-size"></span>
		        		</p>
		        	</div>
		        </div>
		        
		     </div>
			<div class="modal-body teacher-create-lesson grey-text">
				<div class="row mbt-10">
					<label class="text-dark-liver"><?=__d('school', 'detail')?></label>
				</div>
				<div class="row mbt-15">
					<div class="col-md-12 p-0 input-w-floating-label pointer" >
						<input class="form-control input a4l-input m-0" id="video_title" name="video_title" id="video_title" required  />
						<span class="normal-weight"><?=__d('school', 'video_title')?></span>
					</div>
				</div>
				<div class="row mbt-15">
					<div class="col-md-12 p-0 input-w-floating-label pointer">
						<textarea class="form-control input m-0" rows="4" id="post_description" name="post_description" id="post_description"></textarea>
						<span class="normal-weight"><?=__d('school', 'what_is_your_video_about')?></span>
					</div>
				</div>

				<div class="row m-0">
					<label class="text-dark-liver"><?=__d('school', 'video_cover')?></label>
				</div>
				<div class="row m-0 grb-dropfile" id="grb-dropfile-video-cover">
					<div class="col-md-12 p-0 text-grey">
						<p class="text-grey"><?= sprintf(__d('school', 'file_upload_hint'), '16:9', __d('school', 'image'), '5MB')?></p>
					</div>
					<div class="col-md-10 col-xs-10 p-0 import-file-area pointer" id="import-video-cover">
						<p class="text-grey-light"><span class="fa fa-cloud-upload"></span><?=__d('member', 'upload_file_or_drag_it_here')?></p>
						<p class="text-grey-light">(<?=sprintf( __d('member', 'upload_max_size_file'), '15MB')?>)</p>
					</div>
					<input type="file" class="hidden" id="upload-video-cover" accept="<?=implode(', ', Environment::read('allow_file_upload'))?>" multiple/>
				</div>
				<div class="row m-0 preview-image hidden">
					<div class="item" id="preview-video-cover"></div>
				</div>
				<div class="row mbt-15">
					<label class="text-dark-liver"><?=__d('school', 'privacy')?></label>
					<div class="col-md-12 p-0 grp-radio">
						<input type="radio" required name="post_privacy" id="post_privacy-public" value="public">
						<label class="normal-weight" for="post_privacy-public"> <?=__d('school', 'public')?> </label>

						<input type="radio" required name="post_privacy" id="post_privacy-school_member" value="school_member">
						<label class="normal-weight" for="post_privacy-school_member"> <?=__d('school', 'school_member')?> </label>
					</div>
				</div>
				<div class="row mbt-15">
					<label class="text-dark-liver"><?=__d('school', 'price')?></label>
					<div class="col-md-12 p-0 grp-radio">
						<input type="radio" required name="video_price" id="video_price-free" value="free">
						<label class="normal-weight" for="video_price-free"> <?=__d('school', 'free')?> </label>

						<input type="radio" required name="video_price" id="video_price-paid" value="paid">
						<label class="normal-weight" for="video_price-paid"> <?=__d('school', 'paid')?> </label>
					</div>
				</div>
				<div class="row mbt-15 hidden" id="grb-input-video-credits">
					<label class="text-dark-liver"><?=__d('school', 'charge')?></label>
					<div class="col-md-12 p-0">
						<div class="row m-0 d-flex flex-start align-item-center">
							<div class="col-xs-3 p-0 mr-10">
								<input class="form-control input a4l-input m-0  text-center" id="video_credits" name="video_tokens"  />
							</div>
							<label class="normal-weight text-grey"><?=__d('school', 'credits')?></label>
						</div>
					</div>
					
				</div>
			</div>
			<div class="modal-footer">
				<div class="row m-0 flex-end">
				  	<button class="btn btn-w-radius btn-green" type="submit" id="submit-create-post-w-video" disabled><?=__d('member', 'publish')?></button>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- Modal video config -->

<?php
	echo $this->Html->script('pages/school/school_landing.js?v='.date('U'));
?>
<script type="text/javascript">
	$(document).ready(function() {
		SCHOOL_LANDING.init_page();
	});
</script>