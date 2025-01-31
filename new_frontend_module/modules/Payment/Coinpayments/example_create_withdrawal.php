<?php
/*
    CoinPayments.net API Example
    Copyright 2014-2018 CoinPayments.net. All rights reserved.
    License: GPLv2 - http://www.gnu.org/licenses/gpl-2.0.txt
*/

use Modules\Payment\CoinPayments\CoinPaymentsAPI;

$cps = new CoinPaymentsAPI();
$cps->Setup('Your_Private_Key', 'Your_Public_Key');

$result = $cps->CreateWithdrawal(0.1, 'BTC', 'bitcoin_address');
if ($result['error'] == 'ok') {
    echo 'Withdrawal created with ID: '.$result['result']['id'];
} else {
    echo 'Error: '.$result['error']."\n";
}
