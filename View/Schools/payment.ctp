<?= $this->element('menu/top_menu') ?>
<div class="container">
	<div class="row">
		<?php 
        foreach ($manage_school as $item_school) { 
            $school = $item_school['School'];
            $school_language = $school['SchoolLanguage'][0];
      ?>
			<div class="col-md-4 flex-center">
				<div class="element-school-payment">
					<center class="group-img-radius icon-school">
              <div class="box-img border-grey">
                <?php 
                  $avatar = '';
                  foreach ($school['SchoolImage'] as $img) {
                    if($img['image_type_id'] == 1){ 
                      if($img['path']!=''){
                        $avatar = $this->Html->image(Router::url('/', true).$img['path'], ['class' => "profile-image"]); 
                      }else{
                      	$avatar = "<span class='default-text-avatar'>".$school['minimal_name']."</span>";
                      }
                      break;
                    }
                  }
                  if($avatar == ''){
                    $minimal_name = $this->App->get_minimal_name($school_language['name']);
                    $avatar = "<span class='default-text-avatar'>".$minimal_name."</span>";
                  }
                  echo $avatar;
                ?>
              </div>
              <h5 class="school_name text-dark-liver" id="name-<?=$school['id']?>"><?=$school_language['name']?></h5>
            </center>
            <hr class="line-grey-dashed">
            <div class="balance-detail">
            	<p class="text-dark-liver">
                <?php
                    $dtime = strtotime(date("d-m-Y H:i:s"));
                    echo sprintf( __d('member', 'school_actual_credit'), date(Environment::read('locale_format.'.$this->Session->read('Config.language')), $dtime)); 
                  ?>
                  
              </p>
            	<div class="group-img-radius">
            		<div class="box-img pull-left">
            			<?=$this->Html->image('icons/coin.png', ['class' => "profile-image"]); ?>
            		</div>
            		<div class="addon-text">
            			<span class="coin"><?=number_format($school['credit'])?></span>
            		</div>
            	</div>
            </div>
            <form class="row m-0 payment-action create-payment" id="<?=$school['id']?>">
            	<p class="col-md-12 p-0 m-0 text-dark-liver"><?=__d('member', 'topup_coins')?></p>
            	<div class="col-md-12 p-0 m-0 form-group input-w-icon-t">
            		<input type="text" placeholder="<?=__d('member', 'input_quantity')?>" id="amount-<?=$school['id']?>" class="form-control a4l-input no-text-indent format-number" />
            		<span class="unit text-dark-liver no-underline"><?=__d('member', 'coin')?></span>
            	</div>
            	<p class="col-md-12 p-0 m-0 error text-red" id="error-<?=$school['id']?>"></p>
            	<div class="col-md-12 form-group flex-center">
            		<button class="btn btn-w-radius btn-green" type="submit"><?=__d('member', 'topup')?></button>
            	</div>
            </form>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<?php echo $this->Form->create('schools', array('role' => 'form', 'class' => 'hidden', 'id'=>'form-school-payment')); ?>
  <input type="hidden" name="merchantId" id="merchantId" value="<?=Environment::read('paydollar.merchant_id')?>">
  <input type="hidden" name="amount"     id="amount" value="">
  <input type="hidden" name="orderRef"   id="orderRef" value="">
  <input type="hidden" name="currCode"   id="currCode" value="<?=Environment::read('paydollar.currency')?>">
  <input type="hidden" name="successUrl" id="successUrl" value="<?=Router::url('/', true).Environment::read('paydollar.success_url')?>">
  <input type="hidden" name="failUrl"    id="failUrl" value="<?=Router::url('/', true).Environment::read('paydollar.fail_url')?>">
  <input type="hidden" name="cancelUrl"  id="cancelUrl" value="<?=Router::url('/', true).Environment::read('paydollar.cancel_url')?>">
  <input type="hidden" name="payType"    id="payType" value="<?=Environment::read('paydollar.payment_type')?>">
  <input type="hidden" name="lang"       id="lang" value="<?=Environment::read('paydollar.lang')?>">
  <input type="hidden" name="mpsMode"    id="mpsMode" value="">
  <input type="hidden" name="payMethod"  id="payMethod" value="">

  <input type="hidden" name="secureHash" id="secureHash" value="">
  <input type="hidden" name="remark"     id="remark" value="">
  <input type="hidden" name="redirect"   id="redirect" value="">
  <input type="hidden" name="oriCountry" id="oriCountry" value="">
  <input type="hidden" name="destCountry"id="destCountry" value="">
  <input type="hidden" name="school_name"id="school_name" value="">
<?php echo $this->Form->end(); ?>

<?php
  // Modal payment success
  if(isset($payment_receipt) && $payment_receipt && $payment_receipt['PayDollar']['successcode'] == 0){
?>
<!-- Modal payment success -->
<div class="modal a4l-modal modal-success " id="modal-payment-success" tabindex="-1" role="dialog" aria-labelledby="short-message">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <div class="row m-0 flex-center">
          <?=$this->Html->image('icon-success.png', ['width' => "70px"]); ?>
        </div>
        <h3 class="text-green" id="short-message"> <?=__d('member', 'top_up_success')?> </h3>
        <p class="message text-dark-liver" id="long-message"><?= sprintf(__d('member', 'top_up_success_message'), number_format($payment_receipt['PayDollar']['Amt']), $payment_receipt['School']['SchoolLanguage'][0]['name'])?> </p>
      </div>
      <div class="modal-footer">
        <div class="row m-0 flex-center">
          <button class="btn btn-w-radius btn-min-width-210 btn-green" type="button" data-dismiss="modal" aria-label="Close"><?=__d('member', 'done')?></button>
        </div>
        
      </div>
    </div>
  </div>
</div>
<!-- Modal payment success -->
<?php
  echo "<script>$(document).on('ready', function(){ $('#modal-payment-success').modal(); })</script>";
?>
<?php } ?>


<?php
  // Modal payment fail
  if(isset($payment_receipt) && !empty($payment_receipt) && !empty($payment_receipt['PayDollar']) && $payment_receipt['PayDollar']['successcode']==1){
?>
<!-- Modal payment fail -->
<div class="modal a4l-modal modal-success " id="modal-payment-fail" tabindex="-1" role="dialog" aria-labelledby="short-message">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <div class="row m-0 flex-center">
          <?=$this->Html->image('icon-fail.png', ['width' => "70px"]); ?>
        </div>
        <h3 class="text-red-orange" id="short-message"> <?=__d('member', 'top_up_fail')?> </h3>
        <p class="message text-dark-liver" id="long-message"><?=__d('member', 'top_up_fail_message')?> </p>
      </div>
      <div class="modal-footer">
        <div class="row m-0 flex-center">
          <button class="btn btn-w-radius btn-min-width-210 btn-green" type="button" data-dismiss="modal" aria-label="Close"><?=__d('member', 'done')?></button>
        </div>
        
      </div>
    </div>
  </div>
</div>
<!-- Modal payment fail -->
<?php
  echo "<script>$(document).on('ready', function(){ $('#modal-payment-fail').modal(); })</script>";
?>
<?php } ?>


<!-- Modal confirm payment -->
<div class="modal a4l-modal modal-success " id="modal-confirm-payment" tabindex="-1" role="dialog" aria-labelledby="long-message">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-body teacher-create-lesson ">
        <p class="message text-dark-liver text-center" id="long-message"></p>
        <hr>
        <p class="message text-dark-liver text-left">
          <?=__d('member', 'coin')?>：<br>
          <?=__d('member', 'token_explains')?>
        </p>
      </div>

      <div class="modal-footer ">
        <div class="row m-0 flex-center">
          <button class="btn btn-w-radius btn-min-width-210 btn-green" type="button" onclick="SCHOOL_PAYMENT.confirm_payment(true)"><?=__d('member', 'confirm')?></button>
        </div>
        <div class="row mt-10 flex-center">
          <button class="btn btn-w-radius btn-min-width-210 btn-green-o" onclick="SCHOOL_PAYMENT.confirm_payment(false)"><?=__d('member', 'back')?></button>
        </div>
      </div>

    </div>
  </div>
</div>
<!-- Modal confirm payment -->



<?php
	echo $this->Html->script('pages/school/school_payment.js?v='.date('U'));
?>
<script type="text/javascript">
	$(document).ready(function() {
		SCHOOL_PAYMENT.init_page();
	});
</script>