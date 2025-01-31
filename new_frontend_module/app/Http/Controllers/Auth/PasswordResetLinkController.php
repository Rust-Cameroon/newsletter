<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Traits\NotifyTrait;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;

class PasswordResetLinkController extends Controller
{
    use NotifyTrait;

    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $page = Page::where('code', 'forgetpassword')->first();
        $data = json_decode($page->data, true);

        return view('frontend::auth.forgot-password', compact('data'));
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back()->with('error', __('Email or Username not found!'));
        }

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        $token = route('password.reset', ['token' => $token, 'email' => $request->email]);

        $shortcodes = [
            '[[token]]' => $token,
            '[[site_title]]' => setting('site_title', 'global'),
            '[[site_url]]' => route('home'),
        ];

        $this->mailNotify($request->email, 'user_password_change', $shortcodes);

        return redirect()->back()->with('status', __('We have emailed your password reset link!'));

    }
}
