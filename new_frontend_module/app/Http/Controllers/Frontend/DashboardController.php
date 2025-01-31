<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\DpsStatus;
use App\Enums\FdrStatus;
use App\Enums\LoanStatus;
use App\Http\Controllers\Controller;
use App\Models\DpsTransaction;
use App\Models\FDRTransaction;
use App\Models\LoanTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {

        $user = auth()->user();
        $transactions = Transaction::where('user_id', $user->id);

        $recentTransactions = $transactions->latest()->take(5)->get();

        $referral = $user->getReferrals()->first();

        $dps_last_date = DpsTransaction::where('dps_id', $user->dps->first()?->id)->latest('given_date')->first()?->given_date->format('d M Y');
        $fdr_last_date = FDRTransaction::where('fdr_id', $user->fdr->first()?->id)->latest('given_date')->first()?->given_date->format('d M Y');
        $loan_last_date = LoanTransaction::where('loan_id', $user->loan->whereIn('status', [LoanStatus::Running, LoanStatus::Due])->first()?->id)->latest('installment_date')->first()?->installment_date->format('d M Y');

        $dataCount = [
            'total_transaction' => $transactions->count(),
            'total_deposit' => $user->totalDeposit(),
            'total_profit' => $user->totalProfit(),
            'profit_last_7_days' => $user->totalProfit(7),
            'total_withdraw' => $user->totalWithdraw(),
            'total_transfer' => $user->totalTransfer(),
            'total_dps' => $user->dps->count(),
            'total_bill' => $user->bill->count(),
            'total_fdr' => $user->fdr->count(),
            'total_running_dps' => $user->dps->whereIn('status', [DpsStatus::Running, DpsStatus::Due])->count(),
            'total_running_loan' => $user->loan->whereIn('status', [LoanStatus::Running, LoanStatus::Due])->count(),
            'total_running_fdr' => $user->fdr->where('status', FdrStatus::Running)->count(),
            'dps_last_date' => $dps_last_date,
            'fdr_last_date' => $fdr_last_date,
            'loan_last_date' => $loan_last_date,
            'total_loan' => $user->loan->count(),
            'total_referral_profit' => $user->totalReferralProfit(),
            'total_referral' => $referral?->relationships()->count() ?? 0,
            'deposit_bonus' => $user->totalDepositBonus(),
            'portfolio_achieved' => $user->portfolioAchieved(),
            'total_tickets' => $user->ticket->count(),
            'recentTransactions' => $recentTransactions,
            'user' => $user,
        ];

        return view('frontend::user.dashboard', $dataCount);
    }
}
