<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\DpsStatus;
use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Http\Controllers\Controller;
use App\Models\Dps;
use App\Models\DpsPlan;
use App\Models\DpsTransaction;
use App\Models\LevelReferral;
use App\Traits\NotifyTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Txn;
use Validator;

class DpsController extends Controller
{
    use NotifyTrait;

    public function index()
    {
        if (! setting('user_dps', 'permission') || ! Auth::user()->dps_status) {
            notify()->error(__('DPS currently unavailble!'), 'Error');

            return to_route('user.dashboard');
        } elseif (! setting('kyc_dps') && ! auth()->user()->kyc) {
            notify()->error(__('Please verify your KYC.'), 'Error');

            return to_route('user.dashboard');
        }

        $plans = DpsPlan::active()->get();

        return view('frontend::dps.index', compact('plans'));
    }

    public function history()
    {
        // Get all dps transaction history
        $from_date = trim(@explode('-', request('daterange'))[0]);
        $to_date = trim(@explode('-', request('daterange'))[1]);

        $dpses = Dps::with(['user', 'plan', 'transactions'])
            ->where('user_id', auth()->id())
            ->when(request('dps_id'), function ($query) {
                $query->where('dps_id', 'LIKE', '%'.request('dps_id').'%');
            })
            ->when(request('daterange'), function ($query) use ($from_date, $to_date) {
                $query->whereDate('created_at', '>=', Carbon::parse($from_date)->format('Y-m-d'));
                $query->whereDate('created_at', '<=', Carbon::parse($to_date)->format('Y-m-d'));
            })
            ->latest()
            ->paginate(request('limit', 15))
            ->withQueryString();

        return view('frontend::dps.history', compact('dpses'));
    }

    public function subscribe($id)
    {

        if (! setting('user_dps', 'permission') || ! Auth::user()->dps_status) {
            notify()->error(__('DPS currently unavailble!'), 'Error');

            return to_route('user.dashboard');
        } elseif (! setting('kyc_dps') && ! auth()->user()->kyc) {
            notify()->error(__('Please verify your KYC.'), 'Error');

            return to_route('user.dashboard');
        }

        // Get user data
        $user = auth()->user();
        // Get dps plan data
        $plan = DpsPlan::find($id);

        // When plan not found then throw error
        if (! $plan) {
            notify()->error(__('Dps Plan Not found.'), 'Error');

            return redirect()->back();
        }

        // Get per installment amount
        $amount = $plan->per_installment;
        // Get currency symbol
        $currency = setting('currency_symbol', 'global');

        // If user balance is low then get error
        if (auth()->user()->balance <= $amount) {
            $message = __('Insufficient Balance. Your balance must be upper than '.$currency.$amount);
            notify()->error($message, 'Error');

            return redirect()->back();
        }

        // Create dps for user
        $dps = Dps::create([
            'dps_id' => mt_rand(10000000, 99999999),
            'plan_id' => $plan->id,
            'user_id' => $user->id,
            'per_installment' => $plan->per_installment,
        ]);

        if ($dps) {

            // Store all installments
            $installments = [];
            for ($i = 0; $i < $plan->total_installment; $i++) {
                $installments[] = [
                    'dps_id' => $dps->id,
                    'paid_amount' => $dps->per_installment,
                    'installment_date' => Carbon::parse($dps->created_at)->addDays($plan->interval * $i),
                ];
            }

            // Insert installments into dps transaction table
            DpsTransaction::insert($installments);

            // paid first installment
            $transaction = DpsTransaction::where('dps_id', $dps->id)->first();
            $transaction->given_date = today();
            $transaction->paid_amount = $amount;
            $transaction->charge = 0;
            $transaction->final_amount = $amount;
            $transaction->save();

            // Balance deducted from user
            $user->decrement('balance', $amount);

            Txn::new($amount, 0, $amount, 'System', 'DPS Plan Subscribed #'.$dps->dps_id.'', TxnType::DpsInstallment, TxnStatus::Success, '', null, auth()->id(), null, 'User');

            // Level referral
            if (setting('dps_level')) {
                $level = LevelReferral::where('type', 'dps')->max('the_order') + 1;
                creditReferralBonus($user, 'dps', $transaction->paid_amount, $level);
            }

            $dps->given_installment = 1;
            $dps->save();

            $shortcodes = [
                '[[site_title]]' => setting('site_title', 'global'),
                '[[site_url]]' => route('home'),
                '[[plan_name]]' => $dps->plan->name,
                '[[user_name]]' => $user->full_name,
                '[[full_name]]' => $user->full_name,
                '[[dps_id]]' => $dps->dps_id,
                '[[per_installment]]' => $dps->per_installment,
                '[[interest_rate]]' => $dps->plan->interest_rate,
                '[[given_installment]]' => $dps->given_installment,
                '[[total_installment]]' => count($dps->transactions),
                '[[matured_amount]]' => getTotalMature($dps),
            ];

            $this->smsNotify('dps_opened', $shortcodes, $dps->user->phone);
            $this->mailNotify($dps->user->email, 'dps_opened', $shortcodes);
            $this->pushNotify('dps_opened', $shortcodes, route('admin.dps.details', $dps->id), $dps->user_id, 'Admin');

        }
        notify()->success(__('DPS Plan Subscribed Successfully!'), 'Success');

        return redirect()->route('user.dps.history');

    }

