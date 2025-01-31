<?php

namespace Payment\Paytm;

use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use Payment\Transaction\BaseTxn;

class PaytmTxn extends BaseTxn
{
    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);
        $gatewayInfo = (array) gateway_info('paytm');
        $gatewayInfo['env'] = 'production';
        config()->set('services.paytm-wallet', $gatewayInfo);
    }

    public function deposit()
    {

        $payment = PaytmWallet::with('receive');
        $payment->prepare([
            'order' => $this->txn,
            'user' => $this->userName,
            'mobile_number' => $this->userPhone,
            'email' => $this->userEmail,
            'amount' => $this->amount,
            'callback_url' => route('ipn.paytm'),
        ]);

        return $payment->receive();

    }
}
