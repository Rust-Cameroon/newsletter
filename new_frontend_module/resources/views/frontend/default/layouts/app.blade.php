<!DOCTYPE html>
@php
    $isRtl = isRtl(app()->getLocale());
@endphp
<html lang="{{ app()->getLocale() }}" @if($isRtl) dir="rtl" @endif>
@include('frontend::include.__head')
<body @class([
    'dark-theme' => session()->get('site-color-mode',setting('default_mode')) == 'dark',
    'rtl_mode' => $isRtl,
    'body-landing-bg'
])>
    <!--Notification-->
    @include('global._notify')

    <!-- Pre loader area start -->
    <div class="preloader">
        <div class='loader'>
            <div class='circle'></div>
            <div class='circle'></div>
            <div class='circle'></div>
            <div class='circle'></div>
            <div class='circle'></div>
        </div>
    </div>
    <!-- Pre loader area end -->

    <!-- Offcanvas area start -->
    <div class="fix">
        <div class="offcanvas-area">
            <div class="offcanva-wrapper">
                <div class="offcanvas-content">
                    <div class="offcanvas-top d-flex justify-content-between align-items-center">
                        <div class="offcanvas-logo">
                            <a href="index.html">
                                <img src="{{ asset(setting('site_logo','global')) }}" alt="logo not found">
                            </a>
                        </div>
                        <div class="offcanvas-close">
                            <button class="offcanvas-close-icon animation--flip">
                                <span class="offcanvas-m-lines">
                                    <span class="offcanvas-m-line line--1"></span><span
                                        class="offcanvas-m-line line--2"></span><span
                                        class="offcanvas-m-line line--3"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="mobile-menu fix"></div>
                    <div class="offcanvas-btn mb-3">
                        @auth('web')
                        <a class="gradient-btn" href="{{ route('user.dashboard') }}">
                            <span><i data-lucide="layout-dashboard"></i></span>
                            {{ __('Dashboard') }}
                        </a>
                        @else
                            <a class="gradient-btn" href="{{ route('login') }}">
                                <span><i data-lucide="circle-user-round"></i></span>
                                {{ __('Log In') }}
                            </a>
                            <a class="td-primary-btn" href="{{ route('register') }}">
                                <span><i data-lucide="user-round-plus"></i></span>
                                {{ __('Sign Up') }}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-overlay"></div>
    <div class="offcanvas-overlay-white"></div>
    <!-- Offcanvas area start -->
    @if(setting('back_to_top','permission'))
    <!-- Backtotop start -->
    <div class="backtotop-wrap cursor-pointer">
        <svg class="backtotop-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- Backtotop end -->
    @endif

    @include('frontend::include.__header')

    <!-- Body main wrapper start -->
    <main class="fix">
        @yield('content')
    </main>
    <!-- Body main wrapper end -->

    @include('frontend::include.__footer')
    @include('frontend::cookie.gdpr_cookie')
    @include('frontend::include.__script')

    <script src="{{ asset('front/js/landing.js?v1.0') }}"></script>

</body>
</html>


