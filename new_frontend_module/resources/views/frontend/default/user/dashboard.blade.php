@extends('frontend::layouts.user')
@section('title')
    {{ __('Dashboard') }}
@endsection
@section('content')

    <div class="row">
        <div class="col-xl-4 col-lg-12 col-md-12 col-12">
            <div class="user-profile-card">
                @if (setting('user_portfolio', 'permission') && Auth::user()->portfolio_status && auth()->user()->portfolio_id != null)
                <div class="badge">
                    <a href="{{ route('user.portfolio') }}" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-placement="top" data-bs-title="{{ auth()->user()->portfolio?->portfolio_name }}">
                        <img src="{{ asset(auth()->user()->portfolio?->icon) }}" alt="">
                    </a>
                </div>
                @endif

                <input type="hidden" id="refLink" value="{{ auth()->user()->account_number }}">

                <h4 class="title">{{ __('Account Balance') }}</h4>

                <h3 class="acc-balance" id="passo">
                    {{ setting('currency_symbol','global').number_format($user->balance,2) }}
                </h3>

                <div class="acc-num">A/C:
                    <strong>{{ auth()->user()->account_number }}</strong>
                    <span id="copy" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-placement="right" data-bs-title="Copy"><i data-lucide="copy"></i></span>
                </div>

                @php
                    $last_login = auth()->user()->activities->last();
                    $browser = getBrowser($last_login?->agent);
                @endphp
                @if($last_login)
                <div class="last-login">{{ __('Last Login At') }} {{ $last_login?->created_at->format('d M, h:i A') }}. {{ data_get($browser,'platform') }} . {{ data_get($browser,'browser') }}</div>
                @endif
                <div class="buttons">
                    <a href="{{ route('user.deposit.amount') }}" class="add"><i data-lucide="plus-circle"></i>{{ __('Add Money') }}</a>
                    <a href="{{ route('user.fund_transfer.index') }}" class="send"><i data-lucide="send"></i>{{ __('Send Money') }}</a>
                </div>
                <div class="o">O</div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-12 col-md-12 col-12">
            <div class="row">
                @if(setting('user_dps','permission'))
                <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                    <div class="single-spec-stat">
                        <div class="top">
                            <div class="icon">
                                <i data-lucide="archive"></i>
                            </div>
                            <div class="title">{{ __('My DPS') }}</div>
                        </div>
                        <div class="text">
                            @if($total_running_dps > 0)
                            <p>{{ __('DPS will be end by') }} <strong>{{ $dps_last_date }}</strong> {{ __('and fund will be added on your account.') }}</p>
                            @else
                            <p>{{ __('Currently No DPS Found.') }}</p>
                            @endif
                        </div>
                        <div class="bottom">
                            @if($total_running_dps > 0)
                            <div class="amount">{{ $currencySymbol.number_format(getTotalMature($user->dps->first()),2)  }}</div>
                            @else
                            <div class="amount">{{ $currencySymbol.number_format(0,2)  }}</div>
                            @endif
                            <a href="{{ route('user.dps.history') }}" class="ex-link"><i data-lucide="arrow-up-right"></i></a>
                        </div>
                    </div>
                </div>
                @endif
                @if(setting('user_fdr','permission'))
                <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                    <div class="single-spec-stat">
                        <div class="top">
                            <div class="icon">
                                <i data-lucide="book"></i>
                            </div>
                            <div class="title">
                                {{ __('My FDR') }}
                            </div>
                        </div>
                        <div class="text">
                            @if($total_running_fdr > 0)
                            <p>{{ __('FDR will be end by ') }}<strong>{{ $fdr_last_date }}</strong>{{ __(' and fund will be added on your account.') }}</p>
                            @else
                            <p>{{ __('Currently No FDR Found.') }}</p>
                            @endif
                        </div>
                        <div class="bottom">
                            @if($total_running_fdr > 0)
                            <div class="amount">{{ $currencySymbol.number_format($user->fdr->first()->transactions->sum('given_amount'),2) }}</div>
                            @else
                            <div class="amount">{{ $currencySymbol.number_format(0,2) }}</div>
                            @endif
                            <a href="{{ route('user.fdr.history') }}" class="ex-link"><i data-lucide="arrow-up-right"></i></a>
                        </div>
                    </div>
                </div>
                @endif
                @if(setting('user_loan','permission'))
                <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                    <div class="single-spec-stat">
                        <div class="top">
                            <div class="icon">
                                <i data-lucide="alert-triangle"></i>
                            </div>
                            <div class="title">{{ __('My Loan') }}</div>
                        </div>
                        <div class="text">
                            @if($total_running_loan > 0)
                            <p>{{ __('Your Loan will be closed on') }} <strong>{{ $loan_last_date }}</strong>, {{ __('Need to payback continuously.') }}</p>
                            @else
                            <p>{{ __('Currently No Loan Found.') }}</p>
                            @endif
                        </div>
                        <div class="bottom">
                            @if($total_running_loan > 0)
                            <div class="amount">{{ $currencySymbol.number_format($user->loan->first()->totalPayableAmount(),2) }}</div>
                            @else
                            <div class="amount">{{ $currencySymbol.number_format(0,2) }}</div>
                            @endif
                            <a href="{{ route('user.loan.history') }}" class="ex-link"><i data-lucide="arrow-up-right"></i></a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
            <div class="single-user-stat-card">
                <div class="icon">
                    <img src="{{ asset('front/images/icons/fintech/1.png') }}" alt="">
                </div>
                <div class="number">{{ $total_transaction }}</div>
                <div class="title">{{ __('All Transactions') }}</div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
            <div class="single-user-stat-card">
                <div class="icon">
                    <img src="{{ asset('front/images/icons/fintech/2.png') }}" alt="">
                </div>
                <div class="number">{{ $total_deposit }} {{ $currency }}</div>
                <div class="title">{{ __('Total Deposit') }}</div>
            </div>
        </div>
        @if(setting('transfer_status','permission'))
        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
            <div class="single-user-stat-card">
                <div class="icon">
                    <img src="{{ asset('front/images/icons/fintech/3.png') }}" alt="">
                </div>
                <div class="number">{{ $total_transfer }} {{ $currency }}</div>
                <div class="title">{{ __('Total Transfer') }}</div>
            </div>
        </div>
        @endif
        @if(setting('user_pay_bill','permission'))
        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
            <div class="single-user-stat-card">
                <div class="icon">
                    <img src="{{ asset('front/images/icons/fintech/9.png') }}" alt="">
                </div>
                <div class="number">{{ $total_bill }}</div>
                <div class="title">{{ __('Total Pay Bill') }}</div>
            </div>
        </div>
        @endif
        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
            <div class="single-user-stat-card">
                <div class="icon">
                    <img src="{{ asset('front/images/icons/fintech/4.png') }}" alt="">
                </div>
                <div class="number">{{ $total_referral_profit }} {{ $currency }}</div>
                <div class="title">{{ __('Referral Bonus') }}</div>
            </div>
        </div>
        @if(setting('user_dps','permission'))
        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
            <div class="single-user-stat-card">
                <div class="icon">
                    <img src="{{ asset('front/images/icons/fintech/5.png') }}" alt="">
                </div>
                <div class="number">{{ $total_dps }}</div>
                <div class="title">{{ __('Total DPS') }}</div>
            </div>
        </div>
        @endif
        @if(setting('user_fdr','permission'))
        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
            <div class="single-user-stat-card">
                <div class="icon">
                    <img src="{{ asset('front/images/icons/fintech/6.png') }}" alt="">
                </div>
                <div class="number">{{ $total_fdr }}</div>
                <div class="title">{{ __('Total FDR') }}</div>
            </div>
        </div>
        @endif
        @if(setting('user_loan','permission'))
        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
            <div class="single-user-stat-card">
                <div class="icon">
                    <img src="{{ asset('front/images/icons/fintech/7.png') }}" alt="">
                </div>
                <div class="number">{{ $total_loan }}</div>
                <div class="title">{{ __('Total Loan') }}</div>
            </div>
        </div>
        @endif
        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
            <div class="single-user-stat-card">
                <div class="icon">
                    <img src="{{ asset('front/images/icons/fintech/8.png') }}" alt="">
                </div>
                <div class="number">{{ $deposit_bonus }} {{ $currency }}</div>
                <div class="title">{{ __('Deposit Bonus') }}</div>
            </div>
        </div>
        @if(setting('sign_up_referral','permission'))
        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
            <div class="single-user-stat-card">
                <div class="icon">
                    <img src="{{ asset('front/images/icons/fintech/10.png') }}" alt="">
                </div>
                <div class="number">{{ $total_referral }}</div>
                <div class="title">{{ __('Total Referral') }}</div>
            </div>
        </div>
        @endif
        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
            <div class="single-user-stat-card">
                <div class="icon">
                    <img src="{{ asset('front/images/icons/fintech/11.png') }}" alt="">
                </div>
                <div class="number">{{ $total_withdraw }} {{ $currency }}</div>
                <div class="title">{{ __('Total Withdraw') }}</div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
            <div class="single-user-stat-card">
                <div class="icon">
                    <img src="{{ asset('front/images/icons/fintech/12.png') }}" alt="">
                </div>
                <div class="number">{{ $total_tickets }}</div>
                <div class="title">{{ __('Total Ticket') }}</div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title-small">{{ __('Recent Transactions') }}</div>
                    <div class="card-header-links">
                        <a href="{{ route('user.transactions') }}" class="card-header-link"><i data-lucide="eye"></i>{{ __('See All') }}</a>
                    </div>
                </div>
                <div class="site-card-body p-0 overflow-x-auto">
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
                            </div>
                            @foreach ($recentTransactions as $transaction)
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
                            </div>
                            @endforeach
                        </div>
                        @if(count($recentTransactions) == 0)
                        <div class="no-data-found">{{ __('No Data Found') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('script')
    <script>

        $('#copy').on('click',function(){
            copyRef();
        });

        function copyRef() {
            /* Get the text field */
            var textToCopy = $('#refLink').val();
            // Create a temporary input element
            var tempInput = $('<input>');
            $('body').append(tempInput);
            tempInput.val(textToCopy).select();
            // Copy the text from the temporary input
            document.execCommand('copy');
            // Remove the temporary input element
            tempInput.remove();

            // Set tooltip as copied
            var tooltip = bootstrap.Tooltip.getInstance('#copy');
            tooltip.setContent({ '.tooltip-inner': 'Copied' });

            setTimeout(() => {
                tooltip.setContent({ '.tooltip-inner': 'Copy' });
            }, 4000);
        }

    </script>
@endsection
