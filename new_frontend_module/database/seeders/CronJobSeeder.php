<?php

namespace Database\Seeders;

use App\Models\CronJob;
use Illuminate\Database\Seeder;

class CronJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = [
            [
                'name' => 'User Portfolio',
                'next_run_at' => now()->addMinutes(1),
                'schedule' => 86400,
                'type' => 'system',
                'reserved_method' => 'userPortfolio',
                'status' => 'running',
            ],
            [
                'name' => 'User Inactive Account Disabled',
                'next_run_at' => now()->addMinutes(1),
                'schedule' => 86400,
                'type' => 'system',
                'reserved_method' => 'userInactive',
                'status' => 'running',
            ],
            [
                'name' => 'DPS',
                'next_run_at' => now()->addMinutes(1),
                'schedule' => 86400,
                'type' => 'system',
                'reserved_method' => 'dps',
                'status' => 'running',
            ],
            [
                'name' => 'FDR',
                'next_run_at' => now()->addMinutes(1),
                'schedule' => 86400,
                'type' => 'system',
                'reserved_method' => 'fdr',
                'status' => 'running',
            ],
            [
                'name' => 'Loan',
                'next_run_at' => now()->addMinutes(1),
                'schedule' => 86400,
                'type' => 'system',
                'reserved_method' => 'loan',
                'status' => 'running',
            ],
        ];

        CronJob::insert($jobs);
    }
}
