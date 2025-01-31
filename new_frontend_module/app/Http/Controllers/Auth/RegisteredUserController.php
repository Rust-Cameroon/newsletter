<?php

namespace App\Http\Controllers\Auth;

use Txn;
use Session;
use App\Models\Page;
use App\Models\User;
use App\Enums\TxnType;
use App\Models\Branch;
use App\Enums\TxnStatus;
use App\Rules\Recaptcha;
use Illuminate\View\View;
use App\Traits\NotifyTrait;
use App\Events\UserReferred;
use App\Models\ReferralLink;
use Illuminate\Http\Request;
use App\Models\LoginActivities;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    use NotifyTrait;

    public function step1()
    {
        if (! setting('account_creation', 'permission')) {
            abort('403', 'User registration is closed now');
        }
        $page = Page::where('code', 'registration')->where('locale', app()->getLocale())->first();

        if(!$page){
            $page = Page::where('code', 'registration')->where('locale', defaultLocale())->first();
        }
        $data = json_decode($page?->data, true);

        $location = getLocation();
        $referralCode = ReferralLink::find(request()->cookie('invite'))?->code;

        return view('frontend::auth.register', compact('location', 'referralCode','data'));
    }

    public function step1Store(Request $request)
    {
        $isCountry = (bool) getPageSetting('country_validation');
        $isPhone = (bool) getPageSetting('phone_validation');
        $isReferralCode = (bool) getPageSetting('referral_code_validation');

        $request->validate([
            'country' => [Rule::requiredIf($isCountry), 'string', 'max:255'],
            'phone' => [Rule::requiredIf($isPhone), 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'invite' => [Rule::requiredIf($isReferralCode), 'exists:referral_links,code']
        ], [
            'invite.required' => __('Referral code field is required.'),
            'invite.exists' => __('Referral code is invalid'),
        ]);

        $input = $request->all();

        session(['step1' => $input]);

        return redirect()->route('register.step2');
    }

    /**
     * Handle an incoming registration request.
     *
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function store(Request $request)
    {

        $isUsername = (bool) getPageSetting('username_validation');
        $isCountry = (bool) getPageSetting('country_validation');
        $isPhone = (bool) getPageSetting('phone_validation');
        $isBranch = getPageSetting('branch_validation') && branch_enabled() && getPageSetting('branch_show');

        $isGender = (bool) getPageSetting('gender_validation');

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'g-recaptcha-response' => Rule::requiredIf(plugin_active('Google reCaptcha')), new Recaptcha(),
            'gender' => [Rule::requiredIf($isGender), 'in:Male,Female,Others'],
            'username' => [Rule::requiredIf($isUsername), 'string', 'max:255', 'unique:users'],
            'branch_id' => [Rule::requiredIf($isBranch), 'exists:branches,id'],
            'i_agree' => ['required'],
        ]);

        $input = $request->all();

        $formData = array_merge(session('step1'), $input);
        $location = getLocation();
        $phone = $isPhone ? ($isCountry ? explode(':', $formData['country'])[1] : $location->dial_code).' '.$formData['phone'] : $location->dial_code.' ';
        $country = $isCountry ? explode(':', $formData['country'])[0] : $location->name;

        $user = User::create([
            'portfolio_id' => null,
            'portfolios' => json_encode([]),
            'first_name' => $formData['first_name'],
            'last_name' => $formData['last_name'],
            'branch_id' => $request->get('branch_id'),
            'gender' => $formData['gender'],
            'username' => $isUsername ? $formData['username'] : $formData['first_name'].$formData['last_name'].rand(1000, 9999),
            'country' => $country,
            'phone' => $phone,
            'email' => $formData['email'],
            'password' => Hash::make($formData['password']),
        ]);

        $shortcodes = [
            '[[full_name]]' => $formData['first_name'].' '.$formData['last_name'],
        ];

        // Notify user and admin
        $this->pushNotify('new_user', $shortcodes, route('admin.user.edit', $user->id), $user->id, 'Admin');
        $this->pushNotify('new_user', $shortcodes, null, $user->id);
        $this->smsNotify('new_user', $shortcodes, $user->phone);

        // Referred event
        event(new UserReferred($request->cookie('invite'), $user));

        if (setting('referral_signup_bonus', 'permission') && (float) setting('signup_bonus', 'fee') > 0) {
            $signupBonus = (float) setting('signup_bonus', 'fee');
            $user->increment('balance', $signupBonus);
            Txn::new($signupBonus, 0, $signupBonus, 'system', 'Signup Bonus', TxnType::SignupBonus, TxnStatus::Success, null, null, $user->id);
            Session::put('signup_bonus', $signupBonus);
        }

        Cookie::forget('invite');
        Auth::login($user);
        LoginActivities::add();

        $request->session()->put('newly_registered',true);
        return to_route('register.final');
    }

    /**
     * Display the registration view.
     *
     * @return View
     */
    public function create()
    {
        if (! setting('account_creation', 'permission')) {
            notify()->warning(__('User registration is closed now.'));

            return to_route('home');
        }

        $page = Page::where('code', 'registration')->where('locale', app()->getLocale())->first();

        if(!$page){
            $page = Page::where('code', 'registration')->where('locale', defaultLocale())->first();
        }
        $data = json_decode($page?->data, true);

        $googleReCaptcha = plugin_active('Google reCaptcha');
        $location = getLocation();
        $branches = Branch::where('status', 1)->get();

        return view('frontend::auth.register2', compact('location', 'googleReCaptcha','data', 'branches'));
    }

    public function final()
    {
        if (!request()->session()->has('newly_registered')) {
            return to_route('user.dashboard');
        }

        request()->session()->forget('newly_registered');
        return view('frontend::auth.final');
    }
}
