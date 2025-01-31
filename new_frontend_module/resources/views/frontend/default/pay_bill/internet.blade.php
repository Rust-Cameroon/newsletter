@extends('frontend::layouts.user')
@section('title')
    {{ __('Internet') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title">{{ __('Pay Bill') }}</div>
                    <div class="card-header-links">
                        <a href="{{ route('user.pay.bill.history') }}" class="card-header-link"><i data-lucide="credit-card"></i>{{ __('My Bill Payments') }}</a>
                    </div>
                </div>
                <div class="site-card-body">

                    @include('frontend::pay_bill.include.bill-menu')

                    <div class="step-details-form">
                        <form action="{{ route('user.pay.bill.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Countries') }} <span class="required">*</span></label>
                                        <select name="country" class="box-input" id="country">
                                            <option value="" selected disabled>{{ __('Select Country') }}</option>
                                            @foreach ($countries as $country)
                                            <option value="{{ $country }}">{{ $country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Services') }} <span class="required">*</span></label>
                                        <select name="service_id" class="box-input" id="services">
                                            <option value="" selected disabled>{{ __('Select Service') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6" id="labels">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Account Number') }} <span class="required">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="data['Account Number']" class="form-control" placeholder="{{ __('Account Number') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Amount') }} <span class="required">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="amount" class="form-control" placeholder="Amount">
                                            <span class="input-group-text" id="currency">{{ $currency }}</span>
                                        </div>
                                        {{-- <div class="input-info-text min-max">Minimum 10 USD and Maximum 1000 USD</div> --}}
                                    </div>
                                </div>
                                @include('frontend::pay_bill.include.payment-details')
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <button
                                        @if(auth()->user()->passcode !== null && setting('pay_bill_passcode_status'))
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#passcode"
                                        @else
                                        type="submit"
                                        @endif
                                        class="site-btn polis-btn"
                                    >
                                        <i data-lucide="check"></i>{{ __('Submit') }}
                                    </button>
                                </div>
                            </div>

                            @include('frontend::pay_bill.include.passcode-modal')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('frontend::pay_bill.include.bill_script')
@endsection

