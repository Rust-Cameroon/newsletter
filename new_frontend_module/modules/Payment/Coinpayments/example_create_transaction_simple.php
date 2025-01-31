<?php
/*
    CoinPayments.net API Example
    Copyright 2014-2018 CoinPayments.net. All rights reserved.
    License: GPLv2 - http://www.gnu.org/licenses/gpl-2.0.txt
*/

use Modules\Payment\CoinPayments\CoinPaymentsAPI;

require './coinpayments.inc.php';
$cps = new CoinPaymentsAPI();
$cps->Setup('Your_Private_Key', 'Your_Public_Key');

$result = $cps->CreateTransactionSimple(10.00, 'USD', 'BTC', 'your_buyers_email@email.com', '', 'ipn_url');
if ($result['error'] == 'ok') {
    $le = php_sapi_name() == 'cli' ? "\n" : '<br />';
    echo 'Transaction created with ID: '.$result['result']['txn_id'].$le;
    echo 'Buyer should send '.sprintf('%.08f', $result['result']['amount']).' BTC'.$le;
    echo 'Status URL: '.$result['result']['status_url'].$le;
} else {
    echo 'Error: '.$result['error']."\n";
}
