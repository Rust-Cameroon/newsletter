@extends('frontend::layouts.user')
@section('title')
    {{ __('Fund Transfer') }}
@endsection
@section('content')
    <div class="row">
        @include('frontend::fund_transfer.include.__header')

        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title">{{ __('Fund Transfer') }}</div>
                    <div class="card-header-links">
                        <a href="#" class="card-header-link" data-bs-toggle="modal" data-bs-target="#addBox"><i
                                data-lucide="plus-circle"></i>{{ __('Add Beneficiary') }}</a>
                    </div>
                </div>
                <form action="{{ route('user.fund_transfer.transfer') }}" method="POST">
                    @csrf
                    <div class="site-card-body">
                        <div class="step-details-form mb-4">

                            <div class="row">
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Select Bank') }}<span class="required">*</span></label>
                                        <select name="bank_id" class="box-input select2-basic-active" id="bankId">
                                            <option value="" disabled selected>--{{ __('Select Bank') }}--</option>
                                            <option value="0">{{ __('Own Bank') }}</option>
                                            @foreach($banks as $bank)
                                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-info-text charge"></div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Select Beneficiary') }} </label>
                                        <select name="beneficiary_id" class="box-input select2-basic-active"
                                                id="beneficiaryId">
                                            <option value="" selected>--{{ __('Beneficiary') }}--</option>
                                        </select>
                                        <div class="input-info-text transfer"></div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-6 custom-fields">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Account Number') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="account_number" name="manual_data[account_number]">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Enter Amount') }}<span
                                                class="required">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="amount" name="amount">
                                            <span class="input-group-text">{{ setting('site_currency', 'global') }}</span>
                                        </div>
                                        <div class="input-info-text min-max"></div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-6 custom-fields">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Name on account') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="account_name" name="manual_data[account_name]">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-6 custom-fields">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Branch Name') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="branch_name" name="manual_data[branch_name]">
                                        </div>
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
                        <div class="site-card">
                            <div class="site-card-header">
                                <div class="title-small">{{ __('Transfer Review Details:') }}</div>
                            </div>
                            <div class="site-card-body p-0 overflow-x-auto">
                                <div class="site-custom-table site-custom-table-sm">
                                    <div class="contents">
                                        <div class="site-table-list">
                                            <div class="site-table-col">
                                                <div class="trx fw-bold">{{ __('Amount:') }}</div>
                                            </div>
                                            <div class="site-table-col">
                                                <div class="fw-bold amount"><span class="currency"></span></div>
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
                                                <div class="trx fw-bold">{{ __('Bank Name:') }}</div>
                                            </div>
                                            <div class="site-table-col">
                                                <div class="fw-bold"><span
                                                        class="type site-badge badge-primary bank_name"></span></div>
                                            </div>
                                        </div>
                                        <div class="site-table-list" id="logo_sec">
                                            <div class="site-table-col">
                                                <div class="trx fw-bold">{{ __('Bank Logo:') }}</div>
                                            </div>
                                            <div class="site-table-col">
                                                <div class="fw-bold" id="logo"><img class="table-icon" src="" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="site-table-list">
                                            <div class="site-table-col">
                                                <div class="trx fw-bold">{{ __('Total:') }}</div>
                                            </div>
                                            <div class="site-table-col">
                                                <div class="fw-bold total"></div>
                                            </div>
                                        </div>
                                        <div class="site-table-list">
                                            <div class="site-table-col">
                                                <div class="trx fw-bold">{{ __('Transferable Amount:') }}</div>
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
                        @if(auth()->user()->passcode !== null && setting('fund_transfer_passcode_status'))
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#passcode"
                        @else
                        type="submit"
                        @endif
                        class="site-btn polis-btn"
                        >
                            <i data-lucide="send"></i> {{ __('Transfer the fund') }}
                        </button>
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
        <!-- Modal for Add beneficiary-->
        @include('frontend::fund_transfer.include.__add_beneficiary')
        <!-- Modal for Add beneficiary end-->
    </div>
