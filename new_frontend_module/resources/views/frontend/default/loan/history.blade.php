@extends('frontend::layouts.user')
@section('title')
    {{ __('My Loan') }}
@endsection
@push('style')
<link rel="stylesheet" href="{{ asset('front/css/daterangepicker.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title-small">{{ __('My Loan List') }}</div>
                    <div class="card-header-links">
                        <a href="{{ route('user.loan.index') }}" class="card-header-link"><i data-lucide="archive"></i>{{ __('Loan Plan List') }}</a>
                    </div>
                </div>
                <div class="site-card-body p-0 overflow-x-auto">
                    <form>
                        <div class="table-filter">
                            <div class="filter">
                                <div class="single-f-box">
                                    <label for="">{{ __('Loan ID') }}</label>
                                    <input class="search" type="text" name="loan_id" value="{{ request('loan_id') }}" autocomplete="off"/>
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
                                <div class="site-table-col">{{ __('Loan Name') }}</div>
                                <div class="site-table-col">{{ __('Loan ID') }}</div>
                                <div class="site-table-col">{{ __('Amount') }}</div>
                                <div class="site-table-col">{{ __('Installment Amount') }}</div>
                                <div class="site-table-col">{{ __('Next Payment') }}</div>
                                <div class="site-table-col">{{ __('Installment') }}</div>
                                <div class="site-table-col">{{ __('Paid') }}</div>
                                <div class="site-table-col">{{ __('Status') }}</div>
                                <div class="site-table-col">{{ __('Action') }}</div>
                            </div>
                            @foreach($loans as $loan)
                                <div class="site-table-list">
                                    <div class="site-table-col">
                                        <div class="description">
                                            <div class="content">
                                                <div class="title">{{ $loan->plan->name }}</div>
                                                <div class="date">{{ $loan->created_at->format('d M Y h:i A') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $loan->loan_no }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $loan->amount }} {{ $currency }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="description">
                                            <div class="content">
                                                <div class="title">{{ ($loan->amount / 100 ) * $loan->plan->per_installment }} {{ $currency }}</div>
                                                <div class="date">Every {{ $loan->plan->installment_intervel }} Days</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">
                                            @if($loan->status == App\Enums\LoanStatus::Reviewing)
                                                -
                                            @else
                                                {{ nextInstallment($loan->id, \App\Models\LoanTransaction::class, 'loan_id') }}
                                            @endif

                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="description">
                                            <div class="content">
                                                <div class="title">{{ $loan->plan->total_installment }}</div>
                                                <div class="date">Given: {{ $loan->givenInstallemnt() ?? 0 }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">{{ $loan->transactions->sum('amount') }} {{ $currency }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        @if($loan->status->value == 'running')
                                            <div class="type site-badge badge-primary">{{ ucfirst($loan->status->value) }}</div>
                                        @elseif($loan->status->value == 'rejected' || $loan->status->value == 'cancelled')
                                            <div class="type site-badge badge-failed">{{ ucfirst($loan->status->value) }}</div>
                                        @elseif($loan->status->value == 'completed')
                                            <div class="type site-badge badge-success">{{ ucfirst($loan->status->value) }}</div>
                                        @elseif($loan->status->value == 'due')
                                            <div class="type site-badge badge-failed">{{ ucfirst($loan->status->value) }}</div>
                                        @elseif($loan->status->value == 'reviewing')
                                            <div class="type site-badge badge-pending">{{ ucfirst($loan->status->value) }}</div>
                                        @endif

                                    </div>
                                    <div class="site-table-col">
                                        <div class="action">
                                            <a href="{{ route('user.loan.details', $loan->loan_no) }}" class="icon-btn me-2"><i data-lucide="eye"></i>{{ __('Details') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{ $loans->links() }}
                        </div>
                        @if(count($loans) == 0)
                        <div class="no-data-found">{{ __('No Data Found!') }}</div>
                        @endif
                    </div>
                </div>
            </div>

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
                window.location.href = "{{ route('user.loan.history') }}";
            });
        })
    </script>
@endsection
