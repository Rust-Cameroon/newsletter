@extends('backend.layouts.app')
@section('title')
    {{ __('Settings') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">@yield('setting-title')</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="site-tab-bars">
                        <ul>
                            @can('site-setting')
                                <li class="{{ isActive('admin.settings.site') }}">
                                    <a href="{{ route('admin.settings.site') }}"><i
                                            data-lucide="settings"></i>{{ __('Site Settings') }}</a>
                                </li>
                            @endcan

                            @can('email-setting')
                                <li class="{{ isActive('admin.settings.mail') }}">
                                    <a href="{{ route('admin.settings.mail') }}"><i
                                            data-lucide="mail"></i>{{ __('Email') }}</a>
                                </li>
                            @endcan

                            @can('site-setting')
                                <li class="{{ isActive('admin.settings.seo.meta') }} ">
                                    <a href="{{ route('admin.settings.seo.meta') }}"><i
                                            data-lucide="search-code"></i>{{__('SEO Meta') }}</a>
                                </li>
                            @endcan

                            @can('language-setting')
                                <li class="{{ isActive('admin.language.*') }} ">
                                    <a href="{{ route('admin.language.index') }}"><i
                                            data-lucide="languages"></i>{{__('Language') }}</a>
                                </li>
                            @endcan

                            @can('page-manage')
                                <li class="{{ isActive('admin.page.setting') }} ">
                                    <a href="{{ route('admin.page.setting') }}"><i
                                            data-lucide="layout"></i>{{__('Page') }}</a>
                                </li>
                            @endcan

                            @can('plugin-setting')
                                <li class="{{ isActive('admin.settings.plugin','system') }} ">
                                    <a href="{{ route('admin.settings.plugin','system') }}"><i
                                            data-lucide="award"></i>{{__('Plugin') }}</a>
                                </li>
                            @endcan

                            @can('sms-setting')
                                <li class="{{ isActive('admin.settings.plugin','sms') }} ">
                                    <a href="{{ route('admin.settings.plugin','sms') }}"><i
                                            data-lucide="message-circle"></i>{{__('SMS') }}</a>
                                </li>
                            @endcan
                            @can('push-notification-setting')
                                <li class="{{ isActive('admin.settings.plugin','notification') }} ">
                                    <a href="{{ route('admin.settings.plugin','notification') }}"><i
                                            data-lucide="bell-ring"></i>{{__('Notification') }}</a>
                                </li>
                            @endcan
                            @can('notification-tune-setting')
                                <li class="{{ isActive('admin.settings.notification.tune') }} ">
                                    <a href="{{ route('admin.settings.notification.tune') }}"><i
                                            data-lucide="volume-2"></i>{{__('Notification Tune') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                    <div class="row">
                        @yield('setting-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
