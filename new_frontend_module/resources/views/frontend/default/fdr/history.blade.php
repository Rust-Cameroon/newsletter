@extends('frontend::layouts.user')
@section('title')
    {{ __('My FDR') }}
@endsection
@push('style')
<link rel="stylesheet" href="{{ asset('front/css/daterangepicker.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title-small">{{ __('My FDR List') }}</div>
                    <div class="card-header-links">
                        <a href="{{ route('user.fdr.index') }}" class="card-header-link"><i
                                data-lucide="archive"></i>{{ __('FDR List') }}
                        </a>
                    </div>
                </div>
                <div class="site-card-body p-0 overflow-x-auto">
                    <form>
                        <div class="table-filter">
                            <div class="filter">
                                <div class="single-f-box">
                                    <label for="">{{ __('FDR ID') }}</label>
                                    <input class="search" type="text" name="fdr_id" value="{{ request('fdr_id') }}" autocomplete="off"/>
                                </div>
                                <div class="single-f-box">
                                    <label for="">{{ __('Date') }}</label>
                                    <input type="text" name="daterange" value="{{ request('daterange') }}" autocomplete="off" />
                                </div>
                                <button class="apply-btn me-2" name="filter">
                                    <i data-lucide="filter"></i>{{ __('Filter') }}
                                </button>
                                @if(request()->has('filter'))
                                <button type="button" class="apply-btn bg-danger reset-filter">
                                    <i data-lucide="x"></i>{{ __('Reset Filter') }}
                                </button>
                                @endif
                            </div>
                            <div class="filter">
                                <div class="single-f-box w-auto ms-4 me-0">
                                    <label for="">{{ __('Entries') }}</label>
                                    <select name="limit" class="nice-select page-count" onchange="$('form').submit()">
                                        <option value="15" @selected(request('limit',15) == '15')>15</option>
                                        <option value="30" @selected(request('limit') == '30')>30</option>
                                        <option value="50" @selected(request('limit') == '50')>50</option>
                                        <option value="100" @selected(request('limit') == '100')>100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="site-custom-table">
                        <div class="contents">
                            <div class="site-table-list site-table-head">
                                <div class="site-table-col">{{ __('FDR Name') }}</div>
                                <div class="site-table-col">{{ __('FDR ID') }}</div>
                                <div class="site-table-col">{{ __('Amount') }}</div>
                                <div class="site-table-col">{{ __('Profit') }}</div>
                                <div class="site-table-col">{{ __('Next Receive') }}</div>
                                <div class="site-table-col">{{ __('Returns') }}</div>
                                <div class="site-table-col">{{ __('Paid') }}</div>
                                <div class="site-table-col">{{ __('Status') }}</div>
                                <div class="site-table-col">{{ __('Action') }}</div>
                            </div>
                            @foreach($fdrs as $fdr)
                                <div class="site-table-list">
                                    <div class="site-table-col">
                                        <div class="description">
                                            <div class="content">
                                                <div class="title">{{ $fdr->plan->name }}</div>
                                                <div class="date">{{ $fdr->created_at->format('d M Y h:i A') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $fdr->fdr_id }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $fdr->amount }} {{ $currency }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="description">
                                            <div class="content">
                                                <div class="title">{{ $fdr->profit() }} {{ $currency }}</div>
                                                <div class="date">{{ __('Every') }} {{ $fdr->plan->intervel }} {{ __('Days') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">
                                            @php
                                                $trx = \App\Models\FDRTransaction::where('fdr_id', $fdr->id)->where('paid_amount', null)->first();
                                            @endphp
                                            {{ $trx?->given_date?->format('d M Y') }}
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="description">
                                            <div class="content">
                                                <div class="title">{{ $fdr->totalInstallment() }}</div>
                                                <div class="date">{{ __('Return') }}: {{ $fdr->givenInstallemnt() ?? 0 }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div
                                            class="fw-bold">{{ $fdr->transactions->sum('paid_amount') }} {{ $currency }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        @if($fdr->status->value == 'running')
                                            <div class="type site-badge badge-primary">{{ $fdr->status->value }}</div>
                                        @elseif($fdr->status->value == 'closed')
                                            <div class="type site-badge badge-failed">{{ $fdr->status->value }}</div>
                                        @elseif($fdr->status->value == 'completed')
                                            <div class="type site-badge badge-success">{{ $fdr->status->value }}</div>
                                        @endif

                                    </div>
                                    <div class="site-table-col">
                                        <div class="action">
                                            <a href="{{ route('user.fdr.details', $fdr->fdr_id) }}" class="icon-btn me-2">
                                                <i data-lucide="eye"></i>{{ __('Details') }}
                                            </a>
                                            @php
                                                $cancellationDays = (int) $fdr->plan->cancel_days;
                                                $creationDate = $fdr->created_at;
                                                $currentDate = now();
                                                $cancel_fee = $fdr->plan->cancel_fee_type == 'percentage' ? (($fdr->plan->cancel_fee / 100) * $fdr->plan->per_installment) : $fdr->plan->cancel_fee;
                                            @endphp
                                            @if($fdr->plan->can_cancel && $fdr->status == App\Enums\FdrStatus::Running)
                                               @if ($fdr->plan->cancel_type == 'fixed' && $currentDate->diffInDays($creationDate) <= $cancellationDays)
                                               <span data-bs-toggle="modal" data-bs-target="#cancelFDR">
                                                    <button
                                                        class="circle-btn red-btn cancelBtn"
                                                        data-id="{{ $fdr->fdr_id }}"
                                                        data-fee="{{ $cancel_fee }} {{ $currency }}"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-title="{{ __('Cancel FDR') }}">
                                                        <i data-lucide="x"></i>
                                                    </button>
                                                </span>
                                                @elseif($fdr->plan->cancel_type == 'anytime')
                                                <span data-bs-toggle="modal" data-bs-target="#cancelFDR">
                                                    <button
                                                        class="circle-btn red-btn cancelBtn"
                                                        data-id="{{ $fdr->fdr_id }}"
                                                        data-fee="{{ $cancel_fee }} {{ $currency }}"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-title="{{ __('Cancel FDR') }}">
                                                        <i data-lucide="x"></i>
                                                    </button>
                                                </span>
                                               @endif
                                            @else
                                            --
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if(count($fdrs) == 0)
                        <div class="no-data-found">{{ __('No Data Found!') }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal for Delete Box -->
            <div class="modal fade" id="cancelFDR" tabindex="-1" aria-labelledby="cancelFDRModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content site-table-modal">
                        <div class="modal-body popup-body">
                            <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                    data-lucide="x"></i></button>
                            <div class="popup-body-text centered">
                                <div class="info-icon">
                                    <i data-lucide="alert-triangle"></i>
                                </div>
                                <div class="title">
                                    <h4>{{ __('Are you sure?') }}</h4>
                                </div>
                                <p>
                                    {{ __('You want to Cancel this FDR?') }}
                                </p>
                                <p class="mb-4 red-color fw-bold">{{ __('Cancel Fee') }}: <strong class="cancel_fee"></strong></p>
                                <div class="action-btns">
                                    <a href="" class="site-btn-sm primary-btn me-2 confirm_btn">
                                        <i data-lucide="check"></i>
                                        {{ __('Confirm') }}
                                    </a>
                                    <a href="" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-lucide="x"></i>
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal for Delete Box End-->
        </div>
    </div>
@endsection
@section('script')
<script src="{{ asset('front/js/moment.min.js') }}"></script>
<script src="{{ asset('front/js/daterangepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            "use strict"

            const currency = @json($currency)

            $(document).on('click', '.cancelBtn', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                var fee = $(this).data('fee');

                $('.cancel_fee').text(fee)

                var url = "{{ route('user.fdr.cancel', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $('.confirm_btn').attr('href', url);
            });

            // Initialize datepicker
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            });

            @if(request('daterange') == null)
            // Set default is empty for date range
            $('input[name=daterange]').val('');
            @endif

            // Reset filter
            $('.reset-filter').on('click',function(){
                window.location.href = "{{ route('user.fdr.history') }}";
            });
        })
    </script>
@endsection
