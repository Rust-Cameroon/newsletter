<div class="col-xl-6 col-lg-12 col-md-12 col-12">
    <div class="site-card">
        <div class="site-card-header">
            <h3 class="title">{{$fields['title']}}</h3>
        </div>
        <div class="site-card-body">
            @include('backend.setting.site_setting.include.form.__open_action')

            <div class="site-input-groups row mb-0">
                <div class="col-sm-4 col-label">{{ __('User Bonus') }}</div>
                <div class="col-sm-8">
                    <div class="form-row">
                        <div class="col-xl-6 col-sm-12 col-12">
                            <div class="site-input-groups">
                                <label for="" class="box-input-label">{{ __('Referral Bonus:') }}</label>
                                <div class="input-group joint-input">
                                    <input type="text" class="form-control" name="referral_bonus"
                                           value="{{ oldSetting('referral_bonus','fee') }}">
                                    <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-12 col-12">
                            <div class="site-input-groups">
                                <label for="" class="box-input-label">{{ __('Signup Bonus:') }}</label>
                                <div class="input-group joint-input">
                                    <input type="text" class="form-control" name="signup_bonus"
                                           value="{{ oldSetting('signup_bonus','fee') }}">
                                    <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="site-input-groups row">
                <label for="" class="col-sm-4 col-label">{{ __('Fund Transfer Charge') }}</label>
                <div class="col-sm-8">
                    <div class="site-input-groups position-relative">
                        <div class="position-relative">
                            <input type="text" class="box-input" value="{{ oldSetting('fund_transfer_charge','fee') }}"
                                   name="fund_transfer_charge">
                            <div class="prcntcurr">
                                <select name="fund_transfer_charge_type" class="form-select" id="">
                                    @foreach(['fixed' => setting('currency_symbol','fee') , 'percentage' => '%'] as $key => $value)
                                        <option @if( oldSetting('fund_transfer_charge_type','fee') == $key) selected @endif
                                        value="{{ $key }}"> {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('backend.setting.site_setting.include.form.__close_action')
        </div>
    </div>
</div>

