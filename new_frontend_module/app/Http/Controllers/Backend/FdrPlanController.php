<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FdrPlan;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FdrPlanController extends Controller
{
    use ImageUpload;

    public function __construct()
    {
        $this->middleware('permission:fdr-plan-list', ['only' => ['index']]);
        $this->middleware('permission:fdr-plan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:fdr-plan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:fdr-plan-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $plans = FdrPlan::latest()->get();

        return view('backend.plan.index', compact('plans'));
    }

    public function create()
    {
        return view('backend.plan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'minimum_amount' => 'required',
            'maximum_amount' => 'required',
            'interest_rate' => 'required',
            'intervel' => 'required',
            'period' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $input = $request->all();

        $finalData = [
            'name' => $input['name'],
            'badge' => $input['badge'],
            'featured' => $input['featured'],
            'minimum_amount' => $request->float('minimum_amount'),
            'maximum_amount' => $request->float('maximum_amount'),
            'is_compounding' => $input['is_compounding'],
            'interest_rate' => $request->float('interest_rate'),
            'intervel' => $input['intervel'],
            'locked' => $input['period'],
            'can_cancel' => $input['can_cancel'],
            'cancel_type' => $input['cancel_type'],
            'cancel_days' => $input['cancel_days'],
            'cancel_fee' => $request->float('cancel_fee'),
            'cancel_fee_type' => $input['cancel_fee_type'],
            'is_add_fund_fdr' => $input['is_add_fund_fdr'],
            'increment_fee' => $request->float('increment_fee'),
            'increment_type' => $input['increment_type'],
            'increment_times' => $request->integer('increment_times'),
            'min_increment_amount' => $request->float('min_increment'),
            'max_increment_amount' => $request->float('max_increment'),
            'is_deduct_fund_fdr' => $input['is_deduct_fund_fdr'],
            'decrement_fee' => $request->float('decrement_fee'),
            'decrement_type' => $input['decrement_type'],
            'decrement_times' => $request->float('decrement_times'),
            'min_decrement_amount' => $request->float('min_decrement'),
            'max_decrement_amount' => $request->float('max_decrement'),
            'increment_charge_type' => $input['increment_charge_type'],
            'decrement_charge_type' => $input['decrement_charge_type'],
            'add_maturity_platform_fee' => $input['add_maturity_platform_fee'],
            'maturity_platform_fee' => $request->float('maturity_platform_fee'),
            'status' => $input['status'],
        ];

        FdrPlan::create($finalData);

        notify()->success('FDR Plan created successfully');

        return redirect()->route('admin.plan.fdr.index');
    }

    public function edit($id)
    {
        $plan = FdrPlan::find($id);

        return view('backend.plan.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'minimum_amount' => 'required',
            'maximum_amount' => 'required',
            'interest_rate' => 'required',
            'intervel' => 'required',
            'period' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $plan = FdrPlan::findOrFail($id);
        $input = $request->all();

        $finalData = [
            'name' => $input['name'],
            'badge' => $input['badge'],
            'featured' => $input['featured'],
            'minimum_amount' => $request->float('minimum_amount'),
            'maximum_amount' => $request->float('maximum_amount'),
            'is_compounding' => $input['is_compounding'],
            'interest_rate' => $request->float('interest_rate'),
            'intervel' => $request->integer('intervel'),
            'locked' => $request->integer('period'),
            'can_cancel' => $input['can_cancel'],
            'cancel_type' => $input['cancel_type'],
            'cancel_days' => $input['cancel_days'],
            'cancel_fee' => $request->float('cancel_fee'),
            'cancel_fee_type' => $input['cancel_fee_type'],
            'is_add_fund_fdr' => $input['is_add_fund_fdr'],
            'increment_fee' => $request->float('increment_fee'),
            'increment_type' => $input['increment_type'],
            'increment_times' => $request->integer('increment_times'),
            'min_increment_amount' => $request->float('min_increment'),
            'max_increment_amount' => $request->float('max_increment'),
            'is_deduct_fund_fdr' => $input['is_deduct_fund_fdr'],
            'decrement_fee' => $request->float('decrement_fee'),
            'decrement_type' => $input['decrement_type'],
            'decrement_times' => $request->float('decrement_times'),
            'min_decrement_amount' => $request->float('min_decrement'),
            'max_decrement_amount' => $request->float('max_decrement'),
            'increment_charge_type' => $input['increment_charge_type'],
            'decrement_charge_type' => $input['decrement_charge_type'],
            'add_maturity_platform_fee' => $input['add_maturity_platform_fee'],
            'maturity_platform_fee' => $request->float('maturity_platform_fee'),
            'status' => $input['status'],
        ];

        $plan->update($finalData);

        notify()->success('FDR plan updated successfully');

        return redirect()->route('admin.plan.fdr.index');
    }

    public function destroy($id)
    {
        $plan = FdrPlan::find($id);
        $plan->delete();

        notify()->success('FDR plan deleted successfully');

        return redirect()->back();
    }
}
