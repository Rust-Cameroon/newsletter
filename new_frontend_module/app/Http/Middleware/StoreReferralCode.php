<?php

namespace App\Http\Middleware;

use App\Models\ReferralLink;
use Closure;
use Illuminate\Http\Request;

class StoreReferralCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if ($request->cookie('invite') == null && $request->has('invite')) {
            $referral = ReferralLink::whereCode($request->get('invite'))->first();

            if (! $referral) {
                return $response;
            }
            $response->withCookie(cookie('invite', $referral->id, $referral->lifetime_minutes));

            return $response;
        }

        return $response;

    }
}
