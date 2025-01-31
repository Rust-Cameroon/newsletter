<?php

namespace Razorpay\Api;

class Token extends Entity
{
    public function create($attributes = [])
    {
        $url = $this->getEntityUrl();

        return $this->request('POST', $url, $attributes);
    }

    /**
     * @param  $id  Token id
     */
    public function fetch($id)
    {
        $relativeUrl = 'customers/'.$this->customer_id.'/'.$this->getEntityUrl().$id;

        return $this->request('GET', $relativeUrl);
    }

    public function fetchCardPropertiesByToken($attributes = [])
    {
        $relativeUrl = $this->getEntityUrl().'/fetch';

        return $this->request('POST', $relativeUrl, $attributes);
    }

    public function all($options = [])
    {
        $relativeUrl = 'customers/'.$this->customer_id.'/'.$this->getEntityUrl();

        return $this->request('GET', $relativeUrl, $options);
    }

    public function delete($id)
    {
        $relativeUrl = 'customers/'.$this->customer_id.'/'.$this->getEntityUrl().$id;

        return $this->request('DELETE', $relativeUrl);
    }

    public function deleteToken($attributes = [])
    {
        $relativeUrl = $this->getEntityUrl().'/delete';

        return $this->request('POST', $relativeUrl, $attributes);
    }

    public function processPaymentOnAlternatePAorPG($attributes = [])
    {
        $relativeUrl = $this->getEntityUrl().'service_provider_tokens/token_transactional_data';

        return $this->request('POST', $relativeUrl, $attributes);
    }
}
