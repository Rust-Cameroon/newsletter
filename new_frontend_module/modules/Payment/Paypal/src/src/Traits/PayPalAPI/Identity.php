<?php

namespace Srmklive\PayPal\Traits\PayPalAPI;

trait Identity
{
    /**
     * Get user profile information.
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/identity/v1/#userinfo_get
     */
    public function showProfileInfo()
    {
        $this->apiEndPoint = 'v1/identity/oauth2/userinfo?schema=paypalv1.1';

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }

    /**
     * Create a merchant application.
     *
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/identity/v1/#applications_post
     */
    public function createMerchantApplication(string $client_name, array $redirect_uris, array $contacts, string $payer_id, string $migrated_app, string $application_type = 'web', string $logo_url = '')
    {
        $this->apiEndPoint = 'v1/identity/applications';

        $this->options['json'] = array_filter([
            'application_type' => $application_type,
            'redirect_uris' => $redirect_uris,
            'client_name' => $client_name,
            'contacts' => $contacts,
            'payer_id' => $payer_id,
            'migrated_app' => $migrated_app,
            'logo_uri' => $logo_url,
        ]);

        $this->verb = 'post';

        return $this->doPayPalRequest();
    }

    /**
     * Create a merchant application.
     *
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/identity/v1/#account-settings_post
     */
    public function setAccountProperties(array $features, string $account_property = 'BRAINTREE_MERCHANT')
    {
        $this->apiEndPoint = 'v1/identity/account-settings';

        $this->options['json'] = [
            'account_property' => $account_property,
            'features' => $features,
        ];

        $this->verb = 'post';

        return $this->doPayPalRequest();
    }

    /**
     * Create a merchant application.
     *
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/identity/v1/#account-settings_deactivate
     */
    public function disableAccountProperties(string $account_property = 'BRAINTREE_MERCHANT')
    {
        $this->apiEndPoint = 'v1/identity/account-settings/deactivate';

        $this->options['json'] = [
            'account_property' => $account_property,
        ];

        $this->verb = 'post';

        return $this->doPayPalRequest();
    }

    /**
     * Get a client token.
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/multiparty/checkout/advanced/integrate/#link-sampleclienttokenrequest
     */
    public function getClientToken()
    {
        $this->apiEndPoint = 'v1/identity/generate-token';

        $this->verb = 'post';

        return $this->doPayPalRequest();
    }
}
