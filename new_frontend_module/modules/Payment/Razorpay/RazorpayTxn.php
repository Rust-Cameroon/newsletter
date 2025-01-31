<?php

namespace Payment\Razorpay;

use App\Traits\Payment;
use Payment\Transaction\BaseTxn;

class RazorpayTxn extends BaseTxn
{
    use Payment;

    private $razorpayKey;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);

        $credentials = gateway_info('razorpay');
        $this->razorpayKey = $credentials->razorpay_key;
    }

    public function deposit()
    {
        $data = [
            'key' => $this->razorpayKey,
            'amount' => $this->amount,
            'button_text' => 'Pay '.$this->amount.' INR',
            'name' => $this->siteName,
            'description' => $this->siteName,
            'image' => asset(setting('site_logo', 'global')),
            'prefill_name' => $this->userName,
            'prefill_email' => $this->userEmail,
            'theme_color' => '#ff7529',
            'txn' => $this->txn,
        ];

        return view('gateway.razorpay', compact('data'));
    }
}
