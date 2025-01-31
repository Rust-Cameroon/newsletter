<?php

namespace Payment\Coinremitter;

use Coinremitter\Coinremitter;
use Exception;
use Payment\Transaction\BaseTxn;

class CoinremitterTxn extends BaseTxn
{
    protected $merchantId;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);

        $coinremitterCredential = gateway_info('coinremitter');
        config()->set([
            'coinremitter.BTC.API_KEY' => $coinremitterCredential->api_key,
            'coinremitter.BTC.PASSWORD' => $coinremitterCredential->password,
        ]);

        $fieldData = json_decode($txnInfo->manual_field_data, true);
        $this->toAddress = $fieldData['to_address']['value'] ?? '';
    }

    public function deposit()
    {

        $btc_wallet = new Coinremitter($this->currency);
        $param = [
            'amount' => $this->amount,      //required.
            'notify_url' => '', //optional,url on which you wants to receive notification,
            'fail_url' => '', //optional,url on which user will be redirect if user cancel invoice,
            'suceess_url' => '', //optional,url on which user will be redirect when invoice paid,
            'name' => '', //optional,
            'currency' => 'usd', //optional,
            'expire_time' => '20', //optional, invoice will expire in 20 minutes.
            'description' => $this->txn, //optional.
        ];

        try {
            $transaction = $btc_wallet->create_invoice($param);
            $url = $transaction['data']['url'];

            return redirect($url);

        } catch (Exception $e) {
            notify()->error('Something went wrong', 'Error');

            return redirect()->back();
        }
    }

    public function withdraw()
    {
        $btc_wallet = new Coinremitter($this->currency);
        $param = [
            'to_address' => $this->toAddress,
            'amount' => $this->amount,
        ];

        return $btc_wallet->withdraw($param);
    }
}
