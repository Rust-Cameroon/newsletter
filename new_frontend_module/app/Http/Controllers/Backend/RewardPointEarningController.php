<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\RewardPointEarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RewardPointEarningController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:reward-earning-list', ['only' => ['index']]);
        $this->middleware('permission:reward-earning-create', ['only' => ['store']]);
        $this->middleware('permission:reward-earning-edit', ['only' => ['update']]);
        $this->middleware('permission:reward-earning-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $earnings = RewardPointEarning::with('portfolio')->latest()->paginate();
        $portfolios = Portfolio::active()->get();

        return view('backend.reward-point.earning.index', compact('earnings', 'portfolios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'portfolio_id' => 'required|unique:reward_point_earnings,portfolio_id',
            'amount_of_transactions' => 'required|regex:/^\d+(\.\d{1,2})?$/|unique:reward_point_earnings,amount_of_transactions',
            'point' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ], [
            'portfolio_id.unique' => __('Portfolio reward already exists.'),
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        RewardPointEarning::create([
            'portfolio_id' => $request->get('portfolio_id'),
            'amount_of_transactions' => $request->get('amount_of_transactions'),
            'point' => $request->get('point'),
        ]);

        notify()->success(__('Reward added successfully!'), 'Success');

        return redirect()->route('admin.reward.point.earnings.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'portfolio_id' => 'required|unique:reward_point_earnings,portfolio_id,'.$id,
            'amount_of_transactions' => 'required|regex:/^\d+(\.\d{1,2})?$/|unique:reward_point_earnings,amount_of_transactions,'.$id,
            'point' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ], [
            'portfolio_id.unique' => __('Portfolio reward already exists.'),
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        RewardPointEarning::findOrFail($id)->update([
            'portfolio_id' => $request->get('portfolio_id'),
            'amount_of_transactions' => $request->get('amount_of_transactions'),
            'point' => $request->get('point'),
        ]);

        notify()->success(__('Reward updated successfully!'), 'Success');

        return redirect()->route('admin.reward.point.earnings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        RewardPointEarning::destroy($id);

        notify()->success(__('Reward deleted successfully!'), 'Success');

        return redirect()->route('admin.reward.point.earnings.index');
    }
}
