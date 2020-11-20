
<?php
	$params = $this->Paginator->params();

	$extra_pagintion_parameters = array();

	if( isset($this->request->data) && !empty($this->request->data) ){
		$extra_pagintion_parameters = array(
			'url' => $this->request->data
		);
	}

	$this->Paginator->options($extra_pagintion_parameters);
	
	if ($params['pageCount'] > 1) {
?>
<ul class="a4l-pagination clearfix">
			<?php
				echo $this->Paginator->prev('<i class="fa fa-long-arrow-left"></i>', 
											array('class' => 'item arrow',
													'tag' => 'li',
													'escape' => false), 
											'<a onclick="return false;"><i class="fa fa-long-arrow-left"></i></a>', 
											array('class' => 'item arrow disabled',
													'tag' => 'li',
													'escape' => false));

				echo $this->Paginator->numbers(
												array(	'separator' => '', 
														'class' => 'item ',
														'tag' => 'li', 
														'currentClass' => 'active')
											);

				echo $this->Paginator->next('<i class="fa fa-long-arrow-right"></i>', 
											array('class' => 'item arrow',
													'tag' => 'li',
													'escape' => false), 
											'<a onclick="return false;"><i class="fa fa-long-arrow-right"></i></a>', 
											array('class' => 'item arrow disabled',
													'tag' => 'li',
													'escape' => false));
			?>
</ul>
<?php } ?>