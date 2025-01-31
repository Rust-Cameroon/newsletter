<?php

namespace App\Providers;

use App\Http\Controllers\Frontend\PageController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/user/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware(['web', 'XSS', 'translate','trans','isDemo','install_check'])
                ->group(base_path('routes/web.php'));

            Route::middleware(['web', 'XSS', 'translate','trans','install_check'])
                ->group(base_path('routes/auth.php'));

            Route::middleware(['web', 'auth:admin', 'XSS', 'isDemo', 'translate','trans','install_check'])
                ->prefix(setting('site_admin_prefix', 'global'))
                ->name('admin.')
                ->group(base_path('routes/admin.php'));

            // Dyanmic Page
            Route::middleware('web','translate','trans','install_check')
                ->get('/{page}', PageController::class)
                ->name('page');
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
