@extends('backend.layouts.app')
@section('title')
    {{ __('Bank Profits') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title"></div>
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h4 class="title">{{ __('Bank Profits') }}</h4>
                            <div class="card-header-info">{{ __('Total Profits:') }} {{ $totalProfits }} {{ $currency }}</div>
                        </div>
                        <div class="site-card-body p-0">
                            <div class="site-table table-responsive">
                                @include('backend.transaction.include.__filter', ['status' => true, 'type' => true ])
                                <table class="table">
                                    <thead>
                                    <tr>
                                        @include('backend.filter.th',['label' => 'Date','field' => 'created_at'])
                                        @include('backend.filter.th',['label' => 'User','field' => 'user'])
                                        @include('backend.filter.th',['label' => 'Amount','field' => 'final_amount'])
                                        @include('backend.filter.th',['label' => 'Type','field' => 'type'])
                                        @include('backend.filter.th',['label' => 'Description','field' => 'description'])
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($profits as $profit)
                                        <tr>
                                            <td>
                                                {{ $profit->created_at }}
                                            </td>
                                            <td>
                                                @include('backend.transaction.include.__user', ['id' => $profit->user_id, 'name' => $profit->user->username])
                                            </td>
                                            <td>
                                                {{ $currencySymbol.$profit->charge }}
                                            </td>
                                            <td>
                                                @include('backend.transaction.include.__txn_type', ['txnType' => $profit->type->value])
                                            </td>
                                            <td>
                                                {{ safe($profit->description) }}
                                            </td>
                                        </tr>
                                    @empty
                                    <td colspan="6" class="text-center">{{ __('No Data Found!') }}</td>
                                    @endforelse
                                    </tbody>
                                </table>

                                {{ $profits->links('backend.include.__pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

