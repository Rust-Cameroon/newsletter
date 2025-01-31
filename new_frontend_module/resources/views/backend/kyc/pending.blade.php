@extends('backend.layouts.app')
@section('title')
    {{ __('Pending KYC') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Pending KYC') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="row">

                    <div class="col-xl-12 col-md-12">
                        <div class="site-table table-responsive">
                            @include('backend.kyc.include.__filter',['status' => false])
                            <table class="table">
                                <thead>
                                <tr>
                                    @include('backend.filter.th',['label' => 'Date','field' => 'updated_at'])
                                    @include('backend.filter.th',['label' => 'User','field' => 'username'])
                                    <th>{{ __('Type') }}</th>
                                    @include('backend.filter.th',['label' => 'Status','field' => 'status'])
                                    <th>{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($kycs as $kyc)
                                    <tr>
                                        <td>
                                            @include('backend.kyc.include.__time', ['kyc_time' => $kyc->kyc_time])
                                        </td>
                                        <td>
                                            @include('backend.kyc.include.__user', ['id' => $kyc->id, 'username' => Str::limit($kyc->username,15)])
                                        </td>
                                        <td>
                                            @include('backend.kyc.include.__type', ['kyc_type' => $kyc->kyc_type])
                                        </td>
                                        <td>
                                            @include('backend.kyc.include.__status', ['kyc' => $kyc->kyc])
                                        </td>

                                        <td>
                                            @include('backend.kyc.include.__action' , ['id' => $kyc->id])
                                        </td>
                                    </tr>
                                @empty
                                <td colspan="5" class="text-center">{{ __('No Data Found!') }}</td>
                                @endforelse
                                </tbody>
                            </table>

                            {{ $kycs->links('backend.include.__pagination') }}
                        </div>

                        <!-- Modal for Pending KYC Details -->
                        @can('kyc-action')
                        @include('backend.kyc.include.__details_modal')
                        @endcan
                        <!-- Modal for Pending KYC Details -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>

        "use strict";

        let loader = '<div class="text-center"><img src="{{ asset('front/images/loader.gif') }}" width="100"><h5>{{ __('Please wait') }}...</h5></div>';

        $(document).on('click', '#action-kyc', function (e) {
            e.preventDefault()

            $('#kyc-action-data').html(loader);
            var id = $(this).data('id');
            var url = '{{ route("admin.kyc.action",":id") }}';
            url = url.replace(':id', id);

            $.get(url, function (data) {
                $('#kyc-action-data').html(data);
            })

            $('#kyc-action-modal').modal('toggle');
        })
    </script>
@endsection
