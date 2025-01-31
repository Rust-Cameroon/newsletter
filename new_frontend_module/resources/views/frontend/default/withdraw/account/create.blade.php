@extends('frontend::layouts.user')
@section('title')
    {{ __('Withdraw Account Create') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title">{{ __('Add New Withdraw Account') }}</div>
                    <div class="card-header-links">
                        <a href="{{ route('user.withdraw.account.index') }}" class="card-header-link"
                        ><i data-lucide="alert-circle"></i>{{ __('Withdraw Account') }}</a
                        >
                    </div>
                </div>
                <form action="{{ route('user.withdraw.account.store') }}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="site-card-body">
                        <div class="step-details-form mb-4">

                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 selectMethodCol">
                                    <div class="inputs">
                                        <label for="" class="input-label"
                                        >{{ __('Select') }}<span class="required">*</span></label
                                        >
                                        <select
                                            name="withdraw_method_id"
                                            class="box-input select2-basic-active"
                                            id="selectMethod"
                                        >
                                            <option disabled selected>{{ __('Select Gateway') }}</option>
                                            @foreach($withdrawMethods as $raw)
                                                <option value="{{ $raw->id }}">{{ $raw->name }}
                                                    ({{ ucwords($raw->type) }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="site-btn polis-btn">
                            <i data-lucide="download"></i>
                            {{ __('Add New Withdraw Account') }}
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        "use strict";

        // Select 2 activation
        $(".select2-basic-active").select2({
            minimumResultsForSearch: Infinity,
        });

        // nice select
        $(".add-beneficiary").niceSelect();
        $(".edit-beneficiary").niceSelect();

        $("#selectMethod").on('change', function (e) {
            "use strict"
            e.preventDefault();

            $('.selectMethodRow').children().not(':first').remove();

            var id = $(this).val()

            var url = '{{ route("user.withdraw.method",":id") }}';
            url = url.replace(':id', id);
            $.get(url, function (data) {
                $(data).insertAfter(".selectMethodCol");
                imagePreview()
            })
        })
    </script>
@endsection
