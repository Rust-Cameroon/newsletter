<?php

namespace Payment\Coinpayments;

use Modules\Payment\CoinPayments\CoinPaymentsAPI;
use Payment\Transaction\BaseTxn;
use Txn;

class CoinpaymentsTxn extends BaseTxn
{
    protected $privateKey;

    protected $publicKey;

    protected $buyerEmail;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);
        $credential = gateway_info('coinpayments');
        $this->privateKey = $credential->private_key;
        $this->publicKey = $credential->public_key;
        $this->buyerEmail = $credential->buyer_email;
    }

    public function deposit()
    {
        $cps = new CoinPaymentsAPI();
        $cps->Setup($this->privateKey, $this->publicKey);

        $req = [
            'amount' => $this->amount,
            'currency1' => 'USD',
            'currency2' => $this->currency,
            'buyer_email' => $this->buyerEmail,
            'item_name' => $this->txn,
            'address' => '', // leave blank send to follow your settings on the Coin Settings page
            'ipn_url' => route('ipn.coinpayments'),
        ];

        $result = $cps->CreateTransaction($req);

        if ($result['error'] == 'ok') {
            return redirect($result['result']['checkout_url']);

        }
        // echo 'YOu cancel the payment';
        Txn::update($this->txn, 'failed');
        notify()->warning($result['error'], 'error');

        return redirect(route('user.dashboard'));

    }
}
