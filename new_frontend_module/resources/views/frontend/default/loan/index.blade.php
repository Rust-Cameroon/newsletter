@extends('frontend::layouts.user')
@section('title')
    {{ __('Loan') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title">{{ __('Loan Plans') }}</div>
                    <div class="card-header-links">
                        <a href="{{ route('user.loan.history') }}" class="card-header-link"><i
                                data-lucide="archive"></i>{{ __('My Loans') }}</a>
                    </div>
                </div>
                <div class="site-card-body">
                    <div class="row">
                        @foreach($plans as $plan)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                <div class="plan-card-box">
                                    <div class="name">{{ __($plan->name) }}</div>
                                    <div class="amount">{{ $plan->per_installment }}%<span>/ {{ $plan->installment_intervel }} {{ __('Days') }}</span></div>
                                    <div class="list">
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('Minimum Loan') }}</div>
                                            <div>{{ $plan->minimum_amount }} {{ $currency }}</div>
                                        </div>
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('Maximum Loan') }}</div>
                                            <div>{{ $plan->maximum_amount }} {{ $currency }}</div>
                                        </div>
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('Installment Rate') }}
                                            </div>
                                            <div>{{ $plan->per_installment }}%</div>
                                        </div>
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('Installment Slice') }}
                                            </div>
                                            <div>{{ $plan->installment_intervel }} {{ __('Days') }}</div>
                                        </div>
                                        <div class="single">
                                            <div><span><i data-lucide="check"></i></span>{{ __('Total Installment') }}
                                            </div>
                                            <div>{{ $plan->total_installment }}</div>
                                        </div>
                                    </div>
                                    <a href=""
                                       class="site-btn-sm black-btn subscribeBtn"
                                       type="button"
                                       data-name="{{ $plan->name }}"
                                       data-id="{{ encrypt($plan->id) }}"
                                       data-min="{{ $plan->minimum_amount }}"
                                       data-max="{{ $plan->maximum_amount }}"
                                       data-bs-toggle="modal"
                                       data-bs-target="#fdr">
                                        <i data-lucide="check"></i>
                                        {{ __('Apply Loan') }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Modal for Loan Apply-->
                    <div class="modal fade" id="fdr" tabindex="-1" aria-labelledby="fdrModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content site-table-modal">
                                <div class="modal-body popup-body">
                                    <button type="button" class="modal-btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"><i data-lucide="x"></i></button>
                                    <div class="popup-body-text">
                                        <form action="{{ route('user.loan.subscribe') }}" method="GET">

                                            <input type="hidden" name="loan_id" id="loan_id">
                                            <div class="title" id="name"></div>
                                            <div class="modal-beneficiary-details">

                                                <div class="step-details-form">
                                                    <div class="inputs">
                                                        <label for="" class="input-label">{{ __('Enter Amount') }}<span
                                                                class="required">*</span></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="amount">
                                                            <span class="input-group-text">{{ $currency }}</span>
                                                        </div>
                                                        <div class="input-info-text min-max"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="action-btns mt-3">
                                                <button type="submit" class="site-btn-sm polis-btn me-2 w-100 applyBtn">
                                                    <i data-lucide="check"></i>
                                                    {{ __('Apply Now') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal for Loan Apply end-->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            "use strict"

            const currency = @json($currency);

            // Click Subscribe Btn
            $(document).on('click', '.subscribeBtn', function (e) {
                e.preventDefault();

                var id = $(this).data('id');
                var name = $(this).data('name');
                var min = $(this).data('min');
                var max = $(this).data('max');

                $('#name').text(name);

                var message = `Minimum ${min} ${currency} and Maximum ${max} ${currency}`;

                $('.min-max').text(message);

                $('#loan_id').val(id);

                var url = "{{ route('user.loan.application', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $('form').attr('action', url);
            });
        })
    </script>
@endsection
