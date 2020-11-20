<h2> ACCOUNT RESET CONFIRMATION </h2>

<p> We have determined that someone has request to reset to your All4Learn account. If this is you, please click here to continue step: </p>

<p>  <?= $link ?>  </p>

<p> This is your username：<font style="color: red; font-weight: 700"> <?= $username; ?>  </font>

<?php 
    if ($school_code && !empty($school_code)) { ?>
        ,and your school code:  <font style="color: red; font-weight: 700"> <?= $school_code; ?> </font>
    <?php } ?>
</p> 

<p> If this is not you or you are unsure, we suggest you dont do anything change</p>

<p> If you have any queries, please contact All4LeARN support team via below email: support@all4learn.com </p>

<p> Received this email by mistakes? Just ignore it! </p>