@endsection
@section('script')

    <script>
        $(document).ready(function () {
            "use strict"

            var currency = @json($currency);

            $('#account_number').on('input',function(){
                $.ajax({
                    type: 'GET',
                    url: '/user/search-by-account-number/'+$(this).val(),
                    success: function (data) {
                        $('#account_name').val(data.name);
                        $('#branch_name').val(data.branch_name);
                    },
                    error: function(error){
                        $('#account_name').val('');
                        $('#branch_name').val('');
                    }
                });
            });

            // Select 2 activation
            $('#bank_id').select2({
                dropdownParent: $('#addBox')
            });

            $('.select2-basic-active').select2({
                minimumResultsForSearch: Infinity,
            });

            // show/hide custom fields
            $('#beneficiaryId').on('change',function(){
                customFieldsVisibility();
            });

            function customFieldsVisibility(){
                let fields = $('.custom-fields');
                if($('#beneficiaryId').val() != ''){
                    fields.hide();
                }else{
                    fields.show();
                }
            }

            // nice select
            $('.add-beneficiary').niceSelect();
            $('.edit-beneficiary').niceSelect();

            // own bank select event
            $("#bank_name").on('change', function (e) {

                if ($(this).val() == null) {
                    $('#branch_name_sec').hide();
                } else {
                    $('#branch_name_sec').show();
                }
            })
            var globalData;
            //select bank
            $('#bankId').change(function () {
                const selectedBankId = $(this).val();
                $('.charge').text('');
                $('.min-max').text('');
                $('.transfer').text('');
                $.ajax({
                    type: 'GET',
                    url: '/user/fund-transfer/beneficiary/' + selectedBankId,
                    success: function (data) {
                        // Clear existing options
                        $('#beneficiaryId').empty();
                        // Add new options based on the retrieved data
                        globalData = data.banksData;
                        $('#beneficiaryId').append('<option value="" selected>--{{ __('Beneficiary') }}--</option>');
                        $.each(data.beneficiaries, function (key, beneficiary) {
                            let accountNumber = beneficiary.account_number;
                            $('#beneficiaryId').append('<option value="' + beneficiary.id + '">' + beneficiary.account_name + ' **** ' + accountNumber.slice(-4) + '</option>');
                        });
                        if(selectedBankId != 0){
                            $('.bank_name').text(data.banksData.name);
                            var img = '<img class="table-icon" src="../assets/' + data.banksData.logo + '">'
                            $('#logo').html(img);
                            $('.charge').text('Charge ' + data.banksData.charge + ' ' + (data.banksData.charge_type === 'percentage' ? ' % ' : currency))
                            $('.min-max').text('Minimum ' + data.banksData.minimum_transfer + ' ' + currency + ' and ' + 'Maximum ' + data.banksData.maximum_transfer + ' ' + currency)
                            $('.transfer').text('Transfer in: ' + data.banksData.processing_time + ' ' + data.banksData.processing_type)
                        }else{
                            $('.bank_name').text('Own Bank');
                            $("#logo_sec").hide();
                        }
                        customFieldsVisibility();
                    },
                    error: function (error) {
                        console.error('Error fetching beneficiaries:', error);
                        customFieldsVisibility();
                    }
                });

            })

            //amount on key up
            $('#amount').on('keyup', function (e) {
                var amount = $(this).val();
                $('.amount').text((Number(amount) + ' ' + currency))
                $('.currency').text(currency)
                var charge = globalData.charge_type === 'percentage' ? calPercentage(amount, globalData.charge) : globalData.charge
                $('.charge2').text(charge + ' ' + currency)
                var total = (Number(amount) + Number(charge));
                $('.total').text(total + ' ' + currency)
                var payTotal = (Number(amount) + Number(charge));
                $('.pay-amount').text(payTotal + ' ' + currency);
            });
        })

    </script>
@endsection
