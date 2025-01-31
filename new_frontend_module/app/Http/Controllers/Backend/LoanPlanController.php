<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LoanPlan;
use App\Traits\ImageUpload;
use App\Traits\NotifyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Purifier;

class LoanPlanController extends Controller
{
    use ImageUpload, NotifyTrait;

    public function __construct()
    {
        $this->middleware('permission:loan-plan-list', ['only' => ['index']]);
        $this->middleware('permission:loan-plan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:loan-plan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:loan-plan-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $plans = LoanPlan::latest()->get();

        return view('backend.plan.loan.index', compact('plans'));
    }

    public function create()
    {
        return view('backend.plan.loan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'installment_intervel' => 'required',
            'total_installment' => 'required',
            'per_installment' => 'required',
            'charge' => 'required',
            'delay_days' => 'required',
            'charge_type' => 'required',
            'field_options' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $options = [];

        foreach ($request->field_options ?? [] as $key => $field) {
            $field['values'] = data_get($request->field_options_value, $key);

            $options[] = $field;
        }

        $data = [
            'name' => $request->get('name'),
            'minimum_amount' => $request->float('minimum_amount'),
            'maximum_amount' => $request->float('maximum_amount'),
            'per_installment' => $request->integer('per_installment'),
            'installment_intervel' => $request->integer('installment_intervel'),
            'charge' => $request->integer('charge'),
            'charge_type' => $request->get('charge_type'),
            'total_installment' => $request->integer('total_installment'),
            'loan_fee' => $request->float('loan_fee'),
            'admin_profit' => $request->float('bank_profit'),
            'delay_days' => $request->integer('delay_days'),
            'status' => $request->get('status', 1),
            'featured' => $request->get('featured'),
            'badge' => $request->get('badge'),
            'field_options' => $request->has('field_options') ? json_encode($options) : null,
            'instructions' => $request->get('instructions'),
        ];

        LoanPlan::create($data);

        notify()->success(__('Loan plan created successfully!'));

        return redirect()->route('admin.plan.loan.index');
    }

    public function edit($id)
    {
        $plan = LoanPlan::find($id);

        return view('backend.plan.loan.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'installment_intervel' => 'required',
            'total_installment' => 'required',
            'per_installment' => 'required',
            'charge' => 'required',
            'delay_days' => 'required',
            'charge_type' => 'required',
            'field_options' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $options = [];

        foreach ($request->field_options ?? [] as $key => $field) {
            $field['values'] = data_get($request->field_options_value, $key);

            $options[] = $field;
        }

        $data = [
            'name' => $request->get('name'),
            'minimum_amount' => $request->float('minimum_amount'),
            'maximum_amount' => $request->float('maximum_amount'),
            'per_installment' => $request->integer('per_installment'),
            'installment_intervel' => $request->integer('installment_intervel'),
            'charge' => $request->integer('charge'),
            'charge_type' => $request->get('charge_type'),
            'total_installment' => $request->integer('total_installment'),
            'loan_fee' => $request->float('loan_fee'),
            'admin_profit' => $request->float('bank_profit'),
            'delay_days' => $request->integer('delay_days'),
            'status' => $request->get('status', 1),
            'featured' => $request->get('featured'),
            'badge' => $request->get('badge'),
            'field_options' => $request->has('field_options') ? json_encode($options) : null,
            'instructions' => $request->get('instructions'),
        ];

        $plan = LoanPlan::find($id);

        $plan->update($data);

        notify()->success(__('Loan plan updated successfully!'));

        return redirect()->route('admin.plan.loan.index');
    }

    public function destroy($id)
    {
        $plan = LoanPlan::find($id);

        $plan->delete();

        notify()->success(__('Loan plan deleted successfully!'));

        return redirect()->back();
    }
}
