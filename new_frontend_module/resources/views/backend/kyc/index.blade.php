@extends('backend.layouts.app')
@section('title')
    {{ __('KYC') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('KYC') }}</h2>
                            <a href="{{ route('admin.kyc-form.create') }}" class="title-btn"><i
                                    data-lucide="plus-circle"></i>{{ __('Add New') }}</a>
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
                                        <th scope="col">{{ __('Verification Name') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($kycs as $kyc)
                                        <tr>
                                            <td>
                                                <strong>{{ $kyc->name }}</strong>
                                            </td>
                                            <td>
                                                @if( $kyc->status)
                                                    <div class="site-badge success">{{ __('Active') }}</div>
                                                @else
                                                    <div class="site-badge pending">{{ __('Disabled') }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.kyc-form.edit',$kyc->id) }}"
                                                   class="round-icon-btn primary-btn">
                                                    <i data-lucide="edit-3"></i>
                                                </a>
                                                <button type="button" data-id="{{ $kyc->id }}"
                                                        data-name="{{ $kyc->name }}"
                                                        class="round-icon-btn red-btn deleteKyc">
                                                    <i data-lucide="trash-2"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Delete deleteKycType -->
        <div
            class="modal fade"
            id="deleteKyc"
            tabindex="-1"
            aria-labelledby="deleteKycTypeModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content site-table-modal">
                    <div class="modal-body popup-body">
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                        <div class="popup-body-text centered">
                            <form method="post" id="kycEditForm">
                                @method('DELETE')
                                @csrf
                                <div class="info-icon">
                                    <i data-lucide="alert-triangle"></i>
                                </div>
                                <div class="title">
                                    <h4>{{ __('Are you sure?') }}</h4>
                                </div>
                                <p>
                                    {{ __('You want to Delete') }} <strong
                                        class="name"></strong> {{ __('KYC Verification Type?') }}
                                </p>
                                <div class="action-btns">
                                    <button type="submit" class="site-btn-sm primary-btn me-2">
                                        <i data-lucide="check"></i>
                                        {{ __(' Confirm') }}
                                    </button>
                                    <a href="" class="site-btn-sm red-btn" type="button"
                                       class="btn-close"
                                       data-bs-dismiss="modal"
                                       aria-label="Close">
                                        <i data-lucide="x"></i>
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for Delete deleteKycType-->
    </div>
@endsection
@section('script')
    <script>

        $('.deleteKyc').on('click',function (e) {
            "use strict";
            e.preventDefault();

            var id = $(this).data('id');
            var name = $(this).data('name');

            var url = '{{ route("admin.kyc-form.destroy", ":id") }}';
            url = url.replace(':id', id);
            $('#kycEditForm').attr('action', url)

            $('.name').html(name);
            $('#deleteKyc').modal('show');
        })
    </script>
@endsection
