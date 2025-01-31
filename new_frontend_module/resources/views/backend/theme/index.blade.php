@extends('backend.layouts.app')
@section('title')
    {{ __('Theme Management') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <h2 class="title">@yield('theme-title')</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="site-tab-bars">
                        <ul>
                            <li class="{{ isActive('admin.theme.site') }}">
                                <a href="{{ route('admin.theme.site') }}"><i
                                        data-lucide="roller-coaster"></i>{{ __('Site Theme') }}</a>
                            </li>
                            <li class="{{ isActive('admin.theme.dynamic-landing') }}">
                                <a href="{{ route('admin.theme.dynamic-landing') }}"><i
                                        data-lucide="warehouse"></i>{{ __('Site Dynamic Landing Theme') }}</a>
                            </li>

                        </ul>
                    </div>
                    <div class="row">
                        @yield('theme-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
