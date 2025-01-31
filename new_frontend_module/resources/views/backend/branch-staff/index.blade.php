@extends('backend.layouts.app')
@section('title')
    {{ __('Manage Branch') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Branch Staff') }}</h2>
                            @can('branch-staff-create')
                                <a href="{{route('admin.branch-staff.create')}}" class="title-btn"><i
                                        data-lucide="plus-circle"></i>{{ __('Add New') }}</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="site-table table-responsive">
                        @include('backend.branch-staff.include.__filter', ['status' => true])
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Designation') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Mobile') }}</th>
                                <th>{{ __('Branch') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($staffs as $staff)
                                <tr>
                                    <td>{{ safe($staff->user?->name) }}</td>
                                    <td>{{ safe($staff->user?->getRoleNames()->first()) }}</td>
                                    <td>{{ $staff->user?->email }}</td>
                                    <td>{{ $staff->user?->phone }}</td>
                                    <td>
                                        {{ $staff->branch->name }}
                                    </td>
                                    <td>
                                        @include('backend.branch-staff.include.__status', ['status' => $staff->status])
                                    </td>
                                    <td>
                                        @include('backend.branch-staff.include.__action', ['staff' => $staff])
                                    </td>
                                </tr>
                            @empty
                            <td colspan="7" class="text-center">{{ __('No Data Found!') }}</td>
                            @endforelse
                            </tbody>

                        </table>

                        {{ $staffs->links('backend.include.__pagination') }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')

<script>
    (function ($) {
            "use strict";

            // Delete
            $('body').on('click', '#deleteModal', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');

                $('#data-name').html(name);
                var url = '{{ route("admin.branch-staff.destroy", ":id") }}';
                url = url.replace(':id', id);
                $('#deleteForm').attr('action', url);
                $('#delete').modal('toggle')

            })

        })(jQuery);
</script>
@endsection
