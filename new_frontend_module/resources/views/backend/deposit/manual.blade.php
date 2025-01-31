@extends('backend.deposit.index')
@section('title')
    {{ __('Pending Manual Deposit') }}
@endsection
@section('deposit_content')
    <div class="col-xl-12 col-md-12">
        <div class="site-card">
            <div class="site-card-body table-responsive">
                <div class="site-table table-responsive">
                    @include('backend.deposit.include.__filter')
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
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($deposits as $deposit)
                            <tr>
                                <td>
                                    {{ $deposit->created_at }}
                                </td>
                                <td>
                                    @include('backend.transaction.include.__user', ['id' => $deposit->user_id, 'name' => $deposit->user->username])
                                </td>
                                <td>{{ safe($deposit->tnx) }}</td>
                                <td>
                                    @include('backend.transaction.include.__txn_amount', ['txnType' => $deposit->type, 'amount' => $deposit->final_amount, 'currency' => $deposit->pay_currency])
                                </td>
                                <td>
                                    {{ safe($deposit->charge.' '.setting('site_currency', 'global')) }}
                                </td>
                                <td>
                                    {{ safe($deposit->method) }}
                                </td>
                                <td>
                                    @include('backend.transaction.include.__txn_status', ['txnStatus' => $deposit->status->value])
                                </td>
                                <td>
                                    @include('backend.deposit.include.__action', ['id' => $deposit->id])
                                </td>
                            </tr>
                        @empty
                        <td colspan="8" class="text-center">{{ __('No Data Found!') }}</td>
                        @endforelse
                        </tbody>
                    </table>

                    {{ $deposits->links('backend.include.__pagination') }}
                </div>
            </div>
        </div>
        <!-- Modal for Pending Deposit Approval -->
        @can('deposit-action')
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
                            <div class="popup-body-text deposit-action">

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
            $('body').on('click', '#deposit-action', function () {
                $('.deposit-action').html(loader);

                var id = $(this).data('id');
                var url = '{{ route("admin.deposit.action",":id") }}';
                url = url.replace(':id', id);
                $.get(url, function (data) {
                    $('.deposit-action').html(data)
                    imagePreview()
                });

                $('#deposit-action-modal').modal('toggle');
            })


        })(jQuery);
    </script>
@endsection
