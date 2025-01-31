<div class="col-xl-6 col-lg-12 col-md-12 col-12">
    <div class="site-card">
        <div class="site-card-header">
            <h3 class="title">{{ __($fields['title']) }}</h3>
        </div>
        <div class="site-card-body">

            <p class="paragraph mb-4"><i data-lucide="alert-triangle"></i><strong>Warning:</strong> Once you <strong>Enable</strong>
                the <strong>Maintenance Mode</strong> then you need to remember the <strong>Secret Key</strong> to turn
                back the website.</p>

            @include('backend.setting.site_setting.include.form.__open_action')
            @foreach($fields['elements'] as $key => $field)
                @if($field['type'] == 'checkbox')
                    <div class="site-input-groups row">
                        <div class="col-sm-4 col-label pt-0">{{ __($field['label']) }}
                            <i data-lucide="info" data-bs-toggle="tooltip" title=""
                            data-bs-original-title="Do not enable it unless you want the site need to be under Maintenance"></i>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-switch ps-0">
                                <input class="form-check-input" type="hidden" value="0" name="{{$field['name']}}"/>
                                <div class="switch-field same-type m-0">
                                    <input
                                        type="radio"
                                        id="{{$field['name'], $key}}"
                                        name="{{$field['name']}}"
                                        value="1"
                                        @if(oldSetting($field['name'],$section)) checked @endif
                                    />
                                    <label for="{{$field['name'], $key}}">{{ __('Enable') }}</label>
                                    <input
                                        type="radio"
                                        id="disable-{{$field['name'], $key}}"
                                        name="{{$field['name']}}"
                                        value="0"
                                        @if(!oldSetting($field['name'],$section)) checked @endif
                                    />
                                    <label for="disable-{{$field['name'], $key}}">{{ __('Disabled') }}</label>
                                </div>

                            </div>
                        </div>
                    </div>
                @elseif($field['type'] == 'textarea')
                    <div class="site-input-groups row">
                        <div class="col-sm-4 col-label">{{ __($field['label']) }}</div>
                        <div class="col-sm-8">
                            <textarea name="{{ $field['name'] }}"
                                      class="form-textarea  @if($errors->has($field['name'])) has-error @endif">{{oldSetting($field['name'],$section)}}</textarea>
                        </div>
                    </div>

                @else
                    <div class="site-input-groups row">
                        <div class="col-sm-4 col-label">{{ __($field['label']) }}
                            @if($field['name'] == 'secret_key')
                                <i data-lucide="info" data-bs-toggle="tooltip" title=""
                                   data-bs-original-title="Remember the Secret Key. Use domain/secret-key to trun back the website live"></i>
                            @endif
                        </div>
                        <div class="col-sm-8">
                            <input type="{{$field['type']}}" name="{{ $field['name'] }}"
                                   class="box-input @if($errors->has($field['name'])) has-error @endif"
                                   placeholder="Label" value="{{oldSetting($field['name'],$section)}}" required="">
                        </div>
                    </div>

                @endif
            @endforeach
            @include('backend.setting.site_setting.include.form.__close_action')
        </div>
    </div>
</div>
