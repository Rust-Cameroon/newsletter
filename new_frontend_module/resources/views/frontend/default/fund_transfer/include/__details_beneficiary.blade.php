<div class="modal fade" id="detailsBox" tabindex="-1" aria-labelledby="detailsBoxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-lucide="x"></i></button>
                <div class="popup-body-text">
                    <div class="title">{{ __('Beneficiary Details') }}</div>
                    <div class="modal-beneficiary-details">
                        <div class="profile-text-data">
                            <div class="attribute">{{ __('Bank Name') }}</div>
                            <div class="value" id="bank_name"></div>
                        </div>
                        <div class="profile-text-data">
                            <div class="attribute">{{ __('Account Number') }}</div>
                            <div class="value" id="account_number"></div>
                        </div>
                        <div class="profile-text-data">
                            <div class="attribute">{{__('Name on Account')}}</div>
                            <div class="value" id="account_name"></div>
                        </div>
                        <div class="profile-text-data">
                            <div class="attribute">{{ __('Branch Name') }}</div>
                            <div class="value" id="branch_name"></div>
                        </div>
                        <div class="profile-text-data">
                            <div class="attribute">{{ __('Nick Name') }}</div>
                            <div class="value" id="nick_name"></div>
                        </div>
                        <div class="profile-text-data">
                            <div class="attribute">{{ __('Daily Limit') }}</div>
                            <div class="value daily_limit"></div>
                        </div>
                        <div class="profile-text-data">
                            <div class="attribute">{{ __('Monthly Limit') }}</div>
                            <div class="value monthly_limit"></div>
                        </div>
                        <div class="profile-text-data">
                            <div class="attribute">{{ __('Charge per transfer') }}</div>
                            <div class="value charge"></div>
                        </div>
                    </div>
                    <div class="action-btns mt-3">
                        <a href="" class="site-btn-sm polis-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i data-lucide="check"></i>
                            {{ __('Close it') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
