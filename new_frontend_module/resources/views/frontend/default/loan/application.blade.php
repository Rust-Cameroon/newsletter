@extends('frontend::layouts.user')
@section('title')
    {{ __('Loan Details') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-7 col-lg-7 col-md-7">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title-small">{{ __('Application Form') }}</div>
                </div>
                <div class="site-card-body">
                    <form action="{{ route('user.loan.subscribe') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="loan_id" value="{{ encrypt($plan->id) }}">
                        <input type="hidden" name="amount" value="{{ $request->amount }}">

                        <div class="step-details-form mb-4">
                            @foreach(json_decode($plan->field_options,true) as $key => $value)

                                @if(data_get($value,'type') == 'text')
                                <div class="inputs">
                                    <label for="" class="input-label">{{ data_get($value, 'name') }}
                                        {!! data_get($value, 'validation') == 'required' ? '<span class="required">*</span>' : '' !!}
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="submitted_data[{{ data_get($value, 'name') }}]"  @required(data_get($value, 'validation') == 'required')>
                                    </div>
                                </div>
                                @elseif(data_get($value,'type') == 'select')
                                    <div class="inputs">
                                        <label for="" class="input-label">
                                            {{ data_get($value,'name') }}
                                            {!! data_get($value, 'validation') == 'required' ? '<span class="required">*</span>' : '' !!}
                                        </label>
                                        <select name="submitted_data[{{ data_get($value, 'name') }}]" class="box-input data-selectbox">
                                            <option value="" disabled selected>{{ __('Select '.data_get($value,'name')) }}</option>
                                            @foreach (data_get($value, 'values',[]) as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @elseif (data_get($value,'type') == 'file')
                                <div class="inputs">
                                    <label for="" class="input-label">{{ data_get($value, 'name') }}
                                        {!! data_get($value, 'validation') == 'required' ? '<span class="required">*</span>' : '' !!}
                                    </label>

                                    <div class="wrap-custom-file">
                                      <input type="file" name="submitted_data[{{ data_get($value, 'name') }}]" id="image1"/>
                                        <label for="image1">
                                            <img class="upload-icon" src="{{ asset('front/images/icons/upload.svg') }}" alt=""/>
                                            <span>{{ __('Upload') }} {{ data_get($value, 'name') }}</span>
                                        </label>
                                    </div>

                                </div>
                                @elseif (data_get($value,'type') == 'textarea')
                                <div class="inputs">
                                    <label for="" class="input-label">{{ data_get($value, 'name') }}
                                        {!! data_get($value, 'validation') == 'required' ? '<span class="required">*</span>' : '' !!}
                                    </label>
                                    <textarea name="submitted_data[{{ data_get($value, 'name') }}]" id="" cols="10" rows="5" class="box-textarea" @required(data_get($value, 'validation') == 'required')></textarea>
                                </div>
                                @endif
                            @endforeach
                            <button
                                @if(auth()->user()->passcode !== null && setting('loan_passcode_status'))
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#passcode"
                                @else
                                type="submit"
                                @endif
                                class="site-btn polis-btn"
                            >
                                {{ __('Apply Now') }}
                            </button>
                        </div>

                        @if(auth()->user()->passcode !== null && setting('loan_passcode_status'))
                        <div class="modal fade" id="passcode" tabindex="-1" aria-labelledby="passcodeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                                <div class="modal-content site-table-modal">
                                    <div class="modal-body popup-body">
                                        <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-lucide="x"></i>
                                        </button>
                                        <div class="popup-body-text">
                                            <div class="title">{{ __('Confirm Your Passcode') }}</div>
                                            <div class="step-details-form">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                                        <div class="inputs">
                                                            <label for="" class="input-label">{{ __('Passcode') }}<span class="required">*</span></label>
                                                            <input type="password" class="box-input" name="passcode" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="action-btns">
                                                <button type="submit" class="site-btn-sm primary-btn me-2">
                                                    <i data-lucide="check"></i>
                                                    {{ __('Confirm') }}
                                                </button>
                                                <button type="button" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
                                                    <i data-lucide="x"></i>
                                                    {{ __('Close') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-lg-5 col-md-5">
            <div class="site-card mb-2">
                <div class="site-card-header">
                    <div class="title-small">{{ __('Loan Instructions') }}</div>
                </div>
                <div class="site-card-body">
                    {!! $plan->instructions !!}
                </div>
            </div>
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title-small">{{ __('Application for :plan_name',['plan_name' => $plan->name]) }}</div>
                </div>
                <div class="site-card-body p-0">
                    <div class="site-custom-table site-custom-table-sm">
                        <div class="contents">
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Plan Name:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ $plan->name }}</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Loan Amount:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ $request->amount }} {{ $currency }}</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ __('Total Installments:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold"><span class="type site-badge badge-primary">{{ $plan->total_installment }} {{ __('Times') }}</span></div>
                                </div>
                            </div>
                            @php
                                $per_installment_fee = ($plan->per_installment / 100) * $request->integer('amount');
                            @endphp
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ __('Per Installment:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ $per_installment_fee }}  {{ $currency }}</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ __('Interest Amount:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="red-color fw-bold">{{ $per_installment_fee * $plan->total_installment - $request->integer('amount') }}  {{ $currency }}</div>
                                </div>
                            </div>
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ __('Total Payable Amount:') }}</div>
                                </div>
                                <div class="site-table-col">
                                    <div class="fw-bold">{{ $per_installment_fee * $plan->total_installment }}  {{ $currency }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('js')
<script>
    "use strict"

    $('.data-selectbox').select2({
        minimumResultsForSearch: Infinity
    });
</script>
@endpush
@endsection
