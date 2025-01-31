@extends('backend.layouts.app')
@section('title')
    {{ __('Edit FDR Plan') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Edit FDR Plan') }}</h2>
                            <a href="{{ url()->previous() }}" class="title-btn"><i
                                    data-lucide="corner-down-left"></i>{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <form action="{{route('admin.plan.fdr.update',$plan->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="site-card">
                            <div class="site-card-header">
                                <h3 class="title">{{ __('Basic Info') }}</h3>
                            </div>
                            <div class="site-card-body">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Plan Name:') }}</label>
                                            <input
                                                type="text"
                                                name="name"
                                                class="box-input"
                                                placeholder="Plan name"
                                                value="{{ $plan->name }}"
                                                required
                                            />
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Min Amount:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="text" name="minimum_amount" class="form-control" value="{{ $plan->minimum_amount }}" />
                                            <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Max Amount:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="text" name="maximum_amount" class="form-control" value="{{ $plan->maximum_amount }}" />
                                            <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                        </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Interest Rate:') }} <i data-lucide="info"data-bs-toggle="tooltip" data-bs-original-title="{{ __('User will receive this interest amount in every receiving interval') }}"></i></label>
                                        <div class="input-group joint-input">
                                            <input type="text" name="interest_rate" class="form-control" value="{{ $plan->interest_rate }}" required/>
                                            <span class="input-group-text">{{ __('%') }}</span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Receiving Interval:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="text" name="intervel" class="form-control" value="{{ $plan->intervel }}"/>
                                            <span class="input-group-text">{{ __('Days') }}</span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Lock In Period:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="text" name="period" class="form-control" value="{{ $plan->locked }}"/>
                                            <span class="input-group-text">{{ __('Days') }}</span>
                                        </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Add maturity platform fee?') }}</label>
                                            <div class="switch-field same-type">
                                                <input type="radio" id="add-fee-yes" name="add_maturity_platform_fee" @checked($plan->add_maturity_platform_fee) value="1" />
                                                <label for="add-fee-yes">{{ __('Yes') }}</label>
                                                <input type="radio" id="add-fee-no" name="add_maturity_platform_fee" @checked(!$plan->add_maturity_platform_fee) value="0" />
                                                <label for="add-fee-no">{{ __('No') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6" id="maturity-platform-fee-sec">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Maturity platform fee:') }}</label>
                                            <div class="input-group joint-input">
                                                <input type="text"  name="maturity_platform_fee" oninput="this.value = validateDouble(this.value)" value="{{ $plan->maturity_platform_fee }}" class="form-control" />
                                                <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <p class="alert alert-success paragraph mb-0 mt-2 fst-italic profit-info">
                                            <i data-lucide="info"></i>
                                            <strong>Minimum <span class="min-value"></span> {{ setting('site_currency') }} to a maximum <span class="max-value"></span> {{ setting('site_currency') }} will get the user every <span class="interval-days"></span> days.</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="site-card">
                            <div class="site-card-header">
                                <h3 class="title">{{ __('FDR Return') }}</h3>
                            </div>
                            <div class="site-card-body">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('FDR Return Type') }}<i data-lucide="info"data-bs-toggle="tooltip" data-bs-original-title="{{ __('Compounding is the profit will be generated after adding the profit with the fdr amount.') }}"></i></label>
                                            <div class="switch-field same-type">
                                                <input type="radio" id="radio-seven" name="is_compounding" @checked($plan->is_compounding) value="1" />
                                                <label for="radio-seven">{{ __('Compounding') }}</label>
                                                <input type="radio" id="radio-eight" name="is_compounding" value="0" @checked(!$plan->is_compounding)/>
                                                <label for="radio-eight">{{ __('Non Compounding') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="site-card">
                            <div class="site-card-header">
                                <h3 class="title">{{ __('FDR Cancellation') }}</h3>
                            </div>
                            <div class="site-card-body">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Can Cancel ') }}</label>
                                            <div class="switch-field same-type">
                                                <input type="radio" id="radio-can-cancel" name="can_cancel" @checked($plan->can_cancel) value="1" />
                                                <label for="radio-can-cancel">{{ __('Yes') }}</label>
                                                <input type="radio" id="radio-can-cancel1" name="can_cancel" value="0" @checked(!$plan->can_cancel) />
                                                <label for="radio-can-cancel1">{{ __('No') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6" id="cancel_type_sec">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Cancel Type') }}</label>
                                            <div class="switch-field same-type">
                                                <input type="radio" id="radio-cancel-type" name="cancel_type" @checked($plan->cancel_type == 'anytime') value="anytime" />
                                                <label for="radio-cancel-type">{{ __('Anytime') }}</label>
                                                <input type="radio" id="radio-cancel-type1" name="cancel_type" @checked($plan->cancel_type == 'fixed') value="fixed" />
                                                <label for="radio-cancel-type1">{{ __('Fixed') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6" id="cancel_time_sec">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Cancellation Time:') }}</label>
                                            <div class="input-group joint-input">
                                                <input type="text" name="cancel_days" class="form-control" value="{{ $plan->cancel_days }}"/>
                                                <span class="input-group-text">{{ __('Days') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6" id="cancel_fee_sec">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Cancellation Charge:') }}</label>
                                            <div class="position-relative">
                                                <input type="number" class="box-input" placeholder="charge" name="cancel_fee"
                                                    oninput="this.value = validateDouble(this.value)" value="{{ $plan->cancel_fee }}" />
                                                <div class="prcntcurr">
                                                    <select name="cancel_fee_type" class="form-select" id="">
                                                        <option value="percentage" @selected($plan->cancel_fee_type == 'percentage')>{{ __('%') }}</option>
                                                        <option value="fixed" @selected($plan->cancel_fee_type == 'fixed')>{{ $currencySymbol }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="site-card">
                            <div class="site-card-header">
                                <h3 class="title">{{ __('FDR Increase Info') }}</h3>
                            </div>
                            <div class="site-card-body">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Add New Fund to Existing FDR ?') }}</label>
                                            <div class="switch-field same-type">
                                                <input type="radio" id="radio-can-add" name="is_add_fund_fdr" @checked($plan->is_add_fund_fdr) value="1" />
                                                <label for="radio-can-add">{{ __('Yes') }}</label>
                                                <input type="radio" id="radio-can-add1" name="is_add_fund_fdr" @checked(!$plan->is_add_fund_fdr) value="0" />
                                                <label for="radio-can-add1">{{ __('No') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6" id="fdr-increase-type">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Increase Type') }}</label>
                                            <div class="switch-field same-type">
                                                <input type="radio" id="increment-unlimited" name="increment_type" @checked($plan->increment_type == 'unlimited') value="unlimited" />
                                                <label for="increment-unlimited">{{ __('Unlimited') }}</label>
                                                <input type="radio" id="increment-fixed" name="increment_type" @checked($plan->increment_type == 'fixed') value="fixed" />
                                                <label for="increment-fixed">{{ __('Fixed') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6" id="fdr-max-increase">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Max Increase:') }}</label>
                                            <div class="input-group joint-input">
                                                <input type="text" name="increment_times" value="{{ $plan->increment_times }}"
                                                    oninput="this.value = validateDouble(this.value)"
                                                    class="form-control"/>
                                                <span
                                                    class="input-group-text">{{ __('Times') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6" id="fdr-min-increase-amount">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Min Increase Amount:') }}</label>
                                            <div class="input-group joint-input">
                                                <input type="text" name="min_increment"
                                                    oninput="this.value = validateDouble(this.value)" value="{{ $plan->min_increment_amount }}"
                                                    class="form-control"/>
                                                <span
                                                    class="input-group-text">{{ setting('site_currency','global') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6" id="fdr-max-increase-amount">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Max Increase Amount:') }}</label>
                                            <div class="input-group joint-input">
                                                <input type="text" name="max_increment" value="{{ $plan->max_increment_amount }}"
                                                    oninput="this.value = validateDouble(this.value)"
                                                    class="form-control"/>
                                                <span
                                                    class="input-group-text">{{ setting('site_currency','global') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6" id="fdr-increase-charge-type">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Increase Charge Type') }}</label>
                                            <div class="switch-field same-type">
                                                <input type="radio" id="increment-charge-yes" name="increment_charge_type" @checked($plan->increment_charge_type) value="1" />
                                                <label for="increment-charge-yes">{{ __('Yes') }}</label>
                                                <input type="radio" id="increment-charge-no" name="increment_charge_type" @checked(!$plan->increment_charge_type) value="0" />
                                                <label for="increment-charge-no">{{ __('No') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6" id="fdr-increase-charge">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Increase Charge:') }}</label>
                                            <div class="input-group joint-input">
                                                <input type="text" name="increment_fee" value="{{ $plan->increment_fee }}"
                                                    oninput="this.value = validateDouble(this.value)"
                                                    class="form-control"/>
                                                <span
                                                    class="input-group-text">{{ setting('site_currency','global') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="site-card">
                            <div class="site-card-header">
                                <h3 class="title">{{ __('FDR Decrease Info') }}</h3>
                            </div>
                            <div class="site-card-body">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Deduct Fund to Existing FDR ?') }}</label>
                                            <div class="switch-field same-type">
                                                <input type="radio" id="radio-can-deduct" name="is_deduct_fund_fdr" @checked($plan->is_deduct_fund_fdr) value="1" />
                                                <label for="radio-can-deduct">{{ __('Yes') }}</label>
                                                <input type="radio" id="radio-can-deduct1" name="is_deduct_fund_fdr" @checked(!$plan->is_deduct_fund_fdr) value="0" />
                                                <label for="radio-can-deduct1">{{ __('No') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6" id="fdr-decrease-type">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Decrease Type') }}</label>
                                            <div class="switch-field same-type">
                                                <input type="radio" id="decrement-unlimited" name="decrement_type" @checked($plan->decrement_type == 'unlimited') value="unlimited" />
                                                <label for="decrement-unlimited">{{ __('Unlimited') }}</label>
                                                <input type="radio" id="decrement-fixed" name="decrement_type" @checked($plan->decrement_type == 'fixed')  value="fixed" />
                                                <label for="decrement-fixed">{{ __('Fixed') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6" id="fdr-max-decrease">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Max Decrease:') }}</label>
                                            <div class="input-group joint-input">
                                                <input type="text" name="decrement_times" value="{{ $plan->decrement_times }}"
                                                    oninput="this.value = validateDouble(this.value)"
                                                    class="form-control"/>
                                                <span
                                                    class="input-group-text">{{ __('Times') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6" id="fdr-min-decrease-amount">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Min Decrease Amount:') }}</label>
                                            <div class="input-group joint-input">
                                                <input type="text" name="min_decrement" value="{{ $plan->min_decrement_amount }}"
                                                    oninput="this.value = validateDouble(this.value)"
                                                    class="form-control"/>
                                                <span
                                                    class="input-group-text">{{ setting('site_currency','global') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6" id="fdr-max-decrease-amount">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Max Decrease Amount:') }}</label>
                                            <div class="input-group joint-input">
                                                <input type="text" name="max_decrement" value="{{ $plan->max_decrement_amount }}"
                                                    oninput="this.value = validateDouble(this.value)"
                                                    class="form-control"/>
                                                <span
                                                    class="input-group-text">{{ setting('site_currency','global') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6" id="fdr-decrease-charge-type">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Decrease Charge Type') }}</label>
                                            <div class="switch-field same-type">
                                                <input type="radio" id="decrement-charge-yes" name="decrement_charge_type" @checked($plan->decrement_charge_type) value="1" />
                                                <label for="decrement-charge-yes">{{ __('Yes') }}</label>
                                                <input type="radio" id="decrement-charge-no" name="decrement_charge_type" @checked(!$plan->decrement_charge_type) value="0" />
                                                <label for="decrement-charge-no">{{ __('No') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6" id="fdr-decrease-charge">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Decrease Charge:') }}</label>
                                            <div class="input-group joint-input">
                                                <input type="text" name="decrement_fee" value="{{ $plan->decrement_fee }}"
                                                    oninput="this.value = validateDouble(this.value)"
                                                    class="form-control"/>
                                                <span
                                                    class="input-group-text">{{ setting('site_currency','global') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="site-card">
                            <div class="site-card-header">
                                <h3 class="title">{{ __('FDR Featured Info') }}</h3>
                            </div>
                            <div class="site-card-body">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Featured') }}</label>
                                            <div class="switch-field same-type">
                                                <input type="radio" id="radio-can-featured" name="featured" @checked($plan->featured) value="1" />
                                                <label for="radio-can-featured">{{ __('Yes') }}</label>
                                                <input type="radio" id="radio-can-featured1" name="featured" @checked(!$plan->featured) value="0" />
                                                <label for="radio-can-featured1">{{ __('No') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6" id="badge">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Badge:') }}</label>
                                            <div class="input-group joint-input">
                                                <input type="text" name="badge" class="form-control" value="{{ $plan->badge }}"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="site-card">
                            <div class="site-card-header">
                                <h3 class="title">{{ __('FDR Status') }}</h3>
                            </div>
                            <div class="site-card-body">
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Status:') }}</label>
                                        <div class="switch-field same-type">
                                            <input
                                                type="radio"
                                                id="radio-five"
                                                name="status"
                                                @checked($plan->status)
                                                value="1"
                                            />
                                            <label for="radio-five">{{ __('Active') }}</label>
                                            <input
                                                type="radio"
                                                id="radio-six"
                                                name="status"
                                                @checked(!$plan->status)
                                                value="0"
                                            />
                                            <label for="radio-six">{{ __('Deactivate') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <button type="submit" class="site-btn-sm primary-btn w-100">
                                {{ __('Update Plan') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        (function ($) {
            "use strict";

            function calculateProfit()
            {
                var minAmount = parseFloat($('input[name=minimum_amount]').val());
                var maxAmount = parseFloat($('input[name=maximum_amount]').val());
                var intervalDays = $('input[name=intervel]').val();
                var interestRate = parseFloat($('input[name=interest_rate]').val());

                $('span.min-value').text((minAmount / 100) * interestRate);
                $('span.max-value').text((maxAmount / 100) * interestRate);
                $('span.interval-days').text(intervalDays);

                if(!isNaN(minAmount) && !isNaN(maxAmount) && intervalDays.length > 0 && !isNaN(interestRate)){
                    $('.profit-info').show();
                    return;
                }

                $('.profit-info').hide();
            }

            calculateProfit();

            $('input[name=minimum_amount],input[name=maximum_amount],input[name=intervel],input[name=interest_rate]').on('input',function(){
                calculateProfit();
            });

            function toggleElementsVisibility() {
                var canCancel = $('input[name="can_cancel"]:checked').val();

                // Check the value and show/hide elements accordingly
                if (canCancel == 1) {
                    $('#cancel_type_sec').show();
                    $('#cancel_fee_sec').show();
                    $('#empty_col').show();
                    toggleTimeVisibility();
                } else {
                    $('#cancel_time_sec').hide();
                    $('#cancel_type_sec').hide();
                    $("#cancel_fee_sec").hide();
                    $("#empty_col").hide();
                }
            }

            function toggleTimeVisibility()
            {
                var cancel_type = $('input[name="cancel_type"]:checked').val();
                if (cancel_type === 'fixed') {
                    $('#cancel_time_sec').show();
                    $('#empty_col').show();
                } else {
                    $('#cancel_time_sec').hide();
                    $('#empty_col').hide();
                }
            }

            function deductFund()
            {
                var deduct = $('input[name="is_deduct_fund_fdr"]:checked').val();
                if (deduct === '1') {
                    $('#deduct_fund_charge').show();
                } else {
                    $('#deduct_fund_charge').hide();
                }
            }

            function toggleBadgeVisibility()
            {
                var featured = $('input[name="featured"]:checked').val();
                if (featured === '1') {
                    $('#badge').show();
                } else {
                    $('#badge').hide();
                }
            }


            function toggleIncreaseTypeVisibility()
            {
                var type = $('input[name="increment_type"]:checked').val();
                if (type === 'fixed') {
                    $('#fdr-max-increase').show();
                } else {
                    $('#fdr-max-increase').hide();
                }
            }

            function toggleDecreaseTypeVisibility()
            {
                var type = $('input[name="decrement_type"]:checked').val();
                if (type === 'fixed') {
                    $('#fdr-max-decrease').show();
                } else {
                    $('#fdr-max-decrease').hide();
                }
            }

            function toggleIsFundAddVisibility()
            {
                var type = $('input[name="is_add_fund_fdr"]:checked').val();

                if(type == 1){
                    $('#fdr-max-increase').show();
                    $('#fdr-increase-type').show();
                    $('#fdr-increase-charge-type').show();
                    $('#fdr-increase-charge').show();
                    $('#fdr-min-increase-amount').show();
                    $('#fdr-max-increase-amount').show();
                }else{
                    $('#fdr-max-increase').hide();
                    $('#fdr-increase-type').hide();
                    $('#fdr-increase-charge-type').hide();
                    $('#fdr-increase-charge').hide();
                    $('#fdr-min-increase-amount').hide();
                    $('#fdr-max-increase-amount').hide();
                }
            }

            function toggleIsFundDeductVisibility()
            {
                var type = $('input[name="is_deduct_fund_fdr"]:checked').val();

                if(type == 1){
                    $('#fdr-max-decrease').show();
                    $('#fdr-decrease-type').show();
                    $('#fdr-decrease-charge-type').show();
                    $('#fdr-decrease-charge').show();
                    $('#fdr-min-decrease-amount').show();
                    $('#fdr-max-decrease-amount').show();
                }else{
                    $('#fdr-max-decrease').hide();
                    $('#fdr-decrease-type').hide();
                    $('#fdr-decrease-charge-type').hide();
                    $('#fdr-decrease-charge').hide();
                    $('#fdr-min-decrease-amount').hide();
                    $('#fdr-max-decrease-amount').hide();
                }
            }


            function toggleIncrementChargeType()
            {
                var type = $('input[name="increment_charge_type"]:checked').val();
                if(type == 1){
                    $('#fdr-increase-charge').show();
                }else{
                    $('#fdr-increase-charge').hide();
                }
            }

            function toggleDecrementChargeType()
            {
                var type = $('input[name="decrement_charge_type"]:checked').val();
                if(type == 1){
                    $('#fdr-decrease-charge').show();
                }else{
                    $('#fdr-decrease-charge').hide();
                }
            }

            function togglePlatformFee()
            {
                var type = $('input[name="add_maturity_platform_fee"]:checked').val();

                if(type == 1){
                    $('#maturity-platform-fee-sec').show();
                }else {
                    $('#maturity-platform-fee-sec').hide();
                }
            }

            // Initial toggle on page load
            toggleElementsVisibility();
            if($('input[name="can_cancel"]:checked').val() == 1){
                toggleTimeVisibility();
            }
            deductFund();
            toggleBadgeVisibility();
            toggleIncreaseTypeVisibility();
            toggleIsFundAddVisibility();
            toggleIsFundDeductVisibility();
            togglePlatformFee();

            $('input[name="can_cancel"]').on('change', function () {
                toggleElementsVisibility();
            });

            $('input[name="cancel_type"]').on('change', function () {
                toggleTimeVisibility();
            });

            $('input[name="increment_charge_type"]').on('change', function () {
                toggleIncrementChargeType();
            });

            $('input[name="decrement_charge_type"]').on('change', function () {
                toggleDecrementChargeType();
            });

            $('input[name="is_deduct_fund_fdr"]').on('change', function () {
                deductFund();
            });
            $('input[name="featured"]').on('change', function () {
                toggleBadgeVisibility();
            });

            $('input[name="is_add_fund_fdr"]').on('change', function () {
                toggleIsFundAddVisibility();
            });

            $('input[name="increment_type"]').on('change', function () {
                toggleIncreaseTypeVisibility();
            });

            $('input[name="is_deduct_fund_fdr"]').on('change', function () {
                toggleIsFundDeductVisibility();
            });

            $('input[name="decrement_type"]').on('change', function () {
                toggleDecreaseTypeVisibility();
            });

            $('input[name="add_maturity_platform_fee"]').on('change', function () {
                togglePlatformFee();
            });

        })(jQuery);
    </script>
@endsection
