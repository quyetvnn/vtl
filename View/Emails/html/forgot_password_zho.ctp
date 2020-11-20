<h2>帳戶重置確認 </h2>

<p>全民學習團隊收到有人要求重置您的All4Learn帳戶。如果是您，請單擊此處繼續步驟：</p>

<p>  <?= $link ?>  </p>

<p> 这个是您的賬號： <font style="color: red; font-weight: 700"> <?= $username; ?>  </font>

<?php 
    if ($school_code && !empty($school_code)) { ?>
        ，學校編號: <font style="color: red; font-weight: 700"> <?= $school_code; ?>  </font>
    <?php } ?>
</p> 


<p> 如有任何疑問，請通過以下電子郵箱與全民學習支援團隊聯繫： support@all4learn.com </p>

<p> 如誤收到此電子郵箱，請忽略它！</p>

<p> 請不要回覆此電子郵箱。</p>