<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissions = [

            ['category' => 'Statistics Management', 'name' => 'total-users'],
            ['category' => 'Statistics Management', 'name' => 'active-users'],
            ['category' => 'Statistics Management', 'name' => 'disabled-users'],
            ['category' => 'Statistics Management', 'name' => 'total-staff'],
            ['category' => 'Statistics Management', 'name' => 'total-deposits'],
            ['category' => 'Statistics Management', 'name' => 'total-withdraw'],
            ['category' => 'Statistics Management', 'name' => 'total-referral'],
            ['category' => 'Statistics Management', 'name' => 'total-fund-transfer'],
            ['category' => 'Statistics Management', 'name' => 'total-dps'],
            ['category' => 'Statistics Management', 'name' => 'total-fdr'],
            ['category' => 'Statistics Management', 'name' => 'total-loan'],
            ['category' => 'Statistics Management', 'name' => 'total-pay-bill'],
            ['category' => 'Statistics Management', 'name' => 'total-reward-points'],
            ['category' => 'Statistics Management', 'name' => 'deposit-bonus'],
            ['category' => 'Statistics Management', 'name' => 'total-automatic-gateway'],
            ['category' => 'Statistics Management', 'name' => 'total-ticket'],
            ['category' => 'Statistics Management', 'name' => 'site-statistics-chart'],
            ['category' => 'Statistics Management', 'name' => 'fund-transfer-statistics'],

            ['category' => 'Statistics Management', 'name' => 'top-country-statistics'],
            ['category' => 'Statistics Management', 'name' => 'top-browser-statistics'],
            ['category' => 'Statistics Management', 'name' => 'top-os-statistics'],
            ['category' => 'Statistics Management', 'name' => 'latest-users'],

            ['category' => 'Customer Management', 'name' => 'customer-list'],
            ['category' => 'Customer Management', 'name' => 'customer-login'],
            ['category' => 'Customer Management', 'name' => 'customer-mail-send'],
            ['category' => 'Customer Management', 'name' => 'customer-basic-manage'],
            ['category' => 'Customer Management', 'name' => 'customer-balance-add-or-subtract'],
            ['category' => 'Customer Management', 'name' => 'customer-change-password'],
            ['category' => 'Customer Management', 'name' => 'all-type-status'],

            ['category' => 'Kyc Management', 'name' => 'kyc-list'],
            ['category' => 'Kyc Management', 'name' => 'kyc-action'],
            ['category' => 'Kyc Management', 'name' => 'kyc-form-manage'],

            ['category' => 'Role Management', 'name' => 'role-list'],
            ['category' => 'Role Management', 'name' => 'role-create'],
            ['category' => 'Role Management', 'name' => 'role-edit'],

            ['category' => 'Staff Management', 'name' => 'staff-list'],
            ['category' => 'Staff Management', 'name' => 'staff-create'],
            ['category' => 'Staff Management', 'name' => 'staff-edit'],

            ['category' => 'Transaction Management', 'name' => 'transaction-list'],
            ['category' => 'Transaction Management', 'name' => 'user-paybacks'],
            ['category' => 'Transaction Management', 'name' => 'bank-profit'],

            ['category' => 'Branch Management', 'name' => 'branch-list'],
            ['category' => 'Branch Management', 'name' => 'branch-create'],
            ['category' => 'Branch Management', 'name' => 'branch-edit'],
            ['category' => 'Branch Management', 'name' => 'branch-delete'],
            ['category' => 'Branch Management', 'name' => 'branch-staff-list'],
            ['category' => 'Branch Management', 'name' => 'branch-staff-create'],
            ['category' => 'Branch Management', 'name' => 'branch-staff-edit'],
            ['category' => 'Branch Management', 'name' => 'branch-staff-delete'],

            ['category' => 'Fund Transfer Management', 'name' => 'pending-transfers'],
            ['category' => 'Fund Transfer Management', 'name' => 'rejected-transfers'],
            ['category' => 'Fund Transfer Management', 'name' => 'all-transfers'],
            ['category' => 'Fund Transfer Management', 'name' => 'allied-transfers'],
            ['category' => 'Fund Transfer Management', 'name' => 'other-bank-transfers'],
            ['category' => 'Fund Transfer Management', 'name' => 'wire-transfer'],
            ['category' => 'Fund Transfer Management', 'name' => 'others-bank-list'],
            ['category' => 'Fund Transfer Management', 'name' => 'others-bank-create'],
            ['category' => 'Fund Transfer Management', 'name' => 'others-bank-edit'],
            ['category' => 'Fund Transfer Management', 'name' => 'others-bank-delete'],
            ['category' => 'Fund Transfer Management', 'name' => 'fund-transfer-approval'],

            ['category' => 'DPS Management', 'name' => 'dps-plan-list'],
            ['category' => 'DPS Management', 'name' => 'dps-plan-create'],
            ['category' => 'DPS Management', 'name' => 'dps-plan-edit'],
            ['category' => 'DPS Management', 'name' => 'dps-plan-delete'],
            ['category' => 'DPS Management', 'name' => 'ongoing-dps'],
            ['category' => 'DPS Management', 'name' => 'payable-dps'],
            ['category' => 'DPS Management', 'name' => 'complete-dps'],
            ['category' => 'DPS Management', 'name' => 'closed-dps'],
            ['category' => 'DPS Management', 'name' => 'all-dps'],
            ['category' => 'DPS Management', 'name' => 'view-dps-details'],

            ['category' => 'FDR Management', 'name' => 'fdr-plan-list'],
            ['category' => 'FDR Management', 'name' => 'fdr-plan-create'],
            ['category' => 'FDR Management', 'name' => 'fdr-plan-edit'],
            ['category' => 'FDR Management', 'name' => 'fdr-plan-delete'],
            ['category' => 'FDR Management', 'name' => 'running-fdr'],
            ['category' => 'FDR Management', 'name' => 'due-fdr'],
            ['category' => 'FDR Management', 'name' => 'closed-fdr'],
            ['category' => 'FDR Management', 'name' => 'all-fdr'],
            ['category' => 'FDR Management', 'name' => 'view-fdr-details'],

            ['category' => 'Loan Management', 'name' => 'loan-plan-list'],
            ['category' => 'Loan Management', 'name' => 'loan-plan-create'],
            ['category' => 'Loan Management', 'name' => 'loan-plan-edit'],
            ['category' => 'Loan Management', 'name' => 'loan-plan-delete'],
            ['category' => 'Loan Management', 'name' => 'pending-loan'],
            ['category' => 'Loan Management', 'name' => 'running-loan'],
            ['category' => 'Loan Management', 'name' => 'due-loan'],
            ['category' => 'Loan Management', 'name' => 'paid-loan'],
            ['category' => 'Loan Management', 'name' => 'rejected-loan'],
            ['category' => 'Loan Management', 'name' => 'all-loan'],
            ['category' => 'Loan Management', 'name' => 'view-loan-details'],
            ['category' => 'Loan Management', 'name' => 'loan-approval'],

            ['category' => 'Bill Management', 'name' => 'bill-service-import'],
            ['category' => 'Bill Management', 'name' => 'bill-service-list'],
            ['category' => 'Bill Management', 'name' => 'bill-service-edit'],
            ['category' => 'Bill Management', 'name' => 'bill-convert-rate'],
            ['category' => 'Bill Management', 'name' => 'all-bills'],
            ['category' => 'Bill Management', 'name' => 'pending-bills'],
            ['category' => 'Bill Management', 'name' => 'complete-bills'],
            ['category' => 'Bill Management', 'name' => 'return-bills'],

            ['category' => 'Deposit Management', 'name' => 'automatic-gateway-manage'],
            ['category' => 'Deposit Management', 'name' => 'manual-gateway-manage'],
            ['category' => 'Deposit Management', 'name' => 'deposit-list'],
            ['category' => 'Deposit Management', 'name' => 'deposit-action'],

            ['category' => 'Withdraw Management', 'name' => 'withdraw-list'],
            ['category' => 'Withdraw Management', 'name' => 'withdraw-method-manage'],
            ['category' => 'Withdraw Management', 'name' => 'withdraw-action'],
            ['category' => 'Withdraw Management', 'name' => 'withdraw-schedule'],

            ['category' => 'Portfolio Management', 'name' => 'manage-portfolio'],
            ['category' => 'Portfolio Management', 'name' => 'portfolio-create'],
            ['category' => 'Portfolio Management', 'name' => 'portfolio-edit'],

            ['category' => 'Referral Management', 'name' => 'manage-referral'],
            ['category' => 'Referral Management', 'name' => 'referral-create'],
            ['category' => 'Referral Management', 'name' => 'referral-edit'],
            ['category' => 'Referral Management', 'name' => 'referral-delete'],

            ['category' => 'Reward Management', 'name' => 'reward-earning-list'],
            ['category' => 'Reward Management', 'name' => 'reward-earning-create'],
            ['category' => 'Reward Management', 'name' => 'reward-earning-edit'],
            ['category' => 'Reward Management', 'name' => 'reward-earning-delete'],
            ['category' => 'Reward Management', 'name' => 'reward-redeem-list'],
            ['category' => 'Reward Management', 'name' => 'reward-redeem-create'],
            ['category' => 'Reward Management', 'name' => 'reward-redeem-edit'],
            ['category' => 'Reward Management', 'name' => 'reward-redeem-delete'],

            ['category' => 'Frontend Management', 'name' => 'landing-page-manage'],
            ['category' => 'Frontend Management', 'name' => 'page-manage'],
            ['category' => 'Frontend Management', 'name' => 'footer-manage'],
            ['category' => 'Frontend Management', 'name' => 'navigation-manage'],
            ['category' => 'Frontend Management', 'name' => 'custom-css'],

            ['category' => 'Subscriber Management', 'name' => 'subscriber-list'],
            ['category' => 'Subscriber Management', 'name' => 'subscriber-mail-send'],

            ['category' => 'Support Ticket Management', 'name' => 'support-ticket-list'],
            ['category' => 'Support Ticket Management', 'name' => 'support-ticket-action'],

            ['category' => 'Setting Management', 'name' => 'site-setting'],
            ['category' => 'Setting Management', 'name' => 'email-setting'],
            ['category' => 'Setting Management', 'name' => 'plugin-setting'],
            ['category' => 'Setting Management', 'name' => 'language-setting'],
            ['category' => 'Setting Management', 'name' => 'page-setting'],
            ['category' => 'Setting Management', 'name' => 'sms-setting'],
            ['category' => 'Setting Management', 'name' => 'push-notification-setting'],
            ['category' => 'Setting Management', 'name' => 'notification-tune-setting'],

            ['category' => 'Template Management', 'name' => 'sms-template'],
            ['category' => 'Template Management', 'name' => 'email-template'],
            ['category' => 'Template Management', 'name' => 'push-notification-template'],

            ['category' => 'System Management', 'name' => 'manage-cron-job'],
            ['category' => 'System Management', 'name' => 'cron-job-create'],
            ['category' => 'System Management', 'name' => 'cron-job-edit'],
            ['category' => 'System Management', 'name' => 'cron-job-delete'],
            ['category' => 'System Management', 'name' => 'cron-job-logs'],
            ['category' => 'System Management', 'name' => 'cron-job-run'],
            ['category' => 'System Management', 'name' => 'clear-cache'],
            ['category' => 'System Management', 'name' => 'application-details'],
        ];

        foreach ($permissions as $permission) {
            Permission::create(['guard_name' => 'admin', 'name' => $permission['name'], 'category' => $permission['category']]);
        }
    }
}
