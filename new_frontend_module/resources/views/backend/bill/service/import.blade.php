@extends('backend.layouts.app')
@section('title')
{{ __('Import Services') }}
@endsection
@section('content')
<div class="main-content">
    <div class="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="title-content">
                        <h2 class="title">{{ __('Import Services') }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="site-card">
                    <div class="site-card-body">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-3 col-xl-3">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Method:') }}</label>
                                        <select name="method" class="form-select">
                                            <option value="" selected disabled>{{ __('Select Method') }}</option>
                                            @foreach ($methods as $method)
                                            <option value="{{ strtolower($method->name) }}" @selected(request('method') == strtolower($method->name))>{{ __($method->name) }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xl-3">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Categories:') }}</label>
                                        <select name="category" class="form-select">
                                            <option value="" selected disabled>{{ __('Select Category') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xl-3" id="operator-area">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Operators:') }}</label>
                                        <select name="operator" class="form-select">
                                            <option value="" selected disabled>{{ __('Select Operator') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xl-3">

                                    <button type="submit" name="type" value="get_service" class="site-btn-sm primary-btn mt-4">
                                        <i data-lucide="search"></i>
                                        {{ __('Search Service') }}
                                    </button>
                                </div>
                            </div>



                        </form>
                    </div>
                </div>
            </div>
            @isset($services)
            <div class="col-xl-12">
                <form action="{{ route('admin.bill.service.bulk.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="method" value="{{ request('method') }}">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <input type="hidden" name="operator" value="{{ request('operator') }}">
                    <div class="site-card">
                        <div class="site-card-body">
                            <button type="submit" class="site-btn-sm primary-btn mb-2">
                                <i data-lucide="plus-circle"></i> {{ __('Bulk Insert') }}
                            </button>
                            <div class="site-table table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <input type="checkbox" id="all-checked" class="form-check-input">
                                            </th>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('Code') }}</th>
                                            <th scope="col">{{ __('Country') }}</th>
                                            <th scope="col">{{ __('Amount') }}</th>
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($services as $service)
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" name="services[]" id="check-row" value="{{ json_encode($service) }}" class="form-check-input">
                                            </td>
                                            <td>
                                                {{ $service['biller_name'] }}
                                            </td>
                                            <td>
                                                {{ $service['biller_code'] }}
                                            </td>
                                            <td>
                                                {{ $service['country'] }}
                                            </td>
                                            <td>
                                                {{ $service['amount'] }}
                                            </td>
                                            <td>
                                                <button type="button" class="round-icon-btn red-btn" id="addService" data-info="{{ json_encode($service) }}">
                                                    <i data-lucide="plus-circle"></i>
                                                </button>
                                                <button type="button" class="round-icon-btn primary-btn d-none" id="addedService" disabled>
                                                    <i data-lucide="check-circle"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endisset
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    "use strict";

    $('body').on('click', '#edit', function (event) {

        event.preventDefault();
        $('#edit-staff-body').empty();
        var id = $(this).data('id');

        $.get('edit/' + id, function (data) {

            $('#editModal').modal('show');
            $('#edit-staff-body').append(data);

        })
    });

    $('#all-checked').on('click',function(){
        $('input[id=check-row]').prop('checked',this.checked);
    });

    function operatorToggle(method){
        if(method == 'bloc'){
            $('#operator-area').show();
        }else{
            $('#operator-area').hide();
        }
    }

    operatorToggle('{{ request('method') }}');

    $('select[name=method]').on('change', function () {

        var method = $(this).val();

        operatorToggle(method);

        getCategories(method);

    });

    function getCategories(method){

        $.get('{{ url('admin/bill/get-categories') }}/' + method, function (data) {

            $('select[name=category]').html(data);

            $('select[name=category]').val('{{ request('category') }}')

        });
    }

    @if(request('type') == 'get_service')
        getCategories('{{ request('method') }}');
    @endif

    $(document).on('click','#addService',function(){

        let method = "{{ request('method') }}";
        let category = "{{ request('category') }}";
        let data  = $(this).data('info');
        let element  = $(this);
        let loader = '<div class="text-center"><img src="{{ asset('front/images/loader.gif') }}" width="100"><h5>{{ __('Please wait') }}...</h5></div>';

        element.removeAttr('id');
        element.html(loader);

        $.ajax({
            url : "{{ route('admin.bill.service.store') }}",
            data : {_token:"{{ csrf_token() }}",method:method,category:category,data:data},
            method : "POST",
            success : function(response){
                if(response.success){
                    element.parent().find('#addedService').removeClass('d-none');

                    element.remove();

                    tNotify('success',response.message,'Success');
                }else{
                    element.attr('id','addService');
                    element.html('<i data-lucide="plus-circle"></i>');
                    lucide.createIcons();
                    tNotify('warning',response.message,'Error');
                }
            },
            error : function(error){
                element.attr('id','addService');
                element.html('<i data-lucide="plus-circle"></i>');
                lucide.createIcons();
                tNotify('error',"{{ __('Sorry, Something went wrong!') }}",'Error');
            }
        });

    });

</script>
@endsection
