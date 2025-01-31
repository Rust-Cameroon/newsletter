<?php

namespace Payment\Transaction;

class BaseTxn
{
    protected float $amount;

    protected float $final_amount;

    protected string $currency;

    protected string $txn;

    protected string $siteName;

    protected string $userName;

    protected string $userEmail;

    protected string $userPhone;

    public function __construct($txnInfo)
    {
        $this->amount = $txnInfo->pay_amount;
        $this->final_amount = $txnInfo->final_amount;
        $this->currency = $txnInfo->pay_currency;
        $this->txn = $txnInfo->tnx;
        $this->siteName = setting('site_title', 'global');
        $this->userName = $txnInfo->user->full_name;
        $this->userEmail = $txnInfo->user->email;
        $this->userPhone = $txnInfo->user->phone;
        $this->userId = $txnInfo->user->id;
    }
}
