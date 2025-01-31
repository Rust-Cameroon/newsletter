@extends('backend.layouts.app')
@section('title')
    {{ __($statusForFrontend.' FDR') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __($statusForFrontend.' FDR') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="site-table table-responsive">
                        @include('backend.fdr.include.__filter', ['status' => false, 'type' => false ])
                        <table class="table">
                            <thead>
                            <tr>
                                @include('backend.filter.th',['label' => 'Plan','field' => 'plan'])
                                @include('backend.filter.th',['label' => 'User','field' => 'user'])
                                @include('backend.filter.th',['label' => 'FDR ID','field' => 'fdr_id'])
                                @include('backend.filter.th',['label' => 'Amount','field' => 'amount'])
                                <th>{{ __('Next Return') }}</th>
                                <th>{{ __('Profit') }}</th>
                                @include('backend.filter.th',['label' => 'Open At','field' => 'created_at'])
                                @include('backend.filter.th',['label' => 'Status','field' => 'status'])
                                <th>{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($lists as $fdr)
                                <tr>
                                    <td>
                                        {{ $fdr->plan->name }}
                                    </td>
                                    <td>
                                        @include('backend.fdr.include.__user', ['id' => $fdr->user_id, 'name' => $fdr->user->username])
                                    </td>
                                    <td>{{ safe($fdr->fdr_id) }}</td>
                                    <td>
                                        {{ setting('currency_symbol', 'global').safe($fdr->amount) }}
                                    </td>
                                    <td>
                                        @php
                                            $trx = \App\Models\FDRTransaction::where('fdr_id', $fdr->id)->where('paid_amount', null)->first();
                                        @endphp
                                        {{ $trx->given_date->format('d M Y') }}
                                    </td>
                                    <td>
                                        {{ setting('currency_symbol', 'global').$fdr->profit() }}
                                    </td>
                                    <td>
                                        {{ $fdr->created_at }}
                                    </td>
                                    <td>
                                        @include('backend.fdr.include.__dps_status', ['status' => $fdr->status->value])
                                    </td>
                                    <td>
                                        @include('backend.fdr.include.__action', ['id' => $fdr->id])
                                    </td>
                                </tr>
                            @empty
                            <td colspan="9" class="text-center">{{ __('No Data Found!') }}</td>
                            @endforelse
                            </tbody>
                        </table>

                        {{ $lists->links('backend.include.__pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

