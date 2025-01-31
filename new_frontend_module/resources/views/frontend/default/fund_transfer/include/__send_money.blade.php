
<form action="{{ route('user.fund_transfer.transfer') }}" method="POST">
    @csrf
    <div class="modal fade" id="sendBox" tabindex="-1" aria-labelledby="sendBoxModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content site-table-modal">
                <div class="modal-body popup-body">
                    <button type="button" class="modal-btn-close" data-bs-dismiss="modal"
                            aria-label="Close"><i data-lucide="x"></i></button>
                    <div class="popup-body-text">
                        <div class="title">{{ __('Send Money') }}</div>
                        <input type="hidden" name="bank_id" id="bank_id">
                        <input type="hidden" name="beneficiary_id" id="beneficiary_id">
                        <div class="step-details-form">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Enter Amount') }}<span
                                                class="required">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="amount" id="send-money-amount">
                                            <span class="input-group-text">{{ $currency }}</span>
                                        </div>
                                        <div class="input-info-text min-max"></div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Purpose of transfer') }}</label>
                                        <textarea name="purpose" rows="3" class="box-textarea"></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="modal-beneficiary-details mt-4 mb-4">
                                        <div class="profile-text-data">
                                            <div class="attribute">{{ __('Transferrable Amount') }}</div>
                                            <div class="value transfer_amount"></div>
                                        </div>
                                        <div class="profile-text-data">
                                            <div class="attribute">{{ __('Charge') }}</div>
                                            <div class="value transfer_charge"></div>
                                        </div>
                                        <div class="profile-text-data">
                                            <div class="attribute">{{ __('Total Amount') }}</div>
                                            <div class="value total_transfer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="action-btns">
                            <button class="site-btn-sm primary-btn me-2"
                            @if(auth()->user()->passcode !== null && setting('fund_transfer_passcode_status'))
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#passcode"
                            @else
                            type="submit"
                            @endif>
                                <i data-lucide="send"></i>
                                {{ __('Send Money') }}
                            </button>
                            <a href="" class="site-btn-sm red-btn" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-lucide="x"></i>
                                {{ __('Close') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->passcode !== null && setting('fund_transfer_passcode_status'))
    <div class="modal fade" id="passcode" tabindex="-1" aria-labelledby="passcodeModalLabel" aria-hidden="true" >
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
</form>
