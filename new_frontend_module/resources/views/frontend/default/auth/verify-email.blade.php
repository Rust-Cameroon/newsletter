@extends('frontend::layouts.auth')
@section('title')
    {{ __('Verify Email') }}
@endsection
@section('content')
    <!-- Email Verification Section -->
    <div class="half-authpage">
        <div class="authOne">
            <div class="auth-contents">
                @php
                    $height = setting('site_logo_height','global') == 'auto' ? 'auto' : setting('site_logo_height','global').'px';
                    $width = setting('site_logo_width','global') == 'auto' ? 'auto' : setting('site_logo_width','global').'px';
                @endphp
                <div class="logo">
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
                        <h3>{{ __('Email Verification') }}</h3>
                        <div class="success-message">
                            <p>{{ __('Sent the link on your email. Please check your inbox') }}</p>
                        </div>
                        @if (session('status') === 'verification-link-sent')
                            <div class="success-message">
                                <p>{{ __('A new verification link has been sent to the email address you provided during registration.') }}</p>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <div class="inputs">
                                <button type="submit" class="site-btn primary-btn w-100 centered">{{ __('Resend the email') }}</button>
                            </div>
                        </form>
                        <p>{{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Login here') }}</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="authOne">
            <div class="auth-banner" style="background: url('{{ asset(getPageSetting('breadcrumb')) }}') no-repeat;"></div>
        </div>
    </div>
    <!-- Email Verification Section End -->
@endsection



