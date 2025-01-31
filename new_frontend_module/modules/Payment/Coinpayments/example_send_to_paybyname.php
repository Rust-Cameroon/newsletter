<?php
/*
    CoinPayments.net API Example
    Copyright 2016 CoinPayments.net. All rights reserved.
    License: GPLv2 - http://www.gnu.org/licenses/gpl-2.0.txt
*/

use Modules\Payment\CoinPayments\CoinPaymentsAPI;

require './coinpayments.inc.php';
$cps = new CoinPaymentsAPI();
$cps->Setup('Your_Private_Key', 'Your_Public_Key');

$result = $cps->SendToPayByName(0.1, 'BTC', '$CoinPayments');
if ($result['error'] == 'ok') {
    echo 'Transfer created with ID: '.$result['result']['id'];
} else {
    echo 'Error: '.$result['error']."\n";
}
