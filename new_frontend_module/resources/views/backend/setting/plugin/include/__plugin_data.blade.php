<form action="{{ route('admin.settings.plugin.update',$plugin->id) }}" method="post">
    @csrf
    <h3 class="title mb-4">{{ __('Update').' '. $plugin->name }}</h3>


    @foreach(json_decode($plugin->data) as $key => $value)
        @if(is_string($value))
        <div class="site-input-groups">
            <label for="" class="box-input-label">
                {{ ucwords(str_replace('_',' ',$key)) }}
                @if($key == 'site_key')
                <i data-lucide="info" data-bs-toggle="tooltip" data-bs-original-title="Note: Before add reCaptcha select v2 in reCaptcha dashboard."></i>
                @endif
            </label>
            <input type="text" name="data[{{ $key }}]" class="box-input mb-0" value="{{ $value }}" required=""/>
        </div>
        @endif
    @endforeach

    <div class="site-input-groups">
        <label class="box-input-label" for="">{{ __('Status:') }}</label>
        <div class="switch-field">
            <input
                type="radio"
                id="plugin-status"
                name="status"
                value="1"
                @if($plugin->status) checked @endif
            />
            <label for="plugin-status">{{ __('Active') }}</label>
            <input
                type="radio"
                id="plugin-status-no"
                name="status"
                value="0"
                @if(!$plugin->status) checked @endif

            />
            <label for="plugin-status-no">{{ __('Deactivated') }}</label>
        </div>
    </div>

    <div class="action-btns">
        <button type="submit" class="site-btn-sm primary-btn me-2">
            <i data-lucide="check"></i>
            {{ __(' Save Changes') }}
        </button>
        <a
            href="#"
            class="site-btn-sm red-btn"
            data-bs-dismiss="modal"
            aria-label="Close"
        >
            <i data-lucide="x"></i>
            {{ __('Close') }}
        </a>
    </div>
</form>

<script>
    "use strict";


</script>
