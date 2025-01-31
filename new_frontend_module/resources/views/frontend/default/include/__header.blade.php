
<!-- Header area start -->
<header>
    <div id="header-sticky" class="header-area header-transparent">
        <div class="container">
            <div class="mega-menu-wrapper position-relative">
                <div class="header-main">
                    <div class="header-left">
                        <div class="header-logo">
                            <a href="{{ route('home') }}">
                                @php
                                    $height = setting('site_logo_height','global') == 'auto' ? 'auto' : setting('site_logo_height','global').'px';
                                    $width = setting('site_logo_width','global') == 'auto' ? 'auto' : setting('site_logo_width','global').'px';
                                @endphp
                                <img class="logo-white" src="{{ asset(setting('site_logo','global')) }}" style="height:{{ $height }};width:{{ $width }};max-width:none" alt="{{ setting('site_title','global') }}">
                            </a>
                        </div>
                    </div>

                    <div class="header-middle">
                        <div class="mean__menu-wrapper d-none d-lg-block">
                            <div class="main-menu">
                                <nav id="mobile-menu">
                                    <ul>
                                        @foreach($navigations as $navigation)
                                            @if($navigation->page_id == null)
                                            <li @class([
                                                'active' => $navigation->url == Request::url()
                                            ])>
                                                <a href="{{ $navigation->url }}">{{ $navigation->tname }}</a>
                                            </li>
                                            @else
                                            <li @class([
                                                'active' => url($navigation->url) == Request::url()
                                            ])>
                                                <a href="{{ url($navigation->url) }}">{{ $navigation->tname }}</a>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="header-right">
                        <div class="header-action">
                            <div class="quick-use">
                                <div class="language-switcher">
                                    @if(setting('language_switcher'))
                                    <select name="language" class="langu-swit small" onchange="window.location.href=this.options[this.selectedIndex].value;">
                                        @foreach(\App\Models\Language::where('status',true)->get() as $lang)
                                            <option value="{{ route('language-update',['name'=> $lang->locale]) }}" @selected(app()->getLocale() == $lang->locale || $lang->is_default)>{{$lang->name}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                                <div class="color-switcher">
                                    <img class="light-icon" src="{{ asset('/front/images/icons/sun.png') }}" alt="">
                                    <img class="dark-icon" src="{{ asset('/front/images/icons/moon.png') }}" alt="">
                                </div>
                            </div>

                            <div class="header-btn-wrap d-none d-xl-inline-flex">
                                @auth('web')
                                <a class="gradient-btn" href="{{ route('user.dashboard') }}">
                                    <span><i data-lucide="layout-dashboard"></i></span>
                                    {{ __('Dashboard') }}
                                </a>
                                @else
                                    <a class="td-primary-btn" href="{{ route('register') }}">
                                        <span><i data-lucide="user-round-plus"></i></span>
                                        {{ __('Sign Up') }}
                                    </a>
                                    <a class="gradient-btn" href="{{ route('login') }}">
                                        <span><i data-lucide="circle-user-round"></i></span>
                                        {{ __('Log In') }}
                                    </a>
                                @endauth
                            </div>
                            <div class="header-hamburger ml-20 d-xl-none">
                                <div class="sidebar-toggle">
                                    <a class="bar-icon" href="javascript:void(0)">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header area end -->
