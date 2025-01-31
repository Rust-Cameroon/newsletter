@extends('frontend::layouts.auth')

@section('title')
    {{ __('Register') }}
@endsection
@push('js')
<script>
    "use strict"

    $('#gender, #branch_id').select2();

</script>
@endpush
@section('content')
    <div class="half-authpage">
        <div class="authOne">
            <div class="auth-contents">
                <div class="logo">
                    @php
                        $height = setting('site_logo_height','global') == 'auto' ? 'auto' : setting('site_logo_height','global').'px';
                        $width = setting('site_logo_width','global') == 'auto' ? 'auto' : setting('site_logo_width','global').'px';
                    @endphp
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
                        <div class="go-back"><a href="{{ route('register') }}"><i data-lucide="chevron-left"></i>{{ __('Go back') }}</a></div>
                        <h3>{{ __('We\'re almost there!') }}</h3>
                        @if ($errors->any())
                            <div class="error-message">
                                @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <form action="{{ route('register.now.step2') }}" method="POST">
                            @csrf

                            @if(getPageSetting('username_show'))
                            <div class="inputs">
                                <label for="">{{ __('Username') }}<span class="required">*</span></label>
                                <input type="text" name="username" value="{{ old('username') }}" class="box-input @error('username') border-danger @enderror " required>
                                @error('username')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif

                            <div class="inputs">
                                <label for="">{{ __('First Name') }}<span class="required">*</span></label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="box-input" required>
                            </div>
                            <div class="inputs">
                                <label for="">{{ __('Last Name') }}<span class="required">*</span></label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="box-input" required>
                            </div>

                            <div class="inputs">
                                <label for="">{{ __('Gender') }} @if(getPageSetting('gender_validation'))<span class="required">*</span> @endif</label>
                                <select name="gender" class="box-input" id="gender">
                                    @foreach(['Male','Female','Others'] as $gender)
                                        <option @selected($gender == old('gender')) value="{{ $gender }}">{{ $gender  }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if(getPageSetting('branch_show') && branch_enabled())
                            <div class="inputs">
                                <label for="">{{ __('Branch') }} @if(getPageSetting('branch_validation'))<span class="required">*</span> @endif</label>
                                <select name="branch_id" class="box-input" id="branch_id">
                                    <option value="" selected disabled>{{ __('Select Branch:') }}</option>
                                    @foreach($branches as $branch)
                                        <option @selected($branch->id == old('branch_id')) value="{{ $branch->id }}">{{ $branch->name  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            @if($googleReCaptcha)
                                <div class="g-recaptcha mb-3" id="feedback-recaptcha"
                                     data-sitekey="{{ json_decode($googleReCaptcha->data,true)['site_key'] }}">
                                </div>
                            @endif
                            
                            <div class="inputs">
                                <div class="remem-for">
                                    <div class="checkbox-wrapper-15">
                                        <input class="inp-cbx" id="cbx-15" type="checkbox" name="i_agree" value="yes" style="display: none;"/>
                                        <label class="cbx" for="cbx-15">
                                            <span>
                                              <svg width="12px" height="9px" viewbox="0 0 12 9">
                                                <polyline points="1 5 4 8 11 1"></polyline>
                                              </svg>
                                            </span>
                                            <span>{{ __('I agree with the ') }}<a href="{{ url('/terms-and-conditions') }}">{{ __('Terms & Condition') }}</a></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="inputs centered mt-2">
                                <button type="submit" class="site-btn primary-btn w-100"><i data-lucide="check"></i>{{ __('Finish up Account') }}</button>
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
@endsection

@section('script')
@if($googleReCaptcha)
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endif
@endsection
