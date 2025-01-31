@extends('frontend::layouts.user')
@section('title')
    {{ __('Change Password') }}
@endsection
@section('content')
    <div class="row">
        @include('frontend::user.setting.include.__settings_nav')
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="title">{{ __('Change Password') }}</h3>
                </div>
                <div class="site-card-body">
                    <div class="step-details-form">
                        <form action="{{ route('user.new.password') }}" method="post">
                            @csrf

                            @foreach ($errors->all() as $error)
                                @php
                                    notify()->warning($error);
                                @endphp
                            @endforeach

                            <div class="row">
                                <div class="col-xl-12 col-md-12 inputs">
                                    <label class="form-label">{{ __('Current Password') }}</label>
                                    <div class="input-group">
                                        <input type="password" name="current_password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-12 inputs">
                                    <label class="form-label">{{ __('New Password') }}</label>
                                    <div class="input-group">
                                        <input type="password" name="new_password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-12 inputs">
                                    <label class="form-label">{{ __('Confirm Password') }}</label>
                                    <div class="input-group">
                                        <input type="password" name="new_confirm_password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-12">
                                    <button type="submit" class="site-btn polis-btn">{{ __('Change Password') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
