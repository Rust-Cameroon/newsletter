<div class="col-xl-6 col-lg-12 col-md-12 col-12">
    <div class="site-card">
        <div class="site-card-header">
            <h3 class="title">{{$fields['title']}}</h3>
        </div>
        <div class="site-card-body">
            @include('backend.setting.site_setting.include.form.__open_action')
            @foreach($fields['elements'] as $key => $field)
            <div class="site-input-groups row">
                <label for="" class="col-sm-3 col-label pt-0">{{ __($field['label']) }}:</label>
                <div class="col-sm-9">
                    <input type="{{$field['type']}}" name="{{ $field['name'] }}" id="html5colorpicker" class="@if($errors->has($field['name'])) has-error @endif" onchange="clickColor(94, 63, 201, 1)" value="{{oldSetting($field['name'],$section)}}">
                </div>
            </div>
            @endforeach
            @include('backend.setting.site_setting.include.form.__close_action')
        </div>
    </div>
</div>
