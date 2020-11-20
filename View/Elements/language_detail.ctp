<?php $current_language = $this->Session->read('Config.language'); ?>
<li class="<?php echo $current_language == 'zho' ? 'active' : '' ?>">
	<a href="javascript:" class="btn-change-language" data-lang="zho">
        <?php echo __d('member', 'traditional_chinese') ?> 
	</a>
</li>
<li class="<?php echo $current_language == 'chi' ? 'active' : '' ?>">
	<a href="javascript:" class="btn-change-language" data-lang="chi">
        <?php echo __d('member', 'simplified_chinese') ?> 
	</a>
</li>
<li class="<?php echo $current_language == 'eng' ? 'active' : '' ?>">
	<a href="javascript:" class="btn-change-language" data-lang="eng"> 
        English
    </a>
</li>