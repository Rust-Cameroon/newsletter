@extends('backend.layouts.app')
@section('title')
    {{ __('FDR Details') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('FDR Details') }}</h2>
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
                                <div class="value">{{ $fdr->user->username }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Name') }}</div>
                                <div class="value">{{ $fdr->user->full_name }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Country') }}</div>
                                <div class="value">{{ $fdr->user->country }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Phone') }}</div>
                                <div class="value">{{ $fdr->user->phone }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Balance') }}</div>
                                <div class="value green-color">{{$fdr->user->balance.' '.$currency }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Status') }}</div>
                                <div class="value">{{ $fdr->status->value}}</div>
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
                                <div class="value">{{ $fdr->plan->name }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Interval') }}</div>
                                <div class="value">{{ $fdr->plan->intervel }} {{ __('Days') }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Next Return') }}</div>
                                <div class="value">
                                    @php
                                        $trx = \App\Models\FDRTransaction::where('fdr_id', $fdr->id)->where('paid_amount', null)->first();
                                    @endphp
                                    {{ $trx->given_date->format('d M Y') }}
                                </div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Total Returns') }}</div>
                                <div class="value">{{ $fdr->totalInstallment() }} {{ __('Times') }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Profit') }}</div>
                                <div class="value">{{ $fdr->profit().' '.$currency }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Total Profit') }}</div>
                                <div class="value">{{ $fdr->transactions->sum('given_amount').' '.$currency }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="site-table table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Serial') }}</th>
                                    <th>{{ __('Return Dates') }}</th>
                                    <th>{{ __('Interest Amount') }}</th>
                                    <th>{{ __('Paid Amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($fdr->transactions as $transaction)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ safe($transaction->given_date->format('d M Y')) }}</td>
                                    <td>{{ safe($transaction->given_amount) }} {{ $currency }}</td>
                                    <td>{{ safe($transaction->paid_amount == null ? 'None' : $transaction->paid_amount . ' '. $currency) }}</td>
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
