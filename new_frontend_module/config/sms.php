<?php

return [
    'default' => env('SMS_DRIVER', 'nexmo'),

    'connections' => [
        'nexmo' => [
            'nexmo_from' => '',
            'api_key' => '',
            'api_secret' => '',
        ],

        'twilio' => [
            'twilio_sid' => '',
            'twilio_auth_token' => '',
            'twilio_phone' => '',
        ],
    ],

];
