@extends('backend.auth.index')
@section('title')
    {{ __('Reset Password') }}
@endsection
@section('auth-content')
    <div class="login">
        <div
            class="side-img primary-overlay"
            style="
                background: url({{ asset(setting('login_bg','global')) }}) no-repeat
                center center;
                "
        >
            <div class="title">
                <h3>{{ __('Admin Reset Password') }}</h3>
            </div>
        </div>
        <div class="login-content">
            <div class="logo">
                <a href="{{ route('home') }}"><img src="{{asset(setting('site_logo','global') )}}"
                                                   alt="{{asset(setting('site_title','global') )}}"/></a>
            </div>
            <div class="auth-body">

                <form action="{{ route('admin.reset.password.submit') }}" method="post">
                    @csrf

                    <input type="hidden" name="token" value="{{ request('token') }}">

                    <div class="single-box">
                        <label for="" class="box-label">Admin Email</label>
                        <input
                            type="email"
                            name="email"
                            class="box-input"
                            placeholder="Admin Email"
                            required
                        />
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>


                    <div class="single-box">
                        <label for="" class="box-label">New Password</label>
                        <input
                            type="password"
                            name="password"
                            class="box-input"
                            placeholder="New Password"
                            required
                        />
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif

                    </div>

                    <div class="single-box">
                        <label for="" class="box-label">Confirm Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="box-input"
                            placeholder="Confirm Password"
                            required
                        />
                        @if ($errors->has('password_confirmation'))
                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                    <div class="single-box">
                        <button class="site-btn primary-btn" type="submit">Reset Password Now</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
