<?php

namespace Razorpay\Api;

class FundAccount extends Entity
{
    /**
     * Create a Fund Account .
     *
     * @param  array  $attributes
     * @return FundAccount
     */
    public function create($attributes = [])
    {
        return parent::create($attributes);
    }

    /**
     * Fetch all Fund Accounts
     *
     * @param  array  $options
     * @return Collection
     */
    public function all($options = [])
    {
        return parent::all($options);
    }
}
