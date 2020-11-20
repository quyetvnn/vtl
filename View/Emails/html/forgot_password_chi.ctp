<h2>帐户重置确认 </h2>

<p>全民学习团队收到有人要求重置您的All4Learn帐户。如果是您，请单击此处继续步骤：</p>

<p> <?= $link ?> </p>

<p> 这个是您的账号： <font style="color: red; font-weight: 700"> <?= $username; ?> </font>

<?php 
    if ($school_code && !empty($school_code)) { ?>
        ，学校编号:   <font style="color: red; font-weight: 700"> <?= $school_code; ?> </font>
    <?php } ?>
</p> 

<p> 如有任何疑问，请通过以下电子邮箱与全民学习支援团队联系： support@all4learn.com </p>

<p> 如误收到此电子邮箱，请忽略它！ </p>

<p> 请不要回覆此电子邮箱。 </p>