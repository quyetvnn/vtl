<li>
    <span class="icon icon-envelope-o-green"></span>
    <a href="mailto:support@all4learn.com" style="color: #333; text-decoration: #333">support@all4learn.com</a>
</li>
<li>
    <span class="icon icon-phone-green"></span>
    <a href="javascript: void(0)" class="text-dark-liver">2111 0273</a>
</li>
<li>
	<span class="icon icon-faq"></span>
    <a href="<?=Router::url('/', true)?>uploads/faq_<?=$this->Session->read('Config.language')?>.html" class="text-dark-liver"><?=__d('member', 'faqs')?></a>
</li>
<li>
	<span class="icon icon-userguide"></span>
    <a href="<?=Router::url('/', true)?>uploads/features_<?=$this->Session->read('Config.language')?>.html" class="text-dark-liver"><?=__d('member', 'features')?></a>
</li>
<li>
	<span class="icon icon-privacy"></span>
    <a href="<?=Router::url('/', true)?>uploads/privacy_policy_<?=$this->Session->read('Config.language')?>.html" class="text-dark-liver"><?=__d('member', 'privacy_policy')?></a>

	<?php
		// echo $this->Html->link(
        //                 __d('member', 'privacy_policy'),
        //                 array(
        //                     'plugin' => '', 
        //                     'controller' => 'pages', 
        //                     'action' => 'term_n_conditions',
        //                     'admin' => false,
        //                 ), 
        //                 array('escape' => false, 'class'=>"text-dark-liver", 'target'=>"_blank")
        //             );
	?>
</li>
<li>
	<span class="icon icon-term"></span>
    <a href="<?=Router::url('/', true)?>uploads/terms_and_condition_<?=$this->Session->read('Config.language')?>.html" class="text-dark-liver"><?=__d('member', 'term')?></a>
</li>
