<?php

declare(strict_types=1);

namespace BTCPayServer\Client;

use BTCPayServer\Result\StorePaymentMethodOnChain as ResultStorePaymentMethodOnChain;

/**
 * Handles stores on chain payment methods.
 *
 * @see https://docs.btcpayserver.org/API/Greenfield/v1/#tag/Store-Payment-Methods-(On-Chain)
 */
class StorePaymentMethodOnChain extends AbstractStorePaymentMethodClient
{
    /**
     * @return ResultStorePaymentMethodOnChain[]
     *
     * @throws \JsonException
     */
    public function getPaymentMethods(string $storeId): array
    {
        $url = $this->getApiUrl().'stores/'.urlencode($storeId).'/payment-methods/'.self::PAYMENT_TYPE_ONCHAIN;
        $headers = $this->getRequestHeaders();
        $method = 'GET';
        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            $r = [];
            $data = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            foreach ($data as $item) {
                $r[] = new ResultStorePaymentMethodOnChain($item, $item['cryptoCode']);
            }

            return $r;
        }
        throw $this->getExceptionByStatusCode($method, $url, $response);
    }

    public function getPaymentMethod(string $storeId, string $cryptoCode): ResultStorePaymentMethodOnChain
    {
        $url = $this->getApiUrl().'stores/'.urlencode($storeId).'/payment-methods/'.self::PAYMENT_TYPE_ONCHAIN.'/'.$cryptoCode;
        $headers = $this->getRequestHeaders();
        $method = 'GET';
        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            $data = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

            return new ResultStorePaymentMethodOnChain($data, $data['cryptoCode']);
        }
        throw $this->getExceptionByStatusCode($method, $url, $response);
    }

    /**
     * Update OnChain payment methods.
     *
     *
     * @param  array  $settings  Array of data to update. e.g
     *                           [
     *                           'enabled' => true,
     *                           'derivationScheme' => 'xpub...',
     *                           'label' => 'string',
     *                           'accountKeyPath' => "abcd82a1/84'/0'/0'"
     *                           ]
     *
     * @throws \JsonException
     */
    public function updatePaymentMethod(string $storeId, string $cryptoCode, array $settings): \BTCPayServer\Result\StorePaymentMethodOnChain
    {
        $url = $this->getApiUrl().'stores/'.urlencode($storeId).'/payment-methods/'.self::PAYMENT_TYPE_ONCHAIN.'/'.$cryptoCode;
        $headers = $this->getRequestHeaders();
        $method = 'PUT';
        $response = $this->getHttpClient()->request($method, $url, $headers, json_encode($settings));

        if ($response->getStatus() === 200) {
            $data = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

            return new \BTCPayServer\Result\StorePaymentMethodOnChain($data, $data['cryptoCode']);
        }
        throw $this->getExceptionByStatusCode($method, $url, $response);
    }

    /**
     * Gets a list of OnChain addresses for the current configured xpub/wallet.
     *
     *
     * @return \BTCPayServer\Result\Address[]
     *
     * @throws \JsonException
     */
    public function previewPaymentMethodAddresses(string $storeId, string $cryptoCode): array
    {
        // todo: add offset + amount query parameters

        $url = $this->getApiUrl().'stores/'.urlencode($storeId).'/payment-methods/'.self::PAYMENT_TYPE_ONCHAIN.'/'.$cryptoCode.'/preview';
        $headers = $this->getRequestHeaders();
        $method = 'GET';
        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            $addressList = new \BTCPayServer\Result\AddressList(
                json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR)
            );

            return $addressList->all();
        }
        throw $this->getExceptionByStatusCode($method, $url, $response);
    }

    /**
     * Returns OnChain addresses for any given xpub ($derivationScheme) and
     * account key path.
     *
     * On how to format the account key path please check the Greenfield API
     * docs.
     *
     *
     * @return \BTCPayServer\Result\Address[]
     *
     * @throws \JsonException
     */
    public function previewProposedPaymentMethodAddresses(
        string $storeId,
        string $cryptoCode,
        string $derivationScheme,
        ?string $accountKeyPath = null
    ): array {
        // todo: add offset + amount query parameters + check structure of derivationScheme etc.

        $url = $this->getApiUrl().'stores/'.urlencode($storeId).'/payment-methods/'.self::PAYMENT_TYPE_ONCHAIN.'/'.$cryptoCode.'/preview';
        $headers = $this->getRequestHeaders();
        $method = 'POST';
        $body = json_encode([
            'derivationScheme' => $derivationScheme,
            'accountKeyPath' => $accountKeyPath,
        ]);
        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if ($response->getStatus() === 200) {
            $addressList = new \BTCPayServer\Result\AddressList(
                json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR)
            );

            return $addressList->all();
        }
        throw $this->getExceptionByStatusCode($method, $url, $response);
    }

    /**
     * Disables the OnChain payment method. It also removes your configured
     * xpub key.
     *
     * @param  string  $cryptoCode  e.g. BTC
     */
    public function removePaymentMethod(string $storeId, string $cryptoCode): bool
    {
        $url = $this->getApiUrl().'stores/'.urlencode($storeId).'/payment-methods/'.self::PAYMENT_TYPE_ONCHAIN.'/'.$cryptoCode;
        $headers = $this->getRequestHeaders();
        $method = 'DELETE';
        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            return true;
        }
        throw $this->getExceptionByStatusCode($method, $url, $response);
    }
}
