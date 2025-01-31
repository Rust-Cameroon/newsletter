<?php

namespace App\Facades\Txn;

use Illuminate\Support\Facades\Facade;

class TxnFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'txn';
    }
}
