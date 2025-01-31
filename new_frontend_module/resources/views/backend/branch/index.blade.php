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
                            <h2 class="title">{{ __('All Branch') }}</h2>
                            @can('branch-create')
                                <a href="{{route('admin.branch.create')}}" class="title-btn"><i
                                        data-lucide="plus-circle"></i>{{ __('Add New') }}</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-warning">
            <i data-lucide="alert-circle"></i> {{ __('Branch system will work when bank system is Physical. Otherwise, Branch system not showing and working.') }}
        </div>
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="site-table table-responsive">
                        @include('backend.branch.include.__filter', ['status' => true])
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{ __('Code') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Routing') }}</th>
                                <th>{{ __('Swift') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Address') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($branches as $branch)
                                <tr>
                                    <td>
                                        {{ safe($branch->code) }}
                                    </td>
                                    <td>{{ safe($branch->name) }}</td>
                                    <td>{{ safe($branch->routing_number) }}</td>
                                    <td>{{ $branch->swift_code }}</td>
                                    <td>{{ $branch->phone }}</td>
                                    <td>
                                        {{ $branch->email }}
                                    </td>
                                    <td>
                                        {{ $branch->address }}
                                    </td>
                                    <td>
                                        @include('backend.branch.include.__status', ['status' => $branch->status])
                                    </td>
                                    <td>
                                        @include('backend.branch.include.__action', ['branch' => $branch])
                                    </td>
                                </tr>
                            @empty
                            <td colspan="9" class="text-center">{{ __('No Data Found!') }}</td>
                            @endforelse
                            </tbody>

                        </table>

                        {{ $branches->links('backend.include.__pagination') }}
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
                var url = '{{ route("admin.branch.destroy", ":id") }}';
                url = url.replace(':id', id);
                $('#deleteForm').attr('action', url);
                $('#delete').modal('toggle')

            })

        })(jQuery);
</script>
@endsection
