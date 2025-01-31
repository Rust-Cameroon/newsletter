<?php

namespace Srmklive\PayPal\Traits;

trait PayPalAPI
{
    use PayPalAPI\BillingPlans;
    use PayPalAPI\CatalogProducts;
    use PayPalAPI\Disputes;
    use PayPalAPI\DisputesActions;
    use PayPalAPI\Identity;
    use PayPalAPI\Invoices;
    use PayPalAPI\InvoicesSearch;
    use PayPalAPI\InvoicesTemplates;
    use PayPalAPI\Orders;
    use PayPalAPI\PartnerReferrals;
    use PayPalAPI\PaymentAuthorizations;
    use PayPalAPI\PaymentCaptures;
    use PayPalAPI\PaymentExperienceWebProfiles;
    use PayPalAPI\PaymentRefunds;
    use PayPalAPI\Payouts;
    use PayPalAPI\ReferencedPayouts;
    use PayPalAPI\Reporting;
    use PayPalAPI\Subscriptions;
    use PayPalAPI\Trackers;
    use PayPalAPI\WebHooks;
    use PayPalAPI\WebHooksEvents;
    use PayPalAPI\WebHooksVerification;

    /**
     * Login through PayPal API to get access token.
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/get-an-access-token-curl/
     * @see https://developer.paypal.com/docs/api/get-an-access-token-postman/
     */
    public function getAccessToken()
    {
        $this->apiEndPoint = 'v1/oauth2/token';

        $this->options['auth'] = [$this->config['client_id'], $this->config['client_secret']];
        $this->options[$this->httpBodyParam] = [
            'grant_type' => 'client_credentials',
        ];

        $response = $this->doPayPalRequest();

        unset($this->options['auth']);
        unset($this->options[$this->httpBodyParam]);

        if (isset($response['access_token'])) {
            $this->setAccessToken($response);
        }

        return $response;
    }

    /**
     * Set PayPal Rest API access token.
     *
     *
     * @return void
     */
    public function setAccessToken(array $response)
    {
        $this->access_token = $response['access_token'];

        $this->setPayPalAppId($response);

        $this->options['headers']['Authorization'] = "{$response['token_type']} {$this->access_token}";
    }

    /**
     * Set PayPal App ID.
     *
     *
     * @return void
     */
    private function setPayPalAppId(array $response)
    {
        $app_id = empty($response['app_id']) ? $this->config['app_id'] : $response['app_id'];

        $this->config['app_id'] = $app_id;
    }
}
