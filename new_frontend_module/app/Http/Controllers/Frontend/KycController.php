<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\KYCStatus;
use App\Http\Controllers\Controller;
use App\Models\Kyc;
use App\Models\UserKyc;
use App\Traits\ImageUpload;
use App\Traits\NotifyTrait;
use Illuminate\Http\Request;
use Validator;

class KycController extends Controller
{
    use ImageUpload, NotifyTrait;

    public function kyc()
    {
        $user = auth()->user();

        $user_kycs = UserKyc::with('kyc')->where('user_id',$user->id)->latest()->get();

        $userKycIds = UserKyc::whereIn('status',['pending','approved'])->where('user_id',$user->id)->where('is_valid',true)->pluck('kyc_id');

        $kycs = Kyc::where('status', true)->whereNotIn('id',$userKycIds)->get();

        return view('frontend::user.kyc.index', compact('kycs','user_kycs'));
    }

    public function kycDetails(Request $request)
    {
        $kyc = UserKyc::find($request->id);

        return response()->json([
            'html' => view('frontend::user.kyc.details',compact('kyc'))->render()
        ]);
    }

    public function kycSubmission($id)
    {
        $kyc = Kyc::findOrFail(decrypt($id));

        return view('frontend::user.kyc.submission',compact('kyc'));
    }

    public function kycData($id)
    {
        $fields = Kyc::find($id)->fields;

        return view('frontend::user.kyc.data', compact('fields'))->render();
    }

    public function submit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'kyc_id' => 'required',
            'kyc_credential' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $kyc = Kyc::find(decrypt($request->kyc_id));

        $user = auth()->user();

        $newKycs = $request->kyc_credential;

        foreach ($newKycs as $key => $value) {

            if (is_file($value)) {
                $newKycs[$key] = self::imageUploadTrait($value);
            }
        }

        UserKyc::create([
            'user_id' => $user->id,
            'kyc_id' => $kyc->id,
            'type' => $kyc->name,
            'data' => $newKycs,
            'is_valid' => true,
            'status' => 'pending'
        ]);

        $pendingCount = UserKyc::where('user_id',$user->id)->whereIn('status',['pending','approved'])->where('is_valid',true)->count();
        $isPending = Kyc::where('status',true)->count() == $pendingCount ? true : false;

        $user->update([
            'kyc_credential' => null,
            'kyc' => $isPending ?  KYCStatus::Pending : KYCStatus::NOT_SUBMITTED,
        ]);

        if($isPending){
            $shortcodes = [
                '[[full_name]]' => $user->full_name,
                '[[email]]' => $user->email,
                '[[site_title]]' => setting('site_title', 'global'),
                '[[site_url]]' => route('home'),
                '[[kyc_type]]' => $user->kyc_type,
                '[[status]]' => 'Pending',
            ];

            $this->mailNotify(setting('site_email', 'global'), 'kyc_request', $shortcodes);
            $this->pushNotify('kyc_request', $shortcodes, route('admin.kyc.pending'), $user->id, 'Admin');
        }

        notify()->success(__('Kyc has been submitted.'));

        return redirect()->route('user.kyc');
    }
}
