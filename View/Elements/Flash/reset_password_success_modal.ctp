
<div class="modal a4l-modal modal-success " id="modal-reset-password-success" tabindex="-1" role="dialog" aria-labelledby="short-message">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <center>
          <?=$this->Html->image('all-4-learn-logo-bilingual-colour.png', ['width' => "260px"]); ?>
        </center>
      </div>
      <div class="row p-0 m-0 modal-body flex-center">
        <div class="col-md-10 text-center">
          <h3 class="text-green" id="short-message"> <?=__d('member', 'password_reset_successfully')?> </h3>
          <p class="message text-dark-liver" id="long-message"><?=__d('member', 'password_reset_successfully_message')?> </p>
        </div>
        
      </div>
      <div class="modal-footer">
        <div class="row p-0 m-0 flex-center">
          <div class="col-md-10">
            <button class="btn btn-w-radius btn-width-100 btn-green" onclick="COMMON.trigger_form_login('login')" type="button" data-dismiss="modal" aria-label="Close"><?=__('login')?></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>$(document).on('ready', function(){ $('#modal-reset-password-success').modal(); })</script>