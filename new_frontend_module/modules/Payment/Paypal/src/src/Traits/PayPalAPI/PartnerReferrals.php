<?php

namespace Srmklive\PayPal\Traits\PayPalAPI;

trait PartnerReferrals
{
    /**
     * Create a Partner Referral.
     *
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/partner-referrals/v2/#partner-referrals_create
     */
    public function createPartnerReferral(array $partner_data)
    {
        $this->apiEndPoint = 'v2/customer/partner-referrals';

        $this->options['json'] = $partner_data;

        $this->verb = 'post';

        return $this->doPayPalRequest();
    }

    /**
     * Get Partner Referral Details.
     *
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/partner-referrals/v2/#partner-referrals_read
     */
    public function showReferralData(string $partner_referral_id)
    {
        $this->apiEndPoint = "v2/customer/partner-referrals/{$partner_referral_id}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }
}
