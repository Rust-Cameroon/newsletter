@extends('backend.layouts.app')
@section('title')
    {{ __('Manage Referral Rules') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Referral Rules Settings') }}</h2>
                            <a href="{{ route('admin.referral.index') }}" class="title-btn mx-2"> {{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-6 col-md-6">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('Rules') }}</h3>
                        </div>
                        <div class="site-card-body">
                            <form action="{{ route('admin.settings.update') }}" method="post">
                                @csrf
                                <input type="hidden" name="section" value="global">
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-4 col-label">{{ __('Referral Rules') }} <small>({{ __('For user dashboard') }})</small></label>
                                    <div class="col-xl-12">
                                        <a href="javascript:void(0)" id="addRow" class="site-btn-xs primary-btn mb-3">{{ __('Add Field') }}</a>
                                    </div>
                                    @php
                                        $rowId = 0;
                                        $rules = json_decode(App\Models\Setting::where('name','referral_rules')->first()?->val)
                                    @endphp
                                    <div class="addReferralInfo">
                                        @if(is_array($rules))
                                            @foreach ($rules as $rule)
                                            <div class="option-remove-row row">
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                                    <div class="site-input-groups mb-0">
                                                        <select name="referral_rules[{{ $rowId }}][icon]" class="form-select form-select-lg mb-1">
                                                            <option value="tick" @selected($rule->icon == 'tick')>{{ __('Tick Sign') }}</option>
                                                            <option value="cross" @selected($rule->icon == 'cross')>{{ __('Cross Sign') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-12">
                                                    <div class="site-input-groups">
                                                        <input name="referral_rules[{{ $rowId }}][rule]" class="box-input" type="text" value="{{ $rule->rule }}" required="" placeholder="Write rule..">
                                                    </div>
                                                </div>

                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <button class="delete-option-row delete_desc" type="button"> <i class="fas fa-times"></i> </button>
                                                </div>
                                            </div>
                                            @php
                                                $rowId++;
                                            @endphp
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                @include('backend.setting.site_setting.include.form.__close_action')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('script')

<script>
    'use strict';

    let i = {{ $rowId }};

    $("#addRow").on('click', function () {
        ++i;

        var form = `<div class="option-remove-row row"><div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12"><div class="site-input-groups mb-0"><select name="referral_rules[`+i+`][icon]" class="form-select form-select-lg mb-1"><option value="tick">{{ __('Tick Sign') }}</option><option value="cross">{{ __('Cross Sign') }}</option></select></div></div><div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-12"><div class="site-input-groups"><input name="referral_rules[`+i+`][rule]" class="box-input" required placeholder="Write rule.."></div></div><div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12"><button class="delete-option-row delete_desc" type="button"><i class="fas fa-times"></i></button></div></div>`;

        $('.addReferralInfo').append(form)
    });

    $(document).on('click', '.delete_desc', function () {
        $(this).closest('.option-remove-row').remove();
    });

</script>
@endsection
