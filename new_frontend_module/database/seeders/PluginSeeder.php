<?php

namespace Database\Seeders;

use App\Models\Plugin;
use Illuminate\Database\Seeder;

class PluginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plugin::create([
            'icon' => 'global/plugin/ufitpay.png',
            'type' => 'system',
            'name' => 'Ufitpay',
            'description' => 'Supported Currency are "NGN" and "USD" only',
            'data' => json_encode([
                'api_key' => '',
                'api_token' => '',
            ]),
            'status' => 0,
        ]);
    }
}
