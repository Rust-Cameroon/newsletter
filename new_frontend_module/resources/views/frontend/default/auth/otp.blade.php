@extends('frontend::layouts.auth')
@section('title')
    {{ __('Verify OTP') }}
@endsection
@section('content')
    <!-- OTP Verify Section -->
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
                        <h3>{{ __('OTP Verification') }}</h3>
                        @if(session('error'))
                            <div class="error-message">
                                <p>{{ session('error') }}</p>
                            </div>
                        @endif
                        @if(session('success'))
                            <div class="success-message">
                                <p>{{ __('Enter OTP code sent to') }} <strong>{{ auth()->user()->phone }}</strong>
                                    <br>{{ __('Time left') }} <strong><span id="otptimer"></span></strong></p>
                            </div>
                        @endif

                        <form action="{{ route('otp.verify.post') }}" method="POST">
                            @csrf
                            <div class="inputs">
                                <input type="hidden" name="phone" value="{{ auth()->user()->phone }}">
                                <div class="input-otp">
                                    <input class="inputotp" name="otp[]" type="number"/>
                                    <input class="inputotp" name="otp[]" type="number" disabled/>
                                    <input class="inputotp" name="otp[]" type="number" disabled/>
                                    <input class="inputotp" name="otp[]" type="number" disabled/>
                                </div>
                            </div>
                            <div class="inputs">
                                <button type="submit"
                                        class="otpbtn site-btn primary-btn w-100 centered">{{ __('Verify & Proceed') }}</button>
                            </div>
                        </form>
                        <p>{{ __('Don\'t receive code ?') }} <a href="{{ route('otp.resend') }}">{{ __('Resend again') }}</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="authOne">
            <div class="auth-banner"
                 style="background: url('{{ asset(getPageSetting('breadcrumb')) }}') no-repeat;"></div>
        </div>
    </div>
    <!-- OTP Verify Section End -->
@endsection
@section('script')
    <script>
        'use strict';
        // OTP js code
        const inputs = document.querySelectorAll("input"),
            button = document.querySelector("button");


        //focus the first input which index is 0 on window load
        window.addEventListener("load", () => inputs[0].focus());

        // iterate over all inputs
        inputs.forEach((input, index1) => {
            input.addEventListener("keyup", (e) => {
                const currentInput = input,
                    nextInput = input.nextElementSibling,
                    prevInput = input.previousElementSibling;

                if (currentInput.value.length > 1) {
                    currentInput.value = "";
                    return;
                }
                if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
                    nextInput.removeAttribute("disabled");
                    nextInput.focus();
                }

                // if the backspace key is pressed
                if (e.key === "Backspace") {
                    inputs.forEach((input, index2) => {
                        if (index1 <= index2 && prevInput) {
                            input.setAttribute("disabled", true);
                            input.value = "";
                            prevInput.focus();
                        }
                    });
                }
                if (!inputs[3].disabled && inputs[3].value !== "") {
                    button.classList.add("active");
                    return;
                }
                button.classList.remove("active");
            });
        });


        // OTP Time count down
        let timerOn = true;

        function timer(remaining) {
            var m = Math.floor(remaining / 60);
            var s = remaining % 60;

            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;
            document.getElementById('otptimer').innerHTML = m + ':' + s;
            remaining -= 1;

            if (remaining >= 0 && timerOn) {
                setTimeout(function () {
                    timer(remaining);
                }, 1000);
                return;
            }

            if (!timerOn) {
                // Do validate stuff here
                return;
            }

            // Do timeout stuff here
            alert('Timeout for OTP');
        }

        timer(120);

    </script>
@endsection
