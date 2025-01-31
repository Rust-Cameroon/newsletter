<?php

namespace Database\Seeders;

use App\Models\UserNavigation;
use Illuminate\Database\Seeder;

class UserNavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserNavigation::truncate();

        $navigations = [
            [
                'type' => 'dashboard',
                'icon' => 'inbox',
                'url' => 'user/dashboard',
                'name' => 'Dashboard',
                'position' => 1,
            ],
            [
                'type' => 'deposit',
                'icon' => 'plus-circle',
                'url' => 'user/deposit',
                'name' => 'Deposit',
                'position' => 2,
            ],
            [
                'type' => 'fund_transfer',
                'icon' => 'send',
                'url' => 'user/fund-transfer',
                'name' => 'Fund Transfer',
                'position' => 3,
            ],
            [
                'type' => 'dps',
                'icon' => 'archive',
                'url' => 'user/dps',
                'name' => 'DPS',
                'position' => 4,
            ],
            [
                'type' => 'fdr',
                'icon' => 'book',
                'url' => 'user/fdr',
                'name' => 'FDR',
                'position' => 5,
            ],
            [
                'type' => 'loan',
                'icon' => 'alert-triangle',
                'url' => 'user/loan',
                'name' => 'Loan',
                'position' => 6,
            ],
            [
                'type' => 'pay_bill',
                'icon' => 'credit-card',
                'url' => 'user/pay-bill/airtime',
                'name' => 'Pay Bill',
                'position' => 7,
            ],
            [
                'type' => 'transactions',
                'icon' => 'alert-circle',
                'url' => 'user/transactions',
                'name' => 'Transactions',
                'position' => 8,
            ],
            [
                'type' => 'withdraw',
                'icon' => 'box',
                'url' => 'user/withdraw',
                'name' => 'Withdraw',
                'position' => 9,
            ],
            [
                'type' => 'referral',
                'icon' => 'users',
                'url' => 'user/referral',
                'name' => 'Referral',
                'position' => 10,
            ],
            [
                'type' => 'portfolio',
                'icon' => 'pie-chart',
                'url' => 'user/portfolio',
                'name' => 'Portfolio',
                'position' => 11,
            ],
            [
                'type' => 'rewards',
                'icon' => 'gift',
                'url' => 'user/rewards',
                'name' => 'Rewards',
                'position' => 12,
            ],
            [
                'type' => 'support',
                'icon' => 'message-circle',
                'url' => 'user/support-ticket/index',
                'name' => 'Support',
                'position' => 13,
            ],
            [
                'type' => 'settings',
                'icon' => 'settings',
                'url' => 'user/settings',
                'name' => 'Settings',
                'position' => 14,
            ],
            [
                'type' => 'logout',
                'icon' => 'log-out',
                'url' => '',
                'name' => 'Logout',
                'position' => 15,
            ],
        ];

        UserNavigation::insert($navigations);
    }
}
