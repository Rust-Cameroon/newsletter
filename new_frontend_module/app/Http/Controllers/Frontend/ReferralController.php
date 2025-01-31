<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LevelReferral;
use App\Models\Setting;

class ReferralController extends Controller
{
    public function referral()
    {
        if (! setting('sign_up_referral', 'permission') || ! auth()->user()->referral_status) {
            notify()->error(__('Referral currently unavailble!'), 'Error');

            return to_route('user.dashboard');
        }

        $user = auth()->user();

        $getReferral = $user->getReferrals()->first();

        $level = LevelReferral::max('the_order');

        $rules = json_decode(Setting::where('name', 'referral_rules')->first()?->val);

        return view('frontend::referral.index', compact('getReferral', 'level', 'rules'));
    }

    public function referralTree()
    {
        $level = LevelReferral::max('the_order');

        return view('frontend::referral.tree', compact('level'));
    }
}
