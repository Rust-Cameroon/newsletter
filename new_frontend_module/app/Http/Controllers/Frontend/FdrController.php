<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\FdrStatus;
use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Http\Controllers\Controller;
use App\Models\Fdr;
use App\Models\FdrPlan;
use App\Models\FDRTransaction;
use App\Models\LevelReferral;
use App\Traits\NotifyTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Txn;

class FdrController extends Controller
{
    use NotifyTrait;

    public function index()
    {
        if (! setting('user_fdr', 'permission') || ! Auth::user()->fdr_status) {
            notify()->error(__('FDR currently unavailble!'), 'Error');

            return to_route('user.dashboard');
        } elseif (! setting('kyc_fdr') && ! auth()->user()->kyc) {
            notify()->error(__('Please verify your KYC.'), 'Error');

            return to_route('user.dashboard');
        }

        $plans = FdrPlan::active()->latest()->get();

        return view('frontend::fdr.index', compact('plans'));
    }

    public function subscribe(Request $request)
    {
        if (! setting('user_fdr', 'permission') || ! Auth::user()->fdr_status) {
            notify()->error(__('FDR currently unavailble!'), 'Error');

            return to_route('user.dashboard');
        } elseif (! setting('kyc_fdr') && ! auth()->user()->kyc) {
            notify()->error(__('Please verify your KYC.'), 'Error');

            return to_route('user.dashboard');
        }

        // Get user
        $user = auth()->user();
        // Get FDR Plan
        $plan = FdrPlan::find(decrypt($request->fdr_id));
        // Plan is not exist, then throw error
        if (! $plan) {
            notify()->error(__('FDR Plan Not found.'), 'Error');

            return back();
        }

        // Get amount
        $amount = (int) $request->amount;
        // Get currency symbol
        $currency = setting('currency_symbol', 'global');
        // Get minimum amount of fdr plan
        $min = (int) $plan->minimum_amount;
        // Get maximum amount of fdr plan
        $max = (int) $plan->maximum_amount;

        // Check amount
        if ($amount < $min || $amount > $max) {
            $message = __('You can FDR minimum :minimum_amount and maximum :maximum_amount',['minimum_amount' => $currency.$plan->minimum_amount,'maximum_amount' => $currency.$plan->maximum_amount]);
            notify()->error($message);

            return redirect()->back();
        }

        // Insufficent balance error
        if ($user->balance <= $amount) {
            $message = __('Insufficient Balance. Your balance must be upper than :amount',['amount' => $currency.$amount]);
            notify()->error($message);

            return redirect()->back();
        }

        // Create fdr for user
        $fdr = Fdr::create([
            'fdr_id' => 'F'.random_int(10000000, 99999999),
            'user_id' => $user->id,
            'fdr_plan_id' => $plan->id,
            'amount' => $amount,
            'end_date' => Carbon::now()->addDays($plan->locked),
        ]);

        // If fdr created then excute this code
        if ($fdr) {
            // Calculate total installment
            $total_installment = (int) $plan->locked / (int) $plan->intervel;

            // Store all transactions of FDR
            $fdrTransactions = [];
            for ($i = 1; $i <= (int) $total_installment; $i++) {
                // Calculate compounding process
                if ($plan->is_compounding) {
                    // Calculate interest amount
                    $interest = ($fdr->amount / 100) * $plan->interest_rate;

                    // Increment fdr amount with interest amount
                    $fdr->amount += $interest;
                }

                $fdrTransactions[] = [
                    'fdr_id' => $fdr->id,
                    'given_date' => Carbon::parse($fdr->created_at)->addDays($plan->intervel * $i),
                    'given_amount' => number_format($interest, 2),
                ];
            }

            // Insert all transactions
            FDRTransaction::insert($fdrTransactions);

            // Level referral
            if (setting('fdr_level')) {
                $level = LevelReferral::where('type', 'fdr')->max('the_order') + 1;
                creditReferralBonus($user, 'fdr', $amount, $level);
            }

            // Balance deducted from user
            $user->balance -= $amount;
            $user->save();

            Txn::new($amount, 0, $amount, 'System', 'FDR Plan Subscribed #'.$fdr->fdr_id.'', TxnType::Fdr, TxnStatus::Success, '', null, auth()->id(), null, 'User');

        }

        $trx = \App\Models\FDRTransaction::where('fdr_id', $fdr->id)->where('paid_amount', null)->first();

        $shortcodes = [
            '[[site_title]]' => setting('site_title', 'global'),
            '[[site_url]]' => route('home'),
            '[[plan_name]]' => $fdr->plan->name,
            '[[user_name]]' => $user->full_name,
            '[[full_name]]' => $user->full_name,
            '[[fdr_id]]' => $fdr->fdr_id,
            '[[per_installment]]' => '',
            '[[interest_rate]]' => $fdr->plan->interest_rate,
            '[[given_installment]]' => 0,
            '[[total_installment]]' => count($fdr->transactions),
            '[[amount]]' => $fdr->amount.' '.$currency,
            '[[installment_interval]]' => $fdr->plan->intervel,
            '[[next_installment_date]]' => $trx->given_date->format('d M Y'),
        ];

        $this->smsNotify('fdr_opened', $shortcodes, $fdr->user->phone);
        $this->mailNotify($fdr->user->email, 'fdr_opened', $shortcodes);
        $this->pushNotify('fdr_opened', $shortcodes, route('admin.fdr.details', $fdr->id), $fdr->user_id, 'Admin');

        notify()->success(__('FDR Plan Subscribed Successfully!'), 'Success');

        return redirect()->route('user.fdr.history');
    }

