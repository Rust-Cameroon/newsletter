<?php

namespace App\Http\Controllers\Backend;

use App\Enums\TransferType;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Traits\NotifyTrait;
use App\Traits\RewardTrait;
use Illuminate\Http\Request;

class FundTransferController extends Controller
{
    use NotifyTrait,RewardTrait;

    public function __construct()
    {
        $this->middleware('permission:pending-transfers', ['only' => ['pending']]);
        $this->middleware('permission:rejected-transfers', ['only' => ['rejected']]);
        $this->middleware('permission:all-transfers', ['only' => ['all']]);
        $this->middleware('permission:allied-transfers', ['only' => ['allied']]);
        $this->middleware('permission:other-bank-transfers', ['only' => ['other']]);
        $this->middleware('permission:wire-transfer', ['only' => ['wire']]);
        $this->middleware('permission:fund-transfer-approval', ['only' => ['details', 'actionNow']]);
    }

    public function pending(Request $request)
    {
        $perPage = $request->perPage ?? 15;
        $search = $request->search ?? null;
        $type = $request->type ?? 'all';
        $status = $request->status ?? 'all';

        $lists = Transaction::with('user')
                            ->pending()
                            ->fundTransfar()
                            ->status($status)
                            ->search($search)
                            ->transfertype($type)
                            ->when(in_array($request->sort_field,['created_at','tnx','final_amount','type','status']),function($query){
                                $query->orderBy(request('sort_field'),request('sort_dir'));
                            })
                            ->when($request->sort_field == 'sender',function($query){
                                $query->whereHas('user',function($userQuery){
                                    $userQuery->orderBy('username',request('sort_dir'));
                                });
                            })
                            ->when(!request()->has('sort_field'),function($query){
                                $query->latest();
                            })
                            ->paginate($perPage);

        $statusForFrontend = 'Pending';

        return view('backend.fund-transfer.index', compact('lists', 'statusForFrontend'));
    }

    public function rejected(Request $request)
    {

        $perPage = $request->perPage ?? 15;
        $search = $request->search ?? null;
        $type = $request->type ?? 'all';
        $status = $request->status ?? 'all';

        $lists = Transaction::with('user')
                            ->rejected()
                            ->fundTransfar()
                            ->status($status)
                            ->search($search)
                            ->transfertype($type)
                            ->when(in_array($request->sort_field,['created_at','tnx','final_amount','type','status']),function($query){
                                $query->orderBy(request('sort_field'),request('sort_dir'));
                            })
                            ->when($request->sort_field == 'sender',function($query){
                                $query->whereHas('user',function($userQuery){
                                    $userQuery->orderBy('username',request('sort_dir'));
                                });
                            })
                            ->when(!request()->has('sort_field'),function($query){
                                $query->latest();
                            })
                            ->paginate($perPage);

        $statusForFrontend = 'Rejected';

        return view('backend.fund-transfer.index', compact('lists', 'statusForFrontend'));
    }

    public function all(Request $request)
    {
        $perPage = $request->perPage ?? 15;
        $search = $request->search ?? null;
        $type = $request->type ?? 'all';
        $status = $request->status ?? 'all';

        $lists = Transaction::with('user')
                        ->fundTransfar()
                        ->status($status)
                        ->search($search)
                        ->transfertype($type)
                        ->when(in_array($request->sort_field,['created_at','tnx','final_amount','type','status']),function($query){
                            $query->orderBy(request('sort_field'),request('sort_dir'));
                        })
                        ->when($request->sort_field == 'sender',function($query){
                            $query->whereHas('user',function($userQuery){
                                $userQuery->orderBy('username',request('sort_dir'));
                            });
                        })
                        ->when(!request()->has('sort_field'),function($query){
                            $query->latest();
                        })
                        ->paginate($perPage);

        $statusForFrontend = 'All';

        return view('backend.fund-transfer.index', compact('lists', 'statusForFrontend'));
    }

    public function allied(Request $request)
    {

        $perPage = $request->perPage ?? 15;
        $search = $request->search ?? null;
        $type = $request->type ?? 'all';
        $status = $request->status ?? 'all';

        $lists = Transaction::with('user')
                            ->ownTransfer()
                            ->fundTransfar()
                            ->status($status)
                            ->search($search)
                            ->transfertype($type)
                            ->when(in_array($request->sort_field,['created_at','tnx','final_amount','type','status']),function($query){
                                $query->orderBy(request('sort_field'),request('sort_dir'));
                            })
                            ->when($request->sort_field == 'sender',function($query){
                                $query->whereHas('user',function($userQuery){
                                    $userQuery->orderBy('username',request('sort_dir'));
                                });
                            })
                            ->when(!request()->has('sort_field'),function($query){
                                $query->latest();
                            })
                            ->paginate($perPage);

        $statusForFrontend = 'Allied';

        return view('backend.fund-transfer.index', compact('lists', 'statusForFrontend'));
    }

