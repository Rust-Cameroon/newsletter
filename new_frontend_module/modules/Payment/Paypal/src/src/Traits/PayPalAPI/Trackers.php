<?php

namespace Srmklive\PayPal\Traits\PayPalAPI;

trait Trackers
{
    /**
     * Show tracking information.
     *
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/tracking/v1/#trackers_get
     */
    public function showTrackingDetails(string $tracking_id)
    {
        $this->apiEndPoint = "v1/shipping/trackers/{$tracking_id}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }

    /**
     * Update tracking information.
     *
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/tracking/v1/#trackers_put
     */
    public function updateTrackingDetails(string $tracking_id, array $data)
    {
        $this->apiEndPoint = "v1/shipping/trackers/{$tracking_id}";

        $this->options['json'] = $data;

        $this->verb = 'put';

        return $this->doPayPalRequest(false);
    }

    /**
     * Add batch tracking.
     *
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/tracking/v1/#trackers-batch_post
     */
    public function addBatchTracking(array $data)
    {
        $this->apiEndPoint = 'v1/shipping/trackers-batch';

        $this->options['json'] = $data;

        $this->verb = 'post';

        return $this->doPayPalRequest();
    }
}
