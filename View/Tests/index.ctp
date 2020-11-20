<h1> Test </h1>


<?php 

    $current_password = '9903';
    // $temp = hash('sha256', $current_password, true);
    $temp1 = base64_encode($current_password);

    pr ('current_password original: ' . $current_password);
    pr ('current_password after encrypt (STORE IN DB): ' . "<font style='color:blue'>" . $temp1 . "</font>");
    pr ('current_password after decrypt: ' . base64_decode($temp1)) ; 	

    if (base64_decode($temp1) == "9903") {
        pr ('YES SAME PW');
    } else {
        pr ('NO DIFFERENT PW');
    }


    pr (' ---------------- ');
    $current_password = 'Goo@123456';
    // $temp = hash('sha256', $current_password, true);
    $temp1 = base64_encode($current_password);

    pr ('current_password original: ' . $current_password);
    pr ('current_password after encrypt (STORE IN DB): ' .  "<font style='color:blue'>" . $temp1 . "</font>");
    pr ('current_password after decrypt: ' . base64_decode($temp1)) ;
?>