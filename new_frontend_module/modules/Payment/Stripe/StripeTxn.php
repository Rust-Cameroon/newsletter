<?php

namespace Payment\Stripe;

use Illuminate\Support\Facades\Crypt;
use Payment\Transaction\BaseTxn;

class StripeTxn extends BaseTxn
{
    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);
    }

    public function deposit()
    {
        $stripeCredential = gateway_info('stripe');
        \Stripe\Stripe::setApiKey($stripeCredential->stripe_secret);
        $session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => $this->currency,
                    'product_data' => [
                        'name' => $this->siteName,
                    ],
                    'unit_amount' => (int) ($this->amount * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('status.success', ['reftrn' => Crypt::encryptString($this->txn)]),
            'cancel_url' => route('status.cancel'),
        ]);

        return redirect($session->url);
    }
}
