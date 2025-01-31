<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Twilio\Rest\Client;

trait SmsTrait
{
    protected function sendSms($phone, $message)
    {

        if (config('sms.default') == 'Nexmo') {
            $this->nexmo($phone, $message);
        } elseif (config('sms.default') == 'Twilio') {
            $this->twilio($phone, $message);
        }
    }

    protected function nexmo($phone, $message)
    {

        try {
            $gatewayCredentials = config('sms.connections.nexmo');
            $params = [
                'api_key' => $gatewayCredentials['api_key'],
                'api_secret' => $gatewayCredentials['api_secret'],
                'from' => $gatewayCredentials['nexmo_from'],
                'to' => $phone,
                'text' => $message['message_body'],
            ];

            $response = Http::post('https://rest.nexmo.com/sms/json', $params);
            $json = $response->json();

        } catch (Exception $e) {
            notify()->error('Connection failed', 'Error');

            return false;
        }
    }

    protected function twilio($phone, $message)
    {
        $gatewayCredentials = Config::get('sms.connections.twilio');

        $twilioAccountSid = $gatewayCredentials['twilio_sid'];
        $twilioAuthToken = $gatewayCredentials['twilio_auth_token'];
        $twilioPhoneNumber = $gatewayCredentials['twilio_phone'];
        $twilio = new Client($twilioAccountSid, $twilioAuthToken);

        $twilio->messages->create(
            $phone,
            [
                'from' => $twilioPhoneNumber,
                'body' => $message['message_body'],
            ]
        );

    }
}
