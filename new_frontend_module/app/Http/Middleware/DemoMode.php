<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DemoMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (! env('APP_DEMO', false)) {

            return $next($request);

        } elseif ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('DELETE') || $request->route()->getName() == 'admin.user.login' || $request->route()->getName() == 'admin.theme.status-update') {

            notify()->warning('You cannot change anything in this demo version', 'warning');

            return redirect()->back();
        }

        return $next($request);
    }
}
