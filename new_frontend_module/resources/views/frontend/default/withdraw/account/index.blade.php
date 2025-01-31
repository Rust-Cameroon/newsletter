@extends('frontend::layouts.user')
@section('title')
    {{ __('Withdraw Account') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="title">{{ __('Withdraw Account') }}</h3>
                    <div class="card-header-links">
                        <a href="{{ route('user.withdraw.account.create') }}"
                           class="card-header-link">{{ __('Add New') }}</a>
                    </div>
                </div>
                <div class="site-card-body p-0">
                    <div class="site-custom-table">
                        <div class="contents">
                            <div class="site-table-list site-table-head">
                                <div class="site-table-col">{{ __('Account') }}</div>
                                <div class="site-table-col">{{ __('Action') }}</div>
                            </div>
                            @foreach ($accounts as $account)
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="description">
                                        <div class="event-icon">
                                            <i data-lucide="download"></i>
                                        </div>
                                        <div class="content">
                                            <div class="title">{{$account->method_name}}</div>
                                            <div class="date">{{ $account->method->currency .' '. __('Account') }} </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="site-table-col">
                                    <div class="action">
                                        <a href="{{ route('user.withdraw.account.edit',$account->id) }}" class="icon-btn me-2">
                                            <i data-lucide="edit-2"></i> {{ __('Edit') }}
                                        </a>
                                        <a href="javascript:void(0)" class="icon-btn bg-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteAccount" data-id="{{ encrypt($account->id) }}">
                                            <i data-lucide="trash"></i> {{ __('Remove') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if(count($accounts) == 0)
                        <div class="no-data-found">{{ __('No Data Found') }}</div>
                        @endif
                    </div>

                    <!-- Modal for Delete Account -->
                    <div class="modal fade" id="deleteAccount" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content site-table-modal">
                                <div class="modal-body popup-body"> <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"> <i data-lucide="x"></i> </button>
                                    <div class="popup-body-text centered">
                                        <form action="" method="post" id="delete-account">
                                            @csrf
                                            <div class="info-icon"> <i data-lucide="alert-triangle"></i> </div>
                                            <div class="title">
                                                <h4>{{ __('Are you sure?') }}</h4>
                                            </div>
                                            <p>{{ __('You want to delete this account?') }}</p>
                                            <div class="action-btns">
                                                <button type="submit" class="site-btn-sm primary-btn me-2"> <i data-lucide="check"></i> {{ __('Confirm') }} </button>
                                                <a href="#" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close"> <i data-lucide="x"></i> {{ __('Cancel') }} </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal for Delete Account End-->

                </div>
            </div>
        </div>
    </div>
@push('js')
<script>
    "use strict";

    $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        var url = "{{ url('user/withdraw/account/delete') }}/"+id;
        $('#delete-account').attr('action', url);
    });

</script>
@endpush
@endsection
