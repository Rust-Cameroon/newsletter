@extends('backend.layouts.app')
@section('title')
    {{ __('Others Bank') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Add Others Bank') }}</h2>
                            <a href="{{ url()->previous() }}" class="title-btn"><i
                                    data-lucide="corner-down-left"></i>{{ __('Back') }}</a>
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
                            <form action="{{ route('admin.others-bank.store') }}" class="row" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="col-xl-12">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Add Logo:') }}</label>
                                        <div class="wrap-custom-file">
                                            <input
                                                type="file"
                                                name="logo"
                                                id="logo"
                                                accept=".gif, .jpg, .png"
                                            />
                                            <label for="logo">
                                                <img
                                                    class="upload-icon"
                                                    src="{{ asset('global/materials/upload.svg') }}"
                                                    alt=""
                                                />
                                                <span>{{ __('Upload Logo') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Name:') }}</label>
                                        <input
                                            type="text"
                                            class="box-input"
                                            name="name"
                                        />
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Code Name:') }}</label>
                                        <input
                                            type="text"
                                            class="box-input"
                                            name="code"
                                        />
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="site-input-groups position-relative">
                                        <label class="box-input-label" for="">{{ __('Processing Time:') }}</label>
                                        <div class="position-relative">
                                        <input
                                            type="text"
                                            class="box-input"
                                            name="processing_time"
                                        />
                                        <div class="prcntcurr">
                                            <select name="processing_type" class="form-select">
                                                <option value="hours">{{ __('Hours') }}</option>
                                                <option value="days">{{ __('Days') }}</option>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xl-6">
                                    <div class="site-input-groups position-relative">
                                        <label class="box-input-label" for="">{{ __('Charges:') }}</label>
                                        <div class="position-relative">
                                            <input type="number" class="box-input"
                                                   oninput="this.value = validateDouble(this.value)" name="charge"/>
                                            <div class="prcntcurr">
                                                <select name="charge_type" class="form-select">
                                                    <option value="percentage">{{ __('%') }}</option>
                                                    <option value="fixed">{{ $currencySymbol }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Minimum Transfer:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="minimum_transfer" class="form-control"/>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Maximum Transfer:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="maximum_transfer" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Daily Limit Maximum Amount:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="daily_limit_maximum_amount" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Daily Limit Maximum Count:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="daily_limit_maximum_count" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Monthly Limit Maximum Amount:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="monthly_limit_maximum_amount" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Monthly Limit Maximum Count:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="monthly_limit_maximum_count" class="form-control"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3">
                                    <a href="javascript:void(0)" id="generate"
                                       class="site-btn-xs primary-btn mb-3">{{ __('Add Field option') }}</a>
                                </div>
                                <div class="addOptions">
                                </div>
                                <div class="col-xl-12">
                                    <div class="site-input-groups fw-normal">
                                        <label for="" class="box-input-label">{{ __('Instruction to transfer:') }}</label>
                                        <div class="site-editor">
                                            <textarea class="summernote" name="details"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Status:') }}</label>
                                        <div class="switch-field same-type">
                                            <input
                                                type="radio"
                                                id="radio-five"
                                                name="status"
                                                value="1"
                                                checked
                                            />
                                            <label for="radio-five">{{ __('Active') }}</label>
                                            <input
                                                type="radio"
                                                id="radio-six"
                                                name="status"
                                                value="0"

                                            />
                                            <label for="radio-six">{{ __('Deactivate') }}</label>
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
