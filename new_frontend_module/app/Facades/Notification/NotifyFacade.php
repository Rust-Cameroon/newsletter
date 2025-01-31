<?php

namespace App\Facades\Notification;

use Illuminate\Support\Facades\Facade;

class NotifyFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'notify';
    }
}
