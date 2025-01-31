<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="@yield('meta_keywords')">
    <meta name="description" content="@yield('meta_description')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ url()->current() }}"/>
    <link rel="shortcut icon" href="{{ asset(setting('site_favicon','global')) }}" type="image/x-icon"/>
    <link rel="icon" href="{{ asset(setting('site_favicon','global')) }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('global/css/custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/styles.css') }}?v=1.3" />
    @stack('style')
    @yield('style')
    <style>
        {{ \App\Models\CustomCss::first()->css }}
    </style>
    <title>{{ setting('site_title', 'global') }} - @yield('title')</title>
</head>
