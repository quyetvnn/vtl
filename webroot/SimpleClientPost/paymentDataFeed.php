<?php

require_once('SHAPaydollarSecure.php');

$headers='From: no-reply@testing.com' . $br .
                                'X-Mailer: PHP/' . phpversion();

                                $to='oli.guo@vtl-vtl.com';
                $subject='asiaPay test';

        $br="\r\n";

$src = @$_POST['src'];																//Return bank host status code (secondary).
$prc = @$_POST['prc'];															//Return bank host status code (primary).
$successcode = @$_POST['successcode'];							//0- succeeded, 1- failure, Others - error
$ref = @$_POST['Ref'];															//Merchant‘s Order Reference Number
$payRef = @$_POST['PayRef'];												//PayDollar Payment Reference Number
$amt = @$_POST['Amt'];														//Transaction Amount
$cur = @$_POST['Cur'];															//Transaction Currency
$payerAuth = @$_POST['payerAuth'];									//Payer Authentication Status

$ord = @$_POST['Ord'];															//Bank Reference – Order id
$holder = @$_POST['Holder'];												//The Holder Name of the Payment Account
$remark = @$_POST['remark'];												//A remark field for you to store additional data that will 
$authId = @$_POST['AuthId'];												//Approval Code
$eci = @$_POST['eci'];																//ECI value (for 3D enabled Merchants)
$sourceIp = @$_POST['sourceIp'];											//IP address of payer
$ipCountry = @$_POST['ipCountry'];									//Country of payer ( e.g. HK) - if country is on high risk country list, an asterisk will be shown (e.g. MY*)

$mpsAmt = @$_POST['mpsAmt'];										//MPS Transaction Amount
$mpsCur = @$_POST['mpsCur'];											//MPS Transaction Currency
$mpsForeignAmt = @$_POST['mpsForeignAmt'];				//MPS Transaction Foreign Amount
$mpsForeignCur = @$_POST['mpsForeignCur'];					//MPS Transaction Foreign Currency
$mpsRate = @$_POST['mpsRate'];										//MPS Exchange Rate: (Foreign / Base) e.g. USD / HKD = 7.77
$cardlssuingCountry = @$_POST['cardlssuingCountry'];	//Card Issuing Country Code ( e.g. HK)
$payMethod = @$_POST['payMethod'];								//Payment method (e.g. VISA, Master, Diners, JCB, AMEX)

$secureHash = @$_POST['secureHash'];//when product to call asiapay to get key

$secureHashSecret = "7LEsd2rXZih5nOWgj4K6EL8KHdFqwOuk";//offered by paydollar

echo 'OK';


if(mail($to, $subject, json_encode($_POST), $headers)){

                        }

$isSecureHash=true;
 
if($isSecureHash){
//echo $secureHash;

$secureHashs=explode(',', $secureHash);

$paydollarSecure=new SHAPaydollarSecure();

$verifyResult =false;

while(list($key,$value)=each($secureHashs)){
	$verifyResult = $paydollarSecure->verifyPaymentDatafeed($src,
	$prc, $successcode, $ref, $payRef, $cur, $amt, $payerAuth,
	$secureHashSecret, $value);
	
	//echo '$secureHash=['.$value.']';

	if($verifyResult){
		//echo '<br/>verifyResult= true';
                
                
                $message="src:".$src.$br.
                        "prc:".$prc.$br.
                        "successcode:".$successcode.$br.
                        "Ref:".$ref.$br.
                        "PayRef:".$PayRef.$br;
                        "Amt:".$Amt.$br.
                        "Cur:".$cur.$br.
                         "payerAuth:".$payerAuth.$br.
                          "Ord:".$ord.$br.
                            "Holder:".$holder.$br.
                              "remark:".$remark.$br.
                               "AuthId:".$authId.$br.
                               "eci:".$eci.$br.
                                "sourceIp:".$sourceIp.$br.
                                "ipCountry:".$ipCountry.$br.
                                "mpsAmt:".$mpsAmt.$br.
                                "mpsCur:".$mpsCur.$br.
                                "mpsForeignAmt:".$mpsForeignAmt.$br.
                                "mpsForeignCur:".$mpsForeignCur.$br.
                                "mpsRate:".$mpsRate.$br.
                                "cardlssuingCountry:".$cardlssuingCountry.$br.
                                "payMethod:".$payMethod.$br.
                                "secureHash:".$secureHash ;
                
                        if(mail($to, $subject, $message, $headers)){

                        }
                        if(mail($to, $subject, json_encode($_POST), $headers)){

                        }
        
		break;
	}else{
		//echo '<br/>verifyResult= false';
	}
}
if (!$verifyResult) {
	//echo 'Verify Fail';
	//TODO Verify Fail
	return;
}else{
	//echo 'True';
}
}

if ('0'==$successcode) {
	
	//echo 'TO DO Payment Sucess Logic';
	// Transaction Accepted
		// *** Add the Security Control here, to check the currency, amount with the 
		// *** merchant’s order reference from your database, if the order exist then 
		// *** accepted otherwise rejected the transaction.

		//  Update your database for Transaction Accepted and send email or notify your 
		//   customer.
		//....

		// In case if your database or your system got problem, you can send a void transaction request. See API guide for more details
} else {
	
	//echo 'TO DO Payment Fail Logic';
	// Transaction Rejected
		// Update your database for Transaction Rejected
		//.....
}
//echo '\n\r';

while(list($key,$value)=each(@$_POST)){
	 
	//echo '['.$key.']=['.$value.'],';
 
}


