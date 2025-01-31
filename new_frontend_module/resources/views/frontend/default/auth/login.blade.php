@extends('frontend::layouts.auth')

@section('title')
    {{ __('Login') }}
@endsection
@section('content')
    <!-- Login Section -->
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
                        <h3>{{ $data['title'] }}</h3>
                        @if ($errors->any())
                            <div class="error-message">
                                @foreach($errors->all() as $error)
                                    <p>{{$error}}</p>
                                @endforeach
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="inputs">
                                <label for="">{{ __('Email Or Username') }}</label>
                                <input type="text" name="email" class="box-input" required>
                            </div>
                            <div class="inputs">
                                <label for="">{{ __('Password') }}</label>
                                <div class="passo">
                                    <input type="password" class="box-input" name="password" id="passo" required>
                                    <img src="{{ asset('front/images/icons/eye-off.svg') }}" class="passo-hide-show"
                                         id="eyeicon" alt="">
                                </div>
                            </div>
                            @if($googleReCaptcha)
                                <div class="g-recaptcha mb-3" id="feedback-recaptcha"
                                     data-sitekey="{{ json_decode($googleReCaptcha->data,true)['site_key'] }}">
                                </div>
                            @endif
                            <div class="inputs">
                                <div class="remem-for">
                                    <div class="checkbox-wrapper-15">
                                        <input class="inp-cbx" id="cbx-15" name="remember" type="checkbox"
                                               style="display: none;"/>
                                        <label class="cbx" for="cbx-15">
                                            <span>
                                              <svg width="12px" height="9px" viewbox="0 0 12 9">
                                                <polyline points="1 5 4 8 11 1"></polyline>
                                              </svg>
                                            </span>
                                            <span> {{ __('Remember me') }}</span>
                                        </label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <p><a href="{{ route('password.request') }}">{{ __('Forget Password') }}</a></p>
                                    @endif
                                </div>
                            </div>
                            <div class="inputs">
                                <button type="submit" class="site-btn primary-btn w-100"><i data-lucide="key"></i>
                                    {{ __('Sign in') }}
                                </button>
                            </div>
                        </form>
                        <p>{{ __("Don't have an account?") }} <a
                                href="{{route('register')}}">{{ __('Create account') }}</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="authOne">
            <div class="auth-banner" style="background: url('{{ asset($data['right_image']) }}') no-repeat;"></div>
        </div>
    </div>
    <!-- Login Section End -->
@endsection
@section('script')
    @if($googleReCaptcha)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    <script>
        (function($) {
            'use strict';

            // password hide show
            let eyeicon = document.getElementById('eyeicon')
            let passo = document.getElementById('passo')
            eyeicon.onclick = function() {
                if(passo.type === "password") {
                    passo.type = "text";
                    eyeicon.src = '{{ asset('front/images/icons/eye.svg') }}'
                } else {
                    passo.type = "password";
                    eyeicon.src = '{{ asset('front/images/icons/eye-off.svg') }}'
                }
            }

        })(jQuery);
    </script>
@endsection
