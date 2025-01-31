@extends('frontend::layouts.user')
@section('title')
    {{ __('Deposit Now') }}
@endsection
@section('content')
    <form action="{{ route('user.deposit.now') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="site-card">
                    <div class="site-card-header">
                        <div class="title">{{ __('Add Money') }}</div>
                        <div class="card-header-links">
                            <a href="{{ route('user.deposit.log') }}" class="card-header-link"><i data-lucide="alert-circle"></i>Deposit History</a>
                        </div>
                    </div>
                    <div class="site-card-body">
                        <div class="step-details-form mb-4">
                            <form action="#">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="inputs">
                                            <label for="" class="input-label">{{ __('Select Gateway') }}<span class="required">*</span></label>
                                            <select name="gateway_code" class="box-input deposit-methods" id="gatewaySelect">
                                                <option value="" disabled selected>--{{ __('Select Gateway') }}--</option>
                                                @foreach ($gateways as $gateway)
                                                    <option data-logo="{{ asset($gateway->logo) }}" value="{{ $gateway->gateway_code }}">{{ $gateway->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-info-text charge"></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="inputs">
                                            <label for="" class="input-label">{{ __('Enter Amount:') }}<span class="required">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="amount" id="amount" required>
                                                <span class="input-group-text" id="basic-addon1">{{ $currency }}</span>
                                            </div>
                                            <div class="input-info-text min-max"></div>
                                        </div>
                                    </div>

                                    <div class="row manual-row">

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="site-card">
                            <div class="site-card-header">
                                <div class="title-small">{{ __('Review Details:') }}</div>
                            </div>
                            <div class="site-card-body p-0 overflow-x-auto">
                                <div class="site-custom-table site-custom-table-sm">
                                    <div class="contents">
                                        <div class="site-table-list">
                                            <div class="site-table-col">
                                                <div class="trx fw-bold">{{ __('Amount:') }}</div>
                                            </div>
                                            <div class="site-table-col">
                                                <div class="fw-bold amount"> <span class="currency"></span></div>
                                            </div>
                                        </div>
                                        <div class="site-table-list">
                                            <div class="site-table-col">
                                                <div class="trx fw-bold">{{ __('Charge:') }}</div>
                                            </div>
                                            <div class="site-table-col">
                                                <div class="red-color fw-bold charge2"></div>
                                            </div>
                                        </div>
                                        <div class="site-table-list">
                                            <div class="site-table-col">
                                                <div class="trx fw-bold">{{ __('Payment Method:') }}</div>
                                            </div>
                                            <div class="site-table-col">
                                                <div class="fw-bold method"></div>
                                            </div>
                                        </div>
                                        <div class="site-table-list">
                                            <div class="site-table-col">
                                                <div class="trx fw-bold">{{ __('Payment Method Logo') }}:</div>
                                            </div>
                                            <div class="site-table-col">
                                                <div class="fw-bold" id="logo"><img class="table-icon" src="" alt=""></div>
                                            </div>
                                        </div>
                                        <div class="site-table-list">
                                            <div class="site-table-col">
                                                <div class="fw-bold">{{ __('Conversion Rate') }}:</div>
                                            </div>
                                            <div class="site-table-col">
                                                <div class="fw-bold conversion-rate"></div>
                                            </div>
                                        </div>
                                        <div class="site-table-list">
                                            <div class="site-table-col">
                                                <div class="trx fw-bold">{{ __('Total') }}:</div>
                                            </div>
                                            <div class="site-table-col">
                                                <div class="fw-bold total"></div>
                                            </div>
                                        </div>
                                        <div class="site-table-list">
                                            <div class="site-table-col">
                                                <div class="trx fw-bold">{{ __('Payable Amount') }}:</div>
                                            </div>
                                            <div class="site-table-col">
                                                <div class="fw-bold pay-amount"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button
                            @if(auth()->user()->passcode !== null && setting('deposit_passcode_status'))
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#passcode"
                            @else
                            type="submit"
                            @endif
                            class="site-btn polis-btn"
                        >
                            {{ __('Proceed to payment') }}
                        </button>
                    </div>
                </div>
                @if(auth()->user()->passcode !== null && setting('deposit_passcode_status'))
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
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script>
        "use strict"

        // Select 2 activation
        function formatState(state) {
            if (!state.id) {
                return state.text;
            }

            var $state = $(
                '<span><img src="' + $(state.element).data('logo') + '" class="img-icon" /> ' + state.text + '</span>'
            );

            return $state;
        };

        $('.deposit-methods').select2({
            templateResult: formatState,
            templateSelection : formatState,
            minimumResultsForSearch: Infinity,
        });

        var globalData;
        var currency = @json($currency)

        $("#gatewaySelect").on('change', function (e) {
            "use strict"
            e.preventDefault();
            $('.manual-row').empty();
            var code = $(this).val()
            var url = '{{ route("user.deposit.gateway",":code") }}';
            url = url.replace(':code', code);
            $.get(url, function (data) {

                globalData = data;

                if (data.currency === currency){
                    $('.conversion').addClass('hidden');
                }else {
                    $('.conversion').removeClass('hidden');
                }

                $('.charge').text('Charge ' + data.charge + ' ' + (data.charge_type === 'percentage' ? ' % ' : currency))
                $('.conversion-rate').text('1' +' '+ currency + ' = ' + data.rate +' '+ data.currency)

                $('.method').html('<span class="type site-badge badge-primary">'+data.name+'</span>')
                $('.min-max').text('Minimum ' + data.minimum_deposit + ' ' + currency + ' and ' + 'Maximum ' + data.maximum_deposit + ' ' + currency)
                $('#logo').html(`<img class="table-icon" src='${data.gateway_logo}'>`);
                var amount = $('#amount').val()

                if (Number(amount) > 0) {
                    $('.amount').text((Number(amount)))
                    var charge = data.charge_type === 'percentage' ? calPercentage(amount, data.charge) : data.charge
                    $('.charge2').text(charge + ' ' + currency)
                    $('.total').text((Number(amount) + Number(charge)) + ' ' + currency)
                }

                if (data.credentials !== undefined) {
                    $('.manual-row').append(data.credentials)
                    imagePreview()
                }

            });

            $('#amount').on('keyup', function (e) {
                "use strict"
                var amount = $(this).val()
                $('.amount').text((Number(amount)))
                $('.currency').text(currency)

                var charge = globalData.charge_type === 'percentage' ? calPercentage(amount, globalData.charge) : globalData.charge
                $('.charge2').text(charge + ' ' + currency)

                var total = (Number(amount) + Number(charge));

                $('.total').text(total + ' ' + currency)
                var payTotal = total * globalData.rate +' '+ globalData.currency;
                $('.pay-amount').text(payTotal)
            })


        });
    </script>
@endsection
