@extends('backend.withdraw.index')
@section('title')
    {{ __('Pending Withdraws') }}
@endsection
@section('withdraw_content')
    <div class="col-xl-12 col-md-12">
        <div class="site-card-body table-responsive">
            <div class="site-table table-responsive">
                @include('backend.withdraw.include.__filter')
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Transaction ID') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Charge') }}</th>
                        <th>{{ __('Gateway') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Action') }}</th>
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
                            <td>
                                @include('backend.withdraw.include.__action', ['id' => $withdraw->id])
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

        <!-- Modal for Pending Deposit Approval -->
        @can('withdraw-action')
            <div
                class="modal fade"
                id="deposit-action-modal"
                tabindex="-1"
                aria-labelledby="editPendingDepositModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content site-table-modal">
                        <div class="modal-body popup-body">
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                            <div class="popup-body-text withdraw-action">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        <!-- Modal for Pending Deposit Approval -->
    </div>
@endsection
@section('script')
    <script>
        (function ($) {
            "use strict";

            let loader = '<div class="text-center"><img src="{{ asset('front/images/loader.gif') }}" width="100"><h5>{{ __('Please wait') }}...</h5></div>';

            //send mail modal form open
            $('body').on('click', '#withdraw-action', function () {
                $('.withdraw-action').html(loader);

                var id = $(this).data('id');
                var url = '{{ route("admin.withdraw.action",":id") }}';
                url = url.replace(':id', id);
                $.get(url, function (data) {
                    $('.withdraw-action').html(data)
                    imagePreview()
                })
                $('#deposit-action-modal').modal('toggle')

            });

        })(jQuery);
    </script>
@endsection
