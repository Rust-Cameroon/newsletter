@extends('frontend::layouts.user')
@section('title')
    {{ __('Deposit Now') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="title">{{ __('Add Money') }}</h3>
                    <div class="card-header-links">
                        <a href="{{ route('user.deposit.log') }}"
                           class="card-header-link">{{ __('Deposit History') }}</a>
                    </div>
                </div>
                <div class="site-card-body">
                    <div class="progress-steps">
                        <div class="single-step {{ $isStepOne }}">
                            <div class="number">{{ __('01') }}</div>
                            <div class="content">
                                <h4>{{ __('Deposit Amount') }}</h4>
                                <p>{{ __('Enter your deposit details') }}</p>
                            </div>
                        </div>
                        <div class="single-step {{ $isStepTwo }}">
                            <div class="number">{{ __('02') }}</div>
                            <div class="content">
                                <h4>{{ __('Success') }}</h4>
                                <p>{{  $notify['card-header'] ??  __('Success Your Deposit') }}</p>
                            </div>
                        </div>
                    </div>
                    @yield('deposit_content')
                </div>
            </div>
        </div>
    </div>
@endsection
