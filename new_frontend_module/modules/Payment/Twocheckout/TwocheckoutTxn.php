<?php

namespace Payment\Twocheckout;

use Illuminate\Support\Facades\Redirect;
use Payment\Transaction\BaseTxn;

class TwocheckoutTxn extends BaseTxn
{
    private $sellerId;

    private $secretWord;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);
        $gatewayInfo = gateway_info('twocheckout');
        $this->sellerId = $gatewayInfo->seller_id;
        $this->secretWord = $gatewayInfo->secret_word;
    }

    public function deposit()
    {

        $payload = [
            'sid' => $this->sellerId,
            'mode' => '2CO',
            'li_0_type' => 'product',
            'li_0_name' => 'Product Name',
            'li_0_price' => $this->amount,
            'li_0_quantity' => '1',
            'li_0_product_id' => $this->txn,
            'email' => $this->userEmail,
            'phone' => $this->userPhone,
            'currency_code' => $this->currency,
            'demo' => 'Y',
        ];
        $payload['key'] = md5($payload['sid'].$payload['li_0_price'].$this->secretWord);
        $purchaseUrl = 'https://www.2checkout.com/checkout/purchase?'.http_build_query($payload);

        return Redirect::to($purchaseUrl);
    }
}
