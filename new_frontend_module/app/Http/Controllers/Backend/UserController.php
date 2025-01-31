<?php

namespace App\Http\Controllers\Backend;

use Txn;
use Hash;
use Exception;
use App\Models\Dps;
use App\Models\Fdr;
use App\Models\Kyc;
use App\Models\Loan;
use App\Models\User;
use App\Enums\TxnType;
use App\Models\Branch;
use App\Models\Ticket;
use App\Models\UserKyc;
use App\Enums\KYCStatus;
use App\Enums\TxnStatus;
use App\Models\Transaction;
use App\Traits\ImageUpload;
use App\Traits\NotifyTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\LevelReferral;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Foundation\Application;

class UserController extends Controller
{
    use NotifyTrait,ImageUpload;

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:customer-list|customer-login|customer-mail-send|customer-basic-manage|customer-change-password|all-type-status|customer-balance-add-or-subtract', ['only' => ['index', 'activeUser', 'disabled', 'mailSendAll', 'mailSend']]);
        $this->middleware('permission:customer-basic-manage|customer-change-password|all-type-status|customer-balance-add-or-subtract', ['only' => ['edit']]);
        $this->middleware('permission:customer-login', ['only' => ['userLogin']]);
        $this->middleware('permission:customer-mail-send', ['only' => ['mailSendAll', 'mailSend']]);
        $this->middleware('permission:customer-basic-manage', ['only' => ['update']]);
        $this->middleware('permission:customer-change-password', ['only' => ['passwordUpdate']]);
        $this->middleware('permission:all-type-status', ['only' => ['statusUpdate']]);
        $this->middleware('permission:customer-balance-add-or-subtract', ['only' => ['balanceUpdate']]);
    }

    public function index(Request $request)
    {
        $search = $request->query('query') ?? null;

        $users = User::query()
                    ->when(!blank(request('email_status')),function($query){
                        if(request('email_status')){
                            $query->whereNotNull('email_verified_at');
                        }else{
                            $query->whereNull('email_verified_at');
                        }
                    })
                    ->when(!blank(request('kyc_status')),function($query){
                        $query->where('kyc',request('kyc_status'));
                    })
                    ->when(!blank(request('status')),function($query){
                        $query->where('status',request('status'));
                    })
                    ->when(!blank(request('sort_field')),function($query){
                        $query->orderBy(request('sort_field'),request('sort_dir'));
                    })
                    ->when(!request()->has('sort_field'),function($query){
                        $query->latest();
                    })
                    ->search($search)
                    ->paginate();

        $title = __('All Customers');

        return view('backend.user.index', compact('users', 'title'));
    }

    public function activeUser(Request $request)
    {

        $search = $request->query('query') ?? null;

        $users = User::active()
                    ->when(!blank(request('email_status')),function($query){
                        if(request('email_status')){
                            $query->whereNotNull('email_verified_at');
                        }else{
                            $query->whereNull('email_verified_at');
                        }
                    })
                    ->when(!blank(request('kyc_status')),function($query){
                        $query->where('kyc',request('kyc_status'));
                    })
                    ->when(!blank(request('status')),function($query){
                        $query->where('status',request('status'));
                    })
                    ->when(!blank(request('sort_field')),function($query){
                        $query->orderBy(request('sort_field'),request('sort_dir'));
                    })
                    ->when(!request()->has('sort_field'),function($query){
                        $query->latest();
                    })
                    ->search($search)
                    ->paginate();

        $title = __('Active Customers');

        return view('backend.user.index', compact('users', 'title'));
    }

    public function disabled(Request $request)
    {
        $search = $request->query('query') ?? null;

        $users = User::disabled()
                    ->when(!blank(request('email_status')),function($query){
                        if(request('email_status')){
                            $query->whereNotNull('email_verified_at');
                        }else{
                            $query->whereNull('email_verified_at');
                        }
                    })
                    ->when(!blank(request('kyc_status')),function($query){
                        $query->where('kyc',request('kyc_status'));
                    })
                    ->when(!blank(request('status')),function($query){
                        $query->where('status',request('status'));
                    })
                    ->when(!blank(request('sort_field')),function($query){
                        $query->orderBy(request('sort_field'),request('sort_dir'));
                    })
                    ->when(!request()->has('sort_field'),function($query){
                        $query->latest();
                    })
                    ->search($search)
                    ->paginate();

        $title = __('Disabled Customers');

        return view('backend.user.index', compact('users', 'title'));
    }

    public function closed(Request $request)
    {
        $search = $request->query('query') ?? null;

        $users = User::closed()
                    ->when(!blank(request('email_status')),function($query){
                        if(request('email_status')){
                            $query->whereNotNull('email_verified_at');
                        }else{
                            $query->whereNull('email_verified_at');
                        }
                    })
                    ->when(!blank(request('kyc_status')),function($query){
                        $query->where('kyc',request('kyc_status'));
                    })
                    ->when(!blank(request('status')),function($query){
                        $query->where('status',request('status'));
                    })
                    ->when(!blank(request('sort_field')),function($query){
                        $query->orderBy(request('sort_field'),request('sort_dir'));
                    })
                    ->when(!request()->has('sort_field'),function($query){
                        $query->latest();
                    })
                    ->search($search)
                    ->paginate();

        $title = __('Closed Customers');

        return view('backend.user.index', compact('users', 'title'));
    }

    public function create()
    {
        $kycs = Kyc::where('status',true)->get();
        return view('backend.user.create',compact('kycs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $level = LevelReferral::where('type', 'investment')->max('the_order') + 1;

        $earnings = null;
        $dpses = null;
        $transactions = null;
        $fdres = null;
        $loans = null;
        $tickets = null;

        if(request('tab') == 'paybacks'){
            $earnings = Transaction::where('user_id', $id)
                                        ->profit()
                                        ->when(request('query') != null,function($query){
                                            $query->where('description','LIKE','%'.request('query').'%');
                                        })
                                        ->when(request('sort_field') != null,function($query){
                                            $query->orderBy(request('sort_field'),request('sort_dir'));
                                        })
                                        ->when(!request()->has('sort_field'),function($query){
                                            $query->latest();
                                        })
                                        ->paginate()
                                        ->withQueryString();
        }else if(request('tab') == 'dps'){
            $dpses = Dps::with('plan')
                        ->where('user_id', $id)
                        ->when(request('query') != null,function($query){
                            $query->whereHas('plan',function($planQuery){
                                $planQuery->where('name','LIKE','%'.request('query').'%');
                            });
                        })
                        ->when(in_array(request('sort_field'),['created_at','dps_id','per_installment','status']),function($query){
                            $query->orderBy(request('sort_field'),request('sort_dir'));
                        })
                        ->when(request('sort_field') == 'dps',function($query){
                            $query->whereHas('plan',function($dpsQuery){
                                $dpsQuery->orderBy('name',request('sort_dir'));
                            });
                        })
                        ->when(request('sort_field') == 'interest_rate',function($query){
                            $query->whereHas('plan',function($dpsQuery){
                                $dpsQuery->orderBy('interest_rate',request('sort_dir'));
                            });
                        })
                        ->when(!request()->has('sort_field'),function($query){
                            $query->latest();
                        })
                        ->paginate()
                        ->withQueryString();

        }elseif(request('tab') == 'transactions'){
            $transactions = Transaction::where('user_id', $id)
                                        ->search(request('query'))
                                        ->when(request('sort_field') != null,function($query){
                                            $query->orderBy(request('sort_field'),request('sort_dir'));
                                        })
                                        ->when(!request()->has('sort_field'),function($query){
                                            $query->latest();
                                        })
                                        ->paginate()
                                        ->withQueryString();

        }elseif(request('tab') == 'fdr'){
            $fdres = Fdr::with('plan')
                        ->where('user_id', $id)
                        ->when(request('query') != null,function($query){
                            $query->whereHas('plan',function($planQuery){
                                $planQuery->where('name','LIKE','%'.request('query').'%');
                            });
                        })
                        ->when(in_array(request('sort_field'),['created_at','fdr_id','amount','status']),function($query){
                            $query->orderBy(request('sort_field'),request('sort_dir'));
                        })
                        ->when(request('sort_field') == 'fdr',function($query){
                            $query->whereHas('plan',function($dpsQuery){
                                $dpsQuery->orderBy('name',request('sort_dir'));
                            });
                        })
                        ->when(!request()->has('sort_field'),function($query){
                            $query->latest();
                        })
                        ->paginate()
                        ->withQueryString();
        }elseif(request('tab') == 'loan'){
            $loans = Loan::with('plan')
                        ->where('user_id', $id)
                        ->when(request('query') != null,function($query){
                            $query->whereHas('plan',function($planQuery){
                                $planQuery->where('name','LIKE','%'.request('query').'%');
                            });
                        })
                        ->when(in_array(request('sort_field'),['created_at','loan_no','amount','status']),function($query){
                            $query->orderBy(request('sort_field'),request('sort_dir'));
                        })
                        ->when(request('sort_field') == 'loan',function($query){
                            $query->whereHas('plan',function($dpsQuery){
                                $dpsQuery->orderBy('name',request('sort_dir'));
                            });
                        })
                        ->when(!request()->has('sort_field'),function($query){
                            $query->latest();
                        })
                        ->paginate()
                        ->withQueryString();
        }elseif(request('tab') == 'ticket') {
            $tickets = Ticket::where('user_id', $id)
                            ->when(request('query') != null,function($query){
                                $query->where('title','LIKE','%'.request('query').'%');
                            })
                            ->when(in_array(request('sort_field'),['created_at','title','status']),function($query){
                                $query->orderBy(request('sort_field'),request('sort_dir'));
                            })
                            ->when(!request()->has('sort_field'),function($query){
                                $query->latest();
                            })
                            ->paginate()
                            ->withQueryString();
        }

        $branches = Branch::where('status', 1)->get();

        $statistics = [
            'total_deposit' => $user->total_deposit,
            'total_fund_transfer' => $user->totalTransfer(),
            'total_dps' => $user->dps->sum('total_dps_amount'),
            'total_fdr' => $user->fdr->sum('amount'),
            'total_loan' => $user->loan->sum('amount'),
            'total_bill' => $user->bill->sum('amount'),
            'total_withdraw' => $user->totalWithdraw(),
            'total_tickets' => $user->tickets->count(),
            'points' => $user->points,
            'paybacks' => $user->totalProfit(),
            'all_referral' => $user->referrals()->count(),
        ];

        return view('backend.user.edit', compact('user', 'level', 'branches', 'statistics', 'earnings', 'transactions', 'tickets', 'dpses', 'fdres', 'loans'));
    }

    /**
     * @return RedirectResponse
     */
    public function statusUpdate($id, Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'status' => 'required',
            'email_verified' => 'required',
            'kyc' => 'required',
            'two_fa' => 'required',
            'deposit_status' => 'required',
            'withdraw_status' => 'required',
            'transfer_status' => 'required',
            'otp_status' => 'required',
            'dps_status' => 'required',
            'fdr_status' => 'required',
            'loan_status' => 'required',
            'portfolio_status' => 'required',
            'reward_status' => 'required',
            'referral_status' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $data = [
            'status' => $input['status'],
            'kyc' => $input['kyc'],
            'two_fa' => $input['two_fa'],
            'deposit_status' => $input['deposit_status'],
            'withdraw_status' => $input['withdraw_status'],
            'transfer_status' => $input['transfer_status'],
            'otp_status' => $input['otp_status'],
            'dps_status' => $input['dps_status'],
            'fdr_status' => $input['fdr_status'],
            'loan_status' => $input['loan_status'],
            'portfolio_status' => $input['portfolio_status'],
            'reward_status' => $input['reward_status'],
            'referral_status' => $input['referral_status'],
            'email_verified_at' => $input['email_verified'] == 1 ? now() : null,
        ];

        $user = User::find($id);

        if ($user->status != $input['status'] && ! $input['status']) {

            $shortcodes = [
                '[[full_name]]' => $user->full_name,
                '[[site_title]]' => setting('site_title', 'global'),
                '[[site_url]]' => route('home'),
            ];

            $this->mailNotify($user->email, 'user_account_disabled', $shortcodes);
            $this->smsNotify('user_account_disabled', $shortcodes, $user->phone);
        }

        User::find($id)->update($data);

        if(!$input['kyc']){
            $this->markAsUnverified($id);
        }

        notify()->success('Status Updated Successfully', 'Success');

        return redirect()->back();

    }

    protected function markAsUnverified($user_id)
    {
        UserKyc::where('user_id',$user_id)->where('is_valid',true)->update([
            'is_valid' => false
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fname' => 'required',
            'lname' => 'required',
            'date_of_birth' => 'nullable|date',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back()->withInput();
        }

        $generateUsername = $request->fname.$request->lname;

        $usernameExists = User::withTrashed()->where('username',$generateUsername)->exists();

        $user = User::create([
            'first_name' => $request->fname,
            'last_name' => $request->lname,
            'username' => !$usernameExists ? strtolower($generateUsername) : strtolower($generateUsername.Str::random(4)),
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'branch_id' => $request->get('branch_id'),
            'gender' => $request->gender,
            'date_of_birth' => $request->date('date_of_birth'),
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
            'password' => bcrypt($request->password),
            'status' => 1,
            'kyc' => 0,
            'two_fa' => 0,
            'deposit_status' => 1,
            'withdraw_status' => 1,
            'transfer_status' => 4,
            'otp_status' => 0,
            'dps_status' => 1,
            'fdr_status' => 1,
            'loan_status' => 1,
            'portfolio_status' => 1,
            'reward_status' => 1,
            'referral_status' => 1,
            'email_verified_at' => now(),
            'kyc_credential' => null,
            'kyc' => KYCStatus::Pending,
        ]);

        $kycs = $request->kyc_credential;

        foreach ($kycs as $id => $kyc) {
            if(is_array($kyc)){
                foreach($kyc as $key => $value){
                    if (is_file($value)) {
                        $kycs[$id][$key] = self::imageUploadTrait($value);
                    }
                }
            }
        }

        foreach($request->kyc_ids as $id){

            $kyc = Kyc::find($id);

            UserKyc::create([
                'user_id' => $user->id,
                'kyc_id' => $kyc->id,
                'type' => $kyc->name,
                'data' => $kycs[$id],
                'is_valid' => true,
                'status' => 'pending'
            ]);
        }

        notify()->success(__('Customer added successfully!'),'Success');

        return to_route('admin.user.edit',$user->id);

    }

    /**
     * @return RedirectResponse
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username,'.$id,
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        User::find($id)->update($input);
        notify()->success('User Info Updated Successfully', 'Success');

        return redirect()->back();
    }

    /**
     * @return RedirectResponse
     */
    public function passwordUpdate($id, Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $password = $validator->validated();

        User::find($id)->update([
            'password' => Hash::make($password['new_password']),
        ]);
        notify()->success('User Password Updated Successfully', 'Success');

        return redirect()->back();
    }

    /**
     * @return RedirectResponse|void
     */
    public function balanceUpdate($id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        try {

            $amount = $request->amount;
            $type = $request->type;
            $wallet = $request->wallet;

            $user = User::find($id);
            $adminUser = \Auth::user();

            if ($type == 'add') {

                $user->balance += $amount;
                $user->save();

                Txn::new($amount, 0, $amount, 'system', 'Money added in '.ucwords($wallet).' Wallet from System', TxnType::Deposit, TxnStatus::Success, null, null, $id, $adminUser->id, 'Admin');

                $status = 'Success';
                $message = __('Balance added successfully!');

            } elseif ($type == 'subtract') {

                $user->balance -= $amount;
                $user->save();

                Txn::new($amount, 0, $amount, 'system', 'Money subtract in '.ucwords($wallet).' Wallet from System', TxnType::Subtract, TxnStatus::Success, null, null, $id, $adminUser->id, 'Admin');
                $status = 'Success';
                $message = __('Balance subtracted successfully!');
            }

            notify()->success($message, $status);

            return redirect()->back();

        } catch (Exception $e) {
            $status = 'warning';
            $message = __('something is wrong');
            $code = 503;
        }

    }

    /**
     * @return Application|Factory|View
     */
    public function mailSendAll()
    {
        return view('backend.user.mail_send_all');
    }

    /**
     * @return RedirectResponse
     */
    public function mailSend(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        try {

            $input = [
                'subject' => $request->subject,
                'message' => $request->message,
            ];

            $shortcodes = [
                '[[subject]]' => $input['subject'],
                '[[message]]' => $input['message'],
                '[[site_title]]' => setting('site_title', 'global'),
                '[[site_url]]' => route('home'),
            ];

            if (isset($request->id)) {
                $user = User::find($request->id);

                $shortcodes = array_merge($shortcodes, ['[[full_name]]' => $user->full_name]);

                $this->mailNotify($user->email, 'user_mail', $shortcodes);

            } else {
                $users = User::where('status', 1)->get();

                foreach ($users as $user) {
                    $shortcodes = array_merge($shortcodes, ['[[full_name]]' => $user->full_name]);

                    $this->mailNotify($user->email, 'user_mail', $shortcodes);
                }

            }
            $status = 'Success';
            $message = __('Mail Send Successfully');

        } catch (Exception $e) {

            $status = 'warning';
            $message = __('Sorry, something is wrong');
        }

        notify()->$status($message, $status);

        return redirect()->back();
    }

    /**
     * @return RedirectResponse
     */
    public function userLogin($id)
    {
        Auth::guard('web')->loginUsingId($id);

        return redirect()->route('user.dashboard');
    }

    public function destroy($id)
    {

        try {

            $user = User::find($id);
            $user->kycs()->delete();
            $user->transaction()->delete();
            $user->dps()->delete();
            $user->bill()->delete();
            $user->fdr()->delete();
            $user->loan()->delete();
            $user->ticket()->delete();
            $user->activities()->delete();
            $user->messages()->delete();
            $user->notifications()->delete();
            $user->refferelLinks()->delete();
            $user->withdrawAccounts()->delete();
            $user->delete();

            notify()->success(__('User deleted successfully'), 'Success');

            return to_route('admin.user.index');

        } catch (\Throwable $th) {
            notify()->error(__('Sorry, something went wrong!'), 'Error');

            return redirect()->back();
        }

    }
}
