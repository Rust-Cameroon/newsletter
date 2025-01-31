<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\OthersBank;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class BeneficiaryController extends Controller
{
    public function index()
    {
        $beneficiary = Beneficiary::latest()->get();
        $banks = OthersBank::active()->get();

        return view('frontend::fund_transfer.beneficiary', compact('beneficiary', 'banks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank_id' => 'required_if:bank_id,null',
            'account_name' => 'required',
            'account_number' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        if (! $request->has('bank_id') && ! User::where('account_number', sanitizeAccountNumber($request->account_number))->first()) {
            notify()->error(__('Receiver account not found!'), 'Error');

            return redirect()->back();
        }

        $input = $request->all();
        Beneficiary::create($input);
        notify()->success(__('Beneficiary added successfully!!'));

        return redirect()->route('user.fund_transfer.beneficiary.index');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank_id' => 'required_if:bank_id,null',
            'account_name' => 'required',
            'account_number' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        if (! $request->has('bank_id') && ! User::where('account_number', $request->account_number)->first()) {
            notify()->error(__('Receiver account not found!'), 'Error');

            return redirect()->back();
        }

        $input = $request->all();
        $beneficiary = Beneficiary::find($input['id']);
        $beneficiary->update($input);
        notify()->success(__('Beneficiary Updated Successfully!!'));

        return redirect()->route('user.fund_transfer.beneficiary.index');
    }

    public function delete(Request $request)
    {
        $beneficiary = Beneficiary::find($request->id);
        $beneficiary->delete();

        notify()->success(__('Beneficiary Deleted Successfully!!'));

        return redirect()->back();
    }

    public function show($id)
    {
        $beneficiary = Beneficiary::with('bank')->where('id', $id)->first();

        if($beneficiary){
            return response()->json($beneficiary);
        }
    }
}
