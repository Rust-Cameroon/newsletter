@extends('backend.withdraw.index')
@section('title')
    {{ __('New Withdraw Method') }}
@endsection
@section('withdraw_content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="site-card">
                    <div class="site-card-body">
                        <form action="{{ route('admin.withdraw.method.store') }}" class="row" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="type" value="{{ $type }}">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Add Withdraw Logo:') }}</label>
                                            <div class="wrap-custom-file">
                                                <input
                                                    type="file"
                                                    name="icon"
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
                                </div>
                            </div>

                            @if($type == 'auto')
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Automatic Gateway:') }}</label>
                                        <select name="gateway_id"
                                                class="form-select"
                                                id="gateway-select">
                                            <option>{{ __('Select Gateway') }}</option>
                                            @foreach($gateways as $gateway)
                                                <option data-currencies="{{ $gateway->supported_currencies }}"
                                                        value="{{$gateway->id}}"> {{$gateway->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label"
                                               for="">{{ __('Gateway Supported Currency:') }}</label>
                                        <select name="currency" class="form-select" id="currency">

                                        </select>
                                    </div>
                                </div>
                            @endif

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


                            @if($type == 'manual')
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Currency:') }}</label>
                                        <input
                                            type="text"
                                            class="box-input"
                                            name="currency"
                                            id="currency"
                                        />
                                    </div>
                                </div>
                            @endif

                            <div class="col-xl-6">
                                <div class="site-input-groups row">
                                    <div class="col-xl-12">
                                        <label class="box-input-label" for="">{{ __('Convention Rate:') }}</label>
                                        <div class="input-group joint-input">
                                            <span class="input-group-text">{{'1 '.' '.$currency. ' ='}} </span>
                                            <input type="text" class="form-control" name="rate"/>
                                            <span class="input-group-text" id="currency-selected"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-6">
                                <div class="site-input-groups position-relative">
                                    <label class="box-input-label" for="">{{ __('Charges:') }}</label>
                                    <div class="position-relative">
                                        <input type="text" class="box-input"
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
                                    <label class="box-input-label" for="">{{ __('Minimum Withdraw:') }}</label>
                                    <div class="input-group joint-input">
                                        <input type="text" class="form-control" name="min_withdraw"/>
                                        <span class="input-group-text">{{$currency}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="site-input-groups">
                                    <label class="box-input-label" for="">{{ __('Maximum Withdraw:') }}</label>
                                    <div class="input-group joint-input">
                                        <input type="text" class="form-control" name="max_withdraw"/>
                                        <span class="input-group-text">{{ $currency}}</span>
                                    </div>
                                </div>
                            </div>

                            @if($type == 'manual')
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Processing Time:') }}</label>
                                        <div class="position-relative">
                                            <input type="text" name="required_time" class="box-input mb-0"/>
                                            <div class="prcntcurr">
                                                <select name="required_time_format" class="form-select mb-0">
                                                    @foreach(['minute' => 'Mins','hour' => 'Hours','day' => 'Days' ] as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                            @if($type == 'manual')
                                <div class="col-xl-12">
                                    <a href="javascript:void(0)" id="generate"
                                       class="site-btn-xs primary-btn mb-3">{{ __('Add Field option') }}</a>
                                </div>
                                <div class="addOptions">

                                </div>
                            @endif

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
@endsection
@section('script')
    <script>
        $(document).ready(function (e) {
            "use strict";
            $("#currency").on('change', function () {
                $('#currency-selected').text(this.value);
            });

            var i = 0;
            $("#generate").on('click', function () {
                ++i;
                var form = `<div class="mb-4">
                  <div class="option-remove-row row">
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="site-input-groups">
                        <input name="fields[` + i + `][name]" class="box-input" type="text" value="" required placeholder="Field Name">
                      </div>
                    </div>

                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="site-input-groups">
                        <select name="fields[` + i + `][type]" class="form-select form-select-lg mb-3">
                            <option value="text">Input Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="file">File upload</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="site-input-groups mb-0">
                        <select name="fields[` + i + `][validation]" class="form-select form-select-lg mb-1">
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
                })
            })
        });
    </script>
@endsection
