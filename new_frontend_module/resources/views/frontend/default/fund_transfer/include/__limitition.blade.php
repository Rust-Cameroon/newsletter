<div class="modal fade" id="limitBox" tabindex="-1" aria-labelledby="limitBoxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-lucide="x"></i></button>
                <div class="popup-body-text">
                    <div class="title">{{ __('Wire Transfer Limit') }}</div>
                    <div class="modal-beneficiary-details">
                        <div class="profile-text-data">
                            <div class="attribute">{{ __('Min. per transaction') }}</div>
                            <div class="value">{{ $data->minimum_transfer }} {{ $currency }}</div>
                        </div>
                        <div class="profile-text-data">
                            <div class="attribute">{{ __('Max. per transaction') }}</div>
                            <div class="value">{{ $data->maximum_transfer }} {{ $currency }}</div>
                        </div>
                        <div class="profile-text-data">
                            <div class="attribute">{{ __('Daily Max. transfer') }}</div>
                            <div class="value">{{ $data->daily_limit_maximum_amount }} {{ $currency }}</div>
                        </div>
                        <div class="profile-text-data">
                            <div class="attribute">{{ __('Monthly Max. transfer') }}</div>
                            <div class="value">{{ $data->monthly_limit_maximum_amount }} {{ $currency }}</div>
                        </div>
                        <div class="profile-text-data">
                            <div class="attribute">{{ __('Daily transactions limit') }}</div>
                            <div class="value">{{ $data->daily_limit_maximum_count }} {{ __('Times') }}</div>
                        </div>
                        <div class="profile-text-data">
                            <div class="attribute">{{ __('Monthly transactions limit') }}</div>
                            <div class="value">{{ $data->monthly_limit_maximum_count }} {{ __('Times') }}</div>
                        </div>
                        <div class="profile-text-data">
                            <div class="attribute">{{ __('Per transaction fee') }}</div>
                            <div class="value"> {{ $data->charge }} {{ $data->charge_type == 'percentage' ? '%' : $currency }}</div>
                        </div>
                    </div>
                    <div class="action-btns mt-3">
                        <a href="" class="site-btn-sm polis-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i data-lucide="check"></i>
                            {{ __('Got it') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