    public function other(Request $request)
    {

        $perPage = $request->perPage ?? 15;
        $search = $request->search ?? null;
        $type = $request->type ?? 'all';
        $status = $request->status ?? 'all';

        $lists = Transaction::with('user')
                        ->otherTransfer()
                        ->fundTransfar()
                        ->status($status)
                        ->search($search)
                        ->transfertype($type)
                        ->when(in_array($request->sort_field,['created_at','tnx','final_amount','type','status']),function($query){
                            $query->orderBy(request('sort_field'),request('sort_dir'));
                        })
                        ->when($request->sort_field == 'sender',function($query){
                            $query->whereHas('user',function($userQuery){
                                $userQuery->orderBy('username',request('sort_dir'));
                            });
                        })
                        ->when(!request()->has('sort_field'),function($query){
                            $query->latest();
                        })
                        ->paginate($perPage);

        $statusForFrontend = 'Other Bank';

        return view('backend.fund-transfer.index', compact('lists', 'statusForFrontend'));
    }

    public function wire(Request $request)
    {
        $perPage = $request->perPage ?? 15;
        $search = $request->search ?? null;
        $type = $request->type ?? 'all';
        $status = $request->status ?? 'all';

        $lists = Transaction::with('user')
                        ->wireTransfer()
                        ->fundTransfar()
                        ->status($status)
                        ->search($search)
                        ->transfertype($type)
                        ->when(in_array($request->sort_field,['created_at','tnx','final_amount','type','status']),function($query){
                            $query->orderBy(request('sort_field'),request('sort_dir'));
                        })
                        ->when($request->sort_field == 'sender',function($query){
                            $query->whereHas('user',function($userQuery){
                                $userQuery->orderBy('username',request('sort_dir'));
                            });
                        })
                        ->when(!request()->has('sort_field'),function($query){
                            $query->latest();
                        })
                        ->paginate($perPage);

        $statusForFrontend = 'Wire';

        return view('backend.fund-transfer.index', compact('lists', 'statusForFrontend'));
    }

    public function details($id)
    {
        $transaction = Transaction::with(['user', 'fromUser'])->find($id);
        $manual_field = json_decode($transaction->manual_field_data, true);

        return view('backend.fund-transfer.include.__data', compact('transaction', 'id', 'manual_field'))->render();
    }

    /**
     * @return RedirectResponse
     */
    public function actionNow(Request $request)
    {
        $input = $request->all();
        $transaction = Transaction::find($input['id']);
        $transaction->update([
            'status' => $input['status'],
            'action_message' => $input['message'],
        ]);

        if ($input['status'] == 'success') {
            $this->rewardToUser($transaction->user_id, $transaction->id);
        }

        if ($input['status'] == 'failed') {
            $amount = $transaction->final_amount;
            $transaction->user?->increment('balance', $amount);
        }

        $user = $transaction->user;
        $manual_data = json_decode($transaction->manual_field_data);

        if ($transaction->transfer_type != TransferType::WireTransfer) {
            $shortcodes = [
                '[[full_name]]' => $user->full_name,
                '[[email]]' => $user->email,
                '[[charge]]' => $transaction->charge,
                '[[amount]]' => $transaction->amount,
                '[[total_amount]]' => $transaction->final_amount,
                '[[total_amount]]' => $transaction->final_amount,
                '[[status]]' => $transaction->status->value,
                '[[account_number]]' => data_get($manual_data, 'account_number'),
                '[[account_name]]' => data_get($manual_data, 'account_name'),
                '[[branch_name]]' => data_get($manual_data, 'branch_name'),
                '[[site_title]]' => setting('site_title', 'global'),
                '[[site_url]]' => route('home'),
            ];

            $this->mailNotify($transaction->user->email, 'fund_transfer', $shortcodes);
            $this->smsNotify('fund_transfer', $shortcodes, $transaction->user->phone);
            $this->pushNotify('fund_transfer_request', $shortcodes, route('user.fund_transfer.transfer.log'), $transaction->user->id);
        } else {

            $shortcodes = [
                '[[full_name]]' => $user->full_name,
                '[[email]]' => $user->email,
                '[[charge]]' => $transaction->charge,
                '[[amount]]' => $transaction->amount,
                '[[total_amount]]' => $transaction->final_amount,
                '[[total_amount]]' => $transaction->final_amount,
                '[[status]]' => $transaction->status->value,
                '[[account_number]]' => data_get($manual_data, 'account_number'),
                '[[name_of_account]]' => data_get($manual_data, 'name_of_account'),
                '[[swift_code]]' => data_get($manual_data, 'swift_code'),
                '[[phone_number]]' => data_get($manual_data, 'phone_number'),
                '[[site_title]]' => setting('site_title', 'global'),
                '[[site_url]]' => route('home'),
            ];

            $this->mailNotify($transaction->user->email, 'wire_transfer', $shortcodes);
            $this->smsNotify('wire_transfer', $shortcodes, $transaction->user->phone);
            $this->pushNotify('wire_transfer_request', $shortcodes, route('user.fund_transfer.transfer.log'), $transaction->user->id);
        }

        notify()->success(__('Transfer status updated successfully'), 'Success');

        return redirect()->back();
    }
}
