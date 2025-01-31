<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Rules\MatchOldPassword;
use App\Traits\ImageUpload;
use App\Traits\NotifyTrait;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AppController extends Controller
{
    use ImageUpload, NotifyTrait;

    public function __construct()
    {
        $this->middleware('permission:subscriber-list|subscriber-mail-send', ['only' => ['subscribers']]);
        $this->middleware('permission:subscriber-mail-send', ['only' => ['mailSendSubscriber', 'mailSendSubscriberNow']]);
    }

    public function subscribers(Request $request)
    {
        $perPage = $request->perPage ?? 15;
        $order = $request->order ?? 'asc';
        $search = $request->search ?? null;
        $subscribes = Subscription::order($order)->search($search)->paginate($perPage);

        return view('backend.subscriber.index', compact('subscribes'));
    }

    public function mailSendSubscriber()
    {
        return view('backend.subscriber.mail_send');
    }

    public function mailSendSubscriberNow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        try {
            $input = [
                'subject' => $request->subject,
                'message' => $request->message,
            ];

            $shortcodes = [
                '[[subject]]' => $input['subject'],
                '[[message]]' => $input['message'],
                '[[site_title]]' => setting('site_title', 'global'),
                '[[site_url]]' => route('home'),
            ];

            $subscribers = Subscription::all();
            foreach ($subscribers as $subscriber) {
                $this->mailNotify($subscriber->email, 'subscriber_mail', $shortcodes);
            }
            $status = 'success';
            $message = __('Mail Send Successfully');
        } catch (Exception $e) {
            $status = 'warning';
            $message = __('something is wrong');
        }

        notify()->$status($message, $status);

        return redirect()->back();
    }

    public function profile()
    {
        return view('backend.profile.profile');
    }

    public function profileUpdate(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'.$user->id,
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }
        auth()->user()->update([
            'avatar' => $request->hasFile('avatar') ? self::imageUploadTrait($request->avatar, $user->avatar) : $user->avatar,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        notify()->success('Profile Update Successfully');

        return redirect()->back();
    }

    public function passwordChange()
    {
        return view('backend.profile.password_change');
    }

    public function passwordUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        auth()->user()->update(['password' => Hash::make($request->new_password)]);
        notify()->success('Password Changed Successfully');

        return redirect()->back();
    }

    public function applicationInfo()
    {

        $mySqlVersion =  mySqlVersion();
        $required_extensions = ['bcmath', 'ctype', 'json', 'mbstring', 'zip', 'zlib', 'openssl','pcre','filter','hash','session', 'tokenizer', 'xml', 'dom',  'curl', 'fileinfo', 'gd', 'pdo_mysql'];

        $success = '<i data-lucide="check-circle" class="text-success"></i>';
        $error = '<i data-lucide="circle-x" class="text-danger"></i>';

        return view('backend.system.index', compact('success','required_extensions','error','mySqlVersion'));
    }

    public function clearCache()
    {
        Artisan::call('optimize:clear');

        notify()->success(__('Cache cleared successfully!'), 'Success');

        return redirect()->back();
    }
}
