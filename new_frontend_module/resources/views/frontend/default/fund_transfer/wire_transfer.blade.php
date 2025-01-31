@extends('frontend::layouts.user')
@section('title')
    {{ __('Wire Transfer') }}
@endsection
@section('content')
    <div class="row">
        @include('frontend::fund_transfer.include.__header')

        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title">{{ __('Wire Transfer') }}</div> 
                    <div class="card-header-links">
                        <a href="" class="card-header-link" data-bs-toggle="modal" data-bs-target="#limitBox"><i
                                data-lucide="alert-circle"></i>{{ __('Limits') }}</a>
                    </div>
                </div>
                <form action="{{ route('user.fund_transfer.transfer.wire.post') }}" method="POST">
                    @csrf
                    <div class="site-card-body">
                        <div class="step-details-form">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Enter Amount') }}<span
                                                class="required">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="amount">
                                            <span class="input-group-text">{{ $currency }}</span>
                                        </div>
                                        <div class="input-info-text">{{ __('Minimum') }} {{ $data->minimum_transfer }} {{ $currency }} {{ __('and Maximum') }} {{ $data->maximum_transfer }} {{ $currency }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Name on account') }}<span class="required">*</span></label>
                                        <input type="text" class="box-input" name="name_of_account">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Account Number') }}<span class="required">*</span></label>
                                        <input type="text" class="box-input" name="account_number">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('SWIFT code') }}<span
                                                class="required">*</span></label>
                                        <input type="text" class="box-input" name="swift_code">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Full Name') }}<span
                                                class="required">*</span></label>
                                        <input type="text" class="box-input" name="full_name">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Phone Number') }}<span
                                                class="required">*</span></label>
                                        <input type="text" class="box-input" name="phone_number">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="inputs">
                                        <label for="">{{ __('Purpose of transfer(Optional)') }}</label>
                                        <textarea class="box-textarea" rows="3" name="purpose"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button
                        @if(auth()->user()->passcode !== null && setting('fund_transfer_passcode_status'))
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#passcode"
                        @else
                        type="submit"
                        @endif
                        class="site-btn polis-btn"
                        ><i data-lucide="send"></i> {{ __('Transfer the fund') }}</button>
                    </div>
                    @if(auth()->user()->passcode !== null && setting('fund_transfer_passcode_status'))
                    <div class="modal fade" id="passcode" tabindex="-1" aria-labelledby="passcodeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content site-table-modal">
                                <div class="modal-body popup-body">
                                    <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-lucide="x"></i>
                                    </button>
                                    <div class="popup-body-text">
                                        <div class="title">{{ __('Confirm Your Passcode') }}</div>
                                        <div class="step-details-form">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12">
                                                    <div class="inputs">
                                                        <label for="" class="input-label">{{ __('Passcode') }}<span class="required">*</span></label>
                                                        <input type="password" class="box-input" name="passcode" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="action-btns">
                                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                                <i data-lucide="check"></i>
                                                {{ __('Confirm') }}
                                            </button>
                                            <button type="button" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
                                                <i data-lucide="x"></i>
                                                {{ __('Close') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
        <!-- Modal for Limit beneficiary-->
        @include('frontend::fund_transfer.include.__limitition')
        <!-- Modal for Limit beneficiary end-->
    </div>
@endsection
