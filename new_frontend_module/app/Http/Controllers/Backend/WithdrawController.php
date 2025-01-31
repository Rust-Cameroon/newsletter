<?php

namespace App\Http\Controllers\Backend;

use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Http\Controllers\Controller;
use App\Models\Gateway;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawalSchedule;
use App\Models\WithdrawMethod;
use App\Traits\ImageUpload;
use App\Traits\NotifyTrait;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;
use Txn;

class WithdrawController extends Controller
{
    use ImageUpload, NotifyTrait;

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:withdraw-method-manage', ['only' => ['methods', 'methodCreate', 'methodStore', 'methodEdit', 'methodUpdate']]);
        $this->middleware('permission:withdraw-list|withdraw-action', ['only' => ['pending', 'history']]);
        $this->middleware('permission:withdraw-action', ['only' => ['withdrawAction', 'actionNow']]);
        $this->middleware('permission:withdraw-schedule', ['only' => ['schedule', 'scheduleUpdate']]);
    }

    /**
     * @return Application|Factory|View
     */
    public function methods($type)
    {
        $button = [
            'name' => __('ADD NEW'),
            'icon' => 'plus',
            'route' => route('admin.withdraw.method.create', $type),
        ];
        $withdrawMethods = WithdrawMethod::whereType($type)->get();

        return view('backend.withdraw.method', compact('withdrawMethods', 'button', 'type'));
    }

    /**
     * @return Application|Factory|View
     */
    public function methodCreate($type)
    {
        $button = [
            'name' => __('Back'),
            'icon' => 'corner-down-left',
            'route' => route('admin.withdraw.method.list', $type),
        ];
        $gateways = Gateway::where('status', true)->whereNot('is_withdraw', '=', '0')->get();

        return view('backend.withdraw.method_create', compact('button', 'type', 'gateways'));
    }

    /**
     * @return RedirectResponse
     */
    public function methodStore(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'icon' => 'required_if:type,==,manual',
            'gateway_id' => 'required_if:type,==,auto',
            'name' => 'required',
            'currency' => 'required',
            'required_time' => 'required_if:type,==,manual',
            'required_time_format' => 'required_if:type,==,manual',
            'charge' => 'required',
            'charge_type' => 'required',
            'rate' => 'required',
            'min_withdraw' => 'required',
            'max_withdraw' => 'required',
            'status' => 'required',
            'fields' => 'required_if:type,==,manual',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $fields = null;
        if ($input['type'] == 'auto') {

            $withdrawGateways = Gateway::find($input['gateway_id']);
            $withdrawFields = explode(',', $withdrawGateways->is_withdraw);

            $fields = array_map(function ($field) {
                return [
                    'name' => $field,
                    'type' => 'text',
                    'validation' => 'required',
                ];
            }, $withdrawFields);

        }

        $data = [
            'icon' => isset($input['icon']) ? self::imageUploadTrait($input['icon']) : '',
            'gateway_id' => $input['gateway_id'] ?? null,
            'type' => $input['type'],
            'name' => $input['name'],
            'required_time' => $input['required_time'] ?? 0,
            'required_time_format' => $input['required_time_format'] ?? 'hour',
            'currency' => $input['currency'],
            'charge' => $input['charge'],
            'charge_type' => $input['charge_type'],
            'rate' => $input['rate'],
            'min_withdraw' => $input['min_withdraw'],
            'max_withdraw' => $input['max_withdraw'],
            'status' => $input['status'],
            'fields' => json_encode($fields ?? $input['fields']),
        ];

        $withdrawMethod = WithdrawMethod::create($data);
        notify()->success($withdrawMethod->name.' '.__('Withdraw Method Created'));

        return redirect()->route('admin.withdraw.method.list', $input['type']);
    }

    /**
     * @param  $id
     * @return Application|Factory|View
     */
    public function methodEdit($type)
    {

        $button = [
            'name' => __('Back'),
            'icon' => 'corner-down-left',
            'route' => route('admin.withdraw.method.list', $type),
        ];

        $withdrawMethod = WithdrawMethod::find(\request('id'));
        $supported_currencies = Gateway::find($withdrawMethod->gateway_id)->supported_currencies ?? [];

        return view('backend.withdraw.method_edit', compact('button', 'withdrawMethod', 'type', 'supported_currencies'));
    }

    /**
     * @return RedirectResponse
     */
    public function methodUpdate(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'currency' => 'required',
            'required_time' => 'required_if:type,==,manual',
            'required_time_format' => 'required_if:type,==,manual',
            'charge' => 'required',
            'charge_type' => 'required',
            'rate' => 'required',
            'min_withdraw' => 'required',
            'max_withdraw' => 'required',
            'status' => 'required',
            'fields' => 'required_if:type,==,manual',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $withdrawMethod = WithdrawMethod::find($id);

        $data = [
            'name' => $input['name'],
            'required_time' => $input['required_time'] ?? $withdrawMethod->required_time,
            'required_time_format' => $input['required_time_format'] ?? $withdrawMethod->required_time_format,
            'currency' => $input['currency'] ?? $withdrawMethod->currency,
            'charge' => $input['charge'],
            'charge_type' => $input['charge_type'],
            'rate' => $input['rate'],
            'min_withdraw' => $input['min_withdraw'],
            'max_withdraw' => $input['max_withdraw'],
            'status' => $input['status'],
            'fields' => isset($input['fields']) ? json_encode($input['fields']) : $withdrawMethod->fields,
        ];

        if ($request->hasFile('icon')) {
            $icon = self::imageUploadTrait($input['icon'], $withdrawMethod->icon);
            $data = array_merge($data, ['icon' => $icon]);
        }

        $withdrawMethod->update($data);
        notify()->success($withdrawMethod->name.' '.__('Withdraw Method Updated'));

        return redirect()->route('admin.withdraw.method.list', $withdrawMethod->type);
    }

    /**
     * @return Application|Factory|View|JsonResponse
     *
     * @throws Exception
     */
    public function pending(Request $request)
    {
        $perPage = $request->perPage ?? 15;
        $order = $request->order ?? 'desc';
        $search = $request->search ?? null;
        $withdrawals = Transaction::with('user')
                            ->where(function ($query) {
                                $query->where('type', TxnType::Withdraw->value)
                                    ->where('status',TxnStatus::Pending->value);
                            })
                            ->latest()
                            ->search($search)
                            ->paginate($perPage);

        return view('backend.withdraw.pending', compact('withdrawals'));
    }

    /**
     * @return Application|Factory|View|JsonResponse
     *
     * @throws Exception
     */
    public function history(Request $request)
    {
        $perPage = $request->perPage ?? 15;
        $order = $request->order ?? 'desc';
        $status = $request->status ?? 'all';
        $search = $request->search ?? null;
        $withdrawals = Transaction::with('user')
                            ->whereIn('type',[TxnType::Withdraw->value,TxnType::WithdrawAuto->value])
                            ->search($search)
                            ->when(in_array(request('sort_field'),['created_at','amount','charge','method','status','tnx']),function($query){
                                $query->orderBy(request('sort_field'),request('sort_dir'));
                            })
                            ->when(request('sort_field') == 'user',function($query){
                                $query->whereHas('user',function($userQuery){
                                    $userQuery->orderBy('username',request('sort_dir'));
                                });
                            })
                            ->when(!request()->has('sort_field'),function($query){
                                $query->latest();
                            })
                            ->status($status)
                            ->paginate($perPage);

        return view('backend.withdraw.history', compact('withdrawals'));
    }

    /**
     * @return string
     */
    public function withdrawAction($id)
    {

        $data = Transaction::find($id);

        return view('backend.withdraw.include.__withdraw_action', compact('data', 'id'))->render();
    }

    /**
     * @return RedirectResponse
     */
    public function actionNow(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $approvalCause = $input['message'];
        $transaction = Transaction::find($id);
        $user = User::find($transaction->user_id);

        if (isset($input['approve'])) {
            Txn::update($transaction->tnx, TxnStatus::Success, $transaction->user_id, $approvalCause);
            notify()->success('Approve successfully');
        } elseif (isset($input['reject'])) {

            $user->increment('balance', $transaction->final_amount);
            Txn::update($transaction->tnx, TxnStatus::Failed, $transaction->user_id, $approvalCause);

            $newTransaction = $transaction->replicate();
            $newTransaction->type = TxnType::Refund;
            $newTransaction->status = TxnStatus::Success;
            $newTransaction['method'] = 'system';
            $newTransaction->tnx = 'TRX'.strtoupper(Str::random(10));
            $newTransaction->save();
            notify()->success('Reject successfully');
        }

        $shortcodes = [
            '[[full_name]]' => $user->full_name,
            '[[txn]]' => $transaction->tnx,
            '[[method_name]]' => $transaction->method,
            '[[withdraw_amount]]' => $transaction->amount.setting('site_currency', 'global'),
            '[[site_title]]' => setting('site_title', 'global'),
            '[[site_url]]' => route('home'),
            '[[message]]' => $transaction->approval_cause,
            '[[status]]' => isset($input['approve']) ? 'approved' : 'Rejected',
        ];

        $this->mailNotify($user->email, 'withdraw_request_user', $shortcodes);
        $this->pushNotify('withdraw_request_user', $shortcodes, route('user.withdraw.log'), $user->id);
        $this->smsNotify('withdraw_request_user', $shortcodes, $user->phone);

        return redirect()->back();
    }

    public function schedule()
    {
        $schedules = WithdrawalSchedule::all();

        return view('backend.withdraw.schedule', compact('schedules'));
    }

    public function scheduleUpdate(Request $request)
    {

        $updateSchedules = $request->except('_token');
        foreach ($updateSchedules as $name => $status) {
            WithdrawalSchedule::where('name', $name)->update([
                'status' => $status,
            ]);
        }

        notify()->success('Withdrawal Schedule Update successfully');

        return redirect()->back();
    }
}
