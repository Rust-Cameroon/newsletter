<?php

namespace Bill;

use Illuminate\Support\Facades\Http;

class Bloc
{
    protected $client;

    public function __construct()
    {
        $token = config('bloc.connections.api_key');
        $this->client = Http::baseUrl('https://api.blochq.io/v1/bills')->withToken($token);
    }

    public function getOperators($bill)
    {
        $response = $this->client->get('operators', [
            'bill' => $bill,
        ]);

        if ($response->json('success')) {

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

    public function getOperatorProducts($bill, $operatorId)
    {
        $response = $this->client->withUrlParameters([
            'operatorID' => $operatorId,
            'bill' => $bill,
        ])->get('operators/{operatorID}/products?bill={bill}');

        if ($response->json('success')) {

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

    public function payBill($params)
    {

    }
}
