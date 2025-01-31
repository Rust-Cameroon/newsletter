<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OtpVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (setting('otp_verification', 'permission') && $request->user()->phone_verified == 1) {
            return $next($request);
        }

        return redirect()->route('otp.verify')->with('success', __('Otp Send Successfully'));
    }
}
