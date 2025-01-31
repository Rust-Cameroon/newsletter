<?php

namespace Database\Seeders;

use App\Models\PushNotificationTemplate;
use Illuminate\Database\Seeder;

class PushNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = [
            // [
            //     'icon' => 'send',
            //     'name' => 'Fund Transfer Request',
            //     'code' => 'fund_transfer_request',
            //     'for' => 'Admin',
            //     'title' => 'Fund transfer requested from [[full_name]]',
            //     'message_body' => 'Fund transfer requested from [[full_name]]',
            //     'short_codes' => '["[[full_name]]","[[charge]]","[[account_number]]","[[account_name]]","[[branch_name]]","[[amount]]","[[total_amount]]"]'
            // ],
            // [
            //     'icon' => 'send',
            //     'name' => 'Fund Transfer Request',
            //     'code' => 'fund_transfer_request',
            //     'for' => 'User',
            //     'title' => 'Your fund transfer request is [[status]]',
            //     'message_body' => 'Your fund transfer request is [[status]]',
            //     'short_codes' => '["[[full_name]]","[[status]]","[[charge]]","[[account_number]]","[[account_name]]","[[branch_name]]","[[amount]]","[[total_amount]]"]'
            // ],
            // [
            //     'icon' => 'wifi',
            //     'name' => 'Wire Transfer Request',
            //     'code' => 'wire_transfer_request',
            //     'for' => 'Admin',
            //     'title' => 'Wire transfer requested from [[full_name]]',
            //     'message_body' => 'Wire transfer requested from [[full_name]]',
            //     'short_codes' => '["[[full_name]]","[[charge]]","[[account_number]]","[[name_of_account]]","[[swift_code]]","[[phone_number]]","[[amount]]","[[total_amount]]"]'
            // ],
            // [
            //     'icon' => 'wifi',
            //     'name' => 'Wire Transfer Request',
            //     'code' => 'wire_transfer_request',
            //     'for' => 'User',
            //     'title' => 'Your wire transfer request is [[status]]',
            //     'message_body' => 'Your wire transfer request is [[status]]',
            //     'short_codes' => '["[[full_name]]","[[status]]","[[charge]]","[[account_number]]","[[name_of_account]]","[[swift_code]]","[[phone_number]]","[[amount]]","[[total_amount]]"]'
            // ]
            // [
            //     'icon' => 'archive',
            //     'name' => 'DPS Closed',
            //     'code' => 'dps_closed',
            //     'for' => 'User',
            //     'title' => '"[[plan_name]]" DPS is closed',
            //     'message_body' => '"[[plan_name]]" DPS is closed.',
            //     'short_codes' => '["[[plan_name]]","[[dps_id]]","[[per_installment]]","[[interest_rate]]","[[given_installment]]","[[cancel_fee]]","[[total_installment]]","[[matured_amount]]"]'
            // ],
            // [
            //     'icon' => 'archive',
            //     'name' => 'DPS Installment Due',
            //     'code' => 'dps_installment_due',
            //     'for' => 'User',
            //     'title' => '"[[plan_name]]" DPS installment is due.',
            //     'message_body' => '"[[plan_name]]" DPS installment is due.',
            //     'short_codes' => '["[[plan_name]]","[[dps_id]]","[[per_installment]]","[[interest_rate]]","[[installment_date]]","[[delay_charge]]","[[given_installment]]","[[total_installment]]","[[matured_amount]]"]'
            // ],
            // [
            //     'icon' => 'archive',
            //     'name' => 'DPS Completed',
            //     'code' => 'dps_completed',
            //     'for' => 'User',
            //     'title' => '"[[plan_name]]" DPS is completed.',
            //     'message_body' => '"[[plan_name]]" DPS is completed.',
            //     'short_codes' => '["[[plan_name]]","[[dps_id]]","[[per_installment]]","[[interest_rate]]","[[installment_date]]","[[delay_charge]]","[[given_installment]]","[[total_installment]]","[[matured_amount]]"]'
            // ],
            // [
            //     'icon' => 'archive',
            //     'name' => 'DPS Completed',
            //     'code' => 'dps_completed',
            //     'for' => 'Admin',
            //     'title' => '"[[user_name]]" \'s "[[plan_name]]" DPS is completed.',
            //     'message_body' => '[[user_name]]" \'s "[[plan_name]]" DPS is completed.',
            //     'short_codes' => '["[[plan_name]]","[[dps_id]]","[[per_installment]]","[[interest_rate]]","[[installment_date]]","[[delay_charge]]","[[given_installment]]","[[total_installment]]","[[matured_amount]]"]'
            // ],
            // [
            //     'icon' => 'book',
            //     'name' => 'DPS Open',
            //     'code' => 'dps_opened',
            //     'for' => 'Admin',
            //     'title' => '"[[user_name]]", Subscribed "[[plan_name]]" DPS plan.',
            //     'message_body' => '"[[user_name]]", Subscribed "[[plan_name]]" DPS plan.',
            //     'short_codes' => '["[[plan_name]]","[[dps_id]]","[[per_installment]]","[[interest_rate]]","[[given_installment]]","[[total_installment]]","[[matured_amount]]"]'
            // ],
            // [
            //     'icon' => 'book',
            //     'name' => 'FDR Open',
            //     'code' => 'fdr_opened',
            //     'for' => 'Admin',
            //     'title' => '"[[user_name]]", Subscribed "[[plan_name]]" FDR plan.',
            //     'message_body' => '"[[user_name]]", Subscribed "[[plan_name]]" FDR plan.',
            //     'short_codes' => '["[[plan_name]]","[[fdr_id]]","[[amount]]","[[interest_rate]]","[[given_installment]]","[[installment_interval]]","[[next_installment_date]]","[[total_installment]]"'
            // ],
            // [
            //     'icon' => 'book',
            //     'name' => 'FDR Closed',
            //     'code' => 'fdr_closed',
            //     'for' => 'User',
            //     'title' => '"[[plan_name]]" FDR is closed.',
            //     'message_body' => '"[[plan_name]]" FDR is closed.',
            //     'short_codes' => '["[[plan_name]]","[[fdr_id]]","[[amount]]","[[interest_rate]]","[[given_installment]]","[[installment_interval]]","[[next_installment_date]]","[[total_installment]]"'
            // ],
            // [
            //     'icon' => 'book',
            //     'name' => 'FDR Completed',
            //     'code' => 'fdr_completed',
            //     'for' => 'User',
            //     'title' => '"[[plan_name]]" FDR is completed.',
            //     'message_body' => '"[[plan_name]]" FDR is completed.',
            //     'short_codes' => '["[[plan_name]]","[[fdr_id]]","[[amount]]","[[interest_rate]]","[[given_installment]]","[[installment_interval]]","[[next_installment_date]]","[[total_installment]]"'
            // ],
            // [
            //     'icon' => 'book',
            //     'name' => 'FDR Completed',
            //     'code' => 'fdr_completed',
            //     'for' => 'Admin',
            //     'title' => '"[[user_name]]" \'s "[[plan_name]]" FDR is completed.',
            //     'message_body' => '[[user_name]]" \'s "[[plan_name]]" FDR is completed.',
            //     'short_codes' => '["[[plan_name]]","[[fdr_id]]","[[amount]]","[[interest_rate]]","[[given_installment]]","[[installment_interval]]","[[next_installment_date]]","[[total_installment]]"'
            // ],

            // [
            //     'icon' => 'book',
            //     'name' => 'FDR Installment',
            //     'code' => 'fdr_installment',
            //     'for' => 'User',
            //     'title' => '"[[plan_name]]" FDR Installment Added Your Balance.',
            //     'message_body' => '"[[plan_name]]" FDR Installment Added Your Balance.',
            //     'short_codes' => '["[[plan_name]]","[[fdr_id]]","[[amount]]","[[interest_rate]]","[[given_installment]]","[[installment_interval]]","[[next_installment_date]]","[[total_installment]]"'
            // ],
            // [
            //     'icon' => 'book',
            //     'name' => 'FDR Closed',
            //     'code' => 'fdr_closed',
            //     'for' => 'Admin',
            //     'title' => '"[[user_name]]" \'s "[[plan_name]]" FDR is closed now.',
            //     'message_body' => '"[[plan_name]]" FDR is closed.',
            //     'short_codes' => '["[[plan_name]]","[[fdr_id]]","[[amount]]","[[interest_rate]]","[[given_installment]]","[[installment_interval]]","[[next_installment_date]]","[[total_installment]]"'
            // ],
            // [
            //     'icon' => 'book',
            //     'name' => 'FDR Closed',
            //     'code' => 'fdr_closed',
            //     'for' => 'Admin',
            //     'title' => '"[[user_name]]" \'s "[[plan_name]]" FDR is closed now.',
            //     'message_body' => '"[[plan_name]]" FDR is closed.',
            //     'short_codes' => '["[[plan_name]]","[[fdr_id]]","[[amount]]","[[interest_rate]]","[[given_installment]]","[[installment_interval]]","[[next_installment_date]]","[[total_installment]]"'
            // ],
            // [
            //     'icon' => 'alert-triangle',
            //     'name' => 'Loan Apply',
            //     'code' => 'loan_apply',
            //     'for' => 'Admin',
            //     'title' => '"[[plan_name]]" Loan Application From [[user_name]].',
            //     'message_body' => '"[[plan_name]]" Loan Application From [[user_name]].',
            //     'short_codes' => '["[[user_name]]","[[plan_name]]","[[loan_id]]","[[installment_rate]]","[[loan_amount]]","[[installment_interval]]"'
            // ],
            // [
            //     'icon' => 'alert-triangle',
            //     'name' => 'Loan Approved',
            //     'code' => 'loan_approved',
            //     'for' => 'User',
            //     'title' => '"[[plan_name]]" Loan Approved.',
            //     'message_body' => '"[[plan_name]]" Loan Approved',
            //     'short_codes' => '["[[plan_name]]","[[loan_id]]","[[installment_rate]]","[[loan_amount]]","[[given_installment]]","[[installment_interval]]","[[next_installment_date]]","[[total_installment]]"'
            // ],
            // [
            //     'icon' => 'alert-triangle',
            //     'name' => 'Loan Rejected',
            //     'code' => 'loan_rejected',
            //     'for' => 'User',
            //     'title' => '"[[plan_name]]" Loan Rejected.',
            //     'message_body' => '"[[plan_name]]" Loan Rejected',
            //     'short_codes' => '["[[plan_name]]","[[loan_id]]","[[installment_rate]]","[[loan_amount]]","[[installment_interval]]"'
            // ],
            // [
            //     'icon' => 'alert-triangle',
            //     'name' => 'Loan Installment',
            //     'code' => 'loan_installment',
            //     'for' => 'User',
            //     'title' => '"[[plan_name]]" Loan Installment Fee Deducted From Balance.',
            //     'message_body' => '"[[plan_name]]" Loan Installment Fee Deducted From Balance.',
            //     'short_codes' => '["[[plan_name]]","[[loan_id]]","[[installment_rate]]","[[loan_amount]]","[[delay_charge]]","[[installment_amount]]","[[given_installment]]","[[installment_interval]]","[[next_installment_date]]","[[total_installment]]"'
            // ],

            // [
            //     'icon' => 'alert-triangle',
            //     'name' => 'Loan Installment',
            //     'code' => 'loan_installment',
            //     'for' => 'Admin',
            //     'title' => '"[[user_name]]" \'s "[[plan_name]]" Loan Installment Completed.',
            //     'message_body' => '"[[user_name]]" \'s "[[plan_name]]" Loan Installment Completed.',
            //     'short_codes' => '["[[user_name]]","[[plan_name]]","[[loan_id]]","[[installment_rate]]","[[loan_amount]]","[[delay_charge]]","[[installment_amount]]","[[given_installment]]","[[installment_interval]]","[[next_installment_date]]","[[total_installment]]"'
            // ],
            // [
            //     'icon' => 'credit-card',
            //     'name' => 'Bill Pay',
            //     'code' => 'bill_pay',
            //     'for' => 'Admin',
            //     'title' => '[[user_name]] \'s "[[service_name]]" Pay bill completed.',
            //     'message_body' => '[[user_name]] \'s "[[service_name]]" Pay bill completed.',
            //     'short_codes' => '["[[user_name]]","[[service_name]]","[[amount]]","[[charge]]"]'
            // ],
            // [
            //     'icon' => 'pie-chart',
            //     'name' => 'Portfolio Achieve',
            //     'code' => 'portfolio_achieve',
            //     'for' => 'User',
            //     'title' => 'Congratulations, You achieved "[[portfolio_name]]" portfolio badge.',
            //     'message_body' => 'Congratulations, You achieved "[[portfolio_name]]" portfolio badge.',
            //     'short_codes' => '["[[portfolio_name]]"]'
            // ],
            // [
            //     'icon' => 'gift',
            //     'name' => 'Get rewards',
            //     'code' => 'get_rewards',
            //     'for' => 'User',
            //     'title' => 'Congratulations, You have received [[points]] reward points.',
            //     'message_body' => 'Congratulations, You have received [[points]] reward points.',
            //     'short_codes' => '["[[points]]"]'
            // ],
            // [
            //     'icon' => 'message-circle',
            //     'name' => 'Support Ticket Created',
            //     'code' => 'support_ticket_created',
            //     'for' => 'Admin',
            //     'title' => '[[full_name]] \'s open a support ticket.',
            //     'message_body' => '[[full_name]] \'s open a support ticket.',
            //     'short_codes' => '["[[full_name]]"]'
            // ],
            // [
            //     'icon' => 'message-circle',
            //     'name' => 'Support Ticket Reply',
            //     'code' => 'support_ticket_reply',
            //     'for' => 'Admin',
            //     'title' => '[[full_name]] \'s reply a ticket.',
            //     'message_body' => '[[full_name]] \'s reply a ticket.',
            //     'short_codes' => '["[[full_name]]"]'
            // ],
        ];

        PushNotificationTemplate::insert($notifications);
    }
}
