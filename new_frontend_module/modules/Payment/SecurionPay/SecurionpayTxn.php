<?php

namespace Payment\Securionpay;

use App\Traits\Payment;
use Payment\Transaction\BaseTxn;
use SecurionPay\Exception\SecurionPayException;
use SecurionPay\SecurionPayGateway;

class SecurionpayTxn extends BaseTxn
{
    use Payment;

    protected $secretKey;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);

        $credentials = gateway_info('securionpay');
        $this->secretKey = $credentials->secret_key;
    }

    public function deposit()
    {
        $amountInfo = $this->amount.$this->currency;

        return view('gateway.securion_pay', compact('amountInfo'));
    }

    public function nonHostedPayment($request)
    {

        $cardDate = explode('/', $request->card_date);
        if (! isset($cardDate[1])) {
            abort(406, 'Please Valid Card Expiry Date');
        }

        $card = [
            'number' => $request->card_number,
            'exp_month' => $cardDate[0],
            'exp_year' => $cardDate[1],
        ];

        $gateway = new SecurionPayGateway($this->secretKey);

        $request = [
            'amount' => $this->amount,
            'currency' => $this->currency,
            'card' => [
                'number' => $card['number'],
                'expMonth' => $card['exp_month'],
                'expYear' => $card['exp_year'],
            ],
        ];

        try {
            $charge = $gateway->createCharge($request);
            if ($charge->getStatus() == 'successful' && $charge->getAmount() == (int) $this->amount) {
                return self::paymentSuccess($this->txn);
            }
            abort(406, 'error');

        } catch (SecurionPayException $e) {
            $errorMessage = $e->getMessage();
            abort(406, $errorMessage);

        }
    }
}
