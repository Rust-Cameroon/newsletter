<?php

namespace Razorpay\Api;

class Refund extends Entity
{
    /**
     * @param  $id  Refund id
     */
    public function fetch($id)
    {
        return parent::fetch($id);
    }

    public function create($attributes = [])
    {
        return parent::create($attributes);
    }

    public function all($options = [])
    {
        return parent::all($options);
    }

    public function edit($attributes = [])
    {
        $url = $this->getEntityUrl().$this->id;

        return $this->request('PATCH', $url, $attributes);
    }

    public function refund($options = [])
    {
        $relativeUrl = $this->getEntityUrl().$this->id.'/refund';

        return $this->request('POST', $relativeUrl, $options);
    }
}
