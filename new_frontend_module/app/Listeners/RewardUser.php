<?php

namespace App\Listeners;

use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Events\UserReferred;
use App\Models\ReferralLink;
use App\Models\ReferralRelationship;
use App\Models\User;
use Txn;

class RewardUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(UserReferred $event)
    {
        $referral = ReferralLink::find($event->referralId);
        if (! is_null($referral)) {
            ReferralRelationship::create(['referral_link_id' => $referral->id, 'user_id' => $event->user->id]);

            User::find($event->user->id)->update([
                'ref_id' => $referral->user->id,
            ]);

            $email_verification = setting('email_verification', 'permission') ? $event->user->email_verified_at !== null : true;

            // Sign Up Referral Bonus
            if (setting('sign_up_referral', 'permission') && $email_verification) {

                $referralBonus = (float) setting('referral_bonus', 'fee');
                // User who was sharing link
                $provider = $referral->user;
                $provider->increment('balance', $referralBonus);
                Txn::new($referralBonus, 0, $referralBonus, 'System', 'Referral Bonus via '.$event->user->full_name, TxnType::Referral, TxnStatus::Success, null, null, $provider->id);
            }

        }
    }
}
