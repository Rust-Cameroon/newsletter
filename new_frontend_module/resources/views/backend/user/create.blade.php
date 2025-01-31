@extends('backend.layouts.app')
@section('title')
    {{ __('Add New Customer') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Add New Customer') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <form action="{{ route('admin.user.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="site-card">
                            <div class="site-card-header">
                                <h4 class="title">{{ __('Basic Info') }}</h4>
                            </div>
                            <div class="site-card-body">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('First Name:') }}</label>
                                            <input type="text" name="fname" class="box-input mb-0" value="{{ old('fname') }}" required/>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Last Name:') }}</label>
                                            <input type="text" name="lname" class="box-input mb-0" value="{{ old('lname') }}" required/>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Country:') }}</label>
                                            <select name="country" id="country" class="form-control form-select">
                                                <option value="" selected>{{ __('Select Country') }}</option>
                                                @foreach(getCountries() as $country)
                                                    <option value="{{ $country['name'] }}" @selected(old('country') == $country['name'])>{{ $country['name']  }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @if(branch_enabled())
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Branch:') }}</label>
                                            <select name="branch_id" id="branch_id" class="form-select">
                                                <option value="" selected disabled>{{ __('Select Branch:') }}</option>
                                                @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}" @selected(old('branch_id') == $branch->id)>{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Gender:') }}</label>
                                            <select name="gender" class="form-control form-select">
                                                <option value="" selected>{{ __('Select Gender') }}</option>
                                                <option value="male" @selected(old('gender') == 'male')>{{ __('Male') }}</option>
                                                <option value="female" @selected(old('gender') == 'female')>{{ __('Female') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Email Address:') }}</label>
                                            <input type="email" name="email" class="box-input mb-0" value="{{ old('email') }}" required/>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Phone:') }}</label>
                                            <input type="text" name="phone" class="box-input mb-0" value="{{ old('phone') }}" required/>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Date of Birth:') }}</label>
                                            <input type="date" class="box-input" name="date_of_birth" value="{{ old('date_of_birth') }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('City:') }}</label>
                                            <input type="text" name="city" class="box-input" value="{{ old('city') }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Zip Code:') }}</label>
                                            <input type="text" class="box-input" name="zip_code" value="{{ old('zip_code') }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Address:') }}</label>
                                            <input type="text" class="box-input" name="address" value="{{ old('address') }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Password:') }}</label>
                                            <input type="password" name="password" class="box-input mb-0" value="{{ old('password') }}" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="site-card">
                            <div class="site-card-header">
                                <h4 class="title">{{ __('KYC Submission') }}</h4>
                            </div>
                            <div class="site-card-body">
                                @foreach ($kycs as $kyc)
                                <input type="hidden" name="kyc_ids[]" value="{{ $kyc->id }}">
                                <div class="site-card">
                                    <div class="site-card-header">
                                        <h4 class="title">{{ $kyc->name }}</h4>
                                    </div>
                                    <div class="site-card-body">
                                        <div class="row">
                                            <div class="col-md-4 col-xl-4 col-lg-4">
                                                @foreach(json_decode($kyc->fields, true) as $key => $field)
                                                    @if($field['type'] == 'file')
                                                    <div class="site-input-groups mb-2">
                                                        <label class="box-input-label" for="">{{ $field['name'] }} @if($field['validation'] == 'required') <span class="text text-danger">*</span>
                                                            @endif</label>
                                                        <div class="wrap-custom-file">
                                                            <input type="file" name="kyc_credential[{{ $kyc->id }}][{{ $field['name'] }}]" id="{{ $field['name'] }}" accept=".gif, .jpg, .png, .svg" @required($field['validation'] == 'required')/>
                                                            <label for="{{ $field['name'] }}">
                                                                <img class="upload-icon" src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                                                <span>{{ __('Upload Icon') }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @elseif($field['type'] == 'textarea')
                                                    <div class="site-input-groups">
                                                        <label for="" class="box-input-label">{{ $field['name'] }} @if($field['validation'] == 'required') <span class="text text-danger">*</span>
                                                            @endif</label>
                                                        <textarea type="text" @if($field['validation'] == 'required') required
                                                        @endif name="kyc_credential[{{ $kyc->id }}][{{ $field['name'] }}]" class="box-input mb-0"/>
                                                    </div>
                                                    @else
                                                    <div class="site-input-groups">
                                                        <label for="" class="box-input-label">{{ $field['name'] }} @if($field['validation'] == 'required') <span class="text text-danger">*</span>
                                                            @endif</label>
                                                        <input type="text" name="kyc_credential[{{ $kyc->id }}][{{ $field['name'] }}]" class="box-input mb-0" @if($field['validation'] == 'required') required
                                                        @endif/>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="user-plus"></i>
                                {{ __('Add New') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    "use strict"

    $('#branch_id').select2();
    $('#country').select2();
</script>
@endsection
