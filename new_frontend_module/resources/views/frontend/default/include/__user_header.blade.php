
<div class="user-part-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="nav-wrap">
                    <div class="nav-left">
                        <div class="single-left">
                            <div class="site-sidebar-toggle"><i data-lucide="list"></i></div>
                            <div class="site-logo-inmobile"><a href="{{route('home')}}"><img src="{{ asset(setting('site_logo','global')) }}" alt="{{ setting('site_title') }}"></a></div>
                            <div class="site-logo-inmobile-icon"><a href="{{route('home')}}"><img src="{{ asset(setting('site_favicon','global')) }}" alt="{{ setting('site_title') }}"></a></div>
                            <div class="salutation">{{ grettings() }}! <strong>{{ auth()->user()->full_name }}</strong></div>
                        </div>
                    </div>
                    <div class="nav-right">
                        @if(setting('sign_up_referral','permission'))
                        <div class="single-right mob-650-none">
                            <div class="user-header-btn">
                                <a href="{{ route('user.referral') }}" class=""><i data-lucide="gift"></i>{{ __('Earn') }} {{ $currencySymbol.setting('referral_bonus','fee') }}</a>
                            </div>
                        </div>
                        @endif
                        <div class="single-right">
                            <div class="color-switcher">
                                <img class="light-icon" src="{{ asset('front/images/icons/sun.png') }}" alt="">
                                <img class="dark-icon" src="{{ asset('front/images/icons/moon.png') }}" alt="">
                            </div>
                        </div>
                        @auth
                            @php
                                $userId = auth()->id();
                                $notifications = App\Models\Notification::with('user')->where('for','user')->where('user_id', $userId)->latest()->take(10)->get();
                                $totalUnread = App\Models\Notification::with('user')->where('for','user')->where('user_id', $userId)->where('read', 0)->count();
                                $totalCount = App\Models\Notification::with('user')->where('for','user')->where('user_id', $userId)->get()->count();
                            @endphp
                            <div class="single-right user-notifications{{ $userId }}">
                                @include('frontend.default.include.__user-notification-data',['notifications'=>$notifications,'totalUnread'=>$totalUnread,'totalCount'=>$totalCount])
                            </div>
                        @endauth
                        <div class="single-right">
                            @if(setting('language_switcher'))
                                <div class="language-switcher">
                                    <select class="langu-swit small" name="language" id=""
                                            onchange="window.location.href=this.options[this.selectedIndex].value;">
                                        @foreach(\App\Models\Language::where('status',true)->get() as $lang)
                                            <option
                                                value="{{ route('language-update',['name'=> $lang->locale]) }}" @selected( app()->getLocale() == $lang->locale )>{{$lang->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>
                        <div class="single-right mob-650-none">
                            <div class="help-support">
                                <a href="{{ route('user.ticket.index') }}" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-placement="top" data-bs-title="Help and Support"><i data-lucide="help-circle"></i></a>
                            </div>
                        </div>
                        <div class="single-right">
                            <div class="user-head-drop">
                                <div class="dropdown">
                                    <button class="user-head-drop-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        @if(auth()->user()->avatar != null && file_exists(base_path('assets/'.auth()->user()->avatar)))
                                        <img class="user-icon" src="{{ asset(auth()->user()->avatar) }}" alt="">
                                        @else
                                        <img class="user-icon" src="{{ asset('front/images/user.jpg') }}" alt="">
                                        @endif
                                    </button>

                                    <div class="dropdown-menu">
                                        <div class="user-head-drop-top">
                                            <div class="icon">
                                                @if(auth()->user()->avatar != null && file_exists(base_path('assets/'.auth()->user()->avatar)))
                                                <img src="{{ asset(auth()->user()->avatar) }}" alt="">
                                                @else
                                                <img src="{{ asset('front/images/user.jpg') }}" alt="">
                                                @endif
                                            </div>
                                            <div class="names">
                                                <div class="name">{{ auth()->user()->full_name }} ({{ auth()->user()->username }})</div>
                                                <div class="email text-truncate">{{ auth()->user()->email }}</div>
                                            </div>
                                        </div>
                                        <ul>
                                            <li><a class="dropdown-item" href="{{ route('user.setting.show') }}"><i data-lucide="settings"></i><span>{{ __('Profile Settings') }}</span></a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.change.password') }}"><i data-lucide="lock"></i><span>{{ __('Change Password') }}</span></a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.setting.security') }}"><i data-lucide="shield"></i><span>{{ __('2FA Authentication') }}</span></a></li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('user.kyc') }}"><i data-lucide="file-text"></i><span>{{ __('ID Verification') }}</span>
                                                    @if(auth()->user()->kyc == \App\Enums\KYCStatus::Pending->value)
                                                        <b class="verification pending">{{ __('Pending') }}</b>
                                                    @endif
                                                    @if(auth()->user()->kyc == \App\Enums\KYCStatus::Verified->value)
                                                        <b class="verification bg-success">{{ __('Approved') }}</b>
                                                    @endif
                                                    @if(auth()->user()->kyc == \App\Enums\KYCStatus::NOT_SUBMITTED->value || auth()->user()->kyc == \App\Enums\KYCStatus::Failed->value)
                                                        <b class="verification rejected">{{ __('Submit Now') }}</b>
                                                    @endif
                                                </a>
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('user.notification.all') }}"><i data-lucide="bell"></i><span>{{ __('All Notifiactions') }}</span></a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.ticket.index') }}"><i data-lucide="help-circle"></i><span>{{ __('Help & Support') }}</span></a></li>
                                            <li>
                                                <a class="dropdown-item logout" href="{{ url('logout') }}" class="dropdown-item logout" onclick="event.preventDefault();$('#logout-form').submit();"><i data-lucide="log-out"></i><span>{{ __('Logout') }}</span></a>
                                            </li>
                                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                                @csrf
                                            </form>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
