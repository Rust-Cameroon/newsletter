<?php

namespace Payment\Coinbase;

use Illuminate\Support\Facades\Crypt;
use Payment\Transaction\BaseTxn;
use Shakurov\Coinbase\Facades\Coinbase;
use stdClass;

class CoinbaseTxn extends BaseTxn
{
    protected $account_id; //Coinbase Account ID

    protected $private_key; //Coinbase Private Key

    protected $api_key; //Coinbase API KEY

    protected $url;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);

        //Creating URL For Sending Request
        $coinbaseCredential = gateway_info('coinbase');
        $this->account_id = $coinbaseCredential->account_id; //Coinbase Account ID
        $this->private_key = $coinbaseCredential->private_key; //Coinbase Private Key
        $this->api_key = $coinbaseCredential->apiKey; //Coinbase API KEY
        $this->url = 'https://api.coinbase.com/v2/accounts/'.$this->account_id.'/transactions';

        $fieldData = json_decode($txnInfo->manual_field_data, true);
        $this->toEmail = $fieldData['email_address']['value'] ?? '';
    }

    public function deposit()
    {
        $charge = Coinbase::createCharge([
            'name' => 'Deposit no #'.$this->txn,
            'description' => 'Deposit',
            'cancel_url' => route('status.cancel'),

            'local_price' => [
                'amount' => $this->amount,
                'currency' => $this->currency,
            ],
            'pricing_type' => 'fixed_price',
            'redirect_url' => route('status.pending', 'reftrn='.Crypt::encryptString($this->txn)),
        ]);

        return redirect($charge['data']['hosted_url']);
    }

    public function withdraw()
    {
        $json = new stdClass();
        $json->method = 'POST';
        $json->path = '/v2/accounts/'.$this->account_id.'/transactions';
        $json->secretapikey = $this->private_key;
        $json->apikey = $this->api_key;

        $body = new stdClass();
        $body->type = 'send';
        $body->to = $this->toEmail;
        $body->amount = $this->amount;
        $body->currency = $this->currency;

        $result = json_encode($json);
        $body = json_encode($body);
        $time = time();
        $sign = $time.$json->method.$json->path.$body;
        $hmac = hash_hmac('SHA256', $sign, $json->secretapikey);

        $header = [
            'CB-ACCESS-KEY:'.$this->api_key,
            'CB-ACCESS-SIGN:'.$hmac,
            'CB-ACCESS-TIMESTAMP:'.time(),
            'CB-VERSION:2019-11-15',
            'Content-Type:application/json',
        ];

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
