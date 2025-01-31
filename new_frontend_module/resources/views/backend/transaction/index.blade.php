@extends('backend.layouts.app')
@section('title')
    {{ __('Transactions') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('All Transactions') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="site-table table-responsive">
                        @include('backend.transaction.include.__filter', ['status' => true, 'type' => true ])
                        <table class="table">
                            <thead>
                            <tr>
                                @include('backend.filter.th',['label' => 'Date','field' => 'created_at'])
                                @include('backend.filter.th',['label' => 'User','field' => 'user'])
                                @include('backend.filter.th',['label' => 'Transaction ID','field' => 'tnx'])
                                @include('backend.filter.th',['label' => 'Type','field' => 'type'])
                                @include('backend.filter.th',['label' => 'Amount','field' => 'final_amount'])
                                @include('backend.filter.th',['label' => 'Gateway','field' => 'method'])
                                @include('backend.filter.th',['label' => 'Status','field' => 'status'])
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td>
                                        {{ $transaction->created_at }}
                                    </td>
                                    <td>
                                        @include('backend.transaction.include.__user', ['id' => $transaction->user_id, 'name' => $transaction->user->username])
                                    </td>
                                    <td>{{ safe($transaction->tnx) }}</td>
                                    <td>
                                        @include('backend.transaction.include.__txn_type', ['txnType' => $transaction->type->value])
                                    </td>
                                    <td>
                                        @include('backend.transaction.include.__txn_amount', ['txnType' => $transaction->type->value, 'amount' => $transaction->final_amount, 'currency' => $transaction->pay_currency])
                                    </td>
                                    <td>
                                        {{ safe($transaction->method) }}
                                    </td>
                                    <td>
                                        @include('backend.transaction.include.__txn_status', ['txnStatus' => $transaction->status->value])
                                    </td>
                                </tr>
                            @empty
                            <td colspan="7" class="text-center">{{ __('No Data Found!') }}</td>
                            @endforelse
                            </tbody>
                        </table>

                        {{ $transactions->links('backend.include.__pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

