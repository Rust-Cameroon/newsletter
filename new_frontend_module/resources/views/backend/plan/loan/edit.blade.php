@extends('backend.layouts.app')
@section('title')
    {{ __('Edit Loan Plan') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="title-content">
                            <h2 class="title">{{ __('Edit Loan Plan') }}</h2>
                            <a href="{{ url()->previous() }}" class="title-btn"><i
                                    data-lucide="corner-down-left"></i>{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-12 col-md-12">
                    <div class="site-card">
                        <div class="site-card-body">
                            <form action="{{route('admin.plan.loan.update',$plan->id)}}" method="post"
                                  enctype="multipart/form-data" class="row">
                                @csrf
                                <div class="col-xl-12">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Plan Name:') }}</label>
                                        <input type="text" name="name" class="box-input" placeholder="Plan name" required value="{{ $plan->name }}"/>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                    <label class="box-input-label" for="">{{ __('Min Amount:') }}</label>
                                    <div class="input-group joint-input">
                                        <input type="text" name="minimum_amount" class="form-control" value="{{ $plan->minimum_amount }}" oninput="this.value = validateDouble(this.value)"/>
                                        <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                    <label class="box-input-label" for="">{{ __('Max Amount:') }}</label>
                                    <div class="input-group joint-input">
                                        <input type="text" name="maximum_amount" class="form-control" value="{{ $plan->maximum_amount }}" oninput="this.value = validateDouble(this.value)"/>
                                        <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Installment Rate:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="text" name="per_installment" class="form-control" value="{{ $plan->per_installment }}"/>
                                            <span class="input-group-text">{{ __('%') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Installment Interval:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="text" name="installment_intervel" class="form-control" value="{{ $plan->installment_intervel }}"/>
                                            <span class="input-group-text">{{ __('Days') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Total Installment:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="text" name="total_installment" class="form-control" value="{{ $plan->total_installment }}"/>
                                            <span class="input-group-text">{{ __('Times') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                    <label class="box-input-label" for="">{{ __('Loan Processing Fee:') }}</label>
                                    <div class="input-group joint-input">
                                        <input type="text" name="loan_fee" class="form-control" value="{{ $plan->loan_fee }}" />
                                        <span class="input-group-text">{{ $currency }}</span>
                                    </div>
                                    </div>
                                </div>


                                <div class="col-xl-12">
                                    <a href="javascript:void(0)" id="generate" class="site-btn-xs primary-btn mb-3">{{ __('Add Field option') }}</a>
                                </div>
                                @php
                                    $key = 0;
                                @endphp
                                <div class="addOptions">
                                    @foreach(json_decode($plan->field_options,true) as $key => $value)
                                        @php
                                            $key++;
                                        @endphp
                                    <div class="mb-4">
                                        <div class="option-remove-row row">
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="site-input-groups">
                                                    <input name="field_options[{{$key}}][name]" class="box-input" type="text" value="{{$value['name']}}"
                                                        required placeholder="Field Name">
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="site-input-groups">
                                                    <select name="field_options[{{$key}}][type]" onchange="addOptions(this,'{{ $key }}')" class="form-select form-select-lg mb-3">
                                                        <option value="text" @selected($value['type'] =='text' )  >Input
                                                            {{ __('Text') }}
                                                        </option>
                                                        <option value="textarea" @selected($value['type'] =='textarea' )  >
                                                            {{ __('Textarea') }}
                                                        </option>
                                                        <option value="file" @selected($value['type'] == 'file')>
                                                            {{ __('File upload') }}
                                                        </option>
                                                        <option value="checkbox" @selected($value['type'] == 'checkbox')>
                                                            {{ __('Checkbox') }}
                                                        </option>
                                                        <option value="select" @selected($value['type'] == 'select')>
                                                            {{ __('Select') }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="site-input-groups mb-0">
                                                    <select name="field_options[{{ $key }}][validation]" class="form-select form-select-lg mb-1">
                                                        <option value="required" @if($value['validation']=='required' ) selected @endif>
                                                            {{ __('Required') }}
                                                        </option>
                                                        <option value="nullable" @if($value['validation']=='nullable' ) selected @endif>
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

                                            <div class="option-fields{{ $key }} row">
                                                @if(isset($value['values']) && $value['values'] != null)
                                                    @foreach ($value['values'] as $serial => $value)
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row" id="option-value-row">
                                                        <div class="site-input-groups col-md-10">
                                                            <input name="field_options_value[{{ $key }}][]" class="box-input" type="text" value="{{ $value }}" required placeholder="Enter Value">
                                                        </div>

                                                        <div class="col-md-2" id="option-value-action">
                                                            @if($loop->first)
                                                            <button class="add-option-row me-2" onclick="addOptionValue('option-fields{{ $key }}','{{ $key }}')" type="button"> <i class="fas fa-plus"></i> </button>
                                                            @endif
                                                            <button class="delete-option-row" onclick="removeOptionValue(this)" type="button"> <i class="fas fa-times"></i> </button>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="col-xl-12">
                                    <div class="site-input-groups fw-normal">
                                        <label for="" class="box-input-label">{{ __('Loan Instructions:') }}</label>
                                        <div class="site-editor">
                                            <textarea class="summernote" name="instructions">
                                                {!! $plan->instructions !!}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Charge will Apply if Delay:')
                                            }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="delay_days" class="form-control" value="{{ $plan->delay_days }}"/>
                                            <span class="input-group-text">{{ __('Day') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Delay Charge:') }}</label>
                                        <div class="position-relative">
                                            <input type="number" class="box-input" placeholder="charge" name="charge"
                                                oninput="this.value = validateDouble(this.value)" required value="{{ $plan->charge }}"/>
                                            <div class="prcntcurr">
                                                <select name="charge_type" class="form-select" id="">
                                                    <option value="percentage" {{ $plan->charge_type == 'percentage' ? 'selected' : '' }}>{{ __('%') }}</option>
                                                    <option value="fixed" {{ $plan->charge_type == 'fixed' ? 'selected' : '' }}>{{ $currencySymbol }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Featured') }}</label>
                                        <div class="switch-field same-type">
                                            <input type="radio" id="radio-can-featured" name="featured" checked="" value="1" @checked($plan->featured)/>
                                            <label for="radio-can-featured">{{ __('Yes') }}</label>
                                            <input type="radio" id="radio-can-featured1" name="featured" value="0" @checked(!$plan->featured)/>
                                            <label for="radio-can-featured1">{{ __('No') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6" id="badge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Badge:') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="text" name="badge" class="form-control" value="{{ $plan->badge }}"/>
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
                                                checked=""
                                                value="1"
                                                @checked($plan->status)
                                            />
                                            <label for="radio-five">{{ __('Active') }}</label>
                                            <input
                                                type="radio"
                                                id="radio-six"
                                                name="status"
                                                value="0"
                                                @checked(!$plan->status)
                                            />
                                            <label for="radio-six">{{ __('Deactivate') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <button type="submit" class="site-btn-sm primary-btn w-100">
                                        {{ __('Update Plan') }}
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

    function addOptionValue(element,i){
        var option = `<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row" id="option-value-row">
                            <div class="site-input-groups col-md-10">
                                <input name="field_options_value[` + i + `][]" class="box-input" type="text" value="" required placeholder="Enter Value">
                            </div>
                            <div class="col-md-2" id="option-value-action">
                                <button class="delete-option-row" onclick="removeOptionValue(this)" type="button">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>`;
        $('.'+element).append(option);
    }

    function addOptions(el,i){
        var value = $(el).val();
        var option = `<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row" id="option-value-row">
                        <div class="site-input-groups col-md-10">
                            <input name="field_options_value[` + i + `][]" class="box-input" type="text" value="" required placeholder="Enter Value">
                        </div>
                        <div class="col-md-2" id="option-value-action">
                            <button class="add-option-row me-2" onclick="addOptionValue('option-fields`+ i + `','`+i+`')" type="button">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button class="delete-option-row" onclick="removeOptionValue(this)" type="button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>`;

        if(value == 'checkbox' || value == 'select'){
            $('.option-fields'+i+'').html(option);
        }else{
            $('.option-fields'+i+'').html('');
        }
    }

    function removeOptionValue(el){
        $(el).closest('#option-value-action').parent().remove();
    }

        (function ($) {
            var i = {{ $key }};
            "use strict";

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
                        <select name="field_options[` + i + `][type]" onchange="addOptions(this,`+ i +`)" class="form-select form-select-lg mb-3">
                            <option value="text">Input Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="file">File upload</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="select">Select</option>
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
                    <div class="option-fields`+ i +` row"></div>
                    </div>
                  </div>`;
                $('.addOptions').append(form)
            });

            $(document).on('click', '.delete_desc', function () {
                $(this).closest('.option-remove-row').parent().remove();
            });

            function toggleBadgeVisibility()
            {
                var featured = $('input[name="featured"]:checked').val();
                if (featured === '1') {
                    $('#badge').show();
                } else {
                    $('#badge').hide();
                }
            }

            toggleBadgeVisibility();
            $('input[name="featured"]').on('change', function () {
                toggleBadgeVisibility();
            });

        })(jQuery)
    </script>
@endsection
