<?php

namespace App\Providers;

use Schema;
use Illuminate\Support\ServiceProvider;
use Remotelywork\Installer\Repository\App;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register modules.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap modules.
     *
     * @return void
     */
    public function boot()
    {
        if (App::dbConnectionCheck() && Schema::hasTable('settings')) {

            config()->set([
                'mail.from.name' => setting('email_from_name', 'mail'),
                'mail.from.address' => setting('email_from_address', 'mail'),
                'mail.mailers.smtp.host' => setting('mail_host', 'mail'),
                'mail.mailers.smtp.port' => setting('mail_port', 'mail'),
                'mail.mailers.smtp.encryption' => setting('mail_secure', 'mail'),
                'mail.mailers.smtp.username' => setting('mail_username', 'mail'),
                'mail.mailers.smtp.password' => setting('mail_password', 'mail'),
            ]);

        }
    }
}
