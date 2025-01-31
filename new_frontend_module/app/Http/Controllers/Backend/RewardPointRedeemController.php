<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\RewardPointRedeem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RewardPointRedeemController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:reward-redeem-list', ['only' => ['index']]);
        $this->middleware('permission:reward-redeem-create', ['only' => ['store']]);
        $this->middleware('permission:reward-redeem-edit', ['only' => ['update']]);
        $this->middleware('permission:reward-redeem-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $redeems = RewardPointRedeem::with('portfolio')->latest()->paginate();
        $portfolios = Portfolio::active()->get();

        return view('backend.reward-point.redeem.index', compact('redeems', 'portfolios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'portfolio_id' => 'required|unique:reward_point_redeems,portfolio_id',
            'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/|unique:reward_point_redeems,amount',
            'point' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ], [
            'portfolio_id.unique' => __('Portfolio redeem already exists.'),
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        RewardPointRedeem::create([
            'portfolio_id' => $request->get('portfolio_id'),
            'amount' => $request->get('amount'),
            'point' => $request->get('point'),
        ]);

        notify()->success(__('Redeem added successfully!'), 'Success');

        return redirect()->route('admin.reward.point.redeem.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'portfolio_id' => 'required|unique:reward_point_redeems,portfolio_id,'.$id,
            'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/|unique:reward_point_redeems,amount,'.$id,
            'point' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ], [
            'portfolio_id.unique' => __('Portfolio redeem already exists.'),
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        RewardPointRedeem::findOrFail($id)->update([
            'portfolio_id' => $request->get('portfolio_id'),
            'amount' => $request->get('amount'),
            'point' => $request->get('point'),
        ]);

        notify()->success(__('Redeem updated successfully!'), 'Success');

        return redirect()->route('admin.reward.point.redeem.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        RewardPointRedeem::destroy($id);

        notify()->success(__('Redeem deleted successfully!'), 'Success');

        return redirect()->route('admin.reward.point.redeem.index');
    }
}
