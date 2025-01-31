@extends('frontend::layouts.user')
@section('title')
    {{ __('FDR') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title">{{ __('FDR Plans') }}</div>
                    <div class="card-header-links">
                        <a href="{{ route('user.fdr.history') }}" class="card-header-link"><i
                                data-lucide="archive"></i>{{ __('My FDR') }}</a>
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
                                    <div class="amount">{{ $plan->interest_rate }}%<span>/ {{ $plan->intervel }} {{ __('Days') }}</span></div>
                                    <div class="list">
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('Lock In Period') }}
                                            </div>
                                            <div>{{ $plan->locked }} {{ __('Days') }}</div>
                                        </div>
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('Get Profit Every') }}
                                            </div>
                                            <div>{{ $plan->intervel }} {{ __('Days') }}</div>
                                        </div>
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('Profit Rate') }}
                                            </div>
                                            <div>{{ $plan->interest_rate }}{{ __('%') }}</div>
                                        </div>
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('Minimum FDR') }}</div>
                                            <div>{{ $plan->minimum_amount }} {{ $currency }}</div>
                                        </div>
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('Maximum FDR') }}</div>
                                            <div>{{ $plan->maximum_amount }} {{ $currency }}</div>
                                        </div>
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('Compounding') }}</div>
                                            <div>{{ $plan->is_compounding ? "Yes" : 'No' }}</div>
                                        </div>
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('Cancel In') }}</div>
                                            <div>{{ $plan->cancel_type == 'anytime' ? 'Anytime' : $plan->cancel_days.' Days' }}</div>
                                        </div>

                                    </div>
                                    <a href="#"
                                       class="site-btn-sm black-btn subscribeBtn me-2"
                                       type="button"
                                       data-name="{{ $plan->name }}"
                                       data-min="{{ $plan->minimum_amount }}"
                                       data-max="{{ $plan->maximum_amount }}"
                                       data-id="{{ encrypt($plan->id) }}"
                                       data-bs-toggle="modal"
                                       data-bs-target="#dpsSubPreBox">
                                        <i data-lucide="check"></i>
                                        {{ __('Subscribe Now') }}
                                    </a>
                                    <a href="#"
                                       class="site-btn-sm blue-btn detailsBtn"
                                       type="button"
                                       data-name="{{ $plan->name }}"
                                       data-can-cancel="{{ $plan->can_cancel ? 'Yes' : 'No' }}"
                                       data-period="{{ $plan->locked }} {{ __('Days') }}"
                                       data-every-profit="{{ $plan->intervel }} {{ __('Days') }}"
                                       data-profit-rate="{{ $plan->interest_rate }} {{ __('%') }}"
                                       data-min-amount="{{ $plan->minimum_amount }} {{ $currency }}"
                                       data-max-amount="{{ $plan->maximum_amount }} {{ $currency }}"
                                       data-compounding="{{ $plan->is_compounding ? "Yes" : 'No' }}"
                                       data-maturity-fee-status="{{ $plan->add_maturity_platform_fee ? 'Yes' : 'No' }}"
                                       data-maturity-fee="{{ $plan->maturity_platform_fee }} {{ $currency }}"
                                       data-cancel-in="{{ $plan->cancel_type == 'anytime' ? 'Anytime' : $plan->cancel_days.' Days' }}"
                                       data-cancel-charge="{{ $plan->cancel_fee }} {{ $currency }}"
                                       data-increase="{{ $plan->is_add_fund_fdr ? 'Yes' : 'No' }}"
                                       data-increase-charge="{{ $plan->increment_type ? $plan->increment_fee.' '.$currency : 'No' }}"
                                       data-increase-limit="{{ $plan->increment_type == 'unlimited' ? 'Unlimited' : $plan->increment_times.' Times' }}"
                                       data-min-increase-amount="{{ $plan->min_increment_amount }} {{ $currency }}"
                                       data-max-increase-amount="{{ $plan->max_increment_amount }} {{ $currency }}"
                                       data-decrease="{{ $plan->is_deduct_fund_fdr ? 'Yes' : 'No'  }}"
                                       data-decrease-charge="{{ $plan->decrement_type ? $plan->decrement_fee.' '.$currency : 'No' }}"
                                       data-decrease-limit="{{ $plan->decrement_type == 'unlimited' ? 'Unlimited' : $plan->decrement_times.' Times' }}"
                                       data-min-decrease-amount="{{ $plan->min_decrement_amount }} {{ $currency }}"
                                       data-max-decrease-amount="{{ $plan->max_decrement_amount }} {{ $currency }}"
                                       data-id="{{ encrypt($plan->id) }}"
                                    >
                                        <i data-lucide="eye"></i>
                                        {{ __('Details') }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Modal for dpsSubPreBox-->
                    <form action="{{ route('user.fdr.subscribe') }}" method="POST">
                        @csrf
                        <div class="modal fade" id="dpsSubPreBox" tabindex="-1" aria-labelledby="dpsSubPreBoxModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                                <div class="modal-content site-table-modal">
                                    <div class="modal-body popup-body">
                                        <button type="button" class="modal-btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"><i data-lucide="x"></i>
                                        </button>
                                        <div class="popup-body-text">
                                            <input type="hidden" name="fdr_id" id="fdr_id">
                                            <div class="title" id="name"></div>
                                            <div class="step-details-form">
                                                <div class="inputs">
                                                    <label for="" class="input-label">{{ __('Enter Amount') }}<span
                                                            class="required">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="amount">
                                                        <span class="input-group-text">{{ $currency }}</span>
                                                    </div>
                                                    <div class="input-info-text min-max"></div>
                                                </div>
                                            </div>

                                            <div class="action-btns mt-3">
                                                <button
                                                @if(auth()->user()->passcode !== null && setting('fdr_passcode_status'))
                                                type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#passcode"
                                                @else
                                                type="submit"
                                                @endif
                                                class="site-btn-sm polis-btn me-2 w-100 applyBtn"
                                                >
                                                    <i data-lucide="check"></i>
                                                    {{ __('Apply Now') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(auth()->user()->passcode !== null && setting('fdr_passcode_status'))
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

                    <!-- Modal for dpsSubPreBox end-->

                    <!-- Modal for FDR Details-->
                    <div class="modal fade" id="fdrDetails" tabindex="-1" aria-labelledby="fdrDetailsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content site-table-modal">
                                <div class="modal-body popup-body">
                                    <button type="button" class="modal-btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"><i data-lucide="x"></i>
                                    </button>
                                    <div class="popup-body-text">
                                        <div class="title" id="details-name"></div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="modal-beneficiary-details">
                                                    <div class="profile-text-data">
                                                        <div class="attribute">{{ __('Lock In Period') }}</div>
                                                        <div class="value period-value"></div>
                                                    </div>
                                                    <div class="profile-text-data">
                                                        <div class="attribute">{{ __('Get Profit Every') }}</div>
                                                        <div class="value every-profit-value"></div>
                                                    </div>
                                                    <div class="profile-text-data">
                                                        <div class="attribute">{{ __('Profit Rate') }}</div>
                                                        <div class="value profit-rate-value"></div>
                                                    </div>
                                                    <div class="profile-text-data">
                                                        <div class="attribute">{{ __('Minimum FDR') }}</div>
                                                        <div class="value min-fdr-value"></div>
                                                    </div>
                                                    <div class="profile-text-data">
                                                        <div class="attribute">{{ __('Maximum FDR') }}</div>
                                                        <div class="value max-fdr-value"></div>
                                                    </div>
                                                    <div class="profile-text-data">
                                                        <div class="attribute">{{ __('Compounding') }}</div>
                                                        <div class="value compounding-value"></div>
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
                    <!-- Modal for FDR Details end-->
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
                var min = $(this).data('min');
                var max = $(this).data('max');

                $('#name').text(name);

                var message = `Minimum ${min} ${currency} and Maximum ${max} ${currency}`;

                $('.min-max').text(message);

                $('#fdr_id').val(id);
            });

            $(document).on('click', '.detailsBtn', function (e) {
                e.preventDefault();

                var name = $(this).data('name');

                var period = $(this).data('period');
                var every_profit = $(this).data('every-profit');
                var profit_rate = $(this).data('profit-rate');
                var min_amount = $(this).data('min-amount');
                var max_amount = $(this).data('max-amount');
                var compounding = $(this).data('compounding');
                var can_cancel = $(this).data('can-cancel');
                var cancel_fee = $(this).data('cancel-charge');
                var cancel_in = $(this).data('cancel-in');
                var is_maturity_fee = $(this).data('maturity-fee-status');
                var maturity_fee = $(this).data('maturity-fee');

                if(is_maturity_fee == 'Yes'){
                    $('.maturity-fee-value').text(maturity_fee);
                    $('.maturity-area').show();
                }else{
                    $('.maturity-fee-value').text(maturity_fee);
                    $('.maturity-area').hide();
                }

                if(can_cancel == 'Yes'){
                    $('.cancel-in-value').text(cancel_in);
                    $('.cancel-charge-value').text(cancel_fee);
                    $('.cancel-in-area').show();
                }else{
                    $('.cancel-in-value').text(cancel_in);
                    $('.cancel-charge-value').text(cancel_fee);
                    $('.cancel-in-area').hide();
                }

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

                $('#details-name').text(name);
                $('.period-value').text(period);
                $('.every-profit-value').text(every_profit);
                $('.profit-rate-value').text(profit_rate);
                $('.min-fdr-value').text(min_amount);
                $('.max-fdr-value').text(max_amount);
                $('.compounding-value').text(compounding);
                $('.cancel-in-value').text(cancel_in);

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
