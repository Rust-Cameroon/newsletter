@extends('frontend::layouts.user')
@section('title')
{{ __('Action Settings') }}
@endsection
@section('content')
<div class="row">
    @include('frontend::user.setting.include.__settings_nav')

    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="site-card">
            <div class="site-card-header">
                <div class="title-small">{{ __('Account Closing') }}</div>
            </div>
            <div class="site-card-body">
                <a href="#" class="site-btn red-btn mt-2" data-bs-toggle="modal" data-bs-target="#closeAccount"><i data-lucide="alert-triangle"></i>{{ __('Close my account') }}</a>
            </div>
        </div>
    </div>

    <!-- Modal for Account Closing Start-->
    <div class="modal fade" id="closeAccount" tabindex="-1" aria-labelledby="closeAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content site-table-modal">
                <div class="modal-body popup-body">
                    <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-lucide="x"></i></button>
                    <div class="popup-body-text centered">
                        <form action="{{ route('user.setting.close.account') }}" method="post" class="step-details-form">
                            @csrf

                            <div class="info-icon">
                                <i data-lucide="alert-triangle"></i>
                            </div>
                            <div class="title">
                                <h4>{{ __('Are you sure?') }}</h4>
                            </div>
                            <p>
                                {{ __('You want to close this account?') }}
                            </p>
                            <div class="alert alert-warning">
                                {{ __('You will able to reactivate your account in the future by contacting us at ').setting('support_email', 'global') }}
                            </div>
                            <div class="inputs">
                                <textarea name="reason" placeholder="Reason (optional)" cols="10" rows="5" class="box-textarea"></textarea>
                            </div>
                            <div class="action-btns">
                                <button type="submit" class="site-btn-sm primary-btn me-2 confirm_btn">
                                    <i data-lucide="check"></i>
                                    {{ __('Confirm') }}
                                </button>
                                <button type="button" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-lucide="x"></i>
                                    {{ __('Cancel') }}
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Account Closing End-->

</div>
@endsection
