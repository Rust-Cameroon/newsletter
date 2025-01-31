@extends('frontend::layouts.user')
@section('title')
    {{ $kyc->name }}
@endsection
@section('content')
<div class="row">
    @include('frontend::user.setting.include.__settings_nav')
    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
        <div class="site-card">
            <div class="site-card-header">
                <div class="title">{{ $kyc->name }}</div>
            </div>
            <div class="site-card-body">
                <div class="step-details-form">
                    <form action="{{ route('user.kyc.submit') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="kyc_id" value="{{ encrypt($kyc->id) }}">
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 col-md-6">

                                @foreach(json_decode($kyc->fields, true) as $key => $field)
                                    @if($field['type'] == 'file')
                                        <div class="inputs">
                                            <label for="{{ $key }}" class="input-label">{{ $field['name'] }}
                                                @if($field['validation'] == 'required') <span class="required">*</span> @endif
                                            </label>
                                            <div class="wrap-custom-file">
                                                <input
                                                    type="file"
                                                    name="kyc_credential[{{ $field['name'] }}]"
                                                    id="{{ $key }}"
                                                    accept=".gif, .jpg, .png"
                                                    @if($field['validation'] == 'required') required @endif
                                                />
                                                <label for="{{ $key }}">
                                                    <img
                                                        class="upload-icon"
                                                        src="{{ asset('front/images/icons/upload.svg') }}"
                                                        alt=""
                                                    />
                                                    <span>{{ $field['name'] }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @elseif($field['type'] == 'textarea')

                                        <div class="col-xl-12 col-md-12">
                                            <div class="inputs">
                                                <label for="" class="input-label">{{ $field['name'] }}</label>
                                                <textarea class="box-textarea" @if($field['validation'] == 'required') required
                                                @endif name="kyc_credential[{{$field['name']}}]"></textarea>
                                            </div>
                                        </div>

                                    @else
                                        <div class="col-xl-12 col-md-12">
                                            <div class="inputs">
                                                <label for="" class="input-label">{{ $field['name'] }}<span class="required">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="kyc_credential[{{ $field['name'] }}]" id="amount" @if($field['validation'] == 'required') required @endif>
                                                </div>
                                            </div>
                                        </div>

                                    @endif
                                @endforeach

                                <button type="submit" class="site-btn polis-btn"><i data-lucide="paperclip"></i> {{ __('Submit Now') }} </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
