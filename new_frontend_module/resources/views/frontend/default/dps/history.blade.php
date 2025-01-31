@extends('frontend::layouts.user')
@section('title')
    {{ __('My DPS') }}
@endsection
@push('style')
<link rel="stylesheet" href="{{ asset('front/css/daterangepicker.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title-small">{{ __('My DPS List') }}</div>
                    <div class="card-header-links">
                        <a href="{{ route('user.dps.index') }}" class="card-header-link"><i data-lucide="archive"></i>{{ __('DPS Plan List') }}</a>
                    </div>
                </div>
                <div class="site-card-body p-0 overflow-x-auto">
                    <form>
                        <div class="table-filter">
                            <div class="filter">
                                <div class="single-f-box">
                                    <label for="">{{ __('DPS ID') }}</label>
                                    <input class="search" type="text" name="dps_id" value="{{ request('dps_id') }}" autocomplete="off"/>
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
                                <div class="site-table-col">{{ __('DPS Name') }}</div>
                                <div class="site-table-col">{{ __('DPS ID') }}</div>
                                <div class="site-table-col">{{ __('Rate') }}</div>
                                <div class="site-table-col">{{ __('Amount') }}</div>
                                <div class="site-table-col">{{ __('Next Installment') }}</div>
                                <div class="site-table-col">{{ __('Installments') }}</div>
                                <div class="site-table-col">{{ __('Matured Amount') }}</div>
                                <div class="site-table-col">{{ __('Status') }}</div>
                                <div class="site-table-col">{{ __('Action') }}</div>
                            </div>
                            @foreach($dpses as $dps)
                                <div class="site-table-list">
                                    <div class="site-table-col">
                                        <div class="description">
                                            <div class="content">
                                                <div class="title">{{ $dps->plan->name }}</div>
                                                <div class="date">{{ date('d M Y h:i A',strtotime($dps->created_at)) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $dps->dps_id }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $dps->plan->interest_rate }}%</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="description">
                                            <div class="content">
                                                <div class="title">{{ $dps->per_installment }} {{ $currency }}</div>
                                                <div class="date">{{ __('Every') }} {{ $dps->plan->interval }} {{ __('Days') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">
                                            {{ nextInstallment($dps->id, \App\Models\DpsTransaction::class, 'dps_id') }}
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="description">
                                            <div class="content">
                                                <div class="title">{{ $dps->plan->total_installment }}</div>
                                                <div class="date">{{ __('Given') }}: {{ $dps->given_installment }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">{{ getTotalMature($dps) }} {{ $currency }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        @if($dps->status->value == 'running')
                                            <div class="type site-badge badge-primary">{{ $dps->status->value }}</div>
                                        @elseif($dps->status->value == 'closed')
                                            <div class="type site-badge badge-failed">{{ $dps->status->value }}</div>
                                        @elseif($dps->status->value == 'mature')
                                            <div class="type site-badge badge-success">{{ $dps->status->value }}</div>
                                        @elseif($dps->status->value == 'due')
                                            <div class="type site-badge badge-pending">{{ $dps->status->value }}</div>
                                        @endif

                                    </div>
                                    @php
                                        $cancellationDays = (int) $dps->plan->cancel_days;
                                        $creationDate = $dps->created_at;
                                        $currentDate = now();
                                        $cancel_fee = $dps->plan->cancel_fee_type == 'percentage' ? (($dps->plan->cancel_fee / 100) * $dps->plan->per_installment) : $dps->plan->cancel_fee;
                                    @endphp
                                    <div class="site-table-col">
                                        <div class="action">
                                            <a href="{{ route('user.dps.details', $dps->dps_id) }}" class="icon-btn me-2"><i data-lucide="eye"></i>{{ __('Details') }}</a>
                                            @if($dps->plan->can_cancel && $dps->status->value == App\Enums\DpsStatus::Running->value || $dps->status->value == App\Enums\DpsStatus::Due->value)
                                                @if($dps->plan->cancel_type == 'fixed' && $currentDate->diffInDays($creationDate) <= $cancellationDays)
                                                <span data-bs-toggle="modal" data-bs-target="#cancelDPS">
                                                    <button
                                                        class="circle-btn red-btn cancelBtn"
                                                        data-id="{{ $dps->dps_id }}"
                                                        data-fee="{{ $cancel_fee }} {{ $currency }}"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-title="{{ __('Cancel DPS') }}">
                                                        <i data-lucide="x"></i>
                                                    </button>
                                                </span>
                                                @elseif($dps->plan->cancel_type == 'anytime')
                                                <span data-bs-toggle="modal" data-bs-target="#cancelDPS">
                                                    <button
                                                        class="circle-btn red-btn cancelBtn"
                                                        data-id="{{ $dps->dps_id }}"
                                                        data-fee="{{ $cancel_fee }} {{ $currency }}"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-title="{{ __('Cancel DPS') }}">
                                                        <i data-lucide="x"></i>
                                                    </button>
                                                </span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{ $dpses->links() }}
                        </div>
                        @if(count($dpses) == 0)
                        <div class="no-data-found">{{ __('No Data Found!') }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal for Delete Box -->
            <div class="modal fade" id="cancelDPS" tabindex="-1" aria-labelledby="cancelDPSModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content site-table-modal">
                        <div class="modal-body popup-body">
                            <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-lucide="x"></i></button>
                            <div class="popup-body-text centered">
                                <div class="info-icon">
                                    <i data-lucide="alert-triangle"></i>
                                </div>
                                <div class="title">
                                    <h4>Are you sure?</h4>
                                </div>
                                <p>
                                    {{ __('You want to Cancel this DPS?') }}
                                </p>
                                <p class="mb-4 red-color fw-bold">{{ __('Cancel Fee:') }} <strong class="cancel_fee"></strong></p>
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

            // Click Subscribe Btn
            $(document).on('click', '.cancelBtn', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                var fee = $(this).data('fee');

                $('.cancel_fee').text(fee)

                var url = "{{ route('user.dps.cancel', ['id' => ':id']) }}";
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
                window.location.href = "{{ route('user.dps.history') }}";
            });
        })
    </script>
@endsection
