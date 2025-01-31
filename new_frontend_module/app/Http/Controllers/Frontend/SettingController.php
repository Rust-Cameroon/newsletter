<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\ImageUpload;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class SettingController extends Controller
{
    use ImageUpload;

    public function settings()
    {
        return view('frontend::user.setting.index');
    }

    public function securitySettings()
    {
        return view('frontend::user.setting.security');
    }

    public function profileUpdate(Request $request)
    {
        $input = $request->all();

        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username,'.$user->id,
            'gender' => 'required',
            'date_of_birth' => 'date',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $data = [
            'avatar' => $request->hasFile('avatar') ? self::imageUploadTrait($input['avatar'], $user->avatar) : $user->avatar,
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'username' => $input['username'],
            'gender' => $input['gender'],
            'date_of_birth' => $input['date_of_birth'] == '' ? null : $input['date_of_birth'],
            'phone' => $input['phone'],
            'city' => $input['city'],
            'zip_code' => $input['zip_code'],
            'address' => $input['address'],
        ];

        $user->update($data);

        notify()->success(__('Profile updated successfully'), 'Success');

        return redirect()->route('user.setting.show');

    }

    public function twoFa()
    {
        $user = auth()->user();

        $google2fa = app('pragmarx.google2fa');
        $secret = $google2fa->generateSecretKey();

        $user->update([
            'google2fa_secret' => $secret,
        ]);

        notify()->success(__('QR Code and Secret Key generate successfully'), 'Success');

        return redirect()->back();
    }

    public function actionTwoFa(Request $request)
    {
        $user = auth()->user();

        if ($request->status == 'disable') {

            if (Hash::check(request('one_time_password'), $user->password)) {
                $user->update([
                    'two_fa' => 0,
                ]);

                notify()->success(__('2FA disabled successfully'), 'Success');

                return redirect()->back();
            }

            notify()->warning(__('Your password is wrong!'), 'Error');

            return redirect()->back();

        } elseif ($request->status == 'enable') {
            session([
                config('google2fa.session_var') => [
                    'auth_passed' => false,
                ],
            ]);

            $authenticator = app(Authenticator::class)->boot($request);
            if ($authenticator->isAuthenticated()) {

                $user->update([
                    'two_fa' => 1,
                ]);

                notify()->success(__('2FA enabled successfully'), 'Success');

                return redirect()->back();

            }

            notify()->warning(__('One time key is wrong!'), 'Error');

            return redirect()->back();
        }
    }

    public function passcode(Request $request)
    {
        if ($request->status == 'disable_passcode') {

            if (! Hash::check($request->confirm_password, auth()->user()->password)) {
                notify()->error(__('Password is wrong!'), 'Error');

                return back();
            }

            auth()->user()->update([
                'passcode' => null,
            ]);

            notify()->success(__('Passcode disabled successfully!'), 'Success');

            return back();
        }

        $validator = Validator::make($request->all(), [
            'passcode' => 'required|integer|confirmed|min:4',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return back();
        }

        auth()->user()->update([
            'passcode' => bcrypt($request->passcode),
        ]);

        notify()->success(__('Passcode added successfully!'), 'Success');

        return back();

    }

    public function changePasscode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_passcode' => 'required|integer',
            'passcode' => 'required|integer|confirmed|min:4',
            'passcode_confirmation' => 'required|integer|min:4',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return back();
        }

        if(!Hash::check($request->old_passcode, auth()->user()->passcode)){
            notify()->error(__('Old Passcode is wrong!'));

            return back();
        }

        auth()->user()->update([
            'passcode' => bcrypt($request->passcode),
        ]);

        notify()->success(__('Passcode changed successfully!'), 'Success');

        return back();
    }

    public function action()
    {
        return view('frontend::user.setting.action');
    }

    public function newsletterAction(Request $request)
    {

        $permissions = $request->get('notification_permissions');

        $notifications = [
            'all_push_notifications' => data_get($permissions, 'all_push_notifications', 0),
            '2fa_notifications' => data_get($permissions, '2fa_notifications', 0),
            'deposit_email_notificaitons' => data_get($permissions, 'deposit_email_notificaitons', 0),
            'fund_transfer_email_notificaitons' => data_get($permissions, 'fund_transfer_email_notificaitons', 0),
            'dps_email_notificaitons' => data_get($permissions, 'dps_email_notificaitons', 0),
            'fdr_email_notificaitons' => data_get($permissions, 'fdr_email_notificaitons', 0),
            'loan_email_notificaitons' => data_get($permissions, 'loan_email_notificaitons', 0),
            'pay_bill_email_notificaitons' => data_get($permissions, 'pay_bill_email_notificaitons', 0),
            'withdraw_payment_email_notificaitons' => data_get($permissions, 'withdraw_payment_email_notificaitons', 0),
            'referral_email_notificaitons' => data_get($permissions, 'referral_email_notificaitons', 0),
            'portfolio_email_notificaitons' => data_get($permissions, 'all_push_notifications', 0),
            'rewards_redeem_email_notificaitons' => data_get($permissions, 'rewards_redeem_email_notificaitons', 0),
            'support_email_notificaitons' => data_get($permissions, 'support_email_notificaitons', 0),
        ];

        auth()->user()->update([
            'notifications_permission' => $notifications,
        ]);

        notify()->success(__('Newsletter updated successfully!'), 'Success');

        return back();
    }

    public function closeAccount(Request $request)
    {
        auth()->user()->update([
            'status' => 2,
            'close_reason' => $request->get('reason'),
        ]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->withErrors(['msg' => 'Your Account is Closed.']);
    }
}