    public function details($dpsId)
    {
        // Get history by specific dps
        $dps = Dps::with('transactions')->where('dps_id', $dpsId)->where('user_id', auth()->id())->firstOrFail();

        return view('frontend::dps.details', compact('dps'));
    }

    public function cancel($dpsId)
    {
        // Get dps data
        $dps = Dps::where('dps_id', $dpsId)->where('user_id', auth()->id())->firstOrFail();

        // Check dps
        if (! $this->checkDpsAbility($dps)) {
            return back();
        }

        if (! $dps->plan->can_cancel) {
            notify()->error(__('You can\'t cancel this plan.'), 'Error');

            return back();
        }

        // Check if the DPS is within the days window for cancellation
        $cancellationDays = (int) $dps->plan->cancel_days;
        $creationDate = Carbon::parse($dps->created_at);
        $currentDate = Carbon::now();

        if ($dps->plan->cancel_type == 'fixed' && $currentDate->diffInDays($creationDate) > $cancellationDays) {
            notify()->error(__('DPS cancellation days is over!'), 'Sorry!');

            return back();
        }

        // Calculate cancel fee
        $cancel_fee = $dps->plan->cancel_fee_type == 'percentage' ? (($dps->plan->cancel_fee / 100) * $dps->plan->per_installment) : $dps->plan->cancel_fee;

        // DPS amount back to user balance
        $refund_amount = $dps->per_installment - $cancel_fee;
        $dps->user->increment('balance', $refund_amount);

        // Save dps cancel info
        $dps->cancel_date = now();
        $dps->cancel_fee = $cancel_fee;
        $dps->status = DpsStatus::Closed;
        $dps->save();

        Txn::new($cancel_fee, 0, $cancel_fee, 'System', 'DPS Cancelled #'.$dps->dps_id.'', TxnType::DpsCancelled, TxnStatus::Success, '', null, auth()->id(), null, 'User');

        // Shortcodes for notification
        $shortcodes = [
            '[[site_title]]' => setting('site_title', 'global'),
            '[[site_url]]' => route('home'),
            '[[plan_name]]' => $dps->plan->name,
            '[[full_name]]' => $dps->user->full_name,
            '[[dps_id]]' => $dps->dps_id,
            '[[cancel_fee]]' => $cancel_fee,
            '[[per_installment]]' => $dps->per_installment,
            '[[interest_rate]]' => $dps->plan->interest_rate,
            '[[given_installment]]' => $dps->given_installment,
            '[[total_installment]]' => count($dps->transactions),
            '[[matured_amount]]' => getTotalMature($dps),
        ];

        $this->smsNotify('dps_closed', $shortcodes, $dps->user->phone);
        $this->mailNotify($dps->user->email, 'dps_closed', $shortcodes);
        $this->pushNotify('dps_closed', $shortcodes, route('user.dps.history', $dps->dps_id), $dps->user_id);
        $this->pushNotify('dps_closed', $shortcodes, route('admin.dps.details', $dps->id), $dps->user_id, 'Admin');

        notify()->success(__('DPS Plan Cancelled Successfully!'), 'Success');

        return redirect()->back();
    }

