<?php

namespace Payment\Paymongo;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Payment\Transaction\BaseTxn;

class PaymongoTxn extends BaseTxn
{
    protected $secretKey;

    protected $password;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);
        $credential = gateway_info('paymongo');
        $this->secretKey = $credential->secret_key;
        $this->password = $credential->password;
    }

    public function deposit()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'authorization' => 'Basic '.base64_encode($this->secretKey.':'.$this->password),
        ])->post('https://api.paymongo.com/v1/checkout_sessions', [
            'data' => [
                'attributes' => [
                    'cancel_url' => route('status.cancel'),
                    'billing' => [
                        'name' => $this->userName,
                        'email' => $this->userEmail,
                        'phone' => $this->userPhone,
                    ],
                    'line_items' => [
                        [
                            'amount' => (int) $this->amount,
                            'currency' => $this->currency,
                            'name' => $this->siteName,
                            'quantity' => 1,
                        ],
                    ],
                    'payment_method_types' => ['billease', 'card', 'dob', 'dob_ubp', 'gcash', 'grab_pay', 'paymaya'],
                    'reference_number' => $this->txn,
                    'send_email_receipt' => false,
                    'show_description' => false,
                    'show_line_items' => true,
                    'success_url' => route('status.success', 'reftrn='.Crypt::encryptString($this->txn)),
                ],
            ],
        ]);
        $paymentInfo = json_decode($response->body());
        $checkoutUrl = $paymentInfo->data->attributes->checkout_url;

        return redirect()->to($checkoutUrl);
    }
}
