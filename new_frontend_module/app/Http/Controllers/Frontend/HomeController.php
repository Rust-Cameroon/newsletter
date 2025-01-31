<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Theme;
use App\Models\LandingPage;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function home()
    {
        
        $customLandingTheme = Theme::where('type', 'landing')->where('status', true)->first();
        if ($customLandingTheme) {
            return view('landing_theme.'.$customLandingTheme->name);
        }

        $redirectPage = setting('home_redirect', 'global');
        if ($redirectPage == '/') {
            $homeContent = LandingPage::where('status', true)->whereNot('code', 'footer')->where('locale', app()->getLocale())->orderBy('short')->get();

            return view('frontend::home.index', compact('homeContent'));
        }

        return redirect($redirectPage);

    }

    public function subscribeNow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:subscriptions'],
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        Subscription::create([
            'email' => $request->email,
        ]);

        notify()->success(__('Subscribed Successfully'));

        return redirect()->back();
    }

    public function themeMode()
    {

        $oldTheme = session()->get('site-color-mode', setting('default_mode'));

        if ($oldTheme == 'dark') {
            session()->put('site-color-mode', 'light');
        } else {
            session()->put('site-color-mode', 'dark');
        }

    }

    public function languageUpdate(Request $request)
    {
        session()->put('locale', $request->name);

        return redirect()->back();
    }

    public function session(Request $request)
    {
        $key = $request->input('key');

        $value = $request->input('value');

        session([$key => $value]);

        return response()->json(['success' => true]);
    }
}
