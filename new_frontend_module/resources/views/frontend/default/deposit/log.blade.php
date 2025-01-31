@extends('frontend::layouts.user')
@section('title')
{{ __('Deposit Logs') }}
@endsection
@push('style')
<link rel="stylesheet" href="{{ asset('front/css/daterangepicker.css') }}">
@endpush
@push('js')
<script src="{{ asset('front/js/moment.min.js') }}"></script>
<script src="{{ asset('front/js/daterangepicker.min.js') }}"></script>
<script>

    "use strict";

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
        window.location.href = "{{ route('user.deposit.log') }}";
    });

</script>
@endpush
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
        <div class="site-card">
            <div class="site-card-header">
                <div class="title-small">{{ __('Deposit Log') }}</div>
                <div class="card-header-links">
                    <a href="{{ route('user.deposit.amount') }}" class="card-header-link"><i
                            data-lucide="plus-circle"></i>{{ __('Add Money') }}</a>
                </div>
            </div>
            <div class="site-card-body p-0 overflow-x-auto">
                <form>
                    <div class="table-filter">
                        <div class="filter">
                            <div class="single-f-box">
                                <label for="">{{ __('Transaction ID') }}</label>
                                <input class="search" type="text" name="trx" value="{{ request('trx') }}" autocomplete="off"/>
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
                            <div class="site-table-col"> {{ __('Description') }} </div>
                            <div class="site-table-col"> {{ __('Transaction ID')}} </div>
                            <div class="site-table-col"> {{ __('Amount') }} </div>
                            <div class="site-table-col"> {{ __('Fee') }} </div>
                            <div class="site-table-col"> {{ __('Status') }} </div>
                            <div class="site-table-col"> {{ __('Gateway') }} </div>
                        </div>
                        @foreach($deposits as $raw)
                        <div class="site-table-list">
                            <div class="site-table-col">
                                <div class="description">
                                    <div class="event-icon"><i data-lucide="chevrons-down"></i></div>
                                    <div class="content">
                                        <div class="title">{{$raw->description}}
                                            @if(!in_array($raw->approval_cause,['none',""]))
                                            <span class="msg" data-bs-toggle="tooltip"
                                                data-bs-custom-class="custom-tooltip" data-bs-placement="top"
                                                data-bs-title="{{ $raw->approval_cause }}"><i
                                                    data-lucide="message-square"></i>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="date">{{ $raw->created_at }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="site-table-col">
                                <div class="trx fw-bold">{{ $raw->tnx }}</div>
                            </div>
                            <div class="site-table-col">
                                <div class="green-color fw-bold">+{{$raw->amount.' '.$currency }}</div>
                            </div>
                            <div class="site-table-col">
                                <div class="fw-bold">-{{ $raw->charge }} {{ $currency }}</div>
                            </div>
                            <div class="site-table-col">
                                @switch($raw->status->value)
                                    @case('pending')
                                        <div class="type site-badge badge-pending">{{ __('Pending') }}</div>
                                        @break
                                    @case('success')
                                        <div class="site-badge badge-success">{{ __('Success') }}</div>
                                        @break
                                    @case('failed')
                                        <div class="site-badge badge-failed">{{ __('Cancelled') }}</div>
                                        @break
                                @endswitch
                            </div>
                            <div class="site-table-col">
                                <div class="fw-bold">{{ ucfirst(str_replace('-',' ',$raw->method)) }}</div>
                            </div>
                        </div>
                        @endforeach
                        {{ $deposits->links() }}
                    </div>
                    @if(count($deposits) == 0)
                    <div class="no-data-found">{{ __('No Data Found!') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
