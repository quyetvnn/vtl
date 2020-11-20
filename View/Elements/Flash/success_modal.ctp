
<div class="modal a4l-modal modal-success " id="modal-payment-success" tabindex="-1" role="dialog" aria-labelledby="short-message">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-body ">
        <p class="message text-dark-liver" id="long-message"><?php print h($message); ?></p>
        <br>
        <br>
        <p class="text-dark-liver"><?=__d('member', 'a4l_right_reserved')?></p>
      </div>
      <div class="modal-footer">
        <div class="row m-0 flex-center">
          <button class="btn btn-w-radius btn-min-width-210 btn-green" type="button" data-dismiss="modal" aria-label="Close"><?=__d('member', 'done')?></button>
        </div>
        
      </div>
    </div>
  </div>
</div>
<script>$(document).on('ready', function(){ $('#modal-payment-success').modal(); })</script>