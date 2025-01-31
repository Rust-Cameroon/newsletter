@extends('backend.layouts.app')
@section('title')
    {{ __('DPS Details') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('DPS Details') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h4 class="title-small">{{ __('User Information') }}</h4>
                        </div>
                        <div class="site-card-body">
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Username') }}</div>
                                <div class="value">{{ $dps->user->username }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Name') }}</div>
                                <div class="value">{{ $dps->user->full_name }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Country') }}</div>
                                <div class="value">{{ $dps->user->country }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Phone') }}</div>
                                <div class="value">{{ $dps->user->phone }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Balance') }}</div>
                                <div class="value">{{ $currencySymbol.$dps->user->balance }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Status') }}</div>
                                <div class="value">
                                    @switch($dps->status->value)
                                        @case('running')
                                            <div class="site-badge pending">{{ __('Running') }}</div>
                                            @break
                                        @case('mature')
                                            <div class="site-badge success">{{ __('Mature') }}</div>
                                            @break
                                        @case('due')
                                            <div class="site-badge pending">{{ __('Due') }}</div>
                                            @break
                                        @case('closed')
                                            <div class="site-badge danger">{{ __('Closed') }}</div>
                                            @break
                                    @endswitch
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h4 class="title-small">{{ __('Plan Information') }}</h4>
                        </div>
                        <div class="site-card-body">
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Name') }}</div>
                                <div class="value">{{ $dps->plan->name }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Interval') }}</div>
                                <div class="value">{{ $dps->plan->interval }} {{ __('Days') }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Total Installment') }}</div>
                                <div class="value">{{ $dps->plan->total_installment }} Times</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Per Installment') }}</div>
                                <div class="value">{{ $currencySymbol.$dps->plan->per_installment }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Total Deposit') }}</div>
                                <div class="value">{{ $currencySymbol.$dps->plan->total_deposit }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Mature Amount') }}</div>
                                <div class="value">{{ $currencySymbol.$dps->plan->total_mature_amount }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="site-table table-responsive">
                        <table class="table">
                        <thead>
                        <tr>
                            <th>{{ __('SERIAL') }}</th>
                            <th>{{ __('INSTALLMENT DATES') }}</th>
                            <th>{{ __('GIVEN DATE') }}</th>
                            <th>{{ __('DEFERMENT') }}</th>
                            <th>{{ __('PAID AMOUNT') }}</th>
                            <th>{{ __('CHARGE') }}</th>
                            <th>{{ __('FINAL AMOUNT') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dps->transactions as $transaction)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ safe($transaction->installment_date) }}</td>
                                <td>{{ safe($transaction->given_date == null ? 'Yet To Pay' : $transaction->given_date->format('d M Y')) }}</td>
                                <td>{{ safe($transaction->given_date == null ? 'None' : $transaction->deferment) }}</td>
                                <td>{{ safe($transaction->given_date == null ? 'None' : $currencySymbol.$transaction->paid_amount) }}</td>
                                <td>{{ safe($transaction->given_date == null ? 'None' : $currencySymbol.$transaction->charge) }}</td>
                                <td>{{ safe($transaction->given_date == null ? 'None' : $currencySymbol.$transaction->final_amount) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
