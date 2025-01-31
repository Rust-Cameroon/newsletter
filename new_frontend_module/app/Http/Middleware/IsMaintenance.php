<?php

namespace App\Http\Middleware;

use Artisan;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Remotelywork\Installer\Repository\App;

class IsMaintenance
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!App::dbConnectionCheck()){
            return $next($request);
        }
        
        if ($this->app->isDownForMaintenance()) {
            if (! setting('maintenance_mode', 'site_maintenance')) {
                Artisan::call('up');
            }
        } else {
            if (setting('maintenance_mode', 'site_maintenance')) {
                $artisan = 'down --render="errors.maintenance" --secret='.'"'.setting('secret_key', 'site_maintenance').'"';
                Artisan::call($artisan);
            }
        }

        return $next($request);
    }
}
