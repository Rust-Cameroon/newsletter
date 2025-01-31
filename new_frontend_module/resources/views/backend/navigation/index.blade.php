@extends('backend.layouts.app')
@section('title')
    {{ __('Menu Management') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Menu Management') }}</h2>
                            @isset($button)
                                <a href="{{$button['route']}}"
                                   class="title-btn"
                                   type="button"
                                ><i data-lucide="{{$button['icon']}}"></i>{{$button['name']}}</a>
                            @endisset
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
                            <li class="{{ isActive('admin.navigation.menu') }}">
                                <a href="{{ route('admin.navigation.menu') }}"><i
                                        data-lucide="settings-2"></i>{{ __('All Menu Items') }}</a>
                            </li>
                            <li class="{{ isActive('admin.navigation.header') }}">
                                <a href="{{ route('admin.navigation.header') }}"><i
                                        data-lucide="book-open"></i>{{ __('Header Navigation') }}</a>
                            </li>
                            <li class="{{ isActive('admin.navigation.footer') }}">
                                <a href="{{ route('admin.navigation.footer') }}"><i
                                        data-lucide="box"></i>{{ __('Footer Navigation') }}</a>
                            </li>
                            <li class="{{ isActive('admin.user.navigation.index') }}">
                                <a href="{{ route('admin.user.navigation.index') }}"><i
                                        data-lucide="user"></i>{{ __('User Navigation') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="row">
                        @yield('navigation_content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
