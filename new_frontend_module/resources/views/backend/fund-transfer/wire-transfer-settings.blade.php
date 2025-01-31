@extends('backend.layouts.app')
@section('title')
    {{ __('Wire Transfer Settings') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Wire Transfer Settings') }}</h2>
                            <a href="{{ url()->previous() }}" class="title-btn"><i
                                    data-lucide="corner-down-left"></i>{{ __('All Wire Transfer') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="site-card">
                        <div class="site-card-body">
                            <form action="{{ route('admin.wire.transfer.post') }}" class="row" method="post">
                                @csrf
                                <div class="col-xl-12">
                                    <div class="site-input-groups position-relative">
                                        <label class="box-input-label" for="">{{ __('Charges:') }}</label>
                                        <div class="position-relative">
                                            <input type="number" class="box-input"
                                                   oninput="this.value = validateDouble(this.value)" name="charge" value="{{ $wireTransfer?->charge }}"/>
                                            <div class="prcntcurr">
                                                <select name="charge_type" class="form-select">
                                                    <option value="percentage" {{ $wireTransfer?->charge_type == 'percentage' ? 'selected' : '' }}>{{ __('%') }}</option>
                                                    <option value="fixed" {{ $wireTransfer?->charge_type == 'fixed' ? 'selected' : '' }}>{{ $currencySymbol }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Minimum Transfer:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="minimum_transfer" class="form-control" value="{{ $wireTransfer?->minimum_transfer }}"/>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Maximum Transfer:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="maximum_transfer" class="form-control" value="{{ $wireTransfer?->maximum_transfer }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Daily Limit Maximum Amount:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="daily_limit_maximum_amount" class="form-control" value="{{ $wireTransfer?->daily_limit_maximum_amount }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Daily Limit Maximum Count:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="daily_limit_maximum_count" class="form-control" value="{{ $wireTransfer?->daily_limit_maximum_count }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Monthly Limit Maximum Amount:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="monthly_limit_maximum_amount" class="form-control" value="{{ $wireTransfer?->monthly_limit_maximum_amount }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Monthly Limit Maximum Count:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="monthly_limit_maximum_count" class="form-control" value="{{ $wireTransfer?->monthly_limit_maximum_count }}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3">
                                    <a href="javascript:void(0)" id="generate"
                                       class="site-btn-xs primary-btn mb-3">{{ __('Add Field option') }}</a>
                                </div>
                                <div class="addOptions">
                                    @foreach(json_decode($wireTransfer?->field_options,true) as $key => $value)
                                        <div class="mb-4">
                                            <div class="option-remove-row row">
                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="site-input-groups">
                                                        <input name="field_options[{{$key}}][name]" class="box-input"
                                                               type="text" value="{{$value['name']}}" required
                                                               placeholder="Field Name">
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="site-input-groups">
                                                        <select name="field_options[{{$key}}][type]"
                                                                class="form-select form-select-lg mb-3">
                                                            <option value="text"
                                                                    @if($value['type'] == 'text') selected @endif>
                                                                    {{ __('Input Text') }}
                                                            </option>
                                                            <option value="textarea"
                                                                    @if($value['type'] == 'textarea') selected @endif>
                                                                {{ __('Textarea') }}
                                                            </option>
                                                            <option value="file"
                                                                    @if($value['type'] == 'file') selected @endif>
                                                                    {{ __('File upload') }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="site-input-groups mb-0">
                                                        <select name="field_options[{{ $key }}][validation]"
                                                                class="form-select form-select-lg mb-1">
                                                            <option value="required"
                                                                    @if($value['validation'] == 'required') selected @endif>
                                                                {{ __('Required') }}
                                                            </option>
                                                            <option value="nullable"
                                                                    @if($value['validation'] == 'nullable') selected @endif>
                                                                {{ __('Optional') }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xl-1 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <button class="delete-option-row delete_desc" type="button">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-xl-12">
                                    <div class="site-input-groups fw-normal">
                                        <label for="" class="box-input-label">{{ __('Instruction to transfer:') }}</label>
                                        <div class="site-editor">
                                            <textarea class="summernote" name="instructions">
                                                {!! $wireTransfer?->instructions !!}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xl-12">
                                    <button type="submit" class="site-btn primary-btn w-100">
                                        {{ __('Save Changes') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        (function ($) {
            var i = 0;
            "use strict";

            let currency = null;
            $("#currency").on('change', function () {
                if (currency === null) {
                    $('#currency-selected').text(this.value);
                }
            });

            $("#generate").on('click', function () {
                ++i;
                var form = `<div class="mb-4">
                  <div class="option-remove-row row">
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="site-input-groups">
                        <input name="field_options[` + i + `][name]" class="box-input" type="text" value="" required placeholder="Field Name">
                      </div>
                    </div>

                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="site-input-groups">
                        <select name="field_options[` + i + `][type]" class="form-select form-select-lg mb-3">
                            <option value="text">Input Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="file">File upload</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="site-input-groups mb-0">
                        <select name="field_options[` + i + `][validation]" class="form-select form-select-lg mb-1">
                            <option value="required">Required</option>
                            <option value="nullable">Optional</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-xl-1 col-lg-6 col-md-6 col-sm-6 col-12">
                      <button class="delete-option-row delete_desc" type="button">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                    </div>
                  </div>`;
                $('.addOptions').append(form)
            });

            $(document).on('click', '.delete_desc', function () {
                $(this).closest('.option-remove-row').parent().remove();
            });

            $('#gateway-select').on('change', function () {
                var id = $(this).val();
                var url = '{{ route('admin.gateway.supported.currency',':id') }}';
                url = url.replace(':id', id);
                $.get(url, function ($data) {
                    $('#currency').html($data.view);
                    $('#currency-selected').text($data.pay_currency);
                    currency = $data.pay_currency
                })
            })


        })(jQuery)
    </script>
@endsection
