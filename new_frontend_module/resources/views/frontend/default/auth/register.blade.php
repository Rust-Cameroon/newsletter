@extends('frontend::layouts.auth')

@section('title')
    {{ __('Register') }}
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
                        <h3>{{ data_get($data,'title',__('Create an account')) }}</h3>
                        @if ($errors->any())
                            <div class="error-message">
                                @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="inputs">
                                <label for="">{{ __('Email') }}<span class="required">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" class="box-input" required>
                            </div>

                            @if(getPageSetting('country_show'))
                            <div class="inputs">
                                <label for="">{{ __('Country') }} @if(getPageSetting('country_validation'))<span class="required">*</span> @endif</label>
                                <select name="country" class="box-input select2-basic-active" id="countrySelect">
                                    @foreach( getCountries() as $country)
                                        <option data-flag="https://flagcdn.com/48x36/{{ strtolower(data_get($country,'code')) }}.png" @selected($location->country_code == $country['code']) value="{{ $country['name'].':'.$country['dial_code'] }}" data-code="{{ $country['dial_code'] }}">{{ $country['name']  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            @if(getPageSetting('phone_show'))
                                <div class="inputs">
                                    <label for="">{{ __('Phone') }} @if(getPageSetting('phone_validation'))<span class="required">*</span> @endif</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="dial-code">{{ getLocation()->dial_code }}</span>
                                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
                                    </div>
                                </div>
                            @endif
                            @if(getPageSetting('referral_code_show'))
                                <div class="inputs">
                                    <label for="">{{ __('Referral Code') }} @if(getPageSetting('referral_code_validation'))<span class="required">*</span> @endif</label>
                                    <input type="text" name="invite" value="{{ old('invite',$referralCode) }}" class="box-input">
                                </div>
                            @endif
                            <div class="inputs">
                                <label for="">{{ __('Password') }}<span class="required">*</span></label>
                                <div class="passo">
                                    <input type="password" name="password" class="box-input" id="passo2" required>
                                    <img src="{{ asset('front/images/icons/eye-off.svg') }}" class="passo-hide-show" id="eyeicon2" alt="">
                                </div>
                            </div>

                            <div class="inputs centered">
                                <button type="submit" class="site-btn primary-btn w-100"><i data-lucide="arrow-right"></i>{{ __('1/2 Next Step') }}</button>
                            </div>
                        </form>
                        <p>{{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Login') }}</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="authOne">
            <div class="auth-banner" style="background: url('{{ asset($data['right_image']) }}') no-repeat;"></div>
        </div>
    </div>
    <!-- Register Section End -->
@endsection
@section('script')
    <script>
        (function($) {
            'use strict';

            // password hide show
            let eyeicon2 = document.getElementById('eyeicon2')
            let passo2 = document.getElementById('passo2')

            eyeicon2.onclick = function() {
                if(passo2.type == "password") {
                    passo2.type = "text";
                    eyeicon2.src = '{{ url("assets/front/images/icons/eye.svg") }}'
                } else {
                    passo2.type = "password";
                    eyeicon2.src = '{{ url("assets/front/images/icons/eye-off.svg") }}'
                }
            }

            // Select 2 activation
            function formatState(state) {
                if (!state.id) {
                    return state.text;
                }

                var $state = $(
                    '<span><img src="' + $(state.element).data('flag') + '" class="img-icon" /> ' + state.text + '</span>'
                );

                return $state;
            };

            $('.select2-basic-active').select2({
                templateResult: formatState,
                templateSelection: formatState,
            });

            // Country Select
            $('#countrySelect').on('change', function (e) {
                "use strict";
                e.preventDefault();
                var country = $(this).val();
                $('#dial-code').html(country.split(":")[1])
            })

        })(jQuery);
    </script>
@endsection

