<?php

return [
    'apiKey' => env('COINBASE_API_KEY'),
    'apiVersion' => env('COINBASE_API_VERSION'),

    'webhookSecret' => env('COINBASE_WEBHOOK_SECRET'),
    'webhookJobs' => [
    ],
    'webhookModel' => Shakurov\Coinbase\Models\CoinbaseWebhookCall::class,
];
