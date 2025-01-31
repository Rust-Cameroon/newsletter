@extends('backend.withdraw.index')
@section('title')
    {{ __('Edit Withdraw Method') }}
@endsection
@section('withdraw_content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="site-card">
                    <div class="site-card-body">
                        <form action="{{ route('admin.withdraw.method.update',$withdrawMethod->id) }}" class="row"
                              method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="type" value="{{ $type }}">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="site-input-groups">
                                            <label class="box-input-label" for="">{{ __('Upload Icon:') }}</label>
                                            <div class="wrap-custom-file">
                                                <input
                                                    type="file"
                                                    name="icon"
                                                    id="schema-icon"
                                                    accept=".gif, .jpg, .png"
                                                />
                                                <label for="schema-icon" @if($withdrawMethod->icon)  class="file-ok" style="background-image: url({{ asset($withdrawMethod->icon) }})" @endif>
                                                    <img
                                                        class="upload-icon"
                                                        src="{{ asset('global/materials/upload.svg') }}"
                                                        alt=""
                                                    />
                                                    <span>{{ __('Update Icon') }}</span>
                                                </label>
                                            </div>
                                        </div>
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
                                        value="{{ $withdrawMethod->name }}"
                                    />
                                </div>
                            </div>

                            @if($type == 'auto')
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label"
                                               for="">{{ __('Gateway Supported Currency:') }}</label>
                                        <select name="currency" class="form-select" id="currency">
                                            @foreach(json_decode($supported_currencies) as $currency)
                                                <option
                                                    value="{{ $currency }}" @selected($currency == $withdrawMethod->currency )>{{ $currency }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            @if($type == 'manual')
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Currency:') }}</label>
                                        <input
                                            type="text"
                                            class="box-input"
                                            name="currency"
                                            value="{{ $withdrawMethod->currency }}"
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
                                            <span class="input-group-text">{{'1 '.' '. setting('site_currency','global') . ' ='}} </span>
                                            <input type="text" name="rate" class="form-control"
                                                   value="{{ $withdrawMethod->rate }}"/>
                                            <span class="input-group-text"
                                                  id="currency-selected">{{ $withdrawMethod->currency }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="site-input-groups position-relative">
                                    <label class="box-input-label" for="">{{ __('Charges:') }}</label>
                                    <div class="position-relative">
                                        <input type="text" class="box-input"
                                               oninput="this.value = validateDouble(this.value)" name="charge"
                                               value="{{ $withdrawMethod->charge }}"/>
                                        <div class="prcntcurr">
                                            <select name="charge_type" class="form-select">
                                                <option value="percentage"
                                                        @if( $withdrawMethod->charge_type == 'percentage') selected @endif>{{ __('%') }}</option>
                                                <option value="fixed"
                                                        @if( $withdrawMethod->charge_type == 'fixed') selected @endif>{{ $currencySymbol }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="site-input-groups">
                                    <label class="box-input-label" for="">{{ __('Minimum Withdraw:') }}</label>
                                    <div class="input-group joint-input">
                                        <input type="text" name="min_withdraw" class="form-control"
                                               value="{{ $withdrawMethod->min_withdraw }}"/>
                                        <span class="input-group-text"
                                              id="currency-selected">{{ setting('site_currency','global') }}</span>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="site-input-groups">
                                    <label class="box-input-label" for="">{{ __('Maximum Withdraw:') }}</label>
                                    <div class="input-group joint-input">
                                        <input
                                            type="text"
                                            name="max_withdraw"
                                            class="form-control"
                                            value="{{ $withdrawMethod->max_withdraw  }}"
                                        />
                                        <span class="input-group-text"
                                              id="currency-selected">{{ setting('site_currency','global') }}</span>
                                    </div>
                                </div>
                            </div>
                            @if($type == 'manual')
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Processing Time:') }}</label>
                                        <div class="position-relative">
                                            <input type="text" name="required_time"
                                                   value="{{ $withdrawMethod->required_time }}" class="box-input mb-0"/>
                                            <div class="prcntcurr">
                                                <select name="required_time_format" class="form-select mb-0">
                                                    @foreach(['minute' => 'Minutes','hour' => 'Hours','day' => 'Days' ] as $key => $value)
                                                        <option
                                                            @if( $withdrawMethod->required_time_format == $key) selected
                                                            @endif value="{{ $key }}">{{ $value }}</option>
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
                                            @if($withdrawMethod->status) checked @endif
                                        />
                                        <label for="radio-five">{{ __('Active') }}</label>
                                        <input
                                            type="radio"
                                            id="radio-six"
                                            name="status"
                                            value="0"
                                            @if(!$withdrawMethod->status) checked @endif
                                        />
                                        <label for="radio-six">{{ __('Deactivate') }}</label>
                                    </div>
                                </div>
                            </div>

                            @if($type == 'manual')
                                <div class="col-xl-12">
                                    <a href="javascript:void(0)" id="generate" class="site-btn-xs primary-btn mb-3">Add
                                        Field option</a>
                                </div>

                                <div class="addOptions">
                                    @foreach(json_decode($withdrawMethod->fields,true) as $key => $value)
                                        <div class="mb-4">
                                            <div class="option-remove-row row">
                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="site-input-groups">
                                                        <input name="fields[{{$key}}][name]" class="box-input"
                                                               type="text"
                                                               value="{{$value['name']}}" required
                                                               placeholder="Field Name">
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="site-input-groups">
                                                        <select name="fields[{{$key}}][type]"
                                                                class="form-select form-select-lg mb-3">
                                                            <option value="text"
                                                                    @if($value['type'] == 'text') selected @endif>Input
                                                                Text
                                                            </option>
                                                            <option value="textarea"
                                                                    @if($value['type'] == 'textarea') selected @endif>
                                                                Textarea
                                                            </option>
                                                            <option value="file"
                                                                    @if($value['type'] == 'file') selected @endif>File
                                                                upload
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="site-input-groups mb-0">
                                                        <select name="fields[{{ $key }}][validation]"
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
        $("#currency").on('change', function () {
            $('#currency-selected').text(this.value);
        });

        var i = Object.keys(JSON.parse(@json($withdrawMethod->fields))).length;
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

    </script>
@endsection
