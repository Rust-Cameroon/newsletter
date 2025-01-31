@extends('backend.withdraw.index')
@section('title')
    {{ __('Withdraw History') }}
@endsection
@section('withdraw_content')
    <div class="col-xl-12 col-md-12">
        <div class="site-card-body table-responsive">
            <div class="site-table table-responsive">
                @include('backend.withdraw.include.__filter', ['status' => true])
                <table class="table">
                    <thead>
                        <tr>
                            @include('backend.filter.th',['label' => 'Date','field' => 'created_at'])
                            @include('backend.filter.th',['label' => 'User','field' => 'user'])
                            @include('backend.filter.th',['label' => 'Transaction ID','field' => 'tnx'])
                            @include('backend.filter.th',['label' => 'Amount','field' => 'amount'])
                            @include('backend.filter.th',['label' => 'Charge','field' => 'charge'])
                            @include('backend.filter.th',['label' => 'Gateway','field' => 'method'])
                            @include('backend.filter.th',['label' => 'Status','field' => 'status'])
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($withdrawals as $withdraw)
                        <tr>
                            <td>
                                {{ $withdraw->created_at }}
                            </td>
                            <td>
                                @include('backend.transaction.include.__user', ['id' => $withdraw->user_id, 'name' => $withdraw->user->username])
                            </td>
                            <td>{{ safe($withdraw->tnx) }}</td>
                            <td>
                                @include('backend.transaction.include.__txn_amount', ['txnType' => $withdraw->type->value, 'amount' => $withdraw->final_amount, 'currency' => $withdraw->pay_currency])
                            </td>
                            <td>
                                {{ safe($withdraw->charge.' '.setting('site_currency', 'global')) }}
                            </td>
                            <td>
                                {{ safe($withdraw->method) }}
                            </td>
                            <td>
                                @include('backend.transaction.include.__txn_status', ['txnStatus' => $withdraw->status->value])
                            </td>
                        </tr>
                    @empty
                    <td colspan="8" class="text-center">{{ __('No Data Found!') }}</td>
                    @endforelse
                    </tbody>
                </table>

                {{ $withdrawals->links('backend.include.__pagination') }}
            </div>
        </div>

    </div>
@endsection

