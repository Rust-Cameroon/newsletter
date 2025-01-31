<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\LoanStatus;
use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\LoanPlan;
use App\Traits\ImageUpload;
use App\Traits\NotifyTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Txn;

class LoanController extends Controller
{
    use ImageUpload,NotifyTrait;

    public function index()
    {
        if (! setting('user_loan', 'permission') || ! Auth::user()->loan_status) {
            notify()->error(__('Loan currently unavailble!'), 'Error');

            return to_route('user.dashboard');
        } elseif (! setting('kyc_loan') && ! auth()->user()->kyc) {
            notify()->error(__('Please verify your KYC.'), 'Error');

            return to_route('user.dashboard');
        }
        
        $plans = LoanPlan::active()->get();

        return view('frontend::loan.index', compact('plans'));
    }

    public function application(Request $request, $id)
    {
        // Check loan available or not
        if (! setting('user_loan', 'permission') || ! Auth::user()->loan_status) {
            notify()->error(__('Loan currently unavailble!'), 'Error');

            return to_route('user.dashboard');
        } elseif (! setting('kyc_loan') && ! auth()->user()->kyc) {
            notify()->error(__('Please verify your KYC.'), 'Error');

            return to_route('user.dashboard');
        }

        $plan = LoanPlan::findOrFail(decrypt($id));

        // Get plan minimum & maximum amount range
        $min = (int) $plan->minimum_amount;
        $max = (int) $plan->maximum_amount;
        // Get loan amount
        $amount = (int) $request->amount;
        // Get currency symbol from setting
        $currency = setting('currency_symbol', 'global');

        // Check minimum & maximun requirement
        if ($amount < $min || $max < $amount) {
            $message = __('You must choice minimum '.$currency.$plan->minimum_amount.' and maximum '.$currency.$plan->maximum_amount);
            notify()->error($message, 'Error');

            return redirect()->back();
        }

        return view('frontend::loan.application', compact('plan', 'request'));
    }

    public function subscribe(Request $request)
    {
        // Check loan available or not
        if (! setting('user_loan', 'permission') || ! Auth::user()->loan_status) {
            notify()->error(__('Loan currently unavailble!'), 'Error');

            return to_route('user.dashboard');
        } elseif (! setting('kyc_loan') && ! auth()->user()->kyc) {
            notify()->error(__('Please verify your KYC.'), 'Error');

            return to_route('user.dashboard');
        }

        // Retrieve plan
        $plan = LoanPlan::findOrFail(decrypt($request->loan_id));

        // Plan is not exists throw error
        if (! $plan) {
            notify()->error(__('Loan Plan Not found.'), 'Error');

            return redirect()->back();
        }

        // Get user data
        $user = auth()->user();
        // Get loan amount
        $amount = (int) $request->amount;
        //  Get currency symbol from setting
        $currency = setting('currency_symbol', 'global');

        // Get plan minimum & maximum amount range
        $min = (int) $plan->minimum_amount;
        $max = (int) $plan->maximum_amount;

        // Check minimum & maximun requirement
        if ($amount < $min || $max < $amount) {
            $message = __('You must choice minimum '.$currency.$plan->minimum_amount.' and maximum '.$currency.$plan->maximum_amount);
            notify()->error($message, 'Error');

            return redirect()->back();
        }

        // Loan application process
        $submitted_data = [];

        foreach ($request->submitted_data ?? [] as $key => $value) {

            if (is_file($value)) {
                $submitted_data[$key] = self::imageUploadTrait($value);
            } else {
                $submitted_data[$key] = $value;
            }
        }

        // Create loan request
        $loan = Loan::create([
            'loan_no' => 'L'.random_int(10000000, 99999999),
            'loan_plan_id' => $plan->id,
            'user_id' => $user->id,
            'submitted_data' => json_encode($submitted_data),
            'amount' => $amount,
            'status' => LoanStatus::Reviewing,
        ]);

        $loan_fee = $plan->loan_fee;

        $user->decrement('balance', $loan_fee);

        Txn::new($amount, $loan_fee, $amount + $loan_fee, 'System', 'Loan Applied #'.$loan->loan_no.'', TxnType::LoanApply, TxnStatus::Success, '', null, auth()->id(), null, 'User');

        $shortcodes = [
            '[[site_title]]' => setting('site_title', 'global'),
            '[[site_url]]' => route('home'),
            '[[plan_name]]' => $loan->plan->name,
            '[[user_name]]' => $loan->user->full_name,
            '[[full_name]]' => $loan->user->full_name,
            '[[loan_id]]' => $loan->loan_no,
            '[[loan_amount]]' => $loan->amount.' '.setting('site_currency', 'global'),
            '[[installment_interval]]' => $loan->plan->installment_intervel,
            '[[installment_rate]]' => $loan->plan->installment_rate,
        ];

        $this->smsNotify('loan_apply', $shortcodes, $loan->user->phone);
        $this->mailNotify(setting('support_email', 'global'), 'loan_apply', $shortcodes);
        $this->pushNotify('loan_apply', $shortcodes, route('user.loan.details', $loan->loan_no), $loan->user_id);
        $this->pushNotify('loan_apply', $shortcodes, route('admin.loan.details', $loan->id), $loan->user_id, 'Admin');

        notify()->success(__('Loan applied successfully!'), 'Success');

        return redirect()->route('user.loan.history');
    }

    public function history()
    {
        $from_date = trim(@explode('-', request('daterange'))[0]);
        $to_date = trim(@explode('-', request('daterange'))[1]);

        $loans = Loan::with('transactions', 'plan', 'user')
            ->where('user_id', auth()->id())
            ->when(request('loan_id'), function ($query) {
                $query->where('loan_no', 'LIKE', '%'.request('loan_id').'%');
            })
            ->when(request('daterange'), function ($query) use ($from_date, $to_date) {
                $query->whereDate('created_at', '>=', Carbon::parse($from_date)->format('Y-m-d'));
                $query->whereDate('created_at', '<=', Carbon::parse($to_date)->format('Y-m-d'));
            })
            ->latest()
            ->paginate(request('limit', 15))
            ->withQueryString();

        return view('frontend::loan.history', compact('loans'));
    }

    public function details($loanNo)
    {
        $loan = Loan::with('transactions', 'plan', 'user')->where('loan_no', $loanNo)->where('user_id', auth()->id())->firstOrFail();

        return view('frontend::loan.details', compact('loan'));
    }

    public function cancel($loan_id)
    {
        // Get loan data
        $loan = Loan::where('loan_no', $loan_id)->where('user_id', auth()->id())->firstOrFail();

        if ($loan->status !== LoanStatus::Reviewing) {
            return back();
        }

        // Save loan cancel info
        $loan->cancel_date = now();
        $loan->status = LoanStatus::Cancelled;
        $loan->save();

        notify()->success(__('Loan request cancelled successfully!'), 'Success');

        return redirect()->route('user.loan.history');
    }
}
