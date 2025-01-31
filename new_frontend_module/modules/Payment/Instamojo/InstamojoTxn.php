<?php

namespace Payment\Instamojo;

use Exception;
use GuzzleHttp\Client;
use Payment\Transaction\BaseTxn;

class InstamojoTxn extends BaseTxn
{
    private $apiKey;

    private $authToken;

    private $salt;

    /**
     * @var mixed|string
     */
    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);

        $gatewayInfo = gateway_info('instamojo');
        $this->apiKey = $gatewayInfo->api_key;
        $this->authToken = $gatewayInfo->auth_token;
        $this->salt = $gatewayInfo->salt;

    }

    public function deposit()
    {

        try {
            $client = new Client();
            $response = $client->post('https://www.instamojo.com/api/1.1/payment-requests/', [
                'headers' => [
                    'X-Api-Key' => $this->apiKey,
                    'X-Auth-Token' => $this->authToken,
                ],
                'form_params' => [
                    'purpose' => 'Payment for '.$this->siteName,
                    'amount' => $this->amount,
                    'buyer_name' => $this->userName,
                    'email' => $this->userEmail,
                    'phone' => $this->userPhone,
                    'send_email' => true,
                    'allow_repeated_payments' => false,
                    'redirect_url' => route('status.success'), // Define this route
                    'webhook' => route('ipn.instamojo', ['txn' => $this->txn]),  // Optional
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return redirect($data['payment_request']['longurl']);

        } catch (Exception $e) {
            notify()->error('Something went wrong, Please check api', 'api error');

            return redirect()->back();
        }

    }
}
