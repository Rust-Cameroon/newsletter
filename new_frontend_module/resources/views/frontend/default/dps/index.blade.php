@extends('frontend::layouts.user')
@section('title')
    {{ __('DPS') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title">{{ __('DPS Plans') }}</div>
                    <div class="card-header-links">
                        <a href="{{ route('user.dps.history') }}" class="card-header-link"><i data-lucide="archive"></i>{{ __('My DPS') }}</a>
                    </div>
                </div>
                <div class="site-card-body">
                    <div class="row">
                        @foreach($plans as $plan)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                <div class="plan-card-box">
                                    @if($plan->featured)
                                    <div class="plan-card-badge">{{ $plan->badge }}</div>
                                    @endif
                                    <div class="name">{{ __($plan->name) }}</div>
                                    <div class="amount">{{ setting('currency_symbol', 'global') }}{{ $plan->per_installment }}<span>/ {{ $plan->interval }} {{ __('Days') }}</span></div>
                                    <div class="list">
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('Interest Rate') }}</div>
                                            <div>{{ $plan->interest_rate }}%</div>
                                        </div>
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('Number of Installments') }}</div>
                                            <div>{{ $plan->total_installment }}</div>
                                        </div>
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('Per Installment') }}</div>
                                            <div>{{ $plan->per_installment }} {{ $currency }}</div>
                                        </div>
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('Installment Slice') }}</div>
                                            <div>{{ $plan->interval }} {{ __('Days') }}</div>
                                        </div>
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('All Deposits') }}</div>
                                            <div>{{ $plan->total_deposit }} {{ $currency }}</div>
                                        </div>
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('Final Maturity') }}</div>
                                            <div>{{ $plan->total_mature_amount }} {{ $currency }}</div>
                                        </div>
                                    </div>
                                    <a href=""
                                       class="site-btn-sm black-btn me-2 subscribeBtn"
                                       type="button"
                                       data-name="{{ $plan->name }}"
                                       data-installment="{{ $plan->per_installment }}"
                                       data-interest="{{ $plan->interest_rate }}"
                                       data-installment_number="{{ $plan->total_installment }}"
                                       data-pay="{{ $plan->total_deposit }}"
                                       data-mature="{{ $plan->total_mature_amount }}"
                                       data-id="{{ $plan->id }}"
                                       data-bs-toggle="modal"
                                       data-bs-target="#dpsSubPreBox">
                                        <i data-lucide="check"></i>
                                        {{ __('Subscribe Now') }}
                                    </a>
                                    <a href=""
                                       class="site-btn-sm blue-btn me-2 detailsBtn"
                                       type="button"
                                       data-name="{{ $plan->name }}"
                                       data-installment="{{ $plan->per_installment }}"
                                       data-interest="{{ $plan->interest_rate }}"
                                       data-installment_number="{{ $plan->total_installment }}"
                                       data-pay="{{ $plan->total_deposit }}"
                                       data-mature="{{ $plan->total_mature_amount }}"
                                       data-maturity-fee-status="{{ $plan->add_maturity_platform_fee ? 'Yes' : 'No' }}"
                                       data-maturity-fee="{{ $plan->maturity_platform_fee }} {{ $currency }}"
                                       data-can-cancel="{{ $plan->can_cancel ? 'Yes' : 'No' }}"
                                       data-cancel-fee="{{ $plan->cancel_fee }} {{ $currency }}"
                                       data-cancel-in="{{ $plan->cancel_type == 'anytime' ? 'Anytime' : $plan->cancel_days.' Days' }}"
                                       data-increase="{{ $plan->is_upgrade ? 'Yes' : 'No' }}"
                                       data-increase-charge="{{ $plan->increment_type ? $plan->increment_fee.' '.$currency : 'No' }}"
                                       data-increase-limit="{{ $plan->increment_type == 'unlimited' ? 'Unlimited' : $plan->increment_times.' Times' }}"
                                       data-min-increase-amount="{{ $plan->min_increment_amount }} {{ $currency }}"
                                       data-max-increase-amount="{{ $plan->max_increment_amount }} {{ $currency }}"
                                       data-decrease="{{ $plan->is_downgrade ? 'Yes' : 'No'  }}"
                                       data-decrease-charge="{{ $plan->decrement_type ? $plan->decrement_fee.' '.$currency : 'No' }}"
                                       data-decrease-limit="{{ $plan->decrement_type == 'unlimited' ? 'Unlimited' : $plan->decrement_times.' Times' }}"
                                       data-min-decrease-amount="{{ $plan->min_decrement_amount }} {{ $currency }}"
                                       data-max-decrease-amount="{{ $plan->max_decrement_amount }} {{ $currency }}"
                                       data-id="{{ $plan->id }}"
                                       data-bs-toggle="modal"
                                       data-bs-target="#dpsDetails">
                                        <i data-lucide="eye"></i>
                                        {{ __('Details') }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Modal for dpsSubPreBox-->
                    <div class="modal fade" id="dpsSubPreBox" tabindex="-1" aria-labelledby="dpsSubPreBoxModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content site-table-modal">
                                <div class="modal-body popup-body">
                                    <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-lucide="x"></i></button>
                                    <div class="popup-body-text">
                                        <div class="title" id="dps-title"></div>
                                        <div class="modal-beneficiary-details">
                                            <div class="profile-text-data">
                                                <div class="attribute">{{ __('Per Installment') }}</div>
                                                <div class="value installment"></div>
                                            </div>
                                            <div class="profile-text-data">
                                                <div class="attribute">{{ __('Interest Rate') }}</div>
                                                <div class="value interest"></div>
                                            </div>
                                            <div class="profile-text-data">
                                                <div class="attribute">{{ __('Number of Installments') }}</div>
                                                <div class="value installment_number"></div>
                                            </div>
                                            <div class="profile-text-data">
                                                <div class="attribute">{{ __('All you pay') }}</div>
                                                <div class="value pay"></div>
                                            </div>
                                            <div class="profile-text-data">
                                                <div class="attribute">{{ __('You will get') }}</div>
                                                <div class="value mature"></div>
                                            </div>
                                        </div>
                                        <div class="action-btns mt-3">
                                            <a
                                                href=""
                                                @class([
                                                    'site-btn-sm polis-btn me-2 w-100',
                                                    'applyBtn' => auth()->user()->passcode == null || !setting('dps_passcode_status')
                                                ])
                                                @if(auth()->user()->passcode !== null && setting('dps_passcode_status'))
                                                data-bs-toggle="modal"
                                                data-bs-target="#passcode"
                                                @endif
                                                >
                                                <i data-lucide="check"></i>
                                                {{ __('Subscribe Now') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal for dpsSubPreBox end-->

                    <!-- Modal for DPS Details-->
                    <div class="modal fade" id="dpsDetails" tabindex="-1" aria-labelledby="dpsDetailsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content site-table-modal">
                                <div class="modal-body popup-body">
                                    <button type="button" class="modal-btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"><i data-lucide="x"></i>
                                    </button>
                                    <div class="popup-body-text">
                                        <div class="title" id="details-title"></div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="modal-beneficiary-details">

                                                    <div class="profile-text-data">
                                                        <div class="attribute">{{ __('Per Installment') }}</div>
                                                        <div class="value installment-value"></div>
                                                    </div>
                                                    <div class="profile-text-data">
                                                        <div class="attribute">{{ __('Interest Rate') }}</div>
                                                        <div class="value interest-value"></div>
                                                    </div>
                                                    <div class="profile-text-data">
                                                        <div class="attribute">{{ __('Number of Installments') }}</div>
                                                        <div class="value installment-number-value"></div>
                                                    </div>
                                                    <div class="profile-text-data">
                                                        <div class="attribute">{{ __('All you pay') }}</div>
                                                        <div class="value pay-value"></div>
                                                    </div>
                                                    <div class="profile-text-data">
                                                        <div class="attribute">{{ __('You will get') }}</div>
                                                        <div class="value mature-value"></div>
                                                    </div>
                                                    <div class="cancel-in-area">
                                                        <div class="profile-text-data">
                                                            <div class="attribute">{{ __('Cancel In') }}</div>
                                                            <div class="value cancel-in-value"></div>
                                                        </div>
                                                        <div class="profile-text-data">
                                                            <div class="attribute">{{ __('Cancel Fee') }}</div>
                                                            <div class="value cancel-charge-value"></div>
                                                        </div>
                                                    </div>
                                                    <div class="profile-text-data maturity-area">
                                                        <div class="attribute">{{ __('Maturity Fee') }}</div>
                                                        <div class="value maturity-fee-value"></div>
                                                    </div>

                                                    <div class="increase-details-area">
                                                        <div class="profile-text-data">
                                                            <div class="attribute">{{ __('Increase') }}</div>
                                                            <div class="value increase-value"></div>
                                                        </div>
                                                        <div class="profile-text-data">
                                                            <div class="attribute">{{ __('Increase Charge') }}</div>
                                                            <div class="value increase-charge-value"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="modal-beneficiary-details">
                                                    <div class="increase-details-area">
                                                        <div class="profile-text-data">
                                                            <div class="attribute">{{ __('Increase Limit') }}</div>
                                                            <div class="value increase-limit-value"></div>
                                                        </div>
                                                        <div class="profile-text-data">
                                                            <div class="attribute">{{ __('Min Increase Amount') }}</div>
                                                            <div class="value min-increase-amount-value"></div>
                                                        </div>
                                                        <div class="profile-text-data">
                                                            <div class="attribute">{{ __('Max Increase Amount') }}</div>
                                                            <div class="value max-increase-amount-value"></div>
                                                        </div>
                                                    </div>
                                                    <div class="decrease-details-area">
                                                        <div class="profile-text-data">
                                                            <div class="attribute">{{ __('Decrease') }}</div>
                                                            <div class="value decrease-value"></div>
                                                        </div>
                                                        <div class="profile-text-data">
                                                            <div class="attribute">{{ __('Decrease Charge') }}</div>
                                                            <div class="value decrease-charge-value"></div>
                                                        </div>
                                                        <div class="profile-text-data">
                                                            <div class="attribute">{{ __('Decrease Limit') }}</div>
                                                            <div class="value decrease-limit-value"></div>
                                                        </div>
                                                        <div class="profile-text-data">
                                                            <div class="attribute">{{ __('Min Decrease Amount') }}</div>
                                                            <div class="value min-decrease-amount-value"></div>
                                                        </div>
                                                        <div class="profile-text-data">
                                                            <div class="attribute">{{ __('Max Decrease Amount') }}</div>
                                                            <div class="value max-decrease-amount-value"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="action-btns mt-3">
                                            <button type="button"  data-bs-dismiss="modal"
                                            aria-label="Close" class="site-btn-sm polis-btn me-2 w-100 applyBtn">
                                                <i data-lucide="check"></i>
                                                {{ __('Got It') }}
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal for DPS Details end-->

                    @if(auth()->user()->passcode !== null && setting('dps_passcode_status'))
                    <div class="modal fade" id="passcode" tabindex="-1" aria-labelledby="passcodeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content site-table-modal">
                                <div class="modal-body popup-body">
                                    <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-lucide="x"></i>
                                    </button>
                                    <div class="popup-body-text">
                                        <div class="title">{{ __('Confirm Your Passcode') }}</div>
                                        <form action="" method="get" id="applyForm">
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
                                                <button type="submit" class="site-btn-sm primary-btn me-2 applyBtn">
                                                    <i data-lucide="check"></i>
                                                    {{ __('Confirm') }}
                                                </button>
                                                <button type="button" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
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
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            "use strict"

            const currency = @json($currency)

            // Click Subscribe Btn
            $(document).on('click', '.subscribeBtn', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                var name = $(this).data('name');
                var installment = $(this).data('installment');
                var interest = $(this).data('interest');
                var installment_number = $(this).data('installment_number');
                var pay = $(this).data('pay');
                var mature = $(this).data('mature');

                $('#dps-title').text(name)
                $('.installment').text(installment + ' ' +currency)
                $('.interest').text(interest +'%')
                $('.installment_number').text(installment_number)
                $('.pay').text(pay + ' ' +currency)
                $('.mature').text(mature + ' ' +currency)

                var url = "{{ route('user.dps.subscribe', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $('.applyBtn').attr('href', url);
                $('#applyForm').attr('action',url);
            });

            $(document).on('click', '.detailsBtn', function (e) {
                e.preventDefault();

                var name = $(this).data('name');
                var installment = $(this).data('installment');
                var interest = $(this).data('interest');
                var installment_number = $(this).data('installment_number');
                var pay = $(this).data('pay');
                var mature = $(this).data('mature');

                var period = $(this).data('period');
                var every_profit = $(this).data('every-profit');
                var profit_rate = $(this).data('profit-rate');
                var min_amount = $(this).data('min-amount');
                var max_amount = $(this).data('max-amount');
                var compounding = $(this).data('compounding');
                var can_cancel = $(this).data('can-cancel');
                var cancel_in = $(this).data('cancel-in');
                var cancel_fee = $(this).data('cancel-fee');

                var increase = $(this).data('increase');
                var increase_charge = $(this).data('increase-charge');
                var increase_limit = $(this).data('increase-limit');
                var min_increase_amount = $(this).data('min-increase-amount');
                var max_increase_amount = $(this).data('max-increase-amount');

                var decrease = $(this).data('decrease');
                var decrease_charge = $(this).data('decrease-charge');
                var decrease_limit = $(this).data('decrease-limit');
                var min_decrease_amount = $(this).data('min-decrease-amount');
                var max_decrease_amount = $(this).data('max-decrease-amount');
                var is_maturity_fee = $(this).data('maturity-fee-status');
                var maturity_fee = $(this).data('maturity-fee');

                if(is_maturity_fee == 'Yes'){
                    $('.maturity-fee-value').text(maturity_fee);
                    $('.maturity-area').show();
                }else{
                    $('.maturity-fee-value').text(maturity_fee);
                    $('.maturity-area').hide();
                }

                $('#details-title').text(name);
                $('.installment-value').text(installment + ' ' +currency);
                $('.interest-value').text(interest +'%');
                $('.installment-number-value').text(installment_number);
                $('.pay-value').text(pay + ' ' +currency);
                $('.mature-value').text(mature + ' ' +currency);

                if(can_cancel == 'Yes'){
                    $('.cancel-in-value').text(cancel_in);
                    $('.cancel-charge-value').text(cancel_fee);
                    $('.cancel-in-area').show();
                }else{
                    $('.cancel-in-value').text(cancel_in);
                    $('.cancel-charge-value').text(cancel_fee);
                    $('.cancel-in-area').hide();
                }

                if(increase == 'Yes'){
                    $('.increase-details-area').show();
                    $('.increase-value').text(increase);
                    $('.increase-charge-value').text(increase_charge);
                    $('.increase-limit-value').text(increase_limit);
                    $('.min-increase-amount-value').text(min_increase_amount);
                    $('.max-increase-amount-value').text(max_increase_amount);
                }else{
                    $('.increase-details-area').hide();
                }

                if(decrease == 'Yes'){
                    $('.decrease-details-area').show();
                    $('.decrease-value').text(decrease);
                    $('.decrease-charge-value').text(decrease_charge);
                    $('.decrease-limit-value').text(decrease_limit);
                    $('.min-decrease-amount-value').text(min_decrease_amount);
                    $('.max-decrease-amount-value').text(max_decrease_amount);
                }else{
                    $('.decrease-details-area').hide();
                }

                $('#fdrDetails').modal('show');
            });
        })
    </script>
@endsection
