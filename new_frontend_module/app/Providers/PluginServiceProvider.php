<?php

namespace App\Providers;

use Schema;
use Illuminate\Support\ServiceProvider;
use Remotelywork\Installer\Repository\App;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        if (App::dbConnectionCheck() && Schema::hasTable('plugins')) {

            // Nexmo sms plugin
            if (plugin_active('Nexmo')) {
                $nexmoCredential = json_decode(plugin_active('Nexmo')->data);
                config()->set([
                    'sms.connections.nexmo.nexmo_from' => $nexmoCredential->from,
                    'sms.connections.nexmo.api_key' => $nexmoCredential->api_key,
                    'sms.connections.nexmo.api_secret' => $nexmoCredential->api_secret,
                ]);
            }

            // Twilio sms plugin
            if (plugin_active('Twilio')) {
                $twilioCredential = json_decode(plugin_active('Twilio')->data);
                config()->set([
                    'sms.connections.twilio.twilio_sid' => $twilioCredential->twilio_sid,
                    'sms.connections.twilio.twilio_auth_token' => $twilioCredential->twilio_auth_token,
                    'sms.connections.twilio.twilio_phone' => $twilioCredential->twilio_phone,
                ]);
            }

            // Pusher Notification plugin
            if (plugin_active('Pusher')) {
                $push_notification = plugin_active('Pusher');
                if ($push_notification->name == 'Pusher') {
                    $pusherCredential = json_decode($push_notification->data);
                    config()->set([
                        'broadcasting.connections.pusher.app_id' => $pusherCredential->pusher_app_id,
                        'broadcasting.connections.pusher.key' => $pusherCredential->pusher_app_key,
                        'broadcasting.connections.pusher.secret' => $pusherCredential->pusher_app_secret,
                        'broadcasting.connections.pusher.options.cluster' => $pusherCredential->pusher_app_cluster,
                    ]);
                }
            }

            // Reloadly Plugin
            if (plugin_active('Reloadly')) {
                $reloadly = plugin_active('Reloadly');
                if ($reloadly->name == 'Reloadly') {
                    $reloadlyCredentials = json_decode($reloadly->data);
                    config()->set([
                        'reloadly.connections.client_id' => $reloadlyCredentials->client_id,
                        'reloadly.connections.client_secret' => $reloadlyCredentials->client_secret,
                        'reloadly.connections.live_or_sandbox_url' => $reloadlyCredentials->live_or_sandbox_url,
                    ]);
                }
            }

            // Flutterwave Plugin
            if (plugin_active('Flutterwave')) {
                $flutterwave = plugin_active('Flutterwave');
                if ($flutterwave->name == 'Flutterwave') {

                    $flutterwaveCredentials = json_decode($flutterwave->data);

                    config()->set([
                        'flutterwave.connections.secret_key' => $flutterwaveCredentials->secret_key,
                    ]);
                }
            }

            // Bloc Plugin
            if (plugin_active('Bloc')) {
                $bloc = plugin_active('Bloc');
                if ($bloc->name == 'Bloc') {

                    $blocCredentials = json_decode($bloc->data);

                    config()->set([
                        'bloc.connections.api_key' => $blocCredentials->api_key,
                    ]);
                }
            }

            // Tpaga Plugin
            if (plugin_active('Tpaga')) {
                $tpaga = plugin_active('Tpaga');
                if ($tpaga->name == 'Tpaga') {
                    $tpagaCredentials = json_decode($tpaga->data);
                    config()->set([
                        'tpaga.connections.api_key' => $tpagaCredentials->api_key,
                    ]);
                }
            }

            // Default plugin
            config()->set('sms.default', default_plugin('sms') ?? false);

        }

    }
}
