<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Http\Controllers\Controller;
use App\Models\RewardPointEarning;
use App\Models\RewardPointRedeem;
use App\Models\Transaction;
use Txn;

class RewardController extends Controller
{
    public function index()
    {
        $redeems = RewardPointRedeem::with('portfolio')->get();
        $earnings = RewardPointEarning::with('portfolio')->get();

        $myPortfolio = RewardPointRedeem::where('portfolio_id', auth()->user()->portfolio_id)->first();

        $transactions = Transaction::where('user_id', auth()->id())
            ->latest()
            ->where('type', TxnType::RewardRedeem) 
            ->paginate(5);

        return view('frontend::rewards.index', compact('redeems', 'earnings', 'myPortfolio', 'transactions'));
    }

    public function redeemNow()
    {
        // Get user
        $user = auth()->user();
        // Get user portfolio redeem
        $portfolio = RewardPointRedeem::where('portfolio_id', $user->portfolio_id)->first();

        // Check portfolio exists or not and user's point euqal or less than 0 then redirect back
        if (! $portfolio || $user->points <= 0) {
            return back();
        }

        // Calculate redeem amount by portfolio wise redeem point and amount
        $redeemAmount = ($portfolio->amount / $portfolio->point) * $user->points;

        // Create transaction
        Txn::new($redeemAmount, 0, $redeemAmount, 'System', $user->points.' Points Reward Redeem', TxnType::RewardRedeem, TxnStatus::Success, '', null, $user->id, null, 'User');

        // Deduct user point
        $user->decrement('points', $user->points);

        // Add amount to user balance
        $user->increment('balance', $redeemAmount);

        notify()->success(__('Rewards redeem successfully!'));

        return back();
    }
}
