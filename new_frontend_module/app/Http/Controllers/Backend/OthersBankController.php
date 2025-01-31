<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\OthersBank;
use App\Traits\ImageUpload;
use App\Traits\NotifyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Purifier;

class OthersBankController extends Controller
{
    use ImageUpload, NotifyTrait;

    public function __construct()
    {
        $this->middleware('permission:others-bank-list', ['only' => ['index']]);
        $this->middleware('permission:others-bank-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:others-bank-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:others-bank-delete', ['only' => ['delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $banks = OthersBank::paginate(10);

        return view('backend.fund-transfer.others-bank.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.fund-transfer.others-bank.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'logo' => 'required',
            'name' => 'required',
            'code' => 'required',
            'charge' => 'required',
            'charge_type' => 'required',
            'minimum_transfer' => 'required',
            'maximum_transfer' => 'required',
            'daily_limit_maximum_amount' => 'required',
            'daily_limit_maximum_count' => 'required',
            'monthly_limit_maximum_amount' => 'required',
            'monthly_limit_maximum_count' => 'required',
            'status' => 'required',
            'field_options' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $data = [
            'logo' => isset($input['logo']) ? self::imageUploadTrait($input['logo']) : null,
            'name' => $input['name'],
            'code' => $input['code'],
            'charge' => $input['charge'],
            'processing_time' => $input['processing_time'],
            'processing_type' => $input['processing_type'],
            'charge_type' => $input['charge_type'],
            'minimum_transfer' => $input['minimum_transfer'],
            'maximum_transfer' => $input['maximum_transfer'],
            'daily_limit_maximum_amount' => $input['daily_limit_maximum_amount'],
            'daily_limit_maximum_count' => $input['daily_limit_maximum_count'],
            'monthly_limit_maximum_amount' => $input['monthly_limit_maximum_amount'],
            'monthly_limit_maximum_count' => $input['monthly_limit_maximum_count'],
            'status' => $input['status'],
            'field_options' => isset($input['field_options']) ? json_encode($input['field_options']) : null,
            'details' => isset($input['details']) ? Purifier::clean(htmlspecialchars_decode($input['details'])) : null,
        ];

        $othersBank = OthersBank::create($data);
        notify()->success(__('Others Bank Created successfully!!'));

        return redirect()->route('admin.others-bank.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $bank = OthersBank::find($id);

        return view('backend.fund-transfer.others-bank.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'code' => 'required',
            'charge' => 'required',
            'charge_type' => 'required',
            'minimum_transfer' => 'required',
            'maximum_transfer' => 'required',
            'daily_limit_maximum_amount' => 'required',
            'daily_limit_maximum_count' => 'required',
            'monthly_limit_maximum_amount' => 'required',
            'monthly_limit_maximum_count' => 'required',
            'status' => 'required',
            'field_options' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $bank = OthersBank::find($id);

        $data = [
            'name' => $input['name'],
            'code' => $input['code'],
            'charge' => $input['charge'],
            'processing_time' => $input['processing_time'],
            'processing_type' => $input['processing_type'],
            'charge_type' => $input['charge_type'],
            'minimum_transfer' => $input['minimum_transfer'],
            'maximum_transfer' => $input['maximum_transfer'],
            'daily_limit_maximum_amount' => $input['daily_limit_maximum_amount'],
            'daily_limit_maximum_count' => $input['daily_limit_maximum_count'],
            'monthly_limit_maximum_amount' => $input['monthly_limit_maximum_amount'],
            'monthly_limit_maximum_count' => $input['monthly_limit_maximum_count'],
            'status' => $input['status'],
            'field_options' => isset($input['field_options']) ? json_encode($input['field_options']) : null,
            'details' => isset($input['details']) ? Purifier::clean(htmlspecialchars_decode($input['details'])) : null,
        ];

        if ($request->hasFile('logo')) {
            $logo = self::imageUploadTrait($input['logo'], $bank->logo);
            $data = array_merge($data, ['logo' => $logo]);
        }
        $bank->update($data);
        notify()->success(__('Others Bank Updated successfully!!'));

        return redirect()->route('admin.others-bank.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $bank = OthersBank::find($id);
        if (file_exists('assets/'.$bank->logo)) {
            @unlink('assets/'.$bank->logo);
        }
        $bank->delete();
        notify()->success(__('Others Bank Deleted successfully!!'));

        return redirect()->back();
    }
}
