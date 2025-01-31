<?php

namespace App\Http\Controllers\Backend;

use App\Enums\ReferralType;
use App\Http\Controllers\Controller;
use App\Models\LevelReferral;
use App\Models\Setting;
use Cache;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class ReferralController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-referral', ['only' => ['index']]);
        $this->middleware('permission:referral-create', ['only' => ['store']]);
        $this->middleware('permission:referral-edit', ['only' => ['update']]);
        $this->middleware('permission:referral-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {

        $referralType = [
            ReferralType::Deposit,
            ReferralType::DPS,
            ReferralType::FDR,
            ReferralType::Loan,
            ReferralType::PayBill,
        ];

        $deposits = LevelReferral::where('type', ReferralType::Deposit->value)->get();
        $dpses = LevelReferral::where('type', ReferralType::DPS->value)->get();
        $fdrs = LevelReferral::where('type', ReferralType::FDR->value)->get();
        $loans = LevelReferral::where('type', ReferralType::Loan->value)->get();
        $bills = LevelReferral::where('type', ReferralType::PayBill->value)->get();

        return view('backend.referral.index', compact('referralType', 'dpses', 'deposits', 'fdrs', 'loans', 'bills'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'level_type' => new Enum(ReferralType::class),
            'bounty' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $data = [
            'type' => $request->level_type,
            'bounty' => $request->bounty,
        ];

        $position = LevelReferral::where('type', $request->level_type)->max('the_order');
        $data = array_merge($data, ['the_order' => $position + 1]);

        LevelReferral::create($data);

        notify()->success('Referral level created successfully!', 'Success');

        return redirect()->route('admin.referral.index');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\LevelReferral  $levelReferral
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'bounty' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $input = $request->all();

        $data = [
            'bounty' => $input['bounty'],
        ];

        LevelReferral::find($id)->update($data);
        notify()->success('Referral level updated successfully');

        return redirect()->route('admin.referral.index');
    }

    public function statusUpdate(Request $request)
    {

        $key = $request->type;
        $value = setting($key) ? 0 : 1;

        Setting::add($key, $value, 'boolean');

        Cache::forget('settings.all');

        notify()->success(ucwords(str_replace('_', ' ', $key)).'  Status updated successfully!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LevelReferral  $levelReferral
     * @return RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $levelReferral = LevelReferral::find($id);
        $levelReferral->delete();

        $reorders = LevelReferral::where('type', $request->type)->get();
        $i = 1;
        foreach ($reorders as $reorder) {
            $reorder->the_order = $i;
            $reorder->save();
            $i++;
        }

        notify()->success('Referral level deleted successfully!');

        return redirect()->route('admin.referral.index');

    }

    public function settings()
    {
        return view('backend.referral.settings');
    }
}
