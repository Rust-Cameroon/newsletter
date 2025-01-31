@extends('frontend::layouts.user')
@section('title')
    {{ __('FDR Details') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title-small">{{ __('FDR Details:') }}</div>
                    @if($fdr->status == App\Enums\FdrStatus::Running)
                    <div class="card-header-links d-flex">
                        <a href="javascript:void(0)" class="card-header-link" data-bs-toggle="modal" data-bs-target="#increment"><i data-lucide="plus"></i>{{ __('Increase') }}</a>
                        <a href="javascript:void(0)" class="bg-danger card-header-link" data-bs-toggle="modal" data-bs-target="#decrement"><i data-lucide="minus"></i>{{ __('Decrease') }}</a>
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
                                    <div class="fw-bold">{{ $fdr->plan->name }}</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('FDR ID:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="red-color fw-bold">{{ $fdr->fdr_id }}</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Status:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold"><span class="type site-badge badge-primary">{{ $fdr->status }}</span></div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Amount:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="red-color fw-bold">{{ $fdr->amount . ' '.$currency }}</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ __('Profit:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ $fdr->profit() }} (Every {{ $fdr->plan->intervel }} Days)</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Total Returns:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ $fdr->totalInstallment() }} Times</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Return Received:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold"><span class="type site-badge badge-primary">{{ $fdr->givenInstallemnt() ?? 0 }}</span></div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Next Receive:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">
                                        @php
                                            $trx = \App\Models\FDRTransaction::where('fdr_id', $fdr->id)->where('paid_amount', null)->first();
                                        @endphp
                                        {{ $trx->given_date->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Total Profit:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ $fdr->transactions->sum('given_amount') .' '.$currency  }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($fdr->transactions->count() > 0)
                <div class="site-card">
                    <div class="site-card-header">
                        <div class="title-small">{{ __('Installments List') }}</div>
                    </div>
                    <div class="site-card-body p-0 overflow-x-auto">
                        <div class="site-custom-table">
                            <div class="contents">
                                <div class="site-table-list site-table-head">
                                    <div class="site-table-col">{{ __('Serial') }}</div>
                                    <div class="site-table-col">{{ __('Return Dates') }}</div>
                                    <div class="site-table-col">{{ __('Interest') }}</div>
                                    <div class="site-table-col">{{ __('Paid') }}</div>
                                </div>
                                @foreach($fdr->transactions as $trx)
                                    <div class="site-table-list">
                                        <div class="site-table-col">
                                            <div class="trx fw-bold">{{ $loop->iteration }}</div>
                                        </div>
                                        <div class="site-table-col">
                                            <div class="trx fw-bold">{{ \Carbon\Carbon::parse($trx->given_date)->format('M d Y') }}</div>
                                        </div>
                                        <div class="site-table-col">
                                            <div class="trx fw-bold">{{ $trx->given_amount }} {{ $currency }}</div>
                                        </div>
                                        <div class="site-table-col">
                                            <div class="trx fw-bold">{{ $trx->paid_amount != null ? number_format($trx->paid_amount, 2) . ' '. $currency : 'None' }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- <div class="no-data-found">No Data Found</div> -->
                        </div>
                    </div>
                </div>
            @endif

            {{-- FDR Increment --}}
            <div class="modal fade" id="increment" tabindex="-1" aria-labelledby="incrementModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content site-table-modal">
                        <div class="modal-body popup-body">
                            <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                    data-lucide="x"></i></button>
                            <div class="popup-body-text">
                                <div class="title">{{ __('FDR Increase') }}</div>
                                <form action="{{ route('user.fdr.increment',encrypt($fdr->id)) }}" method="POST">
                                    @csrf
                                    <div class="step-details-form">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12">
                                                <div class="inputs">
                                                    <label for="" class="input-label">{{ __('Enter Increase Amount:') }}<span class="required">*</span></label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="increase_amount" id="increase_amount" required>
                                                        <span class="input-group-text">{{ $currency }}</span>
                                                    </div>
                                                    <div class="input-info-text min-max">{{ __("Minimum {$fdr->plan->minimum_amount} {$currency} and Maximum {$fdr->plan->maximum_amount} {$currency} ") }}</div>
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
            {{-- FDR Decrement --}}
            <div class="modal fade" id="decrement" tabindex="-1" aria-labelledby="decrementModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content site-table-modal">
                        <div class="modal-body popup-body">
                            <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                    data-lucide="x"></i></button>
                            <div class="popup-body-text">
                                <div class="title">{{ __('FDR Decrease') }}</div>
                                <form action="{{ route('user.fdr.decrement',encrypt($fdr->id)) }}" method="POST">
                                    @csrf
                                    <div class="step-details-form">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12">
                                                <div class="inputs">
                                                    <label for="" class="input-label">{{ __('Enter Decrease Amount:') }}<span class="required">*</span></label>
                                                    <div class="input-group">
                                                        <input type="number" min="1" class="form-control" name="decrease_amount" value="">
                                                        <span class="input-group-text">{{ $currency }}</span>
                                                    </div>
                                                    <div class="input-info-text min-max">
                                                        {{ __("Minimum :minium_amount and Maximum :maximum_amount",['minimum_amount' => $currencySymbol.$fdr->plan->minimum_amount,'maximum_amount' => $currencySymbol.$fdr->plan->maximum_amount ]) }}
                                                    </div>
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
