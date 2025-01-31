<?php

namespace Payment\Mollie;

use Mollie\Laravel\Facades\Mollie;
use Payment\Transaction\BaseTxn;

class MollieTxn extends BaseTxn
{
    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);
    }

    public function deposit()
    {
        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => $this->currency, // Type of currency you want to send
                'value' => (string) $this->amount.'.00', // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            'description' => $this->siteName,
            'webhookUrl' => route('ipn.mollie', 'reftrn='.$this->txn),
            'redirectUrl' => route('status.pending'),
        ]);

        $payment = Mollie::api()->payments()->get($payment->id);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }
}
