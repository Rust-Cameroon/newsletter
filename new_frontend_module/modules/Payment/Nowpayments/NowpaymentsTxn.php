<?php

namespace Payment\Nowpayments;

use Modules\Payment\Nowpayments\NowPaymentsAPI;
use Payment\Transaction\BaseTxn;

class NowpaymentsTxn extends BaseTxn
{
    protected $secretKey;

    protected $apiKey;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);
        $credential = gateway_info('nowpayments');
        $this->apiKey = $credential->api_key;
        $this->secretKey = $credential->secret_key;
    }

    public function deposit()
    {
        $nowPaymentsAPI = new NowPaymentsAPI($this->apiKey, $this->secretKey);
        $payment = $nowPaymentsAPI->createInvoice([
            'price_amount' => $this->amount,
            'price_currency' => 'USD',
            // 'pay_currency' => $this->currency,
            'order_id' => $this->txn,
            'ipn_callback_url' => route('ipn.nowpayments'),
            'cancel_url' => route('status.cancel'),
            'success_url' => route('status.success'),
        ]);

        return redirect()->to($payment['invoice_url']);
    }
}
