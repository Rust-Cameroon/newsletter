<?php

namespace App\Traits;

use App\Enums\TxnStatus;
use App\Models\RewardPointEarning;
use App\Models\Transaction;
use App\Models\User;

trait RewardTrait
{
    use NotifyTrait;

    public function rewardToUser($user_id, $trasaction_id)
    {
        $user = User::find($user_id);
        $userPortfolio = RewardPointEarning::where('portfolio_id', $user->portfolio_id)->first();

        if (! $user || ! $userPortfolio) {
            return false;
        }

        $totalTransactions = Transaction::where('user_id', $user_id)->where('status', TxnStatus::Success)->sum('final_amount');

        if ($totalTransactions >= $userPortfolio->amount_of_transactions) {

            Transaction::find($trasaction_id)->update([
                'points' => $userPortfolio->point,
            ]);

            $user->increment('points', $userPortfolio->point);

            $shortcodes = [
                '[[points]]' => $userPortfolio->point,
            ];

            $this->pushNotify('get_rewards', $shortcodes, route('user.rewards.index'), $user->id);
        }

    }
}
