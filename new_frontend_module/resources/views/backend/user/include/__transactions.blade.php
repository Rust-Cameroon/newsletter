@if(request('tab') == 'transactions')
<div
    @class([
        'tab-pane fade',
        'show active' => request('tab') == 'transactions'
    ])
    id="pills-transactions"
    role="tabpanel"
    aria-labelledby="pills-transactions-tab"
>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h4 class="title">{{ __('Transactions') }}</h4>
                </div>
                <div class="site-card-body table-responsive">
                    <div class="site-table">
                        <div class="table-filter">
                            <form action="" method="get">
                                <input type="hidden" name="tab" value="transactions">
                                <div class="filter d-flex">
                                    <div class="search">
                                        <label for="">{{ __('Search:') }}</label>
                                        <input type="text" name="query" value="{{ request('query') }}"/>
                                    </div>
                                    <button class="apply-btn" type="submit"><i data-lucide="search"></i>{{ __('Search') }}</button>
                                </div>
                            </form>
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                @include('backend.filter.th',['label' => 'Date','field' => 'created_at'])
                                @include('backend.filter.th',['label' => 'Transaction ID','field' => 'tnx'])
                                @include('backend.filter.th',['label' => 'Type','field' => 'type'])
                                @include('backend.filter.th',['label' => 'Amount','field' => 'final_amount'])
                                @include('backend.filter.th',['label' => 'Gateway','field' => 'method'])
                                @include('backend.filter.th',['label' => 'Status','field' => 'status'])
                            </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at }}</td>
                                    <td>{{ $transaction->tnx }}</td>
                                    <td>
                                        @include('backend.transaction.include.__txn_type',[ 'txnType' => $transaction->type->value])
                                    </td>
                                    <td>
                                        @include('backend.transaction.include.__txn_amount',['amount' => $transaction->final_amount,'txnType' => $transaction->type->value])
                                    </td>
                                    <td>{{ $transaction->method }}</td>
                                    <td>
                                        @include('backend.user.include.__txn_status',['status' => $transaction->status->value])

                                    </td>
                                </tr>
                                @empty
                                <td colspan="7" class="text-center">{{ __('No Data Found!') }}</td>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
