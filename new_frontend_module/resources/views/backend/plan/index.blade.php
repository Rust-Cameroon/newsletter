@extends('backend.layouts.app')
@section('title')
    {{ __('Manage Plan') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('FDR Plans') }}</h2>
                            @can('schema-create')
                                <a href="{{route('admin.plan.fdr.create')}}" class="title-btn"><i
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
                    <div class="site-card">
                        <div class="site-card-body">
                            <div class="site-table table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('Plan Name') }}</th>
                                        <th scope="col">{{ __('Interest') }}</th>
                                        <th scope="col">{{ __('Interval') }}</th>
                                        <th scope="col">{{ __('Period') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($plans as $plan)
                                        <tr>
                                            <td><strong>{{$plan->name}}</strong></td>
                                            <td>
                                                <strong>{{ $plan->interest_rate }} %</strong>
                                            </td>
                                            <td>
                                                <strong>{{ $plan->intervel }} {{ __('days') }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ $plan->locked }} {{ __('days') }}</strong>
                                            </td>
                                            <td>
                                                <div @class([
                                                    'site-badge', // common classes
                                                    'success' => $plan->status,
                                                    'danger' => !$plan->status
                                                  ])>{{ $plan->status ? 'Active' : 'Deactivated' }}</div>
                                            </td>
                                            <td>
                                                @can('fdr-plan-edit')
                                                    <a href="{{route('admin.plan.fdr.edit',$plan->id)}}"
                                                       class="round-icon-btn primary-btn">
                                                        <i data-lucide="edit-3"></i>
                                                    </a>
                                                @endcan
                                                @can('fdr-plan-delete')
                                                <span type="button" id="deleteModal" data-id="{{$plan->id}}" data-name="{{$plan->name}}">
                                                    <button class="round-icon-btn red-btn" data-bs-toggle="tooltip" title="Delete Plan"
                                                        data-bs-original-title="Delete Plan">
                                                        <i data-lucide="trash-2"></i></button>
                                                </span>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                    <td colspan="7" class="text-center">{{ __('No Data Found') }}</td>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @can('fdr-plan-delete')
                        <!-- Modal for Delete Plan -->
                        <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                                <div class="modal-content site-table-modal">
                                    <div class="modal-body popup-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <div class="popup-body-text centered">
                                            <div class="info-icon">
                                                <i data-lucide="alert-triangle"></i>
                                            </div>
                                            <div class="title">
                                                <h4>{{ __('Are you sure?') }}</h4>
                                            </div>
                                            <p>
                                                {{ __('You want to delete') }} <strong id="data-name"></strong> {{ __('Plan?') }}
                                            </p>
                                            <div class="action-btns">
                                                <form id="deleteForm" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="site-btn-sm primary-btn me-2">
                                                        <i data-lucide="check"></i>
                                                        Confirm
                                                    </button>
                                                    <a href="" class="site-btn-sm red-btn" type="button" data-bs-dismiss="modal"
                                                        aria-label="Close"><i data-lucide="x"></i>{{ __('Cancel') }}</a>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal for Delete Plan End-->
                        @endcan
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

            $('body').on('click', '#deleteModal', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');

                $('#data-name').html(name);
                var url = '{{ route("admin.plan.fdr.destroy", ":id") }}';
                url = url.replace(':id', id);
                $('#deleteForm').attr('action', url);
                $('#delete').modal('toggle')

            })

        })(jQuery);
</script>
@endsection
