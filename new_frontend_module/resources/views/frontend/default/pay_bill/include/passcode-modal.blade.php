@if(auth()->user()->passcode !== null && setting('pay_bill_passcode_status'))
<div class="modal fade" id="passcode" tabindex="-1" aria-labelledby="passcodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-lucide="x"></i>
                </button>
                <div class="popup-body-text">
                    <div class="title">{{ __('Confirm Your Passcode') }}</div>
                    <div class="step-details-form">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="inputs">
                                    <label for="" class="input-label">{{ __('Passcode') }}<span class="required">*</span></label>
                                    <input type="password" class="box-input" name="passcode" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="action-btns">
                        <button type="submit" class="site-btn-sm primary-btn me-2">
                            <i data-lucide="check"></i>
                            {{ __('Confirm') }}
                        </button>
                        <button type="button" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i data-lucide="x"></i>
                            {{ __('Close') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
