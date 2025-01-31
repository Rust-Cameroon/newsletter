<?php

namespace Payment\Binance;

use App\Enums\TxnStatus;
use App\Models\User;
use Binance\API;
use Payment\Transaction\BaseTxn;
use Txn;

class BinanceTxn extends BaseTxn
{
    private $apiKey;

    private $apiSecret;

    /**
     * @var mixed|string
     */
    private mixed $paymentAddress;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);
        $gatewayInfo = gateway_info('binance');
        $this->apiKey = $gatewayInfo->api_key;
        $this->apiSecret = $gatewayInfo->api_secret;
        $this->paymentAddress = $fieldData['address']['value'] ?? '';
    }

    public function deposit()
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $nonce = '';
        for ($i = 1; $i <= 32; $i++) {
            $pos = mt_rand(0, strlen($chars) - 1);
            $char = $chars[$pos];
            $nonce .= $char;
        }
        $ch = curl_init();
        $timestamp = round(microtime(true) * 1000);
        // Request body
        $request = [
            'env' => [
                'terminalType' => 'APP',
            ],
            'merchantTradeNo' => mt_rand(982538, 9825382937292),
            'orderAmount' => $this->amount,
            'currency' => $this->currency,
            'goods' => [
                'goodsType' => '01',
                'goodsCategory' => 'D000',
                'referenceGoodsId' => '7876763A3B',
                'goodsName' => $this->txn,
                'goodsDetail' => $this->txn,
            ],
        ];

        $json_request = json_encode($request);
        $payload = $timestamp."\n".$nonce."\n".$json_request."\n";
        $binance_pay_key = $this->apiKey;
        $binance_pay_secret = $this->apiSecret;
        $signature = strtoupper(hash_hmac('SHA512', $payload, $binance_pay_secret));
        $headers = [];
        $headers[] = 'Content-Type: application/json';
        $headers[] = "BinancePay-Timestamp: $timestamp";
        $headers[] = "BinancePay-Nonce: $nonce";
        $headers[] = "BinancePay-Certificate-SN: $binance_pay_key";
        $headers[] = "BinancePay-Signature: $signature";

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, 'https://bpay.binanceapi.com/binancepay/openapi/v2/order');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_request);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:'.curl_error($ch);
        }
        curl_close($ch);

        return redirect()->to(json_decode($result)->data->checkoutUrl);

        //Redirect user to the payment page
    }

    public function withdraw()
    {

        $asset = $this->currency;
        $address = '1C5gqLRs96Xq4V2ZZAR1347yUCpHie7sa';
        $amount = $this->amount;

        $api = new API($this->apiKey, $this->apiSecret, false);
        $api->useServerTime();

        $timestamp = round(microtime(true) * 1000); // Get the current timestamp

        $query_string = http_build_query([
            'asset' => $asset,
            'address' => $address,
            'amount' => $amount,
            'timestamp' => $timestamp,
        ]);

        $signature = hash_hmac('sha256', $query_string, $this->apiSecret);

        $response = $api->withdraw($asset, $address, $amount, ['timestamp' => $timestamp, 'signature' => $signature]);

        if ($response['success']) {
            Txn::update($this->txn, TxnStatus::Success, $this->userId);
        } else {
            $user = User::find($this->userId);
            $user->increment('balance', $this->final_amount);
            Txn::update($this->txn, TxnStatus::Failed, $this->userId);
        }

    }
}
