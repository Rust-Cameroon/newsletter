<?php
/*
    CoinPayments.net API Example
    Copyright 2014-2018 CoinPayments.net. All rights reserved.
    License: GPLv2 - http://www.gnu.org/licenses/gpl-2.0.txt
*/

use Modules\Payment\CoinPayments\CoinPaymentsAPI;

$cps = new CoinPaymentsAPI();
$cps->Setup('Your_Private_Key', 'Your_Public_Key');

$req = [
    'amount' => 10.00,
    'currency1' => 'USD',
    'currency2' => 'BTC',
    'buyer_email' => 'your_buyers_email@email.com',
    'item_name' => 'Test Item/Order Description',
    'address' => '', // leave blank send to follow your settings on the Coin Settings page
    'ipn_url' => 'https://yourserver.com/ipn_handler.php',
];
// See https://www.coinpayments.net/apidoc-create-transaction for all the available fields

$result = $cps->CreateTransaction($req);
if ($result['error'] == 'ok') {
    $le = php_sapi_name() == 'cli' ? "\n" : '<br />';
    echo 'Transaction created with ID: '.$result['result']['txn_id'].$le;
    echo 'Buyer should send '.sprintf('%.08f', $result['result']['amount']).' BTC'.$le;
    echo 'Status URL: '.$result['result']['status_url'].$le;
} else {
    echo 'Error: '.$result['error']."\n";
}
