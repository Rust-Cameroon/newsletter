@extends('frontend::layouts.user')
@section('title')
    {{ __('My Bill Payments') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title">{{ __('My Bill Payments') }}</div>
                    <div class="card-header-links">
                        <a href="{{ route('user.pay.bill.airtime') }}" class="card-header-link"><i data-lucide="credit-card"></i>{{ __('Pay Bill') }}</a>
                    </div>
                </div>
                <div class="site-card-body p-0">
                    <div class="site-custom-table">
                        <div class="contents">
                            <div class="site-table-list site-table-head">
                                <div class="site-table-col">{{ __('Service') }}</div>
                                <div class="site-table-col">{{ __('Amount') }}</div>
                                <div class="site-table-col">{{ __('Charge') }}</div>
                                <div class="site-table-col">{{ __('Status') }}</div>
                                <div class="site-table-col">{{ __('Action') }}</div>
                            </div>
                            @foreach($bills as $bill)
                                <div class="site-table-list">
                                    <div class="site-table-col">
                                        <div class="description">
                                            <div class="content">
                                                <div class="title">{{ $bill->plan->name }}</div>
                                                <div class="date">{{ date('d M Y h:i A',strtotime($bill->created_at)) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $bill->amount.' '.$currency }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $bill->charge.' '.$currency }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        @if($bill->status->value == 'pending')
                                            <div class="type site-badge badge-pending">{{ $bill->status->value }}</div>
                                        @elseif($bill->status->value == 'return')
                                            <div class="type site-badge badge-failed">{{ $bill->status->value }}</div>
                                        @elseif($bill->status->value == 'completed')
                                            <div class="type site-badge badge-success">{{ $bill->status->value }}</div>
                                        @endif
                                    </div>

                                    <div class="site-table-col">
                                        <div class="action">
                                            <a href="#" class="icon-btn me-2"><i data-lucide="eye"></i>{{ __('Details') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{ $bills->links() }}
                        </div>
                        @if(count($bills) == 0)
                        <div class="no-data-found">{{ __('No Data Found!') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
