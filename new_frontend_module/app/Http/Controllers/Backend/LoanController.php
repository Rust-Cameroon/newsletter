<?php

namespace App\Http\Controllers\Backend;

use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Http\Controllers\Controller;
use App\Models\LevelReferral;
use App\Models\Loan;
use App\Models\LoanTransaction;
use App\Traits\NotifyTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Txn;

class LoanController extends Controller
{
    use NotifyTrait;

    public function __construct()
    {
        $this->middleware('permission:pending-loan', ['only' => ['request']]);
        $this->middleware('permission:running-loan', ['only' => ['approved']]);
        $this->middleware('permission:due-loan', ['only' => ['payable']]);
        $this->middleware('permission:paid-loan', ['only' => ['completed']]);
        $this->middleware('permission:rejected-loan', ['only' => ['rejected']]);
        $this->middleware('permission:all-loan', ['only' => ['all']]);
        $this->middleware('permission:view-loan-details', ['only' => ['details']]);
        $this->middleware('permission:loan-approval', ['only' => ['approvalAction']]);
    }

    public function all(Request $request)
    {
        $search = $request->search;
        $loan = Loan::with(['plan', 'user'])
                    ->search($search)
                    ->when(in_array($request->sort_field,['loan_no','created_at','amount','status']),function($query){
                        $query->orderBy(request('sort_field'),request('sort_dir'));
                    })
                    ->latest()
                    ->paginate(10);

        $statusForFrontend = __('All');

        return view('backend.loan.index', compact('loan', 'statusForFrontend'));
    }

    public function request(Request $request)
    {
        $search = $request->search;
        $loan = Loan::with(['plan', 'user'])
                    ->reviewing()
                    ->search($search)
                    ->when(in_array($request->sort_field,['loan_no','created_at','amount','status']),function($query){
                        $query->orderBy(request('sort_field'),request('sort_dir'));
                    })
                    ->latest()
                    ->paginate(10);

        $statusForFrontend = __('Requested');

        return view('backend.loan.index', compact('loan', 'statusForFrontend'));
    }

    public function rejected(Request $request)
    {
        $search = $request->search;

        $loan = Loan::with(['plan', 'user'])
                        ->rejected()
                        ->search($search)
                        ->when(in_array($request->sort_field,['loan_no','created_at','amount','status']),function($query){
                            $query->orderBy(request('sort_field'),request('sort_dir'));
                        })
                        ->latest()
                        ->paginate(10);

        $statusForFrontend = __('Rejected');

        return view('backend.loan.index', compact('loan', 'statusForFrontend'));
    }

    public function approved(Request $request)
    {
        $search = $request->search;

        $loan = Loan::with(['plan', 'user'])
                    ->running()
                    ->search($search)
                    ->when(in_array($request->sort_field,['loan_no','created_at','amount','status']),function($query){
                        $query->orderBy(request('sort_field'),request('sort_dir'));
                    })
                    ->latest()
                    ->paginate(10);

        $statusForFrontend = __('Approved');

        return view('backend.loan.index', compact('loan', 'statusForFrontend'));
    }

    public function payable(Request $request)
    {
        $search = $request->search;

        $loan = Loan::with(['plan', 'user'])
                    ->due()
                    ->search($search)
                    ->when(in_array($request->sort_field,['loan_no','created_at','amount','status']),function($query){
                        $query->orderBy(request('sort_field'),request('sort_dir'));
                    })
                    ->latest()
                    ->paginate(10);

        $statusForFrontend = __('Payable');

        return view('backend.loan.index', compact('loan', 'statusForFrontend'));
    }

    public function completed(Request $request)
    {
        $search = $request->search;

        $loan = Loan::with(['plan', 'user'])
                    ->completed()
                    ->search($search)
                    ->when(in_array($request->sort_field,['loan_no','created_at','amount','status']),function($query){
                        $query->orderBy(request('sort_field'),request('sort_dir'));
                    })
                    ->latest()
                    ->paginate(10);

        $statusForFrontend = __('Completed');

        return view('backend.loan.index', compact('loan', 'statusForFrontend'));
    }

    public function details($id)
    {
        $loan = Loan::with(['user', 'plan', 'transactions'])->find($id);

        return view('backend.loan.details', compact('loan'));
    }

    public function approvalAction(Request $request)
    {
        $loan = Loan::findOrFail($request->id);

        $loan->update([
            'status' => $request->status,
        ]);

        $plan = $loan->plan;

        $message = __('Loan request rejected successfully!');

        $shortcodes = [
            '[[site_title]]' => setting('site_title', 'global'),
            '[[site_url]]' => route('home'),
            '[[plan_name]]' => $loan->plan->name,
            '[[user_name]]' => $loan->user->full_name,
            '[[loan_id]]' => $loan->loan_no,
            '[[given_installment]]' => 0,
            '[[total_installment]]' => $loan->plan->total_installment,
            '[[next_installment_date]]' => nextInstallment($loan->id, \App\Models\LoanTransaction::class, 'loan_id'),
            '[[loan_amount]]' => $loan->amount.' '.setting('site_currency', 'global'),
            '[[installment_interval]]' => $loan->plan->installment_intervel,
            '[[installment_rate]]' => $loan->plan->installment_rate,
        ];

        if ($request->status == 'running') {
            $loanTransactions = [];

            for ($i = 1; $i <= $plan->total_installment; $i++) {
                $loanTransactions[] = [
                    'loan_id' => $loan->id,
                    'installment_date' => Carbon::now()->addDays($plan->installment_intervel * $i),
                ];
            }

            LoanTransaction::insert($loanTransactions);

            $loan->user->increment('balance', $loan->amount);

            // Create Transaction
            Txn::new($loan->amount, 0, $loan->amount, 'System', 'Loan Approved #'.$loan->loan_no.'', TxnType::Loan, TxnStatus::Success, 'System', null, $loan->user_id, null, 'User');

            $this->smsNotify('loan_approved', $shortcodes, $loan->user->phone);
            $this->mailNotify($loan->user->email, 'loan_approved', $shortcodes);
            $this->pushNotify('loan_approved', $shortcodes, route('user.loan.details', $loan->loan_no), $loan->user_id);

            // Level referral
            if (setting('loan_level')) {
                $level = LevelReferral::where('type', 'loan')->max('the_order') + 1;
                creditReferralBonus($loan->user, 'loan', $loan->amount, $level);
            }

            $message = __('Loan request approved successfully!');
        } else {
            $this->smsNotify('loan_rejected', $shortcodes, $loan->user->phone);
            $this->mailNotify($loan->user->email, 'loan_rejected', $shortcodes);
            $this->pushNotify('loan_rejected', $shortcodes, route('user.loan.details', $loan->loan_no), $loan->user_id);
        }

        notify()->success($message, 'Success');

        return redirect()->route('admin.loan.all');
    }
}
