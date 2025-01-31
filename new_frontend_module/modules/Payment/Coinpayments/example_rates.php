<?php
/*
    CoinPayments.net API Example
    Copyright 2014 CoinPayments.net. All rights reserved.
    License: GPLv2 - http://www.gnu.org/licenses/gpl-2.0.txt
*/
require './coinpayments.inc.php';
$cps = new CoinPaymentsAPI();
$cps->Setup('Your_Private_Key', 'Your_Public_Key');

$result = $cps->GetRates();
if ($result['error'] == 'ok') {
    echo 'Number of currencies: '.count($result['result'])."\n";
    foreach ($result['result'] as $coin => $rate) {
        if (php_sapi_name() == 'cli') {
            echo print_r($rate);
        } else {
            echo nl2br(print_r($rate, true));
        }
    }
} else {
    echo 'Error: '.$result['error']."\n";
}
