@extends('backend.layouts.app')
@section('title')
    {{ __('Add New KYC') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="title-content">
                            <h2 class="title">{{ __('Edit KYC Form') }}</h2>
                            <a href="{{ route('admin.kyc-form.index') }}" class="title-btn"><i
                                    data-lucide="corner-down-left"></i>{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                    <div class="site-card">
                        <div class="site-card-body">
                            <form action="{{ route('admin.kyc-form.update',$kyc->id) }}" method="post" class="row">
                                @method('PUT')
                                @csrf

                                <div class="col-xl-12">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Name:') }}</label>
                                        <input type="text" name="name" value="{{ old('name',$kyc->name) }}"
                                               class="box-input" placeholder="KYC Type Name" required/>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <a href="javascript:void(0)" id="generate"
                                       class="site-btn-xs primary-btn mb-3">{{ __('Add Field option') }}</a>
                                </div>

                                <div class="addOptions">
                                    @foreach(json_decode($kyc->fields,true) as $key => $value)
                                        <div class="mb-4">
                                            <div class="option-remove-row row">
                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="site-input-groups">
                                                        <input name="fields[{{$key}}][name]" class="box-input"
                                                               type="text" value="{{$value['name']}}" required
                                                               placeholder="Field Name">
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="site-input-groups">
                                                        <select name="fields[{{$key}}][type]"
                                                                class="form-select form-select-lg mb-3">
                                                            <option value="text"
                                                                    @if($value['type'] == 'text') selected @endif>{{ __('Input Text') }}</option>
                                                            <option value="textarea"
                                                                    @if($value['type'] == 'textarea') selected @endif>{{ __('Textarea') }}</option>
                                                            <option value="file"
                                                                    @if($value['type'] == 'file') selected @endif>{{ __('File upload') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="site-input-groups mb-0">
                                                        <select name="fields[{{ $key }}][validation]"
                                                                class="form-select form-select-lg mb-1">
                                                            <option value="required"
                                                                    @if($value['validation'] == 'required') selected @endif>{{ __('Required') }}</option>
                                                            <option value="nullable"
                                                                    @if($value['validation'] == 'nullable') selected @endif>{{ __('Optional') }}</option>
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
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                            <div class="site-input-groups">
                                                <label class="box-input-label" for="">{{ __('Status:') }}</label>
                                                <div class="switch-field">
                                                    <input
                                                        type="radio"
                                                        id="active-status"
                                                        name="status"
                                                        @if($kyc->status) checked @endif
                                                        value="1"
                                                    />
                                                    <label for="active-status">{{ __('Active') }}</label>
                                                    <input
                                                        type="radio"
                                                        id="deactivate-status"
                                                        name="status"
                                                        @if(!$kyc->status) checked @endif
                                                        value="0"
                                                    />
                                                    <label for="deactivate-status">{{ __('Deactivate') }}</label>
                                                </div>
                                            </div>
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
        $(document).ready(function (e) {
            "use strict";
            var i = Object.keys(JSON.parse(@json($kyc->fields))).length;

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
        });
    </script>
@endsection
