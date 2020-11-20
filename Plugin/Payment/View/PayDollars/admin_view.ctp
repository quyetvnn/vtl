
<div class="row">
    <div class="col-xs-12">
		
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __('Pay Dollar Log'); ?></h3>
				<div class="box-tools pull-right">
	                <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-pencil"></i>' . __('edit')), array('action' => 'edit', $payDollarLog['PayDollar']['id']), array('class' => 'btn btn-primary', 'escape' => false)); ?>
	            </div>
			</div>
			
			<div class="box-body table-responsive">
                <table id="PayDollarLogs" class="table table-bordered table-striped">
					<tbody>
						<tr>		<td><strong><?php echo __('Id'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['id']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Member'); ?></strong></td>
		<td>
			<?php echo $this->Html->link($payDollarLog['Member']['id'], array('controller' => 'members', 'action' => 'view', $payDollarLog['Member']['id']), array('class' => '')); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('School'); ?></strong></td>
		<td>
			<?php echo $this->Html->link($payDollarLog['School']['id'], array('controller' => 'schools', 'action' => 'view', $payDollarLog['School']['id']), array('class' => '')); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Prc'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['prc']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Src'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['src']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Ord'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['Ord']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Ref'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['Ref']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('PayRef'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['PayRef']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Successcode'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['successcode']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Amt'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['Amt']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Cur'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['Cur']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Holder'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['Holder']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('AuthId'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['AuthId']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('AlertCode'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['AlertCode']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Remark'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['remark']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('Eci'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['eci']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('PayerAuth'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['payerAuth']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('SourceIp'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['sourceIp']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('IpCountry'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['ipCountry']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('PayMethod'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['payMethod']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('TxTime'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['TxTime']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('PanFirst4'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['panFirst4']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('PanLast4'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['panLast4']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('CardIssuingCountry'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['cardIssuingCountry']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('ChannelType'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['channelType']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('MerchantId'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['MerchantId']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><strong><?php echo __('SecureHash'); ?></strong></td>
		<td>
			<?php echo h($payDollarLog['PayDollar']['secureHash']); ?>
			&nbsp;
		</td>
</tr>					</tbody>
				</table><!-- /.table table-striped table-bordered -->
			</div><!-- /.table-responsive -->
			
		</div><!-- /.view -->

			
	</div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->

