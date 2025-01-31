<?php

namespace Bill;

use Illuminate\Support\Facades\Http;

class Reloadly
{
    protected $client;

    protected $accessToken;

    public function __construct()
    {

        $response = $this->getAccessToken();

        if (data_get($response, 'status')) {

            $this->accessToken = data_get($response, 'access_token');

        } else {

            notify()->error(data_get($response, 'message'), 'Error');

            return back();
        }

        $this->client = Http::baseUrl(config('reloadly.connections.live_or_sandbox_url'))->withToken($this->accessToken);

    }

    public function getAccessToken()
    {
        $params = [
            'client_id' => config('reloadly.connections.client_id'),
            'client_secret' => config('reloadly.connections.client_secret'),
            'grant_type' => 'client_credentials',
            'audience' => config('reloadly.connections.live_or_sandbox_url'),
        ];

        $response = Http::post('https://auth.reloadly.com/oauth/token', $params);

        if ($response->status() === 200) {

            return [
                'status' => true,
                'access_token' => $response->json('access_token'),
            ];

        }

        return [
            'status' => false,
            'message' => $response->json('messaage'),
        ];

    }

    public function getBiller($type)
    {
        $params = [
            'type' => $type,
        ];

        $response = $this->client->get('billers', $params);

        if ($response->status() === 200) {

            return [
                'status' => true,
                'data' => $response->json('data'),
                'message' => $response->json('message'),
            ];

        }

        return [
            'status' => false,
            'data' => [],
            'message' => $response->json('message'),
        ];

    }

    public function payBill($data)
    {
        $params = [
            'billerId' => $data['billerId'],
            'amount' => $data['amount'],
            'amountId' => $data['amount_id'] ?? null,
            'billerId' => $data['biller_id'] ?? null,
            'useLocalAmount' => false,
            'referenceId' => $data['reference'] ?? 'None',
            'subscriberAccountNumber' => $data['subscriberAccountNumber'] ?? '',
        ];

        $response = $this->client->post('pay', $params);

        if ($response->status() === 200) {
            return [
                'status' => true,
                'data' => $response->json(),
                'message' => 'Success',
            ];

        }

        return [
            'stauts' => false,
            'data' => [],
            'message' => $response->json('message'),
        ];

    }
}
