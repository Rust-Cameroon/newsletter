<?php

namespace App\Providers;

use URL;
use Schema;
use App\Models\Theme;
use App\Models\Language;
use App\Facades\Notification\Notify;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Remotelywork\Installer\Repository\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application modules.
     *
     * @return void
     */
    public function register()
    {
        Paginator::defaultView('frontend::include.__pagination');
    }

    /**
     * Bootstrap any application modules.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function boot()
    {

        URL::forceScheme('https');

        $this->app->bind('notify', function () {
            return new Notify();
        });

        if(App::dbConnectionCheck()){
            $timezone = setting('site_timezone', 'global');

            config()->set([
                'app.timezone' => $timezone,
                'app.debug' => setting('debug_mode', 'permission'),
                'debugbar.enabled' => setting('debug_mode', 'permission'),
                'session.lifetime' => setting('session_lifetime', 'system'),
            ]);

            date_default_timezone_set($timezone);
        }

        Blade::directive('lasset', function ($expression) {
            $customLandingTheme = Theme::where('type', 'landing')->where('status', true)->first();
            if ($customLandingTheme) {
                return asset("landing_theme/$customLandingTheme->name/$expression");
            }

            return false;
        });

        Blade::directive('removeimg', function ($expression) {
            [$isHidden, $img_field] = explode(',', $expression);
            $isHidden = trim($isHidden);
            $img_field = trim($img_field);

            return "<?php \$isHidden = $isHidden; \$img_field = '$img_field'; ?>
            <div data-des=\"<?php echo \$img_field; ?>\" <?php if(!\$isHidden) echo 'hidden'; ?> class=\"close remove-img <?php echo \$img_field; ?>\"><i data-lucide=\"x\"></i></div>";
        });

        // Set string length to 255
        Schema::defaultStringLength(255);

    }
}
