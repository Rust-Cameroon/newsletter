<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WireTransfar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Purifier;

class WireTransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:wire-transfer', ['only' => ['index', 'post']]);
    }

    public function index()
    {
        $wireTransfer = WireTransfar::first();

        return view('backend.fund-transfer.wire-transfer-settings', compact('wireTransfer'));
    }

    public function post(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'charge' => 'required',
            'charge_type' => 'required',
            'minimum_transfer' => 'required',
            'maximum_transfer' => 'required',
            'daily_limit_maximum_amount' => 'required',
            'daily_limit_maximum_count' => 'required',
            'monthly_limit_maximum_amount' => 'required',
            'monthly_limit_maximum_count' => 'required',
            'field_options' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $data = [
            'charge' => $input['charge'],
            'charge_type' => $input['charge_type'],
            'minimum_transfer' => $input['minimum_transfer'],
            'maximum_transfer' => $input['maximum_transfer'],
            'daily_limit_maximum_amount' => $input['daily_limit_maximum_amount'],
            'daily_limit_maximum_count' => $input['daily_limit_maximum_count'],
            'monthly_limit_maximum_amount' => $input['monthly_limit_maximum_amount'],
            'monthly_limit_maximum_count' => $input['monthly_limit_maximum_count'],
            'field_options' => isset($input['field_options']) ? json_encode($input['field_options']) : null,
            'instructions' => isset($input['instructions']) ? Purifier::clean(htmlspecialchars_decode($input['instructions'])) : null,
        ];
        $wireTransfer = WireTransfar::first();
        if ($wireTransfer) {
            $wireTransfer->update($data);
        } else {
            WireTransfar::create($data);
        }
        notify()->success(__('Wire Transfer Settings Updated successfully!!'));

        return redirect()->back();
    }
}
