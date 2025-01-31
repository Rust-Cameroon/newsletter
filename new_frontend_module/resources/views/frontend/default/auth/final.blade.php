@extends('frontend::layouts.auth')

@section('title')
    {{ __('Finish Up') }}
@endsection

@section('content')
    <!-- Register Section -->
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
                                <select class="langu-swit small" name="language" onchange="window.location.href=this.options[this.selectedIndex].value;">
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
                    <div class="content finish-wrapper">
                        <h3 class="centered">
                            @if(setting('referral_signup_bonus','permission'))
                            {{ __('Congratulations! You have earned :bonus by signing up.',['bonus' => $currencySymbol.setting('signup_bonus','fee')]) }}
                            @else
                            {{ __('Congratulations! You made it.') }}
                            @endif
                        </h3>
                        <div class="inputs centered">
                            <a href="{{ route('user.dashboard') }}" class="site-btn primary-btn"><i data-lucide="inbox"></i>{{ __('Go to Dashboard') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Section End -->
@endsection

@push('js')
<script type="text/javascript" src="{{ asset('front/js/confetti.min.js') }}"></script>
<script>
    'use strict';

    // start
    const start = () => {
        setTimeout(function() {
            confetti.start()
        }, 1000); // 1000 is time that after 1 second start the confetti ( 1000 = 1 sec)
    };

    start();
</script>
@endpush
