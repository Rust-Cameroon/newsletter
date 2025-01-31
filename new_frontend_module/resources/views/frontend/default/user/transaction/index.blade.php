@php use App\Enums\TxnStatus; @endphp
@extends('frontend::layouts.user')
@section('title')
{{ __('Transactions') }}
@endsection
@push('style')
<link rel="stylesheet" href="{{ asset('front/css/daterangepicker.css') }}">
@endpush
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
        <div class="site-card">
            <div class="site-card-header">
                <div class="title-small">{{ __('All Transactions') }}</div>
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
                                <label for="">{{ __('Type') }}</label>
                                <select name="type" class="nice-select page-count w-100 ">
                                    <option value="all" @selected(request('type') == 'all')>{{ __('All Type') }}</option>
                                    <option value="deposit" @selected(request('type') == 'deposit')>{{ __('Deposit') }}</option>
                                    <option value="fund_transfer" @selected(request('type') == 'fund_transfer')>{{ __('Fund Transfer') }}</option>
                                    <option value="dps" @selected(request('type') == 'dps')>{{ __('DPS') }}</option>
                                    <option value="fdr" @selected(request('type') == 'fdr')>{{ __('FDR') }}</option>
                                    <option value="loan" @selected(request('type') == 'loan')>{{ __('Loan') }}</option>
                                    <option value="pay_bill" @selected(request('type') == 'pay_bill')>{{ __('Pay Bill') }}</option>
                                    <option value="withdraw" @selected(request('type') == 'withdraw')>{{ __('Withdraw') }}</option>
                                    <option value="referral" @selected(request('type') == 'referral')>{{ __('Referral') }}</option>
                                    <option value="portfolio" @selected(request('type') == 'portfolio')>{{ __('Portfolio') }}</option>
                                    <option value="rewards" @selected(request('type') == 'rewards')>{{ __('Rewards') }}</option>
                                </select>
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
                            <div class="site-table-col">{{ __('Transactions ID') }}</div>
                            <div class="site-table-col">{{ __('Type') }}</div>
                            <div class="site-table-col">{{ __('Amount') }}</div>
                            <div class="site-table-col">{{ __('Charge') }}</div>
                            <div class="site-table-col">{{ __('Status') }}</div>
                            <div class="site-table-col">{{ __('Method') }}</div>
                            <div class="site-table-col">{{ __('View') }}</div>
                        </div>
                        @foreach ($transactions as $transaction)
                        <div class="site-table-list">
                            <div class="site-table-col">
                                <div class="description">
                                    <div class="event-icon">
                                        @if($transaction->type->value == 'deposit' || $transaction->type->value == 'manual_deposit')
                                        <i data-lucide="chevrons-down"></i>
                                        @elseif(Str::startsWith($transaction->type->value ,'dps'))
                                        <i data-lucide="archive"></i>
                                        @elseif(Str::startsWith($transaction->type->value ,'fdr'))
                                        <i data-lucide="book"></i>
                                        @elseif(Str::startsWith($transaction->type->value ,'loan'))
                                        <i data-lucide="alert-triangle"></i>
                                        @elseif($transaction->type->value == 'subtract')
                                        <i data-lucide="minus-circle"></i>
                                        @elseif($transaction->type->value == 'receive_money')
                                        <i data-lucide="arrow-down-left"></i>
                                        @elseif($transaction->type->value == 'reward_redeem')
                                        <i data-lucide="gift"></i>
                                        @else
                                        <i data-lucide="send"></i>
                                        @endif
                                    </div>
                                    <div class="content">
                                        <div class="title">
                                            {{ $transaction->description }}
                                            @if(!in_array($transaction->approval_cause,['none',""]))
                                            <span class="msg" data-bs-toggle="tooltip"
                                                data-bs-custom-class="custom-tooltip" data-bs-placement="top"
                                                data-bs-title="{{ $transaction->approval_cause }}"><i
                                                    data-lucide="message-square"></i>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="date">{{ $transaction->created_at }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="site-table-col">
                                <div class="trx fw-bold">{{ $transaction->tnx }}</div>
                            </div>
                            <div class="site-table-col">
                                <div class="type site-badge badge-primary">{{ ucfirst(str_replace('_',' ',$transaction->type->value)) }}</div>
                            </div>
                            <div class="site-table-col">
                                <div @class([
                                    "fw-bold",
                                    "green-color" => isPlusTransaction($transaction->type) == true,
                                    "red-color" => isPlusTransaction($transaction->type) == false
                                ])>{{ isPlusTransaction($transaction->type) == true ? '+' : '-' }}{{ $transaction->amount.' '.$currency }}</div>
                            </div>
                            <div class="site-table-col">
                                <div class="fw-bold red-color">-{{ $transaction->charge.' '.$currency }}</div>
                            </div>
                            <div class="site-table-col">
                                @if($transaction->status->value == 'failed')
                                    <div class="type site-badge badge-failed">{{ $transaction->status->value }}</div>
                                @elseif($transaction->status->value == 'success')
                                    <div class="type site-badge badge-success">{{ $transaction->status->value }}</div>
                                @elseif($transaction->status->value == 'pending')
                                    <div class="type site-badge badge-pending">{{ $transaction->status->value }}</div>
                                @endif
                            </div>
                            <div class="site-table-col">
                                <div class="fw-bold">{{ $transaction->method !== '' ? ucfirst(str_replace('-',' ',$transaction->method)) :  __('System') }}</div>
                            </div>
                            <div class="site-table-col">
                                <div class="action">
                                    <a href="javascript:void(0)"
                                    class="icon-btn details-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#trxViewDetailsBox"
                                    data-title="{{ $transaction->description }}"
                                    data-type="{{ $transaction->type->value }}"
                                    data-time="{{ $transaction->created_at }}"
                                    data-transaction-id="{{ $transaction->tnx }}"
                                    data-transaction="{{ $transaction->manual_field_data }}"
                                    data-message="{{ $transaction->action_message }}"
                                    data-amount="{{ isPlusTransaction($transaction->type) == true ? '+' : '-' }}{{ $transaction->amount.' '.$currency }}"
                                    data-charge="{{ $transaction->charge.' '.$currency  }}"
                                    data-status="{{ $transaction->status->value }}"
                                    data-method="{{ $transaction->method !== '' ? ucfirst(str_replace('-',' ',$transaction->method)) :  __('System') }}"
                                    >
                                        <i data-lucide="eye"></i>{{ __('Details') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if(count($transactions) == 0)
                    <div class="no-data-found">{{ __('No Data Found') }}</div>
                    @endif
                </div>

                <!-- Modal for Transaction View Details -->
                <div class="modal fade" id="trxViewDetailsBox" tabindex="-1"
                    aria-labelledby="trxViewDetailsBoxModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content site-table-modal">
                            <div class="modal-body popup-body">
                                <button type="button" class="modal-btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"><i data-lucide="x"></i></button>
                                <div class="popup-body-text">
                                    <div class="title title-value"></div>
                                    <div class="modal-beneficiary-details">
                                        <div class="profile-text-data">
                                            <div class="attribute">{{ __('Time') }}</div>
                                            <div class="value time-value"></div>
                                        </div>
                                        <div class="profile-text-data">
                                            <div class="attribute">{{ __('Transaction ID') }}</div>
                                            <div class="value trx-value"></div>
                                        </div>
                                        <div class="profile-text-data">
                                            <div class="attribute">{{ __('Amount') }}</div>
                                            <div class="value green-color amount-value"></div>
                                        </div>
                                        <div class="profile-text-data">
                                            <div class="attribute">{{ __('Charge') }}</div>
                                            <div class="value red-color charge-value"></div>
                                        </div>
                                        <div class="profile-text-data">
                                            <div class="attribute">{{ __('Status') }}</div>
                                            <div class="value status-value"></div>
                                        </div>
                                        <div class="profile-text-data">
                                            <div class="attribute">{{ __('Method') }}</div>
                                            <div class="value method-value"></div>
                                        </div>
                                        <div class="custom-fields"></div>

                                        <div class="profile-text-data">
                                            <div class="attribute message-value"></div>
                                        </div>
                                    </div>
                                    <div class="action-btns mt-3">
                                        <a href="" class="site-btn-sm polis-btn" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <i data-lucide="check"></i>
                                            {{ __('Close it') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal for Transaction View Details end-->

                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
@push('js')
<script src="{{ asset('front/js/moment.min.js') }}"></script>
<script src="{{ asset('front/js/daterangepicker.min.js') }}"></script>
<script>

    // Initialize datepicker
    $('input[name="daterange"]').daterangepicker({
        opens: 'left'
    });

    @if(request('daterange') == null)
    // Set default is empty for date range
    $('input[name=daterange]').val('');
    @endif

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    // Set data for modal
    $(document).on('click', '.details-btn', function (e) {

        e.preventDefault();

        var id = $(this).data('id');
        var title = $(this).data('title');
        var type = $(this).data('type');
        var time = $(this).data('time');
        var trx = $(this).data('transaction-id');
        var amount = $(this).data('amount');
        var charge = $(this).data('charge');
        var method = $(this).data('method');
        var status = $(this).data('status');
        var transaction = $(this).data('transaction');

        var statusElement = '';
        var additionalData = '';

        $.each(transaction,function(key,value){
            additionalData += '<div class="profile-text-data"><div class="attribute">'+capitalizeFirstLetter(key.replaceAll('_',' '))+'</div><div class="value">'+value+'</div></div>';
        });

        if(status == 'failed'){
            statusElement += `<div class="type site-badge badge-failed">{{ __('Failed') }}</div>`
        }else if(status == 'success'){
            statusElement += `<div class="type site-badge badge-success">{{ __('Success') }}</div>`
        }else{
            statusElement += `<div class="type site-badge badge-pending">{{ __('Pending') }}</div>`
        }

        $('.title-value').text(title);
        $('.trx-value').text(trx);
        $('.time-value').text(time);
        $('.amount-value').text(amount);
        $('.charge-value').text(charge);
        $('.method-value').text(method);
        $('.status-value').html(statusElement);

        $('.custom-fields').html(additionalData);

    });

    // Reset filter
    $('.reset-filter').on('click',function(){
        window.location.href = "{{ route('user.transactions') }}";
    });

</script>
@endpush
@endsection
