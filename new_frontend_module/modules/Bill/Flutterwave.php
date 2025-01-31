<?php

namespace Bill;

use Illuminate\Support\Facades\Http;

class Flutterwave
{
    protected $client;

    public function __construct()
    {
        $secretKey = config('flutterwave.connections.secret_key');

        $this->client = Http::baseUrl('https://api.flutterwave.com/v3')->withToken($secretKey);
    }

    public function getAllCategories($type = null)
    {
        $response = $this->client->withUrlParameters([
            'type' => $type,
        ])->get('/bill-categories?{type}=1');

        if ($response->json('status')) {

            return [
                'status' => true,
                'data' => $response->json('data'),
            ];
        }

        return [
            'status' => false,
            'data' => [],
            'message' => $response->json('message'),
        ];

    }

    public function validatePay($customer, $item_code, $biller_code)
    {
        $response = $this->client->withUrlParameters([
            'item_code' => $item_code,
        ])->get('/bill-items/{item_code}/validate', [
            'code' => $biller_code,
            'customer' => $customer,
        ]);

        dd($response->json());

        if ($response->json('status') == 'success') {
            return [
                'status' => 'success',
            ];
        }

        return [
            'status' => false,
            'message' => $response->json('message'),
        ];

    }

    public function payBill($params)
    {
        // $item_code = data_get(json_decode($service->data,true),'item_code');
        // $validate = $this->validatePay($params['customer'],$item_code,$service->code);
        return $this->createPayment($params);
    }

    public function createPayment($params)
    {
        $response = $this->client->post('bills', $params);

        if ($response->json('status') == 'success') {

            return [
                'status' => true,
                'message' => $response->json('message'),
                'data' => $response->json('data'),
            ];

        }

        return [
            'status' => false,
            'data' => [],
            'message' => $response->json('message'),
        ];

    }
}
