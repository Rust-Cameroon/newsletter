<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SmsTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SmsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:sms-template');
    }

    public function template(Request $request)
    {
        $perPage = $request->perPage ?? 15;
        $order = $request->order ?? 'asc';
        $search = $request->search ?? null;
        $status = $request->status ?? 'all';
        $sms = SmsTemplate::order($order)
            ->search($search)
            ->status($status)
            ->paginate($perPage);

        return view('backend.sms.template', compact('sms'));
    }

    public function edit_template($id)
    {
        $template = SmsTemplate::find($id);

        return view('backend.sms.edit', compact('template'));
    }

    public function update_template(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'message_body' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $input = $request->all();
        $data = [
            'message_body' => nl2br($input['message_body']),
            'status' => $input['status'],
        ];

        $template = SmsTemplate::find($input['id']);

        $template->update($data);

        notify()->success(__('SMS Template Updated Successfully'));

        return redirect()->back();
    }
}
