@extends('backend.layouts.app')
@section('title')
    {{ __('Manage Staff') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Manage Staffs') }}</h2>
                            @can('staff-create')
                                <a href="" class="title-btn" type="button" data-bs-toggle="modal"
                                   data-bs-target="#staffModal"><i data-lucide="plus-circle"></i>{{ __('Add New Staff') }}
                                </a>
                            @endcan
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
                            <div class="site-table table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Email') }}</th>
                                        <th scope="col">{{ __('Role') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($staffs as $staff)
                                        <tr>
                                            <td>
                                                <strong>{{$staff->name}}</strong>
                                            </td>
                                            <td>{{ $staff->email }}</td>
                                            <td><strong
                                                    class="site-badge primary">{{ $staff->getRoleNames()->first() }}</strong>
                                            </td>
                                            <td>
                                                @if($staff->status)
                                                    <div class="site-badge success">{{ __('Active') }}</div>
                                                @else
                                                    <div class="site-badge danger">{{ __('InActive') }}</div>
                                                @endif

                                            </td>
                                            <td>
                                                @if($staff->getRoleNames()->first() === 'Super-Admin')
                                                    <button class="round-icon-btn red-btn" type="button"
                                                            data-bs-toggle="tooltip" title="" data-bs-placement="top"
                                                            data-bs-original-title="Not Editable">
                                                        <i data-lucide="edit-3"></i>
                                                    </button>
                                                @else
                                                    @can('staff-edit')
                                                        <button class="round-icon-btn primary-btn"
                                                                data-id="{{$staff->id}}" type="button" id="edit"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-bs-placement="top"
                                                                data-bs-original-title="Edit Staff">
                                                            <i data-lucide="edit-3"></i>
                                                        </button>
                                                    @endcan
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                    <td colspan="5" class="text-cener">{{ __('No Data Found!') }}</td>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Add New Staff -->
        @can('staff-create')
            @include('backend.staff.modal.__new_staff')
        @endcan
        <!-- Modal for Add New Staff-->

        <!-- Modal for Edit Staff -->
        @can('staff-edit')
            @include('backend.staff.modal.__edit_staff')
        @endcan
        <!-- Modal for Edit Staff-->

    </div>
@endsection

@section('script')
    <script>
        let loader = '<div class="text-center"><img src="{{ asset('front/images/loader.gif') }}" width="100"><h5>{{ __('Please wait') }}...</h5></div>';

        $('body').on('click', '#edit', function (event) {
            "use strict";
            event.preventDefault();
            $('#edit-staff-body').html(loader);
            $('#editModal').modal('show');
            var id = $(this).data('id');

            $.get('staff/' + id + '/edit', function (data) {

                $('#edit-staff-body').html(data);

            })
        })

    </script>
@endsection
