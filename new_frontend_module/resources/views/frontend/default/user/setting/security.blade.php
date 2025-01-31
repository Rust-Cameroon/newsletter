@extends('frontend::layouts.user')
@section('title')
{{ __('Security Settings') }}
@endsection
@section('content')
<div class="row">
    @include('frontend::user.setting.include.__settings_nav')
    <div class="col-xl-6 col-lg-8 col-md-12">
        <div class="site-card">
            <div class="site-card-header">
                <div class="title-small">{{ __('2FA Authentication') }}</div>
            </div>
            <div class="site-card-body fst-normal fs-6">
                @if($user->google2fa_secret !== null)
                    @php
                        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

                        $inlineUrl = $google2fa->getQRCodeInline(setting('site_title','global'),$user->email,$user->google2fa_secret);
                    @endphp

                <div class="step-details-form">
                    <p class="fw-bold">{{ __('Two Factor Authentication (2FA) strengthens access security by requiring two methods (also Referred To As Factors) to verify your identity. Two Factor Authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.') }}</p>
                    <p class="mt-2 fw-500">{{ __('Scan the QR code with you Google Authenticator App') }}</p>
                    <div class="mb-3 w-50">
                        @if(Str::of($inlineUrl)->startsWith('data:image/'))
                        <img src="{{ $inlineUrl }}">
                        @else
                        {!! $inlineUrl !!}
                        @endif
                    </div>

                    <form action="{{ route('user.setting.action-2fa') }}" method="POST">
                        @csrf

                        <div class="inputs">
                            <label for="" class="input-label">
                                @if($user->two_fa)
                                    {{ __('Enter Your Password') }}
                                @else
                                    {{ __('Enter the PIN from Google Authenticator App') }}
                                @endif
                            </label>
                            <input type="password" class="box-input" name="one_time_password">
                        </div>

                        @if($user->two_fa)
                            <button type="submit" class="site-btn bg-danger text-white" value="disable" name="status">
                                <i data-lucide="x-circle"></i> {{ __('Disable 2FA') }}
                            </button>
                        @else
                            <button type="submit" class="site-btn polis-btn" value="enable" name="status">
                                <i data-lucide="shield"></i> {{ __('Enable 2FA') }}
                            </button>
                        @endif

                    </form>
                </div>
                @else
                    <a href="{{ route('user.setting.2fa') }}" class="site-btn polis-btn">
                        <i data-lucide="shield"></i>{{ __('Generate Secret Key For 2FA') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
    @if(setting('passcode_verification','permission'))
    <div class="col-xl-6 col-lg-6 col-md-12">
        <div class="site-card">
            <div class="site-card-header">
                <div class="title-small">{{ __('Passcode') }}</div>
            </div>
            <div class="site-card-body">
                @if(auth()->user()->passcode == null)
                <button class="site-btn-sm polis-btn mt-2" data-bs-toggle="modal" data-bs-target="#generatePcode">
                    <i data-lucide="globe"></i>{{ __('Generate Passcode') }}
                </button>
                @else
                <button class="site-btn-sm red-btn mt-2" data-bs-toggle="modal" data-bs-target="#disablePasscode">
                    <i data-lucide="x"></i>{{ __('Disable Passcode') }}
                </button>
                <button class="site-btn-sm polis-btn mt-2" data-bs-toggle="modal" data-bs-target="#changePasscode">
                    <i data-lucide="key"></i>{{ __('Change Passcode') }}
                </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal for Generate Passcode-->
    <div class="modal fade" id="generatePcode" tabindex="-1" aria-labelledby="generatePcodeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content site-table-modal">
                <div class="modal-body popup-body">
                    <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-lucide="x"></i>
                    </button>
                    <div class="popup-body-text">
                        <div class="title">{{ __('Add Passcode') }}</div>
                        <form action="{{ route('user.setting.passcode') }}" method="POST">
                            @csrf
                            <div class="step-details-form">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="inputs">
                                            <label for="" class="input-label">{{ __('Passcode') }}<span class="required">*</span></label>
                                            <input type="text" class="box-input" minlength="4" maxlength="10" name="passcode" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="inputs">
                                            <label for="">{{ __('Confirm Passcode') }}<span class="required">*</span></label>
                                            <input type="text" class="box-input" minlength="4" maxlength="10" name="passcode_confirmation" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="action-btns">
                                <button type="submit" class="site-btn-sm primary-btn me-2">
                                    <i data-lucide="check"></i>
                                    {{ __('Confirm') }}
                                </button>
                                <button class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-lucide="x"></i>
                                    {{ __('Close') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Generate Passcode end-->

    <!-- Modal for Change Passcode-->
    <div class="modal fade" id="changePasscode" tabindex="-1" aria-labelledby="changePasscodeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content site-table-modal">
                <div class="modal-body popup-body">
                    <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-lucide="x"></i>
                    </button>
                    <div class="popup-body-text">
                        <div class="title">{{ __('Change Passcode') }}</div>
                        <form action="{{ route('user.setting.change.passcode') }}" method="POST">
                            @csrf
                            <div class="step-details-form">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="inputs">
                                            <label for="" class="input-label">{{ __('Old Passcode') }}<span class="required">*</span></label>
                                            <input type="number" class="box-input" minlength="4" maxlength="10" name="old_passcode" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="inputs">
                                            <label for="" class="input-label">{{ __('New Passcode') }}<span class="required">*</span></label>
                                            <input type="number" class="box-input" minlength="4" maxlength="10" name="passcode" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="inputs">
                                            <label for="">{{ __('Confirm Passcode') }}<span class="required">*</span></label>
                                            <input type="number" class="box-input" minlength="4" maxlength="10" name="passcode_confirmation" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="action-btns">
                                <button type="submit" class="site-btn-sm primary-btn me-2">
                                    <i data-lucide="check"></i>
                                    {{ __('Change Passcode') }}
                                </button>
                                <button class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-lucide="x"></i>
                                    {{ __('Close') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Change Passcode end-->

    <!-- Modal for Disable Passcode-->
    <div class="modal fade" id="disablePasscode" tabindex="-1" aria-labelledby="disablePasscodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content site-table-modal">
                <div class="modal-body popup-body">
                    <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-lucide="x"></i>
                    </button>
                    <div class="popup-body-text">
                        <div class="title">{{ __('Confirm Your Password') }}</div>
                        <form action="{{ route('user.setting.passcode') }}" method="POST">
                            @csrf
                            <div class="step-details-form">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="inputs">
                                            <label for="" class="input-label">{{ __('Password') }}<span class="required">*</span></label>
                                            <input type="password" class="box-input" name="confirm_password" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="action-btns">
                                <button type="submit" name="status" value="disable_passcode" class="site-btn-sm primary-btn me-2">
                                    <i data-lucide="check"></i>
                                    {{ __('Confirm') }}
                                </button>
                                <button class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-lucide="x"></i>
                                    {{ __('Close') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Disable Passcode end-->
    @endif

</div>
@endsection