    public function increment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'increase_amount' => 'required|integer',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return back();
        }

        // Get FDR data
        $fdr = Fdr::findOrFail(decrypt($id));

        // Check increment ability
        if (! $fdr->plan->is_add_fund_fdr) {
            notify()->error(__('You can\'t increase amount for this plan.'), 'Error');

            return back();
        }

        // Check FDR
        if (! $this->checkAbility($fdr)) {
            return back();
        }

        // Check limit
        $amount = $request->integer('increase_amount');
        // Get plan
        $plan = $fdr->plan;
        // Get currency symbol
        $currency = setting('currency_symbol', 'global');

        // Check increase min amount & max amount
        $min_increase_amount = $plan->min_increment_amount;
        $max_increment_amount = $plan->max_increment_amount;

        if ($amount < $min_increase_amount || $amount > $max_increment_amount) {
            $message = __('You can increase minimum amount is :minimum_amount and maximum is :maximum_amount',['minimum_amount' => $currency.$min_increase_amount,'maximum_amount' => $currency.$max_increment_amount]);
            notify()->error($message);

            return redirect()->back();
        }

        // Check user balance
        $total_amount = $plan->increment_charge_type ? $request->increase_amount + $plan->increment_fee : $request->increase_amount;
        if ($total_amount >= $fdr->user->balance) {
            notify()->error(__('Insufficent Balance.'));

            return back();
        }

        // Limit check & increase
        if ($plan->increment_type == 'unlimited' || $plan->increment_type == 'fixed' && $plan->increment_times > $fdr->increment_count) {
            $fdr->increment_count += 1;
            if ($plan->increment_charge_type) {
                $fdr->user->decrement('balance', $plan->increment_fee);
            }
        } else {
            notify()->error(__('You reached the increment limit!'), 'Limit Reached!');

            return back();
        }

        // Increase FDR Amount
        $fdr->amount += $request->integer('increase_amount');
        $fdr->save();

        // Deduct balance from user
        $fdr->user->decrement('balance', $request->integer('increase_amount'));

        // Calculate interest amount
        $intereset_amount = ($fdr->amount / 100) * $plan->interest_rate;

        // Update per installment fee in transactions data
        $fdr->transactions()->whereNull('paid_amount')->update([
            'given_amount' => $intereset_amount,
        ]);

        Txn::new($request->integer('increase_amount'), $plan->increment_charge_type ? $plan->increment_fee : 0, $total_amount, 'System', 'FDR Increased #'.$fdr->fdr_id.'', TxnType::FdrIncrease, TxnStatus::Success, null, null, auth()->id(), null, 'User');

        notify()->success(__('FDR Increased Successfully!'), 'Success');

        return back();
    }

    public function decrement(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'decrease_amount' => 'required|integer',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return back();
        }

        // Get FDR data
        $fdr = Fdr::findOrFail(decrypt($id));
        $plan = $fdr->plan;

        // Check decrement ability
        if (! $fdr->plan->is_deduct_fund_fdr) {
            notify()->error(__('You can\'t decrease amount for this plan.'), 'Error');

            return back();
        }

        // Check FDR
        if (! $this->checkAbility($fdr)) {
            return back();
        }

        $amount = $request->integer('decrease_amount');
        // Get currency symbol
        $currency = setting('currency_symbol', 'global');

        // Check increase min amount & max amount
        $min_decrease_amount = $plan->min_decrement_amount;
        $max_decrease_amount = $plan->max_decrement_amount;

        if ($amount < $min_decrease_amount || $amount > $max_decrease_amount) {
            $message = __('You can decrease minimum amount is :minimum_amount and maximum is :maximum_amount',['minimum_amount' => $currency.$min_decrease_amount,'maximum_amount' => $currency.$max_decrease_amount]);
            notify()->error($message);

            return redirect()->back();
        }

        // Check user balance
        $total_amount = $plan->decrement_charge_type ? $request->decrease_amount + $plan->decrement_fee : $request->decrease_amount;
        if ($total_amount > $fdr->user->balance) {
            notify()->error(__('Insufficent Balance.'));

            return back();
        }

        // Limit check & decrease
        $charge = 0;
        if ($plan->decrement_type == 'unlimited' || $plan->decrement_type == 'fixed' && $plan->decrement_times > $fdr->decrement_count) {
            $fdr->decrement_count += 1;
            if ($plan->decrement_charge_type) {
                $charge = $plan->decrement_fee;
            }
        } else {
            notify()->error(__('You reached the decrement limit!'), 'Limit Reached!');

            return back();
        }

        // Decrease Amount
        $fdr->amount -= $request->integer('decrease_amount');
        $fdr->save();

        // Decrease amount added to user balance
        $fdr->user->increment('balance', $request->integer('decrease_amount') - $charge);

        Txn::new($request->integer('decrease_amount') - $charge, $charge, $total_amount, 'System', 'FDR Decreased #'.$fdr->fdr_id.'', TxnType::FdrDecrease, TxnStatus::Success, null, null, auth()->id(), null, 'User');

        // Calculate interest amount
        $intereset_amount = ($fdr->amount / 100) * $fdr->plan->interest_rate;

        // Update per installment fee in transactions data
        $fdr->transactions()->whereNull('paid_amount')->update([
            'given_amount' => $intereset_amount,
        ]);

        notify()->success(__('FDR Decreased Successfully!'), 'Success');

        return back();
    }

    protected function checkAbility($fdr)
    {
        $status = $fdr->status->value;

        if ($status == FdrStatus::Completed->value) {
            notify()->error(__('Sorry, Your FDR is completed!'), 'Error');

            return false;
        } elseif ($status == FdrStatus::Closed->value) {
            notify()->error(__('Your FDR is closed!'), 'Error');

            return false;
        }

        return true;
    }

    public function history()
    {

        $from_date = trim(@explode('-', request('daterange'))[0]);
        $to_date = trim(@explode('-', request('daterange'))[1]);

        $fdrs = Fdr::with(['user', 'plan', 'transactions'])
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

        return view('frontend::fdr.history', compact('fdrs'));
    }

    public function details($fdrId)
    {
        $fdr = Fdr::with(['transactions', 'plan', 'user'])->where('fdr_id', $fdrId)->where('user_id', auth()->id())->firstOrFail();

        return view('frontend::fdr.details', compact('fdr'));
    }

    public function cancel($fdrId)
    {
        // Get fdr data
        $fdr = Fdr::where('fdr_id', $fdrId)->where('user_id', auth()->id())->where('user_id', auth()->id())->firstOrFail();

        // Check fdr
        if (! $this->checkAbility($fdr)) {
            return back();
        }

        if (! $fdr->plan->can_cancel) {
            notify()->error(__('You can\'t cancel this plan.'), 'Error');

            return back();
        }

        // Check if the FDR is within the days window for cancellation
        $cancellationDays = (int) $fdr->plan->cancel_days;
        $creationDate = Carbon::parse($fdr->created_at);
        $currentDate = Carbon::now();

        if ($fdr->plan->cancel_type == 'fixed' && $currentDate->diffInDays($creationDate) > $cancellationDays) {
            notify()->error(__('FDR cancellation days is over!'), 'Sorry!');

            return back();
        }

        // Calculate cancel fee
        $cancel_fee = $fdr->plan->cancel_fee_type == 'percentage' ? (($fdr->plan->cancel_fee / 100) * $fdr->plan->per_installment) : $fdr->plan->cancel_fee;

        // FDR amount back to user balance
        $refund_amount = $fdr->amount - $cancel_fee;
        $fdr->user->increment('balance', $refund_amount);

        // Save fdr cancel info
        $fdr->cancel_date = now();
        $fdr->cancel_fee = $cancel_fee;
        $fdr->status = FdrStatus::Closed;
        $fdr->save();

        Txn::new($refund_amount, $cancel_fee, $fdr->amount + $cancel_fee, 'System', 'FDR Cancelled #'.$fdr->fdr_id.'', TxnType::FdrCancelled, TxnStatus::Success, '', null, auth()->id(), null, 'User');

        $trx = \App\Models\FDRTransaction::where('fdr_id', $fdr->id)->where('paid_amount', null)->first();

        $shortcodes = [
            '[[site_title]]' => setting('site_title', 'global'),
            '[[site_url]]' => route('home'),
            '[[plan_name]]' => $fdr->plan->name,
            '[[user_name]]' => $fdr->user->full_name,
            '[[full_name]]' => $fdr->user->full_name,
            '[[fdr_id]]' => $fdr->fdr_id,
            '[[per_installment]]' => '',
            '[[interest_rate]]' => $fdr->plan->interest_rate,
            '[[given_installment]]' => $fdr->givenInstallemnt() ?? 0,
            '[[total_installment]]' => count($fdr->transactions),
            '[[amount]]' => $fdr->amount.' '.setting('site_currency', 'global'),
            '[[installment_interval]]' => $fdr->plan->intervel,
            '[[next_installment_date]]' => $trx->given_date->format('d M Y'),
        ];

        $this->smsNotify('fdr_closed', $shortcodes, $fdr->user->phone);
        $this->mailNotify($fdr->user->email, 'fdr_closed', $shortcodes);
        $this->pushNotify('fdr_closed', $shortcodes, route('user.fdr.details', $fdr->id), $fdr->user_id);
        $this->pushNotify('fdr_closed', $shortcodes, route('admin.fdr.details', $fdr->id), $fdr->user_id, 'Admin');

        notify()->success(__('FDR Cancelled Successfully!'), 'Success');

        return redirect()->back();
    }
}
