@extends('backend.layouts.app')
@section('title')
    {{ __('Others Bank') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('All Others Bank') }}</h2>
                            @can('others-bank-create')
                                <a href="{{route('admin.others-bank.create')}}" class="title-btn"><i
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
                        @include('backend.fund-transfer.others-bank.include.__filter')
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{ __('Logo') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Code') }}</th>
                                <th>{{ __('Processing Time') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($banks as $bank)
                                <tr>
                                    <td>
                                        <img
                                            src="{{ asset($bank->logo) }}"
                                            alt=""
                                            width="48px"
                                        />
                                    </td>
                                    <td>{{ safe($bank->name) }}</td>
                                    <td>{{ safe($bank->code) }}</td>
                                    <td>{{ $bank->processing_time }} {{ $bank->processing_type ?? '' }} </td>
                                    <td>
                                        @include('backend.fund-transfer.others-bank.include.__status', ['status' => $bank->status])
                                    </td>
                                    <td>
                                        @include('backend.fund-transfer.others-bank.include.__action', ['id' => $bank->id, 'name' => $bank->name])
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>

                        {{ $banks->links('backend.include.__pagination') }}
                    </div>
                </div>
                @can('others-bank-delete')
                <!-- Modal for Delete -->
                <div class="modal fade" id="deletePopUp" tabindex="-1" aria-labelledby="deletePopUpModalLabel" aria-hidden="true">
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
                                        {{ __('You want to delete') }} <strong id="language-name"></strong> {{ __('Bank?') }}
                                    </p>
                                    <div class="action-btns">
                                        <form id="deletePopUpForm" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                                <i data-lucide="check"></i>
                                                {{ __('Confirm') }}
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
                <!-- Modal for Delete End-->
                @endcan
            </div>
        </div>

    </div>
@endsection
@section('script')
<script>
    (function ($) {
            "use strict";

            $('body').on('click', '#deletePopUpModal', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');

                $('#language-name').html(name);
                var url = '{{ route("admin.others-bank.destroy", ":id") }}';
                url = url.replace(':id', id);
                $('#deletePopUpForm').attr('action', url);
                $('#deletePopUp').modal('toggle')

            })

        })(jQuery);
</script>
@endsection
