@extends('frontend::layouts.auth')
@section('title')
    {{ __('Reset Password') }}
@endsection
@section('content')
    <!-- Login Section -->
    <section class="section-style site-auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-8 col-md-12">
                    <div class="auth-contents">
                        @php
                            $height = setting('site_logo_height','global') == 'auto' ? 'auto' : setting('site_logo_height','global').'px';
                            $width = setting('site_logo_width','global') == 'auto' ? 'auto' : setting('site_logo_width','global').'px';
                        @endphp
                        <div class="logo">
                            <a href="{{ route('home')}}"><img src="{{ asset(setting('site_logo','global')) }}" style="height:{{ $height }};width:{{ $width }};max-width:none" alt=""/></a>
                        </div>
                        <div class="title">
                            <h2>👋 {{ __('Reset password') }}</h2>
                            <p>{{  __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                @foreach($errors->all() as $error)
                                    <strong>{{$error}}</strong>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('status'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>{{ session('status') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        @endif


                        <div class="site-auth-form">


                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <!-- Password Reset Token -->
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <!-- Email Address -->

                                <div class="single-field">
                                    <label class="box-label" for="email">{{ __('Email') }}</label>
                                    <input
                                        class="box-input"
                                        type="text"
                                        name="email"
                                        placeholder="Enter your email address"
                                        required
                                        value="{{ old('email',$request->email) }}"
                                    />
                                </div>

                                <div class="single-field">
                                    <label class="box-label" for="email">{{ __('New Password') }}</label>
                                    <input
                                        class="box-input"
                                        type="password"
                                        name="password"
                                        required
                                    />
                                </div>

                                <div class="single-field">
                                    <label class="box-label" for="email">{{ __('Confirm Password') }}</label>
                                    <input
                                        class="box-input"
                                        type="password"
                                        name="password_confirmation"
                                        required
                                    />
                                </div>

                                <button type="submit" class="site-btn grad-btn w-100">
                                    {{ __('Reset Password') }}
                                </button>
                            </form>

                            <div class="singnup-text">
                                <p>
                                    {{ __("Don't have an account?") }}
                                    <a href="{{route('register')}}">{{ __('Signup for free') }}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Section End -->
@endsection

