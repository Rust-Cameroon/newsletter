@extends('backend.layouts.app')
@section('title')
{{ __('Bill Services') }}
@endsection
@section('content')
<div class="main-content">
    <div class="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="title-content">
                        <h2 class="title">{{ __('Bill Services') }}</h2>
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
                                        <th scope="col">{{ __('Code') }}</th>
                                        <th scope="col">{{ __('Type') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($services as $service)
                                    <tr>
                                        <td>
                                            <strong>{{$service->name}}</strong>
                                        </td>
                                        <td>{{ $service->code }}</td>
                                        <td>
                                            {{ Str::ucfirst(str_replace('_', ' ', $service->type)) }}
                                        </td>
                                        <td>
                                            @if($service->status)
                                            <div class="site-badge success">{{ __('Active') }}</div>
                                            @else
                                            <div class="site-badge danger">{{ __('InActive') }}</div>
                                            @endif

                                        </td>
                                        <td>
                                            @can('bill-service-edit')
                                            <button class="round-icon-btn primary-btn" data-id="{{$service->id}}"
                                                type="button" id="edit" data-bs-toggle="tooltip" title=""
                                                data-bs-placement="top" data-bs-original-title="Edit Service">
                                                <i data-lucide="edit-3"></i>
                                            </button>
                                            @endcan
                                        </td>
                                    </tr>
                                    @empty
                                    <td colspan="6" class="text-center">{{ __('No Data Found!') }}</td>
                                    @endforelse

                                </tbody>
                            </table>
                            {{ $services->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Edit -->
    @can('bill-service-edit')
    @include('backend.bill.service.modal.__edit')
    @endcan
    <!-- Modal for Edit-->

</div>
@endsection

@section('script')
<script>
    $('body').on('click', '#edit', function (event) {
            "use strict";
            event.preventDefault();
            $('#edit-staff-body').empty();
            var id = $(this).data('id');

            $.get('edit/' + id, function (data) {

                $('#editModal').modal('show');
                $('#edit-staff-body').append(data);

            })
        })

</script>
@endsection
