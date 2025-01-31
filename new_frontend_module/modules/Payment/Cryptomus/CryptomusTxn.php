<?php

namespace Payment\Cryptomus;

use Exception;
use Payment\Transaction\BaseTxn;

class CryptomusTxn extends BaseTxn
{
    protected $payoutKey;

    protected $merchantId;

    protected $paymentKey;

    protected $toAddress;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);
        $credential = gateway_info('cryptomus');
        $this->merchantId = $credential->merchant_id;
        $this->payoutKey = $credential->payout_key;
        $this->paymentKey = $credential->payment_key;

        $fieldData = json_decode($txnInfo->manual_field_data, true);
        $this->toAddress = $fieldData['address']['value'] ?? '';
    }

    public function deposit()
    {
        $payment = \Cryptomus\Api\Client::payment($this->paymentKey, $this->merchantId);
        $data = [
            'amount' => $this->amount,
            'currency' => 'USD',
            'network' => $this->currency,
            'order_id' => $this->txn,
            'url_return' => route('status.pending'),
            'url_callback' => route('ipn.cryptomus'),
            'is_payment_multiple' => false,
            'lifetime' => '7200',
            'to_currency' => $this->currency,
        ];

        $result = $payment->create($data);

        return redirect()->to($result['url']);
    }

    public function withdraw()
    {

        try {
            $payout = \Cryptomus\Api\Client::payout($this->payoutKey, $this->merchantId);
            $data = [
                'amount' => $this->amount,
                'currency' => 'USD',
                'network' => $this->currency,
                'order_id' => $this->txn,
                'address' => $this->toAddress,
                'is_subtract' => '1',
                'url_callback' => route('ipn.cryptomus'),
            ];

            $payout->create($data);

        } catch (Exception $e) {
            notify()->warning('Not available demo mode', 'warning');

            return redirect()->back();
        }

    }
}
