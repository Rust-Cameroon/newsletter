@extends('backend.auth.index')
@section('title')
    {{ __('Reset Password') }}
@endsection
@section('auth-content')
    <div class="login">
        <div
            class="side-img primary-overlay"
            style="background: url( {{asset( setting('login_bg','global') )}} ) no-repeat center center;">
            <div class="title">
                <h3>{{ __('Admin Reset Password') }}</h3>
            </div>
        </div>
        <div class="login-content">
            @php
                $height = setting('site_logo_height','global') == 'auto' ? 'auto' : setting('site_logo_height','global').'px';
                $width = setting('site_logo_width','global') == 'auto' ? 'auto' : setting('site_logo_width','global').'px';
            @endphp
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{asset(setting('site_logo','global') )}}" style="height:{{ $height }};width:{{ $width }}" alt="{{asset(setting('site_title','global') )}}"/>
                </a>
            </div>
            <div class="auth-body">


                <form action="{{ route('admin.forget.password.submit') }}" method="post">
                    @csrf

                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif

                    <div class="single-box">
                        <label for="" class="box-label">{{ __('Admin Email') }}</label>
                        <input
                            type="email"
                            name="email"
                            class="box-input"
                            required
                        />
                    </div>
                    <div class="single-box">
                        <button class="site-btn primary-btn" type="submit">{{ __('Send Password Reset Link') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
