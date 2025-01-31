<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Dps;
use App\Models\Fdr;
use App\Models\Bill;
use App\Models\Loan;
use App\Models\User;
use App\Models\Admin;
use App\Enums\TxnType;
use App\Models\Ticket;
use App\Models\Gateway;
use App\Enums\KYCStatus;
use App\Enums\TxnStatus;
use App\Enums\TransferType;
use App\Models\Transaction;
use App\Models\LoginActivities;
use App\Http\Controllers\Controller;
use App\Models\ReferralRelationship;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $transaction = new Transaction();
        $user = User::query();
        $admin = Admin::query();

        $totalDeposit = Transaction::where('status', TxnStatus::Success)->where(function ($query) {
            $query->where('type', TxnType::ManualDeposit)
                ->orWhere('type', TxnType::Deposit);
        });

        $totalSend = Transaction::where('status', TxnStatus::Success)
            ->where('type', TxnType::FundTransfer)
            ->sum('amount');

        $activeUser = User::where('status', 1)->count();
        $disabledUser = User::where('status', 0)->count();

        $totalStaff = Admin::count();

        $latestUser = User::latest()->take(5)->get();

        $totalGateway = Gateway::where('status', true)->count();

        $totalWithdraw = Transaction::where('type', [TxnType::Withdraw, TxnType::WithdrawAuto]);

        $withdrawCount = Transaction::where('type', TxnType::Withdraw)
            ->where('status', 'pending')
            ->count();

        $kycCount = User::where('kyc', KYCStatus::Pending)->count();

        $depositCount = Transaction::where('type', TxnType::ManualDeposit)
            ->where('status', 'pending')
            ->count();

        $totalReferral = ReferralRelationship::count();

        // ============================= Start dashboard statistics =============================================

        $startDate = request()->start_date ? Carbon::createFromDate(request()->start_date) : Carbon::now()->subDays(7);
        $endDate = request()->end_date ? Carbon::createFromDate(request()->end_date) : Carbon::now();
        $dateArray = array_fill_keys(generate_date_range_array($startDate, $endDate), 0);

        $dateFilter = [request()->start_date ? $startDate : $startDate->subDays(1), $endDate->addDays(1)];

        $depositStatistics = $totalDeposit->whereBetween('created_at', $dateFilter)->get()->groupBy('day')->map(function ($group) {
            return $group->sum('amount');
        })->toArray();

        $depositStatistics = array_replace($dateArray, $depositStatistics);

        $withdrawStatistics = $totalWithdraw->whereBetween('created_at', $dateFilter)->get()->groupBy('day')->map(function ($group) {
            return $group->sum('amount');
        })->toArray();
        $withdrawStatistics = array_replace($dateArray, $withdrawStatistics);

        $dpsStatistics = Dps::whereBetween('created_at', $dateFilter)->get()->groupBy('day')->map(function ($group) {
            return $group->sum('total_dps_amount');
        })->toArray();

        $dpsStatistics = array_replace($dateArray, $dpsStatistics);

        $fdrStatistics = Fdr::whereBetween('created_at', $dateFilter)->get()->groupBy('day')->map(function ($group) {
            return $group->sum('amount');
        })->toArray();
        $fdrStatistics = array_replace($dateArray, $fdrStatistics);

        $billStatistics = Bill::whereBetween('created_at', $dateFilter)->get()->groupBy('day')->map(function ($group) {
            return $group->sum('amount');
        })->toArray();
        $billStatistics = array_replace($dateArray, $billStatistics);

        $loanStatistics = Loan::whereBetween('created_at', $dateFilter)->get()->groupBy('day')->map(function ($group) {
            return $group->sum('amount');
        })->toArray();
        $loanStatistics = array_replace($dateArray, $loanStatistics);

        // ============================= End dashboard statistics =============================================

        // set cache for 1 minute
        $loginActivities = Cache::remember('login-activities', 60, function () {
            return LoginActivities::get();
        });

        $browser = $loginActivities->groupBy('browser')->map->count()->toArray();
        $platform = $loginActivities->groupBy('platform')->map->count()->toArray();

        $country = User::all()->groupBy('country')->map(function ($country) {
            return $country->count();
        })->toArray();

        arsort($country);
        $country = array_slice($country, 0, 5);


        $symbol = setting('currency_symbol', 'global');
        $total_dps = Dps::get()->sum('total_dps_amount');
        $total_fdr = Fdr::sum('amount');
        $total_loan = Loan::sum('amount');
        $total_bill = $transaction->where('type', TxnType::PayBill)->sum('amount');

        $fund_transfer_statistics = [
            'Fund Transfer' => $transaction->where('type', TxnType::FundTransfer->value)->sum('amount'),
            'Fund Wire Transfer' => $transaction->wireTransfer()->sum('amount')
        ];

        $data = [
            'withdraw_count' => $withdrawCount,
            'kyc_count' => $kycCount,
            'deposit_count' => $depositCount,

            'register_user' => $user->count(),
            'active_user' => $activeUser,
            'disabled_user' => $disabledUser,
            'latest_user' => $latestUser,

            'total_staff' => $totalStaff,

            'total_deposit' => $totalDeposit->sum('amount'),
            'total_dps' => $total_dps,
            'total_fdr' => $total_fdr,
            'total_loan' => $total_loan,
            'total_bill' => $total_bill,
            'points' => User::sum('points'),
            'total_send' => $totalSend,
            'total_withdraw' => $transaction->totalWithdraw()->sum('amount'),
            'total_referral' => $totalReferral,

            'date_label' => $dateArray,
            'deposit_statistics' => $depositStatistics,
            'withdraw_statistics' => $withdrawStatistics,
            'dps_statistics' => $dpsStatistics,
            'fdr_statistics' => $fdrStatistics,
            'loan_statistics' => $loanStatistics,
            'bill_statistics' => $billStatistics,
            'fund_transfer_statistics' => $fund_transfer_statistics,

            'start_date' => isset(request()->start_date) ? $startDate : $startDate->addDays(1)->format('m/d/Y'),
            'end_date' => isset(request()->end_date) ? $endDate : $endDate->subDays(1)->format('m/d/Y'),

            'deposit_bonus' => $transaction->totalDepositBonus(),
            'total_gateway' => $totalGateway,
            'total_ticket' => Ticket::count(),

            'browser' => $browser,
            'platform' => $platform,
            'country' => $country,
            'symbol' => $symbol,
        ];

        // Date range filter for statistics
        if (request()->ajax()) {

            return response()->json([
                'date_label' => $dateArray,
                'deposit_statistics' => $depositStatistics,
                'total_dps' => $dpsStatistics,
                'total_fdr' => $fdrStatistics,
                'total_loan' => $loanStatistics,
                'total_bill' => $billStatistics,
                'withdraw_statistics' => $withdrawStatistics,
                'symbol' => $symbol,
            ]);
        }

        return view('backend.dashboard', compact('data'));
    }
}
