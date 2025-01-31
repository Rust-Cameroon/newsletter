<div class="col-xl-6 col-lg-12 col-md-12 col-12">
    <div class="site-card">
        <div class="site-card-header">
            <h3 class="title">{{$fields['title']}}</h3>
        </div>
        <div class="site-card-body">
            @include('backend.setting.site_setting.include.form.__open_action')

            <div class="site-input-groups row">
                <label for="" class="col-sm-4 col-label">{{ __('Inactive Account Disable') }}</label>
                <div class="col-sm-8">
                    <div class="form-switch ps-0">
                        <div class="switch-field same-type m-0">
                            <input type="radio" id="active1-yes" class="site-currency-type" name="inactive_account_disabled"
                                value="1" @checked(oldSetting('inactive_account_disabled', 'inactive_user' )==1 ) />
                            <label for="active1-yes">{{ __('Yes') }}</label>
                            <input type="radio" id="disable0-no" name="inactive_account_disabled" class="site-currency-type"
                                value="0" @checked(oldSetting('inactive_account_disabled', 'inactive_user' )==0 ) />
                            <label for="disable0-no">{{ __('No') }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site-input-groups row" id="inactive_days_sec">
                <label for="" class="col-sm-4 col-label">{{ __('Inactive Days') }}</label>
                <div class="col-sm-8">
                    <div class="input-group joint-input">
                        <input type="text" name="inactive_days"
                            class=" form-control {{ $errors->has('inactive_days') ? 'has-error' : '' }}"
                            value="{{ oldSetting('inactive_days','inactive_user') }}" />
                    </div>
                </div>
            </div>
            <div class="site-input-groups row" id="inactive_account_fees_sec">
                <label for="" class="col-sm-4 col-label">{{ __('Inactive Account Fees') }}</label>
                <div class="col-sm-8">
                    <div class="form-switch ps-0">
                        <div class="switch-field same-type m-0">
                            <input type="radio" id="active1-yes1" class="site-currency-type" name="inactive_account_fees" value="1"
                                @checked(oldSetting('inactive_account_fees', 'inactive_user' )==1 ) />
                            <label for="active1-yes1">{{ __('Yes') }}</label>
                            <input type="radio" id="disable0-no1" name="inactive_account_fees" class="site-currency-type" value="0"
                                @checked(oldSetting('inactive_account_fees', 'inactive_user' )==0 ) />
                            <label for="disable0-no1">{{ __('No') }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site-input-groups row" id="fees_amount_sec">
                <label for="" class="col-sm-4 col-label">{{ __('Fee Amount') }}</label>
                <div class="col-sm-8">
                    <div class="input-group joint-input">
            
                        <input type="text" name="fee_amount"
                            class=" form-control {{ $errors->has('fee_amount') ? 'has-error' : '' }}"
                            value="{{ oldSetting('fee_amount','inactive_user') }}" />
                        <span class="input-group-text"> {{ setting('site_currency','global') }}</span>
                    </div>
                </div>
            </div>


            @include('backend.setting.site_setting.include.form.__close_action')
        </div>
    </div>
</div>

