<?php

namespace Bill;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Tpaga
{
    protected $client;

    public function __construct()
    {
        $token = config('tpaga.connections.api_key');

        $this->client = Http::baseUrl('https://production.apiv2.tpaga.co/api/gateway_bill_payment/v1')->withToken(base64_encode($token));
    }

    public function getBalance()
    {
        $response = $this->client->get('/merchant/balance');

        if ($response->status() === 200) {
            return [
                'status' => true,
                'balance' => $response->json('balance'),
                'message' => 'Success',
            ];

        }

        return [
            'stauts' => false,
            'data' => [],
            'message' => $response->json('error_message'),
        ];

    }

    public function getProvider()
    {
        $response = $this->client->get('utility_providers');

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
            'message' => $response->json('error_message'),
        ];

    }

    public function payBill($data)
    {
        $params = [
            'idempotency_token' => Str::random(16),
            'amount' => $data['amount'],
            'utility_provider' => $data['utility_provider'],
            'short_bill_reference' => $data['bill_reference'],
            'payment_token' => Str::random(12),
            'payment_origin' => 'Bill payment',
        ];

        $response = $this->client->get('/utility_providers//bills', $params);

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
            'message' => $response->json('error_message'),
        ];

    }
}
