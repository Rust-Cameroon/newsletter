@extends('backend.layouts.app')
@section('title')
{{ __('Add New DPS Plan') }}
@endsection

@section('content')
<div class="main-content">
    <div class="page-title">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="title-content">
                        <h2 class="title">{{ __('Add New DPS Plan') }}</h2>
                        <a href="{{ url()->previous() }}" class="title-btn"><i data-lucide="corner-down-left"></i>{{
                            __('Back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <form action="{{route('admin.plan.dps.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('Basic Info') }}</h3>
                        </div>
                        <div class="site-card-body">
                            <div class="row">

                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Plan Name:') }}</label>
                                        <input type="text" name="name" class="box-input" placeholder="Plan name" required />
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Installment Interval:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="interval" class="form-control" />
                                            <span class="input-group-text">{{ __('Days') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 schema-name">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Total Installment:') }}</label>
                                        <input type="number" id="total_installment" name="total_installment" class="box-input" required />
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Per Installment:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number"  id="per_installment" name="per_installment" class="form-control" />
                                            <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Interest Rate:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" id="interest_rate" name="interest_rate" class="form-control" />
                                            <span class="input-group-text">{{ __('%') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Total Deposit:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="text" id="total_deposit" name="total_deposit" class="form-control" readonly/>
                                            <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Profit Amount:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="text" id="user_profit" name="user_profit" class="form-control" readonly/>
                                            <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Total Mature Amount:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="text" id="total_mature_amount" name="total_mature_amount" class="form-control" readonly/>
                                            <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Charge will Apply if Delay:')
                                            }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="delay_days" class="form-control" />
                                            <span class="input-group-text">{{ __('Day') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Delay Charge:') }}</label>
                                        <div class="position-relative">
                                            <input type="number" class="box-input" name="charge"
                                                 />
                                            <div class="prcntcurr">
                                                <select name="charge_type" class="form-select" id="">
                                                    <option value="percentage">{{ __('%') }}</option>
                                                    <option value="fixed">{{ $currencySymbol }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Maturity fee:') }}</label>
                                        <div class="switch-field same-type">
                                            <input type="radio" id="add-fee-yes" name="add_maturity_platform_fee" checked="" value="1" />
                                            <label for="add-fee-yes">{{ __('Yes') }}</label>
                                            <input type="radio" id="add-fee-no" name="add_maturity_platform_fee" value="0" />
                                            <label for="add-fee-no">{{ __('No') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6" id="maturity-platform-fee-sec">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Maturity platform fee:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number"  name="maturity_platform_fee"  class="form-control" />
                                            <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('DPS Cancellation') }}</h3>
                        </div>
                        <div class="site-card-body">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Can Cancel ?') }}</label>
                                        <div class="switch-field same-type">
                                            <input type="radio" id="radio-can-cancel" name="can_cancel" checked="" value="1" />
                                            <label for="radio-can-cancel">{{ __('Yes') }}</label>
                                            <input type="radio" id="radio-can-cancel1" name="can_cancel" value="0" />
                                            <label for="radio-can-cancel1">{{ __('No') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6" id="cancel_type_sec">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Cancel Type') }}</label>
                                        <div class="switch-field same-type">
                                            <input type="radio" id="radio-cancel-type" name="cancel_type" checked="" value="anytime" />
                                            <label for="radio-cancel-type">{{ __('Anytime') }}</label>
                                            <input type="radio" id="radio-cancel-type1" name="cancel_type" value="fixed" />
                                            <label for="radio-cancel-type1">{{ __('Fixed') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6" id="cancel_time_sec">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Cancellation Time:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="cancel_days" class="form-control" />
                                            <span class="input-group-text">{{ __('Days') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6" id="cancel_fee_sec">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Cancellation Charge:') }}</label>
                                        <div class="position-relative">
                                            <input type="number" class="box-input" name="cancel_fee"
                                                 />
                                            <div class="prcntcurr">
                                                <select name="cancel_fee_type" class="form-select" id="">
                                                    <option value="percentage">{{ __('%') }}</option>
                                                    <option value="fixed">{{ $currencySymbol }}</option>
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
                            <h3 class="title">{{ __('DPS Increase Info') }}</h3>
                        </div>
                        <div class="site-card-body">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Increase DPS Amount') }}</label>
                                        <div class="switch-field same-type">
                                            <input type="radio" id="radio-can-is_upgrade" name="is_upgrade" checked="" value="1" />
                                            <label for="radio-can-is_upgrade">{{ __('Yes') }}</label>
                                            <input type="radio" id="radio-can-is_upgrade1" name="is_upgrade" value="0" />
                                            <label for="radio-can-is_upgrade1">{{ __('No') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6" id="increase_type">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Increase Time') }}</label>
                                        <div class="switch-field same-type">
                                            <input type="radio" id="radio-unlimited" name="increment_type" checked="" value="unlimited" />
                                            <label for="radio-unlimited">{{ __('Unlimited') }}</label>
                                            <input type="radio" id="radio-fixed" name="increment_type" value="fixed" />
                                            <label for="radio-fixed">{{ __('Fixed') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6" id="increase_time">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Max Increase Limit:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="increment_times" class="form-control"/>
                                            <span class="input-group-text">{{ __('Times') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6" id="dps-min-increase-amount">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Min Increase Amount:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="min_increment"
                                                
                                                class="form-control"/>
                                            <span
                                                class="input-group-text">{{ setting('site_currency','global') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6" id="dps-max-increase-amount">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Max Increase Amount:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="max_increment"
                                                
                                                class="form-control"/>
                                            <span
                                                class="input-group-text">{{ setting('site_currency','global') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6" id="dps-increase-charge-type">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Increase Charge Type') }}</label>
                                        <div class="switch-field same-type">
                                            <input type="radio" id="increment-charge-yes" name="increment_charge_type" checked="" value="1" />
                                            <label for="increment-charge-yes">{{ __('Yes') }}</label>
                                            <input type="radio" id="increment-charge-no" name="increment_charge_type" value="0" />
                                            <label for="increment-charge-no">{{ __('No') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6" id="dps-increase-charge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Increase Charge:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="text" name="increment_fee"
                                                
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
                            <h3 class="title">{{ __('DPS Decrease Info') }}</h3>
                        </div>
                        <div class="site-card-body">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Decrease DPS Amount') }}</label>
                                        <div class="switch-field same-type">
                                            <input type="radio" id="radio-can-is_downgrade" name="is_downgrade" checked="" value="1" />
                                            <label for="radio-can-is_downgrade">{{ __('Yes') }}</label>
                                            <input type="radio" id="radio-can-is_downgrade1" name="is_downgrade" value="0" />
                                            <label for="radio-can-is_downgrade1">{{ __('No') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6" id="decrease_type">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Decrease Time') }}</label>
                                        <div class="switch-field same-type">
                                            <input type="radio" id="radio-decrease-unlimited" name="decrement_type" checked="" value="unlimited" />
                                            <label for="radio-decrease-unlimited">{{ __('Unlimited') }}</label>
                                            <input type="radio" id="radio-decrease-fixed" name="decrement_type" value="fixed" />
                                            <label for="radio-decrease-fixed">{{ __('Fixed') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6" id="decrease_time">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Max Decrease Limit:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="decrement_times" class="form-control"/>
                                            <span class="input-group-text">{{ __('Times') }}</span>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6" id="dps-min-decrease-amount">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Min Decrease Amount:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="text" name="min_decrement"
                                                
                                                class="form-control"/>
                                            <span
                                                class="input-group-text">{{ setting('site_currency','global') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6" id="dps-max-decrease-amount">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Max Decrease Amount:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="text" name="max_decrement"
                                                
                                                class="form-control"/>
                                            <span
                                                class="input-group-text">{{ setting('site_currency','global') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6" id="dps-decrease-charge-type">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Decrease Charge Type') }}</label>
                                        <div class="switch-field same-type">
                                            <input type="radio" id="decrement-charge-yes" name="decrement_charge_type" checked="" value="1" />
                                            <label for="decrement-charge-yes">{{ __('Yes') }}</label>
                                            <input type="radio" id="decrement-charge-no" name="decrement_charge_type" value="0" />
                                            <label for="decrement-charge-no">{{ __('No') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6" id="dps-decrease-charge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Decrease Charge:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="text" name="decrement_fee"
                                                
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
                            <h3 class="title">{{ __('DPS Featured Info') }}</h3>
                        </div>
                        <div class="site-card-body">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Featured') }}</label>
                                        <div class="switch-field same-type">
                                            <input type="radio" id="radio-can-featured" name="featured" checked="" value="1" />
                                            <label for="radio-can-featured">{{ __('Yes') }}</label>
                                            <input type="radio" id="radio-can-featured1" name="featured" value="0" />
                                            <label for="radio-can-featured1">{{ __('No') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6" id="badge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Badge:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="text" name="badge" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('DPS Status') }}</h3>
                        </div>
                        <div class="site-card-body">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Status:') }}</label>
                                        <div class="switch-field same-type">
                                            <input type="radio" id="radio-five" name="status" checked="" value="1" />
                                            <label for="radio-five">{{ __('Active') }}</label>
                                            <input type="radio" id="radio-six" name="status" value="0" />
                                            <label for="radio-six">{{ __('Deactivate') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <button type="submit" class="site-btn-sm primary-btn w-100">
                            {{ __('Add New Plan') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('single-script')
    <script>
        $(document).ready(function () {
            function updateFields() {
                var total_installment = parseFloat($("#total_installment").val()) || 0;
                var per_installment = parseFloat($("#per_installment").val()) || 0;
                var interest_rate = parseFloat($("#interest_rate").val()) || 0;

                var total_deposit = total_installment * per_installment;
                var user_profit = (total_installment * per_installment * interest_rate) / 100;
                var total_mature_amount = total_deposit + user_profit;

                $("#total_deposit").val(total_deposit.toFixed(2));
                $("#user_profit").val(user_profit.toFixed(2));
                $("#total_mature_amount").val(total_mature_amount.toFixed(2));
            }

            $("#total_installment, #per_installment, #interest_rate").on("input", updateFields);
        });
    </script>
    <script>
        (function ($) {
            "use strict";

            function toggleElementsVisibility() {
                var canCancel = $('input[name="can_cancel"]:checked').val();

                // Check the value and show/hide elements accordingly
                if (canCancel == 1) {
                    $('#cancel_type_sec').show();
                    $('#cancel_fee_sec').show();
                    toggleTimeVisibility();
                } else {
                    $('#cancel_time_sec').hide();
                    $('#cancel_type_sec').hide();
                    $("#cancel_fee_sec").hide();
                }
            }

            function toggleTimeVisibility()
            {
                var cancel_type = $('input[name="cancel_type"]:checked').val();

                if (cancel_type === 'fixed') {
                    $('#cancel_time_sec').show();
                } else {
                    $('#cancel_time_sec').hide();
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

            function toggleIncrementTimeVisibility()
            {
                var type = $('input[name="increment_type"]:checked').val();
                if (type == 'unlimited') {
                    $('#increase_time').hide();
                } else {
                    $('#increase_time').show();
                }
            }

            function toggleDecrementTimeVisibility()
            {
                var type = $('input[name="decrement_type"]:checked').val();

                if (type == 'unlimited') {
                    $('#decrease_time').hide();
                } else {
                    $('#decrease_time').show();
                }
            }

            function isUpgrade()
            {
                var upgrade = $('input[name="is_upgrade"]:checked').val();
                if(upgrade == '1'){
                    $('#increase_type').show();
                    $('#increase_time').show();
                    $('#dps-min-increase-amount').show();
                    $('#dps-max-increase-amount').show();
                    $('#dps-increase-charge-type').show();
                    $('#dps-increase-charge').show();
                }else{
                    $('#increase_type').hide();
                    $('#increase_time').hide();
                    $('#dps-min-increase-amount').hide();
                    $('#dps-max-increase-amount').hide();
                    $('#dps-increase-charge-type').hide();
                    $('#dps-increase-charge').hide();
                }
            }

            function isDowngrade()
            {
                var downgrade = $('input[name="is_downgrade"]:checked').val();
                if(downgrade == '1'){
                    $('#decrease_type').show();
                    $('#decrease_time').show();
                    $('#dps-decrease-type').show();
                    $('#dps-decrease-charge-type').show();
                    $('#dps-decrease-charge').show();
                    $('#dps-min-decrease-amount').show();
                    $('#dps-max-decrease-amount').show();
                }else{
                    $('#decrease_type').hide();
                    $('#decrease_time').hide();
                    $('#dps-decrease-type').hide();
                    $('#dps-decrease-charge-type').hide();
                    $('#dps-decrease-charge').hide();
                    $('#dps-min-decrease-amount').hide();
                    $('#dps-max-decrease-amount').hide();
                }
            }

            function toggleIncrementChargeType()
            {
                var type = $('input[name="increment_charge_type"]:checked').val();
                if(type == 1){
                    $('#dps-increase-charge').show();
                }else{
                    $('#dps-increase-charge').hide();
                }
            }

            function toggleDecrementChargeType()
            {
                var type = $('input[name="decrement_charge_type"]:checked').val();
                if(type == 1){
                    $('#dps-decrease-charge').show();
                }else{
                    $('#dps-decrease-charge').hide();
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
            toggleTimeVisibility();
            toggleBadgeVisibility();
            isUpgrade();
            isDowngrade();
            toggleIncrementTimeVisibility();
            toggleDecrementTimeVisibility();
            toggleIncrementChargeType();
            toggleDecrementChargeType();
            togglePlatformFee();

            $('input[name="can_cancel"]').on('change', function () {
                toggleElementsVisibility();
            });

            $('input[name="cancel_type"]').on('change', function () {
                toggleTimeVisibility();
            });

            $('input[name="featured"]').on('change', function () {
                toggleBadgeVisibility();
            });

            $('input[name="increment_type"]').on('change', function () {
                toggleIncrementTimeVisibility();
            });
            $('input[name="increment_charge_type"]').on('change', function () {
                toggleIncrementChargeType();
            });

            $('input[name="decrement_charge_type"]').on('change', function () {
                toggleDecrementChargeType();
            });

            $('input[name="decrement_type"]').on('change', function () {
                toggleDecrementTimeVisibility();
            });

            $('input[name="is_upgrade"]').on('change', function () {
                isUpgrade();
            });

            $('input[name="is_downgrade"]').on('change', function () {
                isDowngrade();
            });

            $('input[name="add_maturity_platform_fee"]').on('change', function () {
                togglePlatformFee();
            });

        })(jQuery);
    </script>
@endpush
