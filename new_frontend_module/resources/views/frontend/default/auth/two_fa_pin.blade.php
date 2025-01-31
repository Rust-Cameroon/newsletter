@extends('frontend::layouts.auth')
@section('title')
    {{ __('2FA Security') }}
@endsection
@section('content')
    <div class="half-authpage">
        <div class="authOne">
            <div class="auth-contents">
                <div class="logo">
                    @php
                        $height = setting('site_logo_height','global') == 'auto' ? 'auto' : setting('site_logo_height','global').'px';
                        $width = setting('site_logo_width','global') == 'auto' ? 'auto' : setting('site_logo_width','global').'px';
                    @endphp
                    <a href="{{ route('home')}}"><img src="{{ asset(setting('site_logo','global')) }}" style="height:{{ $height }};width:{{ $width }};max-width:none" alt=""></a>
                    <div class="no-user-header">
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
                        <div class="color-switcher">
                            <img class="light-icon" src="{{ asset('front/images/icons/sun.png') }}" alt="">
                            <img class="dark-icon" src="{{ asset('front/images/icons/moon.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="contents">
                    <div class="content">
                        <h3>{{ __('2FA Security') }}</h3>
                        @if ($errors->any())
                            <div class="error-message">
                                @foreach($errors->all() as $error)
                                    <p>{{$error}}</p>
                                @endforeach
                            </div>
                        @endif
                        <form method="POST" action="{{ route('user.setting.2fa.verify') }}">
                            @csrf
                            <div class="inputs">
                                <p>
                                    {{ __('Please enter the') }}
                                        <strong>{{ __('OTP') }}</strong> {{ __('generated on your Authenticator App.') }}
                                        <br> {{ __('Ensure you submit the current one because it refreshes every 30 seconds.') }}
                                </p>
                                <label for="">
                                    {{ __('One Time Password') }}
                                </label>
                                <input type="password" class="box-input" name="one_time_password" autofocus placeholder="One Time Password" required>
                            </div>

                            <div class="inputs">
                                <button type="submit" class="site-btn primary-btn w-100"><i data-lucide="key"></i>
                                    {{ __('Authenticate Now') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="authOne">
            <div class="auth-banner"
                 style="background: url('{{ asset(getPageSetting('breadcrumb')) }}') no-repeat;"></div>
        </div>
    </div>
@endsection


