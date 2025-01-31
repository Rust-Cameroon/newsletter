@extends('frontend::layouts.user')
@section('title')
    {{ __('Schema Preview') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="title">{{ __('Checkout') }}</h3>
                </div>
                <div class="site-card-body">
                    <div class="step-details-form">
                        <form action="{{ route('ipn.non-hosted.securionpay') }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-xl-12 col-md-12">
                                    <div class="inputs">
                                        <div class="input-icon"><i data-lucide="credit-card"></i></div>
                                        <input name="card_number" onkeypress="return validateNumber(event)" type="text"
                                               class="form-control" placeholder="Card Number" aria-label="Amount"
                                               aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12">
                                    <div class="inputs">
                                        <div class="input-icon"><i data-lucide="calendar"></i></div>
                                        <input name="card_date" type="text" class="form-control" id="cardDate"
                                               onkeypress="return validateNumber(event)" placeholder="MM/YY"
                                               aria-label="Amount" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12">
                                    <div class="inputs">
                                        <div class="input-icon"><i data-lucide="binary"></i></div>
                                        <input name="card-number" type="text" onkeypress="return validateNumber(event)"
                                               class="form-control" placeholder="CVC" aria-label="Amount"
                                               aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                            <div class="buttons">
                                <button type="submit"
                                        class="site-btn blue-btn w-100 centered">{{ __('Pay') }} {{ $amountInfo }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $("#cardDate").keyup(function () {
            if ($(this).val().length == 2) {
                $(this).val($(this).val() + "/");
            }
        });
    </script>
@endsection


