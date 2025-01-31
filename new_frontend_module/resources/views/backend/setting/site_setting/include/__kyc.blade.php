<div class="col-xl-6 col-lg-12 col-md-12 col-12">
    <div class="site-card">
        <div class="site-card-header">
            <h3 class="title">{{$fields['title']}}</h3>
        </div>
        <div class="site-card-body">

            @include('backend.setting.site_setting.include.form.__open_action')
            @foreach($fields['elements'] as $key => $field)
            <div class="site-input-groups row">
                <div class="col-sm-4 col-label pt-0">{{ __($field['label']) }}</div>

                <div class="col-sm-8">
                    <div class="form-switch ps-0">
                        <div class="switch-field same-type m-0">
                            <input
                                type="radio"
                                id="enable-{{ $field['name'] }}"
                                name="{{ $field['name'] }}"
                                value="1"
                                @checked(setting($field['name'],'kyc'))
                            />
                            <label for="enable-{{ $field['name'] }}">{{ __('Enabled') }}</label>
                            <input
                                type="radio"
                                id="disable-{{ $field['name'] }}"
                                name="{{ $field['name'] }}"
                                value="0"
                                @checked(!setting($field['name'],'kyc'))
                            />
                            <label for="disable-{{ $field['name'] }}">{{ __('Disabled') }}</label>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @include('backend.setting.site_setting.include.form.__close_action')
        </div>
    </div>
</div>
