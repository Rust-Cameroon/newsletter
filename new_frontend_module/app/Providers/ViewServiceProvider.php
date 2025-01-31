<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Navigation;
use App\Models\LandingPage;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Remotelywork\Installer\Repository\App;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register modules.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap modules.
     *
     * @return void
     */
    public function boot()
    {

        if(App::dbConnectionCheck()){
            View::composer(['backend.include.__side_nav', 'backend.setting.site_setting.include.__global'], function ($view) {
                $view->with([
                    'landingSections' => cache()->remember('landingSections', 60 * 60 * 24, function () {
                        return LandingPage::where('locale', 'en')->whereNot('code', 'footer')->orderBy('short')->get();
                    }),
                    'pages' => cache()->remember('pages', 60 * 60 * 24, function () {
                        return Page::where('locale', 'en')->get();
                    }),
                ]);
            });

            View::composer(['frontend::include.__header'], function ($view) {
                $view->with([
                    'navigations' => Navigation::where('status', 1)->where(function ($query) {
                        $query->where('type', 'header')
                            ->orWhere('type', 'both');

                    })->orderBy('header_position')->get(),
                ]);
            });

            View::composer(['frontend::include.__footer'], function ($view) {
                $view->with([
                    'navigations' => Navigation::where('status', 1)->where(function ($query) {
                        $query->where('type', 'footer')
                            ->orWhere('type', 'both');

                    })->orderBy('footer_position')->get()->chunk(5),
                ]);
            });

            View::composer(['frontend::include.__footer', 'frontend::include.__header', 'frontend::home.include.__hero'], function ($view) {
                $view->with([
                    'socials' => \App\Models\Social::all(),
                ]);
            });

            View::composer(['*'], function ($view) {
                $view->with([
                    'currencySymbol' => setting('currency_symbol', 'global'),
                    'currency' => setting('site_currency', 'global'),
                ]);
            });
            if (auth('web')) {
                $agent = new Agent();
                View::composer(['frontend*'], function ($view) use ($agent) {
                    $view->with([
                        'user' => auth()->user(),
                        'isMobile' => $agent->isMobile(),
                    ]);
                });
            }
        }
    }
}
