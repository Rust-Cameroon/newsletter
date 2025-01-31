<div class="col-xl-6 col-lg-12 col-md-12 col-12">
    <div class="site-card">
        <div class="site-card-header">
            <h3 class="title">{{$fields['title']}}</h3>
        </div>
        <div class="site-card-body">

            @include('backend.setting.site_setting.include.form.__open_action')

            @foreach( $fields['elements'] as $key => $field)
                @if($field['type'] == 'file')
                    <div class="site-input-groups row">
                        <div
                            class="col-xl-4 col-lg-4 col-md-3 col-12 col-label"
                        >
                            {{ __($field['label']) }}

                            @if($field['name'] == 'site_logo')
                            <small>(406x84)</small>
                            @elseif($field['name'] == 'site_favicon')
                            <small>(128x128)</small>
                            @elseif($field['name'] == 'login_bg')
                            <small>(1197x607)</small>
                            @endif
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-9 col-12">
                            <div class="wrap-custom-file {{ $errors->has($field['name']) ? 'has-error' : '' }}">
                                <input
                                    type="{{$field['type']}}"
                                    name="{{$field['name']}}"
                                    id="{{$field['name']}}"
                                    value="{{ oldSetting($field['name'],$section) }}"
                                    accept=".jpeg, .jpg, .png"
                                />
                                <label for="{{ __($field['name']) }}" class="file-ok"
                                       style="background-image: url( {{asset(oldSetting($field['name'],$section)) }} )">
                                    <img
                                        class="upload-icon"
                                        src="{{ asset('global/materials/upload.svg') }}"
                                        alt=""
                                    />
                                    <span>{{ __('upload') .' '.__($field['label'])}} </span>
                                </label>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="site-input-groups row">
                        <label for="" class="col-sm-4 col-label">{{ __($field['label']) }}</label>
                        <div class="col-sm-8">
                            <div class="input-group joint-input">

                                <input
                                    type="{{$field['type']}}"
                                    name="{{$field['name']}}"
                                    class=" form-control {{ $errors->has($field['name']) ? 'has-error' : '' }}"
                                    value="{{ oldSetting($field['name'],$section) }}"
                                />
                                <span class="input-group-text"> {{ __('Minutes') }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            @include('backend.setting.site_setting.include.form.__close_action')
        </div>
    </div>
</div>
