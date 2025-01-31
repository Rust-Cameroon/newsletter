<script src="{{ asset('global/js/jquery.min.js') }}"></script>
<script src="{{ asset('global/js/jquery-migrate.js') }}"></script>
<script src="{{ asset('global/js/lucide.min.js') }}"></script>
<script src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('front/js/select2.min.js') }}"></script>
<script src="{{ asset('front/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('global/js/simple-notify.min.js') }}"></script>
<script src="{{ asset('global/js/custom.js?v=1.1') }}"></script>
<script src="{{ asset('front/js/magnific.min.js') }}"></script>
<script src="{{ asset('front/js/swiper.min.js') }}"></script>
<script src="{{ asset('front/js/cookie.js') }}"></script>
<script src="{{ asset('front/js/main.js?v=1.0') }}"></script>
<script src="{{ asset('front/js/parallax.min.js') }}"></script>
<script src="{{ asset('front/js/parallax-scroll.js') }}"></script>
<script src="{{ asset('front/js/meanmenu.min.js') }}"></script>
<script src="{{ asset('front/js/aos.js') }}"></script>
<script src="{{ asset('global/js/lucide.min.js') }}"></script>
<script>
    "use strict";

    // Color Switcher
    $(".color-switcher").on('click', function () {
        $("body").toggleClass("dark-theme");

        var url = '{{ route("mode-theme") }}';

        $.get(url);
    });

    let isDisabled = "{{ setting('site_animation','permission') == 1 ?  'mobile' : 'true' }}"

    $(window).on('load', function () {
        AOS.init({
            duration: 1000,
            mirror: true,
            once: true,
            disable: isDisabled == 'true' ? true : 'mobile',
        });
    });

</script>

@include('global.__t_notify')
@if(auth()->check())
    <script src="{{ asset('global/js/pusher.min.js') }}"></script>
    @include('global.__notification_script',['for'=>'user','userId' => auth()->user()->id])
@endif
@yield('script')
@stack('js')
@php
    $googleAnalytics = plugin_active('Google Analytics');
    $tawkChat = plugin_active('Tawk Chat');
    $fb = plugin_active('Facebook Messenger');
@endphp

@if($googleAnalytics)
    @include('frontend::plugin.google_analytics',['GoogleAnalyticsId' => json_decode($googleAnalytics?->data,true)['app_id']])
@endif
@if($tawkChat)
    @include('frontend::plugin.tawk',['data' => json_decode($tawkChat->data, true)])
@endif
@if($fb)
    @include('frontend::plugin.fb',['data' => json_decode($fb->data, true)])
@endif

