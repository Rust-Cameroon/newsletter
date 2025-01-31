@extends('frontend::layouts.user')
@section('title')
    {{ __('DPS Details') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title-small">{{ __('DPS Details:') }}</div>
                    @if($dps->status == App\Enums\DpsStatus::Running || $dps->status == App\Enums\DpsStatus::Due)
                    <div class="card-header-links d-flex">
                        @if($dps->plan->is_upgrade)
                        <a href="javascript:void(0)" class="card-header-link" data-bs-toggle="modal" data-bs-target="#increment"><i data-lucide="plus"></i>{{ __('Increase') }}</a>
                        @endif
                        @if($dps->plan->is_downgrade)
                        <a href="javascript:void(0)" class="bg-danger card-header-link" data-bs-toggle="modal" data-bs-target="#decrement"><i data-lucide="minus"></i>{{ __('Decrease') }}</a>
                        @endif
                    </div>
                    @endif
                </div>
                <div class="site-card-body p-0 overflow-x-auto">
                    <div class="site-custom-table site-custom-table-sm">
                        <div class="contents">
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Plan Name:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ $dps->plan->name }}</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('DPS ID:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="red-color fw-bold">{{ $dps->dps_id }}</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Status:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold"><span class="type site-badge badge-primary">{{ $dps->status }}</span></div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Interest Rate:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="red-color fw-bold">{{ $dps->plan->interest_rate }}%</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ __('Per Installment:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ $dps->per_installment .' '. $currency }} (Every {{ $dps->plan->interval }} Days)</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Number Of Installments:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ $dps->plan->total_installment }} Times</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Given Installments:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold"><span class="type site-badge badge-primary">{{ $dps->given_installment }}</span></div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Next Installment:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">
                                        {{ nextInstallment($dps->id, \App\Models\DpsTransaction::class, 'dps_id') }}
                                    </div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Deferment Charge:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="red-color fw-bold">{{ $dps->plan->charge }} {{ $dps->plan->charge_type == 'percentage' ? '%' : $currency }} / {{ $dps->plan->delay_days }} Day</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Profit Amount:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ $dps->plan->user_profit .' '.$currency  }}</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Matured Amount:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ getTotalMature($dps) .' '.$currency  }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title-small">{{ __('Installments List') }}</div>
                </div>
                <div class="site-card-body p-0 overflow-x-auto">
                    <div class="site-custom-table">
                        <div class="contents">
                            <div class="site-table-list site-table-head">
                                <div class="site-table-col">{{ __('Serial') }}</div>
                                <div class="site-table-col">{{ __('Installment Dates') }}</div>
                                <div class="site-table-col">{{ __('Given Date') }}</div>
                                <div class="site-table-col">{{ __('Amount') }}</div>
                                <div class="site-table-col">{{ __('Charge') }}</div>
                                <div class="site-table-col">{{ __('Deferment Days') }}</div>
                            </div>
                            @foreach($dps->transactions as $trx)
                                <div class="site-table-list">
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $loop->iteration }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $trx->installment_date }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $trx->given_date != null ? \Carbon\Carbon::parse($trx->given_date)->format('M d Y') : __('Yet to pay') }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $trx->given_date != null ? $trx->paid_amount.' '.$currency : __('Yet to pay') }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $trx->given_date != null ? $trx->charge.' '.$currency : __('Yet to pay') }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $trx->deferment }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- <div class="no-data-found">No Data Found</div> -->
                    </div>
                </div>
            </div>

            {{-- DPS Increment --}}
            <div class="modal fade" id="increment" tabindex="-1" aria-labelledby="incrementModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content site-table-modal">
                        <div class="modal-body popup-body">
                            <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                    data-lucide="x"></i></button>
                            <div class="popup-body-text">
                                <div class="title">{{ __('DPS Increase') }}</div>
                                <form action="{{ route('user.dps.increment',encrypt($dps->id)) }}" method="POST">
                                    @csrf
                                    <div class="step-details-form">
                                        <div class="alert alert-info">
                                            <p class="mb-0">{{ __('Current Per Installment Fee') }}: <b>{{ $dps->per_installment }}</b> {{ $currency }}</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12">
                                                <div class="inputs">
                                                    <label for="" class="input-label">{{ __('Increase Amount') }}<span class="required">*</span></label>
                                                    <div class="input-group">
                                                        <input type="number" min="1" class="form-control" name="increase_amount" value="">
                                                        <span class="input-group-text">{{ $currency }}</span>
                                                    </div>
                                                    <div class="input-info-text min-max">{{ __("Minimum {$dps->plan->min_increment_amount} {$currency} and Maximum {$dps->plan->max_increment_amount} {$currency} ") }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="action-btns">
                                        <button type="submit" class="site-btn-sm primary-btn me-2">
                                            <i data-lucide="check"></i>
                                            {{ __('Submit') }}
                                        </button>
                                        <a href="" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-lucide="x"></i>
                                            {{ __('Close') }}
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- DPS Decrement --}}
            <div class="modal fade" id="decrement" tabindex="-1" aria-labelledby="decrementModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content site-table-modal">
                        <div class="modal-body popup-body">
                            <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                    data-lucide="x"></i></button>
                            <div class="popup-body-text">
                                <div class="title">{{ __('DPS Decrease') }}</div>
                                <form action="{{ route('user.dps.decrement',encrypt($dps->id)) }}" method="POST">
                                    @csrf
                                    <div class="step-details-form">
                                        <div class="alert alert-info">
                                            <p class="mb-0">{{ __('Current Per Installment Fee') }}: <b>{{ $dps->per_installment }}</b> {{ $currency }}</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12">
                                                <div class="inputs">
                                                    <label for="" class="input-label">{{ __('Decrease Amount') }}<span class="required">*</span></label>
                                                    <div class="input-group">
                                                        <input type="number" min="1" class="form-control" name="decrease_amount" value="">
                                                        <span class="input-group-text">{{ $currency }}</span>
                                                    </div>
                                                    <div class="input-info-text min-max">{{ __("Minimum :minium_amount and Maximum :maximum_amount",['minimum_amount' => $currencySymbol.$dps->plan->min_decrement_amount,'maximum_amount' => $currencySymbol.$dps->plan->max_decrement_amount ]) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="action-btns">
                                        <button type="submit" class="site-btn-sm primary-btn me-2">
                                            <i data-lucide="check"></i>
                                            {{ __('Submit') }}
                                        </button>
                                        <a href="" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-lucide="x"></i>
                                            {{ __('Close') }}
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
