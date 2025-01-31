<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DpsPlan;
use Illuminate\Http\Request;
use Validator;

class DpsPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:dps-plan-list', ['only' => ['index']]);
        $this->middleware('permission:dps-plan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:dps-plan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:dps-plan-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $plans = DpsPlan::latest()->get();

        return view('backend.plan.dps.index', compact('plans'));
    }

    public function create()
    {
        return view('backend.plan.dps.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'interval' => 'required',
            'total_installment' => 'required',
            'per_installment' => 'required',
            'interest_rate' => 'required',
            'charge' => 'required',
            'delay_days' => 'required',
            'charge_type' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $dps = new DpsPlan();
        $dps->name = $request->get('name');
        $dps->interval = $request->integer('interval');
        $dps->per_installment = $request->integer('per_installment');
        $dps->total_installment = $request->integer('total_installment');
        $dps->interest_rate = $request->integer('interest_rate');
        $dps->total_deposit = $request->get('total_deposit');
        $dps->user_profit = $request->get('user_profit');
        $dps->total_mature_amount = $request->get('total_mature_amount');
        $dps->charge = $request->float('charge');
        $dps->delay_days = $request->get('delay_days');
        $dps->charge_type = $request->get('charge_type');
        $dps->add_maturity_platform_fee = $request->get('add_maturity_platform_fee');
        $dps->maturity_platform_fee = $request->float('maturity_platform_fee');
        $dps->can_cancel = $request->get('can_cancel');
        $dps->cancel_type = $request->get('cancel_type');
        $dps->cancel_days = $request->get('cancel_days');
        $dps->cancel_fee = $request->float('cancel_fee');
        $dps->cancel_fee_type = $request->get('cancel_fee_type');
        $dps->is_upgrade = $request->get('is_upgrade');
        $dps->increment_type = $request->get('increment_type');
        $dps->increment_times = $request->integer('increment_times');
        $dps->min_increment_amount = $request->float('min_increment');
        $dps->max_increment_amount = $request->float('max_increment');
        $dps->increment_charge_type = $request->get('increment_charge_type');
        $dps->increment_fee = $request->float('increment_fee');
        $dps->is_downgrade = $request->get('is_downgrade');
        $dps->decrement_type = $request->get('decrement_type');
        $dps->decrement_times = $request->integer('decrement_times');
        $dps->min_decrement_amount = $request->float('min_decrement');
        $dps->max_decrement_amount = $request->float('max_decrement');
        $dps->decrement_charge_type = $request->get('decrement_charge_type');
        $dps->decrement_fee = $request->float('decrement_fee');
        $dps->featured = $request->get('featured');
        $dps->badge = $request->get('badge');
        $dps->status = $request->get('status');
        $dps->save();

        notify()->success(__('Dps plan created successfully!'));

        return redirect()->route('admin.plan.dps.index');
    }

    public function edit($id)
    {
        $plan = DpsPlan::find($id);

        return view('backend.plan.dps.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'interval' => 'required',
            'total_installment' => 'required',
            'per_installment' => 'required',
            'interest_rate' => 'required',
            'charge' => 'required',
            'delay_days' => 'required',
            'charge_type' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $dps = DpsPlan::findOrFail($id);

        $dps->name = $request->get('name');
        $dps->interval = $request->integer('interval');
        $dps->per_installment = $request->float('per_installment');
        $dps->total_installment = $request->integer('total_installment');
        $dps->interest_rate = $request->integer('interest_rate');
        $dps->total_deposit = $request->get('total_deposit');
        $dps->user_profit = $request->get('user_profit');
        $dps->total_mature_amount = $request->float('total_mature_amount');
        $dps->charge = $request->float('charge');
        $dps->delay_days = $request->integer('delay_days');
        $dps->charge_type = $request->get('charge_type');
        $dps->add_maturity_platform_fee = $request->get('add_maturity_platform_fee');
        $dps->maturity_platform_fee = $request->float('maturity_platform_fee');
        $dps->can_cancel = $request->get('can_cancel');
        $dps->cancel_type = $request->get('cancel_type');
        $dps->cancel_fee = $request->float('cancel_fee');
        $dps->cancel_days = $request->integer('cancel_days');
        $dps->cancel_fee_type = $request->get('cancel_fee_type');
        $dps->is_upgrade = $request->get('is_upgrade');
        $dps->increment_type = $request->get('increment_type');
        $dps->increment_times = $request->integer('increment_times');
        $dps->min_increment_amount = $request->integer('min_increment');
        $dps->max_increment_amount = $request->integer('max_increment');
        $dps->increment_charge_type = $request->get('increment_charge_type');
        $dps->increment_fee = $request->integer('increment_fee');
        $dps->is_downgrade = $request->get('is_downgrade');
        $dps->decrement_type = $request->get('decrement_type');
        $dps->decrement_times = $request->integer('decrement_times');
        $dps->min_decrement_amount = $request->integer('min_decrement');
        $dps->max_decrement_amount = $request->integer('max_decrement');
        $dps->decrement_charge_type = $request->get('decrement_charge_type');
        $dps->decrement_fee = $request->integer('decrement_fee');
        $dps->featured = $request->get('featured');
        $dps->badge = $request->get('badge');
        $dps->status = $request->get('status');
        $dps->save();

        notify()->success(__('Dps plan updated successfully!'));

        return redirect()->route('admin.plan.dps.index');
    }

    public function destroy($id)
    {
        $plan = DpsPlan::find($id);
        $plan->delete();
        notify()->success(__('Dps plan deleted successfully!'));

        return redirect()->back();
    }
}
