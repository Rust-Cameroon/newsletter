@extends('frontend::layouts.user')
@section('title')
    {{ __('Loan Details') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title-small">{{ __('Loan Details:') }}</div>
                    @if($loan->status == App\Enums\LoanStatus::Reviewing)
                    <div class="card-header-links d-flex">
                        <a href="#" data-id="{{ $loan->loan_no }}" class="bg-danger card-header-link cancelBtn"><i data-lucide="x"></i>{{ __('Cancel') }}</a>
                    </div>
                    @endif
                </div>
                <div class="site-card-body p-0 overflow-x-auto">
                    <div class="site-custom-table site-custom-table-sm">
                        <div class="contents">
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Plan Name:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ $loan->plan->name }}</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Loan ID:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ $loan->loan_no }}</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Status:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">
                                        @if($loan->status->value == 'running')
                                            <div class="type site-badge badge-primary">{{ ucfirst($loan->status->value) }}</div>
                                        @elseif($loan->status->value == 'rejected' || $loan->status->value == 'cancelled')
                                            <div class="type site-badge badge-failed">{{ ucfirst($loan->status->value) }}</div>
                                        @elseif($loan->status->value == 'completed')
                                            <div class="type site-badge badge-success">{{ ucfirst($loan->status->value) }}</div>
                                        @elseif($loan->status->value == 'due')
                                            <div class="type site-badge badge-failed">{{ ucfirst($loan->status->value) }}</div>
                                        @elseif($loan->status->value == 'reviewing')
                                            <div class="type site-badge badge-pending">{{ ucfirst($loan->status->value) }}</div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Amount:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ $loan->amount . ' '.$currency }}</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ __('Per Installment:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ ($loan->amount / 100 ) * $loan->plan->per_installment .' '. $currency }} (Every {{ $loan->plan->installment_intervel }} Days)</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Number Of Installments:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ $loan->plan->total_installment }} Times</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Given Installments:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold"><span class="type site-badge badge-primary">{{ $loan->givenInstallemnt() ?? 0 }}</span></div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Next Installment:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">
                                        @if($loan->status == App\Enums\LoanStatus::Reviewing)
                                            -
                                        @else
                                            {{ nextInstallment($loan->id, \App\Models\LoanTransaction::class, 'loan_id') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Deferment Charge:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="red-color fw-bold">{{ $loan->plan->charge }} {{ $loan->plan->charge_type == 'percentage' ? '%' : $currency }} / {{ $loan->plan->delay_days }} Day</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Total Payable Amount:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ $loan->totalPayableAmount() .' '.$currency  }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($loan->transactions->count() > 0)
                <div class="site-card">
                    <div class="site-card-header">
                        <div class="title-small">{{ __('Installments List') }}</div>
                    </div>
                    <div class="site-card-body p-0 overflow-x-auto">
                        <div class="site-custom-table">
                            <div class="contents">
                                <div class="site-table-list site-table-head">
                                    <div class="site-table-col">{{ __('Serial') }}</div>
                                    <div class="site-table-col">{{ __('Installment Dates') }}</div>
                                    <div class="site-table-col">{{ __('Given Date') }}</div>
                                    <div class="site-table-col">{{ __('Deferment') }}</div>
                                </div>
                                @foreach($loan->transactions as $trx)
                                    <div class="site-table-list">
                                        <div class="site-table-col">
                                            <div class="trx fw-bold">{{ $loop->iteration }}</div>
                                        </div>
                                        <div class="site-table-col">
                                            <div class="trx fw-bold">{{ $trx->installment_date->format('d M Y') }}</div>
                                        </div>
                                        <div class="site-table-col">
                                            <div class="trx fw-bold">{{ $trx->given_date != null ? \Carbon\Carbon::parse($trx->given_date)->format('M d Y') : __('Yet to pay') }}</div>
                                        </div>
                                        <div class="site-table-col">
                                            <div class="trx fw-bold">{{ $trx->given_date != null ? $trx->deferment : 'None' }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- <div class="no-data-found">No Data Found</div> -->
                        </div>
                    </div>
                </div>
            @endif

            @if($loan->status == App\Enums\LoanStatus::Reviewing)
            <!-- Modal for Delete Box -->
            <div class="modal fade" id="cancelLoan" tabindex="-1" aria-labelledby="cancelLoanModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content site-table-modal">
                        <div class="modal-body popup-body">
                            <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-lucide="x"></i></button>
                            <div class="popup-body-text centered">
                                <div class="info-icon">
                                    <i data-lucide="alert-triangle"></i>
                                </div>
                                <div class="title">
                                    <h4>{{ __('Are you sure?') }}</h4>
                                </div>
                                <p>
                                    {{ __('You want to Cancel this Loan?') }}
                                </p>
                                <div class="action-btns">
                                    <a href="" class="site-btn-sm primary-btn me-2 confirm_btn">
                                        <i data-lucide="check"></i>
                                        {{ __('Confirm') }}
                                    </a>
                                    <a href="" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-lucide="x"></i>
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal for Delete Box End-->
            @endif
        </div>
    </div>
@push('js')
<script>
    "use strict";
    
    $(document).on('click', '.cancelBtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var fee = $(this).data('fee');

        $('.cancel_fee').text(fee)

        var url = "{{ route('user.loan.cancel', ['id' => ':id']) }}";
        url = url.replace(':id', id);
        $('.confirm_btn').attr('href', url);

        $('#cancelLoan').modal('show');
    });

</script>
@endpush
@endsection
