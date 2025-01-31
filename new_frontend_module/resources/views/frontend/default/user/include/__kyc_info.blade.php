@if($user->kyc != \App\Enums\KYCStatus::Verified->value)
    <div class="row desktop-screen-show">
        <div class="col">
            <div class="alert site-alert alert-dismissible fade show" role="alert">
                <div class="content">
                    <div class="icon"><i class="anticon anticon-warning"></i></div>
                    @if($user->kyc == \App\Enums\KYCStatus::Pending->value)
                        <strong>{{ __('KYC Pending') }}</strong>
                    @else
                        {{ __('You need to submit your') }}
                        <strong>{{ __('KYC and Other Documents') }}</strong> {{ __('before proceed to the system.') }}
                    @endif
                </div>
                @if($user->kyc != \App\Enums\KYCStatus::Pending->value)
                    <div class="action">
                        <a href="{{ route('user.kyc') }}" class="site-btn-sm grad-btn"><i
                                class="anticon anticon-info-circle"></i>{{ __('Submit Now') }}</a>
                        <a href="" class="site-btn-sm red-btn ms-2" type="button" data-bs-dismiss="alert"
                           aria-label="Close"><i class="anticon anticon-close"></i>{{ __('Later') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
