@if($user->kyc == \App\Enums\KYCStatus::Pending->value)
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="identity-alert pending">
                <div class="icon">
                    <i data-lucide="alert-triangle"></i>
                </div>
                <div class="contents">
                    <div class="head">{{ __('Verification Center') }}</div>
                    <div class="content">
                        {{ __('You have submitted your documents and it is awaiting for
                        the approval') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif($user->kyc == \App\Enums\KYCStatus::NOT_SUBMITTED->value) 
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="identity-alert not-approved">
                <div class="icon"><i data-lucide="alert-triangle"></i></div>
                <div class="contents">
                    <div class="head">{{ __('Verification Center') }}</div>
                    <div class="content">{{ __('You have information to submit in Verification Center') }} <a
                            href="{{ route('user.kyc') }}">{{ __('Submit now') }}</a></div>
                </div>
            </div>
        </div>
    </div>
@endif
