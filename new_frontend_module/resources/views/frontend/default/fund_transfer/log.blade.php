@extends('frontend::layouts.user')
@section('title')
    {{ __('Fund Transfer Log') }}
@endsection
@push('style')
<link rel="stylesheet" href="{{ asset('front/css/daterangepicker.css') }}">
@endpush
@section('content')
    <div class="row">
        @include('frontend::fund_transfer.include.__header')
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title-small">{{ __('Transfer History') }}</div>
                    <div class="card-header-links">
                        <a href="{{ route('user.fund_transfer.index') }}" class="card-header-link"><i data-lucide="send"></i>Trasfer Money</a>
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
                                <div class="site-table-col">{{ __('Description') }}</div>
                                <div class="site-table-col">{{ __('Receiver') }}</div>
                                <div class="site-table-col">{{ __('Transaction ID') }}</div>
                                <div class="site-table-col">{{ __('Amount') }}</div>
                                <div class="site-table-col">{{ __('Fee') }}</div>
                                <div class="site-table-col">{{ __('Status') }}</div>
                                <div class="site-table-col">{{ __('Bank') }}</div>
                            </div>
                            @foreach($transactions as $transaction)
                                <div class="site-table-list">
                                    <div class="site-table-col">
                                        <div class="description">
                                            <div class="event-icon"><i data-lucide="send"></i></div>
                                            <div class="content">
                                                <div class="title">
                                                    {{ $transaction->description }}
                                                    @if($transaction->action_message != null)
                                                    <span class="msg" id="action-btn" data-message="{{ $transaction->action_message }}" data-bs-toggle="modal" data-bs-target="#actionMessage"><i data-lucide="message-square"></i></span>
                                                    @endif
                                                </div>
                                                <div class="date">{{ $transaction->created_at }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">
                                            @php
                                                $fieldData = json_decode($transaction->manual_field_data, true)
                                            @endphp

                                            @if($transaction->transfer_type->value != 'wire_transfer')
                                                {{ $transaction->beneficiary->account_name ?? data_get($fieldData,'account_name','-') }}
                                            @else
                                                {{ $fieldData['name_of_account'] ?? '' }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $transaction->tnx }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="green-color fw-bold">- {{ $transaction->amount.' '.$currency }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">{{ $transaction->charge }} {{ $currency }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        @switch($transaction->status->value)
                                            @case('pending')
                                                <div class="type site-badge badge-pending">{{ __('Pending') }}</div>
                                                @break
                                            @case('success')
                                                <div class="site-badge badge-success">{{ __('Success') }}</div>
                                                @break
                                            @case('failed')
                                                <div class="site-badge bg-danger text-white">{{ __('Cancelled') }}</div>
                                                @break
                                        @endswitch
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">
                                            @if($transaction->transfer_type == 'wire_transfer')
                                               {{ __('Wire Transfer') }}
                                            @else
                                                {{$transaction->beneficiary->bank->name ?? 'Own Bank'}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{ $transactions->links() }}
                        </div>
                        @if(count($transactions) == 0)
                        <div class="text-center">{{ __('No Data Found!') }}</div>
                        @endif
                    </div>
                </div>
                @include('frontend.default.fund_transfer.include.__action_message_modal')
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="{{ asset('front/js/moment.min.js') }}"></script>
<script src="{{ asset('front/js/daterangepicker.min.js') }}"></script>
<script>
    "use strict";

    $(document).on('click','#action-btn',function(){
        let message = $(this).data('message');
        $('#message-body').text(message);
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
        window.location.href = "{{ route('user.fund_transfer.transfer.log') }}";
    });

</script>
@endsection