    public function increment(Request $request, $id)
    {
        // Get Dps data
        $dps = Dps::findOrFail(decrypt($id));
        // Get plan
        $plan = $dps->plan;
        // Get currency symbol
        $currency = setting('currency_symbol', 'global');

        $min_increase_amount = $plan->min_increment_amount;
        $max_increment_amount = $plan->max_increment_amount;
        $message = __('You can increase minimum amount is :minimum_amount and maximum is :maximum_amount',['minimum_amount' => $currency.$min_increase_amount,'maximum_amount' => $currency.$max_increment_amount]);

        $validator = Validator::make($request->all(), [
            'increase_amount' => ['required', 'integer', 'min:'.$min_increase_amount, 'max:'.$max_increment_amount],
        ], [
            'increase_amount.min' => $message,
            'increase_amount.max' => $message,
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return back();
        }

        // Check increment ability
        if (! $dps->plan->is_upgrade) {
            notify()->error(__('You can\'t increase amount for this plan.'), 'Error');

            return back();
        }

        // Check dps
        if (! $this->checkDpsAbility($dps)) {
            return back();
        }

        // Check user balance
        $total_amount = $plan->increment_charge_type ? $request->increase_amount + $plan->increment_fee : $request->increase_amount;
        if ($total_amount > $dps->user->balance) {
            notify()->error(__('Insufficent Balance.'), 'Error');

            return back();
        }

        // Limit check & increase
        if ($dps->plan->increment_type == 'unlimited' || $dps->plan->increment_type == 'fixed' && $dps->plan->increment_times > $dps->increment_count) {
            $dps->increment_count += 1;
        } else {
            notify()->error(__('You reached the increment limit!'), 'Limit Reached!');

            return back();
        }

        // Increase amount deducted from user balance
        $dps->user->decrement('balance', $total_amount);

        Txn::new($request->integer('increase_amount'), $plan->increment_charge_type ? $plan->increment_fee : 0, $total_amount, 'System', 'DPS Increased #'.$dps->dps_id.'', TxnType::DpsIncrease, TxnStatus::Success, '', null, auth()->id(), null, 'User');

        // Increase Amount
        $dps->per_installment += $request->integer('increase_amount');
        $dps->save();

        // Update per installment fee in transactions data
        $dps->transactions()->whereNull('given_date')->update([
            'paid_amount' => $dps->per_installment,
        ]);

        notify()->success(__('DPS Increased Successfully!'), 'Success');

        return back();
    }

    public function decrement(Request $request, $id)
    {
        // Get dps data
        $dps = Dps::findOrFail(decrypt($id));
        // Get plan
        $plan = $dps->plan;
        // Get currency symbol
        $currency = setting('currency_symbol', 'global');

        $min_decrease_amount = $plan->min_decrement_amount;
        $max_decrement_amount = $plan->max_decrement_amount;
        $message = __('You can decrease minimum amount is :minimum_amount and maximum is :maximum_amount',['minimum_amount' => $currency.$min_decrease_amount,'maximum_amount' => $currency.$max_decrease_amount]);

        $validator = Validator::make($request->all(), [
            'decrease_amount' => ['required', 'integer', 'min:'.$min_decrease_amount, 'max:'.$max_decrement_amount],
        ], [
            'decrease_amount.min' => $message,
            'decrease_amount.max' => $message,
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return back();
        }

        // Check decrement ability
        if (! $dps->plan->is_downgrade) {
            notify()->error(__('You can\'t decrease amount for this plan.'), 'Error');

            return back();
        }

        // Check dps
        if (! $this->checkDpsAbility($dps)) {
            return back();
        }

        // Limit check & increase
        $charge = 0;
        if ($dps->plan->decrement_type == 'unlimited' || $dps->plan->decrement_type == 'fixed' && $dps->plan->decrement_times > $dps->decrement_count) {
            $dps->decrement_count += 1;
            if ($plan->decrement_charge_type) {
                $charge = $plan->decrement_fee;
            }
        } else {
            notify()->error(__('You reached the decrement limit!'), 'Limit Reached!');

            return back();
        }

        // Check decrease amount equal or less than per installation fee
        if ($dps->per_installment <= $request->integer('decrease_amount')) {
            notify()->error(__('Decrease amount should be equal to or less than per installation fee.'), 'Error');

            return back();
        }

        // Decrease amount added to user balance
        $dps->user->increment('balance', $request->integer('decrease_amount') - $charge);

        Txn::new($request->integer('decrease_amount') - $charge, $charge, $request->integer('decrease_amount') + $charge, 'System', 'DPS Decreased #'.$dps->dps_id.'', TxnType::DpsDecrease, TxnStatus::Success, '', null, auth()->id(), null, 'User');

        // Decrease Amount
        $dps->per_installment -= $request->integer('decrease_amount');
        $dps->save();

        // Update per installment fee in transactions data
        $dps->transactions()->whereNull('given_date')->update([
            'paid_amount' => $dps->per_installment,
        ]);

        notify()->success(__('DPS Decreased Successfully!'), 'Success');

        return back();
    }

    protected function checkDpsAbility($dps)
    {
        $status = $dps->status->value;

        if ($status == DpsStatus::Mature->value) {
            notify()->error(__('Sorry, Your DPS is completed!'), 'Error');

            return false;
        } elseif ($status == DpsStatus::Closed->value) {
            notify()->error(__('Your DPS is closed!'), 'Error');

            return false;
        }

        return true;
    }
}
