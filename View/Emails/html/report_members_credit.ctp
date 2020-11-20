

<!DOCTYPE html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<style type="text/css">
    @media screen and (max-width: 600px) {
        .responsive-table {
            width: 30% !important;
        }
    }

    @media screen and (min-width: 601px) {
        .responsive-table {
            width: 10% !important;
        }
    }

    .head {
        font-weight: 700;
        padding: 10px 15px;
    }
    
    .body {
        padding: 10px 15px;
    }

    .red{
        color: red;
    }

    .blue{
        color: blue;
    }

    .white{
        color: white;
    }

    .bg-brown {
        background-color: brown;
    }

    .bg-custom {
        background-color: #99ccff;  /* #f5f5f5; */
    }

    .black {
        color: #000;
    }
    .main-table{
        border-top: 1px solid #99ccff;  /* #f1f1f1; */
        border-left: 1px solid #99ccff;  /* #f1f1f1; */
        border-bottom: 1px solid #99ccff;  /* #f1f1f1; */
        /* border-radius: 10px; */
    }
    .main-table tr{
        border-bottom: 1px solid #99ccff;   /*#f1f1f1; */
    }
    /* .main-table tr:last-child{
        border-bottom: none;
    } */
    .main-table td{
        border-right: 1px solid #99ccff; /*#f1f1f1; */
    }

    .last-td td {
        border-top: 1px solid #99ccff; /*#f1f1f1; */
    }

    .right {
        text-align: right;
    }

    .left {
        text-align: left;
    }

    .none-border {
        border-right: none !important;
    }
    /* .main-table td .body:last-child{
        border-right: none;
    } */
    /* .main-table td:last-child{
        border-right: none; /*#f1f1f1;
    } */
</style>
</head>

<body>
    
    <p>Dear <?= $email?>， </p>
    <h3>Daily Transaction Summary for <?php echo ("\"" . $school_name . ' (' . $school_code . ")\"") ; ?> </h3>
    <h3>Date:  <span style='font-weight: 700;' class='blue'> <?= $today; ?> </span> (00:00:00 - 23:59:59) </h3>
    
    <?php 
    $total = 0;
    
    if (count($data) == 0) { ?>
        <h3 class="red" style="font-weight: 700" > NO RECORD TODAY! </h3>
    <?php } else { ?>

    <table class="main-table" cellpadding="0" cellspacing="0" height="100%" width="100%" >
        <tbody>
            <tr>
                <td class="head bg-custom black"> <?= "No" ?> </td>
                <td class="head bg-custom black"> <?= "Credit Type / 類型"  ?> </td>
                <td class="head bg-custom black"> <?= "Payment Ref / 支付收據" ?>  </td>
                <td class="head bg-custom black"> <?= "Credit / 充值" ?>  </td>
                <td class="head bg-custom black"> <?= "Remark / 備註" ?>  </td>
                <td class="head bg-custom black"> <?= "Created / 創建時間" ?>  </td>
            </tr>

            <?php 
                $stt = 0;     
                foreach ($data as $value) { 
                    $stt++;        
            ?>
                    <tr>
                        <td class="body" > <?= $stt ?> </td>
                        <td class="body"> <?= reset($value['CreditType']['CreditTypeLanguage'])['name'] . "/" . $value['CreditType']['CreditTypeLanguage'][1]['name']?> </td>
                        <td class="body"> <?= $value['MembersCredit']['pay_dollar_ref'] ?> </td>
                        <td class="body right"> 
                            <?php 
                                if ($value['CreditType']['is_add_point'] == 1) {
                                    echo (number_format($value['MembersCredit']['credit'], 1));
                                
                                }  elseif ($value['CreditType']['is_add_point'] == 0) {
                                    echo ("-" . number_format($value['MembersCredit']['credit'], 1));
            
                                }
                            ?> 
                        </td>
                        <td class="body"> <?= $value['MembersCredit']['remark'] ?> </td>
                        <td class="body"> <?= $value['MembersCredit']['created'] ?> </td>
                    </tr>
                <?php 

                    if ($value['CreditType']['is_add_point'] == 1) {
                        $total = $total + $value['MembersCredit']['credit'];
            
                    } elseif ($value['CreditType']['is_add_point'] == 0) {
                        $total = $total - $value['MembersCredit']['credit'];

                    }
                  
                }  ?>

                <tr class="last-td">
                    <td colspan="3" class="body right">  Daily Total </td>
                    <td colspan="1" class="body right none-border">  <?= number_format($total, 1); ?>  </td>
                    <td colspan="2" >   </td>
                </tr>
        </tbody>
    </table>

    <?php } ?>

    <ul>
        <li class="red">Current ballance:        <span style="font-style: 700; font-size: 20px"> <?= number_format($school_credit, 1); ?>    </span> </li>
    </ul>
    <p>If you have any queries, please contact All4LeARN support team via below email: support@all4learn.com</p>
    <p>Received this email by mistakes? Just ignore it! </p>
    <p> Please do not reply this email. </p>
<br/>
<br/>
</body>