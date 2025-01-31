@if(setting('gdpr_status','gdpr') == true)
    <div class="caches-privacy cookiealert" hidden>
        <div class="content">
            <h4 class="title">{{ __('Cookie Settings') }}</h4>
            <p>{{ setting('gdpr_text','gdpr') }}</p>
        </div>
        <div class="caches-btn">
            <a class="learn-more" href="{{ url(setting('gdpr_button_url','gdpr')) }}" target="_blank">{{setting('gdpr_button_label','gdpr')}}</a>
            <button class="site-btn primary-btn acceptcookies">{{ __('Accept All') }}</button>
        </div>
    </div>
@endif
