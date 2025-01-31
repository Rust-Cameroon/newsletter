<?php

namespace App\Providers;

use App\Facades\Txn\Txn;
use Illuminate\Support\ServiceProvider;

class TxnProvider extends ServiceProvider
{
    /**
     * Register modules.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('txn', function () {
            return new Txn();
        });
    }

    /**
     * Bootstrap modules.
     *
     * @return void
     */
    public function boot()
    {

    }
}
