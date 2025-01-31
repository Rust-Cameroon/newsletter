<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use UfitpayInterface;

class UfitpayService implements UfitpayInterface
{
    protected $client;

    private $headers = [];

    public function __construct()
    {
        $credentials = config('ufitpay.connections');

        $this->client = new Client();

        // Headers Set
        $this->headers = [
            'api-key' => $credentials['api_key'],
            'api-token' => $credentials['api_token'],
        ];
    }

    public function getExchangeRate(string $currency)
    {
        try {
            $response = $this->client->post('https://api.ufitpay.com/v1/get_exchange_rate', [
                'headers' => $this->headers,
                'multipart' => [
                    [
                        'name' => 'currency',
                        'contents' => $currency,
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if ($data['status'] === 'success') {
                $currency = $data['data']['currency'];
                $exchangeRate = $data['data']['exchange_rate'];

                return response()->json(['currency' => $currency, 'exchange_rate' => $exchangeRate]);
            }

            return response()->json(['error' => 'Failed to get exchange rate'], 500);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createCardHolder(array $data)
    {
        try {
            $response = $this->client->post('https://api.ufitpay.com/v1/create_card_holder', [
                'headers' => $this->headers,
                'multipart' => $data,
            ]);

            $data = json_decode($response->getBody(), true);
            if ($data['status'] === 'success') {
                $return = [];
                $return['resource'] = $data['resource'];
                $return['card_holder_id'] = $data['data']['card_holder_id'];
                $return['first_name'] = $data['data']['first_name'];
                $return['last_name'] = $data['data']['last_name'];
                $return['status'] = $data['data']['status'];

                return response()->json($return);
            }

            return response()->json(['error' => 'Failed to create Card Holder'], 500);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteCardHolder(string $cardHolderId)
    {
        try {
            $response = $this->client->post('https://api.ufitpay.com/v1/delete_card_holder', [
                'headers' => $this->headers,
                'multipart' => [
                    [
                        'name' => 'card_holder_id',
                        'contents' => $cardHolderId,
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            if ($data['status'] === 'success') {
                $return = [];
                $return['resource'] = $data['resource'];
                $return['card_holder_id'] = $data['data']['card_holder_id'];
                $return['status'] = $data['data']['status'];

                return response()->json($return);
            }

            return response()->json(['error' => 'Failed to delete Card Holder'], 500);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createVirtualCard(array $data)
    {
        try {
            $response = $this->client->post('https://api.ufitpay.com/v1/create_virtual_card', [
                'headers' => $this->headers,
                'multipart' => $data,
            ]);

            $data = json_decode($response->getBody(), true);
            if ($data['status'] === 'success') {
                $return = [];
                $return['resource'] = $data['resource'];
                $return['data'] = $data['data'];

                return response()->json($return);
            }

            return response()->json(['error' => 'Failed to create virtual card'], 500);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function listVirtualCard(?string $currency = null)
    {
        try {
            $response = $this->client->post('https://api.ufitpay.com/v1/list_virtual_cards', [
                'headers' => $this->headers,
                'multipart' => [
                    [
                        'name' => 'currency',
                        'contents' => $currency,
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            if ($data['status'] === 'success') {
                $return = [];
                $return['resource'] = $data['resource'];
                $return['data'] = $data['data'];

                return response()->json($return);
            }

            return response()->json(['error' => 'Failed to fetch virtual card'], 500);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function cardDetails(string $id)
    {
        try {
            $response = $this->client->post('https://api.ufitpay.com/v1/get_virtual_card', [
                'headers' => $this->headers,
                'multipart' => [
                    [
                        'name' => 'id',
                        'contents' => $id,
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            if ($data['status'] === 'success') {
                $return = [];
                $return['resource'] = $data['resource'];
                $return['data'] = $data['data'];

                return response()->json($return);
            }

            return response()->json(['error' => 'Failed to fetch virtual card details'], 500);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fund(array $data)
    {
        try {
            $response = $this->client->post('https://api.ufitpay.com/v1/fund_virtual_card', [
                'headers' => $this->headers,
                'multipart' => $data,
            ]);

            $data = json_decode($response->getBody(), true);
            if ($data['status'] === 'success') {
                $return = [];
                $return['resource'] = $data['resource'];
                $return['data'] = $data['data'];

                return response()->json($return);
            }

            return response()->json(['error' => 'Failed to fund virtual card'], 500);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function withdraw(array $data)
    {
        try {
            $response = $this->client->post('https://api.ufitpay.com/v1/withdraw_virtual_card_balance', [
                'headers' => $this->headers,
                'multipart' => $data,
            ]);

            $data = json_decode($response->getBody(), true);
            if ($data['status'] === 'success') {
                $return = [];
                $return['resource'] = $data['resource'];
                $return['data'] = $data['data'];

                return response()->json($return);
            }

            return response()->json(['error' => 'Failed to Withdraw'], 500);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function changeStatus(array $data)
    {
        try {
            $response = $this->client->post('https://api.ufitpay.com/v1/update_card_status', [
                'headers' => $this->headers,
                'multipart' => $data,
            ]);

            $data = json_decode($response->getBody(), true);
            if ($data['status'] === 'success') {
                $return = [];
                $return['resource'] = $data['resource'];
                $return['data'] = $data['data'];

                return response()->json($return);
            }

            return response()->json(['error' => 'Failed to update status'], 500);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(string $id, string $callback = '')
    {
        try {
            $response = $this->client->post('https://api.ufitpay.com/v1/update_card_details', [
                'headers' => $this->headers,
                'multipart' => [
                    [
                        'id' => $id,
                        'callback_url' => $callback,
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            if ($data['status'] === 'success') {
                $return = [];
                $return['resource'] = $data['resource'];
                $return['id'] = $data['data']['id'];

                return response()->json($return);
            }

            return response()->json(['error' => 'Failed to update card details'], 500);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchTransaction(string $id, string $limit_datetime = '')
    {
        try {
            $response = $this->client->post('https://api.ufitpay.com/v1/get_card_transactions', [
                'headers' => $this->headers,
                'multipart' => [
                    [
                        'id' => $id,
                        'limit_datetime' => $limit_datetime,
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            if ($data['status'] === 'success') {
                $return = [];
                $return['resource'] = $data['resource'];
                $return['data'] = $data['data'];

                return response()->json($return);
            }

            return response()->json(['error' => 'Failed to fetch transaction'], 500);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function changePin(string $id)
    {
        try {
            $response = $this->client->post('https://api.ufitpay.com/v1/change_card_pin', [
                'headers' => $this->headers,
                'multipart' => [
                    [
                        'id' => $id,
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            if ($data['status'] === 'success') {
                $return = [];
                $return['resource'] = $data['resource'];
                $return['data'] = $data['data'];

                return response()->json($return);
            }

            return response()->json(['error' => 'Failed to change pin'], 500);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteCard(string $id)
    {
        try {
            $response = $this->client->post('https://api.ufitpay.com/v1/delete_card', [
                'headers' => $this->headers,
                'multipart' => [
                    [
                        'id' => $id,
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if ($data['status'] === 'success') {
                $return = [];
                $return['resource'] = $data['resource'];
                $return['data'] = $data['data'];

                return response()->json($return);
            }

            return response()->json(['error' => 'Failed to delete card'], 500);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
