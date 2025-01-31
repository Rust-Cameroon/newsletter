<div class="col-xl-6 col-lg-12 col-md-12 col-12">
    <div class="site-card">
        <div class="site-card-header">
            <h3 class="title">{{ __($fields['title']) }}</h3>
        </div>
        <div class="site-card-body">
            @include('backend.setting.site_setting.include.form.__open_action')
            @foreach($fields['elements'] as $key => $field)
                @if($field['type'] == 'checkbox')
                    <div class="site-input-groups row">
                        <div class="col-sm-4 col-label pt-0">{{ __($field['label']) }}</div>
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
                        <div class="col-sm-4 col-label pt-0">{{ __($field['label']) }}</div>
                        <div class="col-sm-8">
                            <textarea name="{{ $field['name'] }}"
                                      class="form-textarea  @if($errors->has($field['name'])) has-error @endif">{{oldSetting($field['name'],$section)}}</textarea>
                        </div>
                    </div>
                @else
                    <div class="site-input-groups row">
                        <div class="col-sm-4 col-label pt-0">{{ __($field['label']) }}</div>
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
