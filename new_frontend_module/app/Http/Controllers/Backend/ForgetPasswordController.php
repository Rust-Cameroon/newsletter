<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\NotifyTrait;
use Carbon\Carbon;
use DB;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Str;

class ForgetPasswordController extends Controller
{
    use NotifyTrait;

    public function showForgetPasswordForm()
    {
        return view('backend.auth.forget_password');
    }

    public function submitForgetPasswordForm(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:admins',
        ]);

        try {
            $token = Str::random(64);

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);

            $shortcodes = [
                '[[token]]' => route('admin.reset.password.now', ['token' => $token]),
                '[[site_title]]' => setting('site_title', 'global'),
                '[[site_url]]' => route('home'),
            ];

            $this->mailNotify($request->email, 'admin_forget_password', $shortcodes);

            notify()->success('We have e-mailed your password reset link!');

            return back();

        } catch (Exception $e) {
            notify()->error('Sorry, Something went wrong.', 'Error');

            return redirect()->back();
        }

    }

    public function showResetPasswordForm()
    {

        return view('backend.auth.reset_password');
    }

    public function submitResetPasswordForm(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:admins',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        try {

            $updatePassword = DB::table('password_resets')
                ->where([
                    'email' => $request->email,
                    'token' => $request->token,
                ])
                ->first();

            if (! $updatePassword) {
                return back()->withInput()->with('error', 'Invalid token!');
            }

            Admin::where('email', $request->email)
                ->update(['password' => Hash::make($request->password)]);

            DB::table('password_resets')->where(['email' => $request->email])->delete();
            notify()->success('Your password has been changed!');

            return redirect('admin/login');

        } catch (Exception $e) {
            notify()->error('Sorry, Something went wrong.', 'Error');

            return redirect()->back();
        }

    }
}
