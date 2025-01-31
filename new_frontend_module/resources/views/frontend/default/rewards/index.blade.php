@extends('frontend::layouts.user')
@section('title')
    {{ __('Rewards') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-12 col-md-12 col-12">
            <div class="user-profile-card rewards-card">
                @if($myPortfolio)
                <div class="current-member">
                    <img src="{{ asset(auth()->user()->portfolio?->icon) }}" alt=""> {{ auth()->user()->portfolio?->portfolio_name }}
                </div>
                @endif
                <h4 class="title mb-2">{{ __('My Reward Points') }}</h4>
                <h3 class="acc-balance" id="passo">{{ auth()->user()->points }}</h3>

                <a href="{{ route('user.rewards.redeem.now') }}" class="site-btn polis-btn me-2">
                    <i data-lucide="gift"></i>{{ __('Redeem Now') }}
                </a>
                @if($myPortfolio)
                <div class="last-login ms-2 mt-1">{{ __("Every :points reward points are :amount",['points' => $myPortfolio->point,'amount' => $currencySymbol.$myPortfolio->amount]) }}</div>
                @endif
                <div class="o">O</div>
            </div>
        </div>
        <div class="col-xl-4 offset-xl-4 col-lg-12 col-md-12 col-12">
            <img src="{{ asset('front/images/reward.png') }}" alt="" class="rounded">
        </div>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="site-card">
                    <div class="site-card-header">
                        <div class="title-small">{{ __('Reward Point Earnings:') }}</div>
                    </div>
                    <div class="site-card-body p-0 overflow-x-auto">
                        <div class="site-custom-table site-custom-table-sm">
                            <div class="contents">
                                <div class="site-table-list site-table-head">
                                    <div class="site-table-col">{{ __('Portfolio List') }}</div>
                                    <div class="site-table-col">{{ __('Amount Of Transactions') }}</div>
                                    <div class="site-table-col">{{ __('Reward') }}</div>
                                </div>
                                @foreach ($earnings as $earning)
                                <div class="site-table-list">
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $earning->portfolio->portfolio_name }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">{{ $earning->amount_of_transactions.' '.$currency }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">{{ $earning->point }} {{ __('Points') }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="site-card">
                    <div class="site-card-header">
                        <div class="title-small">{{ __('Reward Points Redeem:') }}</div>
                    </div>
                    <div class="site-card-body p-0 overflow-x-auto">
                        <div class="site-custom-table site-custom-table-sm">
                            <div class="contents">
                                <div class="site-table-list site-table-head">
                                    <div class="site-table-col">{{ __('Portfolio List') }}</div>
                                    <div class="site-table-col">{{ __('Per Points') }}</div>
                                    <div class="site-table-col">{{ __('Redeem Amount') }}</div>
                                </div>
                                @foreach ($redeems as $redeem)
                                <div class="site-table-list">
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $redeem->portfolio->portfolio_name }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">{{ $redeem->point }} {{ __('Points') }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">{{ $redeem->amount.' '.$currency }}</div>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="site-card">
                    <div class="site-card-header">
                        <div class="title-small">{{ __('Redeem Summary:') }}</div>
                    </div>
                    <div class="site-card-body p-0 overflow-x-auto">
                        <div class="site-custom-table site-custom-table-sm">
                            <div class="contents">
                                <div class="site-table-list site-table-head">
                                    <div class="site-table-col">{{ __('Description') }}</div>
                                    <div class="site-table-col">{{ __('Amount') }}</div>
                                    <div class="site-table-col">{{ __('Redeemed Date') }}</div>
                                    <div class="site-table-col">{{ __('Transaction Type') }}</div>
                                </div>
                                @foreach ($transactions as $transaction)
                                <div class="site-table-list">
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $transaction->description }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div @class([
                                            "fw-bold",
                                            "green-color" => isPlusTransaction($transaction->type) == true,
                                            "red-color" => isPlusTransaction($transaction->type) == false
                                        ])>{{ isPlusTransaction($transaction->type) == true ? '+' : '-' }}{{ $transaction->amount.' '.$currency }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $transaction->created_at }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="type site-badge badge-primary">{{ ucfirst(str_replace('_',' ',$transaction->type->value)) }}</div>
                                    </div>

                                </div>
                                @endforeach
                                {{ $transactions->links() }}
                            </div>
                            @if(count($transactions) == 0)
                            <div class="no-data-found">{{ __('No Data Found') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
